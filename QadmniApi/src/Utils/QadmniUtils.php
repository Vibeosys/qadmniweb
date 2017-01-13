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

    //put your code here
    protected static $_languageCodes = ['En', 'Ar'];

    public static function requestedLanguage($languageCode) {
        if (in_array($languageCode, static::$_languageCodes)) {
            return $languageCode;
        } else {
            return 'En';
        }
    }

}
