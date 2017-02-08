<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of OrderDetailResponseDto
 *
 * @property \App\Dto\OrderItemDetailDto $items 
 * @author anand
 */
class OrderDetailResponseDto {
    //put your code here
    public $orderId;
    public $orderDate;
    public $items;
    public $totalAmountInSAR;
    public $totalTaxesAndSurcharges;
}
