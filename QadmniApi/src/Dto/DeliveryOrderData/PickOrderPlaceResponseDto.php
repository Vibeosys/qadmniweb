<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\DeliveryOrderData;

/**
 * Description of PickOrderPlaceResponseDto
 *
 * @author anand
 */
class PickOrderPlaceResponseDto extends \App\Dto\JsonDeserializer {
    //put your code here
    public $id;
    public $owner;
    public $status;
    public $status_code;
    public $service_cost;
}

/*
 * {
   "id": 12,
   "owner": "Qadmni@gmail.com",
   "pickup_addr": "24.959517,46.698753",
   "dropoff_addr": "",
   "contact_name": "Anand",
   "phone": "+966554381550",
   "pickup_time": "2017-02-08T13:44:00Z",
   "dropoff_time": "2017-02-08T15:44:00Z",
   "items": "food",
   "payment_type": "COD",
   "cod_fees": null,
   "status": "Waiting Receiver Action",
   "status_code": 1,
   "delivery_notes": null,
   "price": "200.00",
   "service_type": "on-demand",
   "addons": null,
   "service_cost": 34
}
 */
