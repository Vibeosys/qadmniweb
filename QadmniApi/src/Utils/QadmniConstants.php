<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of QadmniConstants
 *
 * @author anand
 */
class QadmniConstants {

    /**
     * Image path directory Qadmni
     */
    const IMAGE_PATH_DIRECTORY = 'images';

    /**
     * Online payment like paypal
     */
    const CHARGE_TYPE_ONLINE = 'ON';
    /**
     * Prepaid delivery charges
     */
    const CHARGE_TYPE_PREPAID_DELIVERY = 'PR';
    /**
     * Cash on delivery charges
     */
    const CHARGE_TYPE_CASH_ON_DELIVERY = 'CD';
    /**
     * Mandatory charges
     */
    const CHARGE_TYPE_MANDATORY = 'MA';
    /**
     * Delivery method home delivery
     */
    const DELIVERY_METHOD_HOME_DELIVERY = 'DL';
    /**
     * Delivery method pickup
     */
    const DELIVERY_METHOD_PICKUP = 'PK';
    /**
     * Payment method paypal
     */
    const PAYMENT_METHOD_PAYPAL = 'PP';
    /**
     * Payment method cash
     */
    const PAYMENT_METHOD_CASH = 'CA';
    
}
