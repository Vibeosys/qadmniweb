<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Requests;

/**
 * Description of ProducerSignupRequestDto
 *
 * @author anand
 */
class ProducerSignupRequestDto extends \App\Dto\JsonDeserializer{
    //put your code here
    public $producerName;
    public $emailId;
    public $password;
    public $businessNameEn;
    public $businessNameAr;
    public $businessAddress;
    public $businessLat;
    public $businessLong;
    public $pushNotificationId;
    public $osVersionType;
}
