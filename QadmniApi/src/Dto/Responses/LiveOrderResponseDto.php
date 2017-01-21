<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of LiveOrderResponseDto
 *
 * @author anand
 */
class LiveOrderResponseDto {
    //put your code here
    public $orderId;
    public $orderDate;
    public $producerBusinessName;
    public $paymentMode;
    public $deliveryMode;
    public $amountInSAR;
    public $stageNo;
    public $currentStatusCode;
    public $deliveryStatus;
}
