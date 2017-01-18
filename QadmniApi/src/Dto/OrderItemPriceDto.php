<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of OrderItemPriceDto
 *
 * @author anand
 */
class OrderItemPriceDto extends OrderItemDto {
    //put your code here
    public $unitPrice;
    public $itemTotalPrice;
    public $itemName;
}
