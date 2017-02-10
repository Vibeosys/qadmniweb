<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of VendorOrderListResponseDto
 *
 * @author anand
 */
class VendorOrderListResponseDto {
    //put your code here
    public $orderId;
    public $orderDate;
    public $scheduleDate;
    public $paymentMode;
    public $paymentMethod;
    public $deliveryMethod;
    public $deliveryType;
    public $customerName;
    public $customerPhone;
    public $deliveryAddress;
    public $deliveryLat;
    public $deliveryLong;
    public $amountInSAR;
    public $stageNo;    
    public $currentStatusCode;
    public $deliveryStatusId;
    public $updatableStatusCodes;
    public $canUpdateStatus;
    public $isGiftWrap;
    public $giftMessage;
}
