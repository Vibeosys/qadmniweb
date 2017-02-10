<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of DateTimeUtil
 *
 * @author anand
 */
class DateTimeUtil {
    //put your code here
    /**
     * Converts to riyadh time zone
     * @param \Cake\I18n\Time $dateTime
     * @return \Cake\I18n\Time
     */
    public static function convertToRiyadhTimezone($dateTime){
        $currentTime = new \Cake\I18n\Time($dateTime);
        $currentTime->setTimezone( 'Asia/Riyadh');
        return $currentTime;
    }
}
