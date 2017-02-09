<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of DeliveryLogisticsProvider
 *
 * @author anand
 */
class DeliveryLogisticsProvider {

    /**
     * Provides delivery interface object
     * @return \App\Utils\DeliveryInterface
     */
    public static function create() {
        return new PickDeliveryFacade();
    }

}
