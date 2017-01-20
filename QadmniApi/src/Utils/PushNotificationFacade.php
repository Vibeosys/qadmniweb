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

    public function __construct() {
        if (static::$_config == null) {
            static::$_config = new \OneSignal\Config();
            static::$_config->setApplicationId(QadmniConstants::ONESIGNAL_APP_ID);
            static::$_config->setApplicationAuthKey(QadmniConstants::ONESIGNAL_APP_AUTH_KEY);
        }
    }

    public function setContents($englishContent, $arabicContent) {
        //$contentArray = [ 'contents' => ['en' => $englishContent, 'ar' => $arabicContent]];
        //$this->_android_options['contents']  =['en' => $englishContent, 'ar' => $arabicContent];
        //array_push($this->_android_options, $contentArray);
        return $this;
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
        //$templateArray = ['template' => $templateId];        
        $this->_android_options['template_id'] = $templateId;
        //array_push($this->_android_options, $templateArray);
        return $this;
    }

    public function setAndroidDevices(array $deviceList) {
        //$devices = ['include_player_ids' => $deviceList];
        $this->_android_options['include_player_ids'] = $deviceList;
        return $this;
    }

    private function getAndroidOptions() {
        $defaultAndroidOptions = [
            'headings' => ['en' => 'Qadmni updates', 'ar' => 'كعكة عيد الميلاد'],
            'android_sound' => 'notification',
            'android_visibility' => 1,
        ];
        $this->_android_options['headings'] = ['en' => 'Qadmni updates', 'ar' => 'كعكة عيد الميلاد'];
        $this->_android_options['android_sound'] = 'notification';
        $this->_android_options['android_visibility'] = 1;
        return $this->_android_options;
    }

    public function sendIOSNotifications() {
        
    }

}
