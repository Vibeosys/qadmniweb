<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\DeliveryOrderData;

/**
 * Description of PlaceDeliveryOrderDto
 *
 * @author anand
 */
class PlaceDeliveryOrderRequestDto {

    public $orderId;
    public $vendorLat;
    public $vendorLong;
    public $customerLat;
    public $customerLong;
    public $customerName;
    public $customerPhone;
    public $pickupTime;
    public $dropoffTime;
    public $paymentType;
    public $price;

}
