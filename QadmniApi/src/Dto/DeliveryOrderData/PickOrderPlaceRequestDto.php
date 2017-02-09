<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\DeliveryOrderData;

/**
 * Description of PickOrderPlaceRequestDto
 *
 * @author anand
 */
class PickOrderPlaceRequestDto {
//put your code here
    public $pickup_addr;
    public $dropoff_addr;
    public $contact_name;
    public $phone;
    public $pickup_time;
    public $dropoff_time;
    public $items = 'food';
    public $payment_type;
    public $price;
    public $service_type = 'on-demand';

}

/*
 * {
"pickup_addr" : "24.959517,46.698753",
"dropoff_addr": "24.981398,44.807305",
"contact_name" : "Anand",
"phone" : 966554381550,
"pickup_time" : "2017-02-08 01:44 PM",
"dropoff_time": "2017-02-08 03:44 PM",
"items" : "food",
"payment_type" : "COD",
"price" : 200,
"service_type" : "on-demand"
}
 */