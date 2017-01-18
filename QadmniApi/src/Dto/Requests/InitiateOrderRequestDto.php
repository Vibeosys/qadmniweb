<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Requests;

/**
 * Description of PlaceOrderRequestDto
 *
 * @author anand
 */
class InitiateOrderRequestDto extends \App\Dto\JsonDeserializer{
    //put your code here
    public $productInfo;
    public $deliveryAddress;
    public $deliveryLat;
    public $deliveryLong;
    public $deliveryMethod;
    public $deliverySchedule;
    public $paymentMethod;
}
