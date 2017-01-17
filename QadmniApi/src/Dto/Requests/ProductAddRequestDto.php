<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Requests;

/**
 * Description of ProductAddRequestDto
 *
 * @author anand
 */
class ProductAddRequestDto extends \App\Dto\JsonDeserializer {
    //put your code here
    public $itemNameEn;
    public $itemNameAr;
    public $itemDescEn;
    public $itemDescAr;
    public $categoryId;
    public $price;
    public $offerText;
}
