<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of ProcessOrderResponseDto
 *
 * @property \App\Dto\PaypalEnvValuesDto $paypalEnvValues 
 * @author anand
 */
class ProcessOrderResponseDto {

    //put your code here
    public $orderId;
    public $transactionRequired;
    public $transactionId;
    public $amount;
    public $currency;
    public $paypalEnvValues;

}
