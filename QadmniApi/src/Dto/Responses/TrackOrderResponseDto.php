<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Dto\Responses;

/**
 * Description of TrackOrderResponseDto
 *
 * @author anand
 */
class TrackOrderResponseDto {

    //put your code here
    public $orderId;
    public $deliveryAddress;
    public $timeRequiredInMinutes;
    public $stageNo;
    public $currentStatusCode;
    public $deliveryStatus;
    public $deliveryMode;

}
