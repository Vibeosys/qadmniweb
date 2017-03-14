<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of OneSignalFacade
 *
 * @author anand
 */
class PushNotificationFacade {

    /**
     * Config for OneSignal
     * @var \OneSignal\Config 
     */
    private static $_config = null;
    private $_android_options = [];
    private $_ios_options = [];

    public function __construct() {
        if (static::$_config == null) {
            static::$_config = new \OneSignal\Config();
            static::$_config->setApplicationId(QadmniConstants::ONESIGNAL_APP_ID);
            static::$_config->setApplicationAuthKey(QadmniConstants::ONESIGNAL_APP_AUTH_KEY);
        }
    }

    public function sendAndroidNotifications() {
        $notificationSent = false;
        $oneSignalApi = new \OneSignal\OneSignal(static::$_config);

        $options = $this->getAndroidOptions();
        try {
            $addResult = $oneSignalApi->notifications->add($options);
            if ($addResult) {
                $resultOpen = $oneSignalApi->notifications->open($addResult['id']);
                if ($resultOpen) {
                    $notificationSent = $resultOpen['Success'];
                }
            }
        } catch (\Exception $ex) {
            \Cake\Log\Log::error($ex);
        }
        $this->_android_options = [];
        return $notificationSent;
    }

    public function setTemplate($templateId) {
        $this->_android_options['template_id'] = $templateId;
        $this->_ios_options['template_id'] = $templateId;
        return $this;
    }

    public function setDevices(array $deviceList) {
        $this->_android_options['include_player_ids'] = $deviceList;
        $this->_ios_options['include_player_ids'] = $deviceList;
        return $this;
    }

    private function getAndroidOptions() {
        $this->_android_options['headings'] = ['en' => 'Qadmni updates', 'ar' => 'كعكة عيد الميلاد'];
        $this->_android_options['android_sound'] = 'notification';
        $this->_android_options['android_visibility'] = 1;
        return $this->_android_options;
    }

    private function getIosOptions() {
        $this->_ios_options['headings'] = ['en' => 'Qadmni updates', 'ar' => 'كعكة عيد الميلاد'];
        $this->_ios_options['subtitle'] = ['en' => 'Qadmni updates', 'ar' => 'كعكة عيد الميلاد'];
        $this->_ios_options['content_available'] = 1;
        return $this->_ios_options;
    }

    public function sendIOSNotifications() {
        $notificationSent = false;
        $oneSignalApi = new \OneSignal\OneSignal(static::$_config);

        $options = $this->getIosOptions();
        try {
            $addResult = $oneSignalApi->notifications->add($options);
            if ($addResult) {
                $resultOpen = $oneSignalApi->notifications->open($addResult['id']);
                if ($resultOpen) {
                    $notificationSent = $resultOpen['Success'];
                }
            }
        } catch (\Exception $ex) {
            \Cake\Log\Log::error($ex);
        }
        $this->_ios_options = [];
        return $notificationSent;
    }

}
