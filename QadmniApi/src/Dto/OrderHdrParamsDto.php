<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of OrderHdrDto
 *
 * @property Requests\InitiateOrderRequestDto $orderInitiationRequest
 * @author anand
 */
class OrderHdrParamsDto {

    //put your code here
    public $orderInitiationRequest;
    public $customerId;
    public $producerId;
    public $orderSubTotal;
    public $orderStatus;
    public $transStatus;
    public $transRequired;
    public $deliveryDateTime;
    public $orderQty;
    public $totalAmountInSAR;
    public $totalAmountInUSD;
    public $deliveryStatus;
    public $isGift;
    public $giftMessage;
}
