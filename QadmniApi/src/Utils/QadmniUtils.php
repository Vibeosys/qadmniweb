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
    public static function requestedNotificationOsType($osType){
        if (in_array($osType, static::$_pushNotificationOsTypes)) {
            return $osType;
        } else {
            return 'IO';
        }
    }

}
