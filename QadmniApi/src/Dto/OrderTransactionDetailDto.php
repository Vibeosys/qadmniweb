<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of OrderTransactionDetailDto
 *
 * @author anand
 */
class OrderTransactionDetailDto {
    //put your code here
    public $transactionRequired;
    public $amountInUSD;
    public $amountInSAR;
    public $orderStatus;
    public $transactionStatus;
    public $customerId;
}
