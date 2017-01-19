<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of QadmniUtils
 *
 * @author anand
 */
class QadmniUtils {

    /**
     * Language codes
     * @var array Language codes 
     */
    protected static $_languageCodes = ['En', 'Ar'];

    /**
     * Push notification OS types
     * @var array Notification types 
     */
    protected static $_pushNotificationOsTypes = ['IO', 'AN'];

    /**
     * Delivery methods DL for Home Delivery and PK for Pickup
     * @var array Delivery methods 
     */
    protected static $_deliveryMethods = ['DL', 'PK'];

    /**
     * Payment methods PP for Paypal and CA for Cash
     * @var array Payment methods 
     */
    protected static $_paymentMethods = ['PP', 'CA'];

    /**
     * Get default or typed language code from lib
     * @param string $languageCode
     * @return string
     */
    public static function requestedLanguage($languageCode) {
        if (in_array($languageCode, static::$_languageCodes)) {
            return $languageCode;
        } else {
            return 'En';
        }
    }

    /**
     * Get default or typed notification OS type from lib
     * @param string $osType
     * @return string
     */
    public static function requestedNotificationOsType($osType) {
        if (in_array($osType, static::$_pushNotificationOsTypes)) {
            return $osType;
        } else {
            return 'IO';
        }
    }

    /**
     * Extract type of delivery method
     * @param string $deliveryMethodRequested
     * @return string
     */
    public static function filterDeliveryMethod($deliveryMethodRequested) {
        if (in_array($deliveryMethodRequested, static::$_deliveryMethods)) {
            return $deliveryMethodRequested;
        } else {
            return 'DL';
        }
    }

    /**
     * Payment method to be inferred
     * @param string $paymentMethodRequested
     * @return string
     */
    public static function filterPaymentMethod($paymentMethodRequested) {
        if (in_array($paymentMethodRequested, static::$_paymentMethods)) {
            return $paymentMethodRequested;
        }
        return 'PP';
    }

    /**
     * Converts from TimeStamp to DATE TIME
     * @param type $timeStamp
     * @return \Cake\I18n\Time
     */
    public static function convertFromTimestampToDate($timeStamp) {
        $tm = new \Cake\I18n\Time();
        $tm->setTimestamp($timeStamp);
        return $tm;
    }

    /**
     * Generates transaction id required for Paypal
     * @param int $customerId
     * @param int $orderId
     * @return string
     */
    public static function generateTransactionId($customerId, $orderId) {
        $dt = new \Cake\I18n\Time();
        $dtm = $dt->getTimestamp();
        $transId = 'QDM-' . $customerId . '-' . $orderId . '-' . $dtm;
        return $transId;
    }

    /**
     * Builds paypal values to return to app
     * @param type $amount
     * @return \App\Dto\PaypalEnvValuesDto
     */
    public static function buildPaypalInfo($amount) {
        $paypalInfo = new \App\Dto\PaypalEnvValuesDto();
        $paypalInfo->environment = QadmniConstants::PAYPAL_ENV;
        $paypalInfo->paypalDesc = 'Total Amount in US $ ' . $amount;
        if (QadmniConstants::PAYPAL_ENV != 'live') {
            $paypalInfo->clientId = QadmniConstants::PAYPAL_SANDBOX_CLIENT_ID;
        } else {
            $paypalInfo->clientId = QadmniConstants::PAYPAL_LIVE_CLIENT_ID;
        }
        return $paypalInfo;
    }

}
