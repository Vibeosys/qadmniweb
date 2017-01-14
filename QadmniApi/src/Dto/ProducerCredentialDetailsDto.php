<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of ProducerCredentialDetailsDto
 *
 * @author anand
 */
class ProducerCredentialDetailsDto extends JsonDeserializer{
    //put your code here
    public $producerId;
    public $password;
}
