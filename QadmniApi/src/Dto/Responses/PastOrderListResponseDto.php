<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of PastOrderListResponseDto
 *
 * @author anand
 */
class PastOrderListResponseDto {
    //put your code here
    public $orderId;
    public $orderDate;
    public $producerBusinessName;
    public $paymentMode;
    public $deliveryMode;
    public $amountInSAR;
    public $deliveryStatus;
    public $deliveryStatusCode;
}
