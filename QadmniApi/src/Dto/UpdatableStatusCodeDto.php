<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto;

/**
 * Description of UpdatableStatusCodeDto
 *
 * @author anand
 */
class UpdatableStatusCodeDto {
    //put your code here
    public $statusId;
    public $statusCode;
    
    public function __construct($statusId = null, $statusCode = null) {
        $this->statusId = $statusId;
        $this->statusCode = $statusCode;
    }
}
