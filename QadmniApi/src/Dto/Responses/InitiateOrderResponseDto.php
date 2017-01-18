<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of InitiateOrderResponseDto
 *
 * @author anand
 */
class InitiateOrderResponseDto {
    //put your code here
    public $orderId;
    public $orderedItems;
    public $chargeBreakup;
    public $totalAmount;
}
