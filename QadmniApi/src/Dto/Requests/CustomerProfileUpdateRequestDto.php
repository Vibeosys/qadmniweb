<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Requests;

/**
 * Description of CustomerProfileUpdateRequestDto
 *
 * @author anand
 */
class CustomerProfileUpdateRequestDto extends \App\Dto\JsonDeserializer {

    //put your code here
    public $name;
    public $phone;
    public $emailId;
    public $password;

}
