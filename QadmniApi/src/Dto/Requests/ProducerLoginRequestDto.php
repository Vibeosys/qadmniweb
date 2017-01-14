<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Requests;

/**
 * Description of ProducerLoginRequestDto
 *
 * @author anand
 */
class ProducerLoginRequestDto extends \App\Dto\JsonDeserializer {
    //put your code here
    public $pushNotificationId;
    public $pushDeviceOsType;
    public $emailId;
    public $password;
}
