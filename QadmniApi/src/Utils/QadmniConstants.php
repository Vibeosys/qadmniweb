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
     * Android OS type
     */
    const ANDROID_OS_TYPE = 'AN';
    /**
     * IOS OS type
     */
    const IOS_OS_TYPE = 'IO';
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
     * Payment method cash in string format
     */
    const PAYMENT_METHOD_CASH_IN_STRING = 'Cash';
    /**
     * Transaction status non initiated is NONE 0
     */
    const TRANSACTION_STATUS_NONE = 0;
    /**
     * Transaction status rejected
     */
    const TRANSACTION_STATUS_REJECTED = 1;
    /**
     * Transaction status approved
     */
    const TRANSACTION_STATUS_APPROVED = 2;
    /**
     * Order status initiated as INITIATED 0
     */
    const ORDER_STATUS_INITIATED = 0;
    /**
     * Order status pending as PENDING 1
     */
    const ORDER_STATUS_PENDING = 1;
    /**
     * Order status confirmed as CONFIRMED 2
     */
    const ORDER_STATUS_CONFIRMED = 2;
    /**
     * Delivery status non initiated 0
     */
    const DELIVERY_STATUS_INITIATED = 0;
    /**
     * Delivery status requested 1
     */
    const DELIVERY_STATUS_REQUESTED = 1;
    /**
     * Delivery status confirmed 2 
     */
    const DELIVERY_STATUS_CONFIRMED = 2;
    /**
     * Delivery status in process 3
     */
    const DELIVERY_STATUS_IN_PROCESS = 3;
    /**
     * Delivery status delivered 4
     */
    const DELIVERY_STATUS_DELIVERED = 4;
    /**
     * Delivery status pickup requested 5
     */
    const DELIVERY_STATUS_PICKUP_REQUESTED = 5;
    /**
     * Delivery status pickup complete 6
     */
    const DELIVERY_STATUS_PICKUP_COMPLETE = 6;
    /**
     * Delivery status pickup not done 7
     */
    const DELIVERY_STATUS_NOT_PICKED_UP = 7;
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
    /**
     * One signal App ID
     */
    const ONESIGNAL_APP_ID = '29d2c9ef-09ee-468b-96c9-b26340758d9a';
    /**
     * One signal AUTH key 
     */
    const ONESIGNAL_APP_AUTH_KEY = 'YTU2ZGZlMWItMjg4MC00Mjc5LWI2MjUtNzk5OTdhMWYxNWQ3';
    /**
     * One signal notification template id for Order confirmation
     */
    const NOTIFICATION_ORDER_CONFIRMATION_TEMPLATE_ID = '9507269b-1da7-4568-a808-c732e5441953';
    /**
     * One signal notification template id for Order confirmation for Producers
     */
    const NOTIFICATION_ORDER_CONFIRMATION_PRODUCER_TEMPLATE_ID = '87c98ec6-ee12-4538-9eac-15c2a6f0a174';
    /**
     * Exchange rate API URL
     */
    const EXCHANGE_RATE_API_URL = "http://apilayer.net/api/live?access_key=0eeb90120a4a52fc97b7ba1d91a5c389&currencies=SAR";
    /**
     * Exchange API call enabled? true or false
     */
    const IS_EXCHANGE_API_CALL_ENABLED = false;
    /**
     * From Email id to be used for Forgot password
     */
    const FROM_EMAIL_ID = 'fouz.sevgili@gmail.com';
    /**
     * Support team name for Qadmni
     */
    const SUPPORT_TEAM_NAME = 'Qadmni Support Team';
    /**
     * Forgot password subject
     */
    const FORGOT_PASSWORD_SUBJECT = 'Qadmni forgot password';
}
