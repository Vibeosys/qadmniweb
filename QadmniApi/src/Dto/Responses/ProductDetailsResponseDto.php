<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of ProductDetailsResponseDto
 *
 * @author anand
 */
class ProductDetailsResponseDto {
    //put your code here
    public $itemId;
    public $itemNameEn;
    public $itemNameAr;
    public $itemDescEn;
    public $itemDescAr;
    public $categoryId;
    public $unitPrice;
    public $offerText;
    public $isActive;
    public $imageUrl;
}
