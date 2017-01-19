<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of OrderValidationDto
 *
 * @author anand
 */
class OrderValidationDto {
    //put your code here
    public $orderId;
    public $orderAmountInSAR;
    public $orderAmountInUSD;
    public $orderStatus;
    public $transactionRequired;
}
