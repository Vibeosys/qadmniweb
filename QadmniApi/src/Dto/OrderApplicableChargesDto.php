<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of OrderApplicableChargesDto
 * @property ChargeDetailBreakupDto $chargeDetailBreakup 
 * @author anand
 */
class OrderApplicableChargesDto {
    //put your code here
    public $orderSubTotal;
    public $orderTotalAmount;
    public $chargeDetailBreakup;
}
