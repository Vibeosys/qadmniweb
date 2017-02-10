<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of OrderParamBuilder
 *
 * @author anand
 */
class OrderParamBuilder {

    /**
     * Creats params required for Order Header Table
     * @param \App\Dto\Requests\InitiateOrderRequestDto $orderInitiationRequest
     * @param \App\Dto\OrderApplicableChargesDto $orderChargeDetails
     * @param \Cake\I18n\Time $deliveryDateTime
     * @param int $customerId
     * @param int $producerId
     * @param \App\Dto\OrderItemPriceDto $itemPriceList 
     * @return \App\Dto\OrderHdrParamsDto
     */
    public static function BuildOrderHeaderParams($orderInitiationRequest, $orderChargeDetails, 
            $deliveryDateTime, $customerId, $producerId, $itemPriceList, $roeRate) {
        //$orderHdrParams = null;
        $orderHdrParams = new \App\Dto\OrderHdrParamsDto();
        $orderHdrParams->customerId = $customerId;
        $orderHdrParams->producerId = $producerId;
        if ($deliveryDateTime == null) {
            $tm = new \Cake\I18n\Time();
            $tm->addMinute(30);
            $orderHdrParams->deliveryDateTime = $tm;
        } else {
            $orderHdrParams->deliveryDateTime = $deliveryDateTime;
        }
        $orderHdrParams->orderSubTotal = $orderChargeDetails->orderSubTotal;
        $orderHdrParams->totalAmountInSAR = round($orderChargeDetails->orderTotalAmount, 2, PHP_ROUND_HALF_UP);
        $orderHdrParams->totalAmountInUSD = round($orderHdrParams->totalAmountInSAR * $roeRate, 2, PHP_ROUND_HALF_UP);
        $orderHdrParams->transStatus = QadmniConstants::TRANSACTION_STATUS_NONE;
        $orderHdrParams->orderStatus = QadmniConstants::ORDER_STATUS_INITIATED;
        $orderHdrParams->deliveryStatus = QadmniConstants::DELIVERY_STATUS_INITIATED;
        $orderHdrParams->isGift = $orderInitiationRequest->isGift == true ? 1 : 0;
        $orderHdrParams->giftMessage = $orderInitiationRequest->giftMessage;
        $transactionRequired = 0;
        if ($orderInitiationRequest->paymentMethod == QadmniConstants::PAYMENT_METHOD_PAYPAL) {
            $transactionRequired = 1;
        }
        $orderHdrParams->transRequired = $transactionRequired;
        $orderHdrParams->orderInitiationRequest = $orderInitiationRequest;
        $totalItemQty = 0;
        foreach ($itemPriceList as $itemRecord) {
            $totalItemQty += $itemRecord->itemQty;
        }
        $orderHdrParams->orderQty = $totalItemQty;

        return $orderHdrParams;
    }

}
