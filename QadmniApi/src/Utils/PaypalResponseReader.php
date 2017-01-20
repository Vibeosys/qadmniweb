<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of PaypalResponseReader
 *
 * @author anand
 */
class PaypalResponseReader {
    
    /**
     * Reads paypal response from paypal and returns an object
     * @param string $paypalId
     * @return \App\Dto\PaypalTransactionDto
     */
    public static function readPaypalResponse($paypalId){
        $paypalResponse = new \App\Dto\PaypalTransactionDto();
        $paypalCaller = QadmniUtils::buildPaypalCaller();

        $credentials = new \PayPal\Auth\OAuthTokenCredential($paypalCaller->clientId, $paypalCaller->secretKey);
        $apiContext = new \PayPal\Rest\ApiContext($credentials);
        $paypalPayment = new \PayPal\Api\Payment();
        $paymentInfo = $paypalPayment->get($paypalId, $apiContext);
        $paymentState = $paymentInfo->getState();

        $payer = $paymentInfo->getPayer();
        $paypalResponse->paymentMethod = $payer->getPaymentMethod();
        
        $transactions = $paymentInfo->getTransactions();
        foreach ($transactions as $paypalTransaction) {
            $paypalResponse->qadmniTransId = $paypalTransaction->getInvoiceNumber();
        }
        if ($paymentState == 'approved') {
            $paypalResponse->isApproved = true;
        } else {
            $paypalResponse->isApproved = false;
        }
        $paypalResponse->paypalId = $paypalId;
        
        return $paypalResponse;
    }
}
