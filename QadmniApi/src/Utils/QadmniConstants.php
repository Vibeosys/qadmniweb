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
    /**
     * Transaction status non initiated is NONE 0
     */
    const TRANSACTION_STATUS_NONE = 0;
    /**
     * Order status initiated as INITIATED 0
     */
    const ORDER_STATUS_INITIATED = 0;
    /**
     * Order status pending as PENDING 1
     */
    const ORDER_STATUS_PENDING = 1;
    /**
     * Delivery status non initiated 0
     */
    const DELIVERY_STATUS_INITIATED = 0;
    /**
     * Payment currency is USD
     */
    const PAYMENT_CURRENCY = 'USD';
    /**
     * Payment status 0 is for Pending
     */
    const PAYMENT_STATUS_PENDING = 0;
    /**
     * Payment status 1 for Confirmed
     */
    const PAYMENT_STATUS_CONFIRMED = 1;
    /**
     * Paypal environment
     */
    const PAYPAL_ENV = 'sandbox';
    /**
     * Client id for sandbox
     */
    const PAYPAL_SANDBOX_CLIENT_ID = 'AazpbjT0kIEf-4PEdLZL7S9Y6F2BU5zLN9vOn9AGgkjLcLHj0bFwIrOxQK-7vXwmT-0Q9SmVGapM5hDS';
    /**
     * Secret for paypal sandbox
     */
    const PAYPAL_SANDBOX_SECRET = 'EKVaFVA51y2y2__FfrSNfdzR0yieyQ86wRp0u_1BYEWaTpivoLWjkfChXk6XAgJOpzR4YeLqam6_po9D';
    /**
     * Paypal live client id
     */
    const PAYPAL_LIVE_CLIENT_ID = 'ARUsUW_-mWCE1NAAdf0Xy4KtxxpTgv9KsM3XtEpG3DlW3C3t7J_Qikz1dA1DfUUN2c0UQUpKfGJaG23z';
    /**
     * Paypal live secret
     */
    const PAYPAL_LIVE_SECRET = 'ECAxCecKjAa1XUga2A4l7NvL9IYwm3dFUkAVtQ_SL_4gOzWcG4-z2uqHTmcyKMXA_Wbkk1ih5CgmBqzp';
}
