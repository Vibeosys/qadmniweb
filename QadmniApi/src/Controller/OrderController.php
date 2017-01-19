<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;

/**
 * Description of OrderController
 *
 * @author anand
 */
class OrderController extends AppController {

    //put your code here

    public function initiateOrder() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        //Now calculate pricing for order
        $orderInitiationRequest = \App\Dto\Requests\InitiateOrderRequestDto::Deserialize($this->postedData);
        $itemMasterTable = new \App\Model\Table\ItemMasterTable();
        //Prepare item id list from request
        $itemIdList = $this->prepareItemList($orderInitiationRequest->productInfo);
        //Fetch details of the items from db
        $ItemPriceList = $itemMasterTable->getItemDetails($itemIdList, $this->languageCode);
        //Verify if all the items have same producer
        $producerId = $this->verifyItemProducer($ItemPriceList);

        //If producer is zero then throw an error
        if ($producerId == 0) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(113));
            return;
        }
        //Prepare item with price and qty
        $totalOrderAmount = $this->prepareOrderItemList($ItemPriceList, $orderInitiationRequest->productInfo);
        //Get charges available
        $chargeMasterTable = new \App\Model\Table\ChargeMasterTable();
        $orderChargeList = $chargeMasterTable->getAllCharges();
        //Call provider engine to provide detail breakup of charges to be levied
        $orderChargeDetails = \App\Utils\OrderChargeProvider::provideApplicableCharges($totalOrderAmount, $orderChargeList, $orderInitiationRequest->deliveryMethod, $orderInitiationRequest->paymentMethod);

        //Set delivery date time
        $deliveryDateTime = null;
        if (!is_null($orderInitiationRequest->deliverySchedule) || $orderInitiationRequest->deliverySchedule != '') {
            $deliveryDateTime = \App\Utils\QadmniUtils::convertFromTimestampToDate
                            ($orderInitiationRequest->deliverySchedule);
        }
        //Get latest Rate Of Exchange from database.
        $roeTable = new \App\Model\Table\RateOfExchangeTable();
        $roeRecord = $roeTable->getLastUpdatedROE();

        //Build params and add to table entries
        $orderHdrParams = \App\Utils\OrderParamBuilder::BuildOrderHeaderParams($orderInitiationRequest, 
                $orderChargeDetails, $deliveryDateTime, $this->postedCustomerData->customerId, 
                $producerId, $ItemPriceList, $roeRecord->rate);
        $orderHeaderTable = new \App\Model\Table\OrderHeaderTable();
        $orderId = $orderHeaderTable->addNewOrder($orderHdrParams);
        //If order id is not generated, then throw error to customer
        if ($orderId == 0) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(114));
            return;
        }

        $orderDtl = new \App\Model\Table\OrderDtlTable();
        $ordersAdded = $orderDtl->addNewOrders($orderId, $ItemPriceList);

        $orderChargeTable = new \App\Model\Table\OrderChargesTable();
        $chargesAdded = $orderChargeTable->addOrderCharges($orderId, $orderChargeDetails->chargeDetailBreakup);

        //Build final response object
        $initiateOrderResponse = new \App\Dto\Responses\InitiateOrderResponseDto();
        $initiateOrderResponse->chargeBreakup = $orderChargeDetails->chargeDetailBreakup;
        $initiateOrderResponse->orderId = $orderId;
        $initiateOrderResponse->orderedItems = $ItemPriceList;
        $initiateOrderResponse->totalAmountInSAR = $orderHdrParams->totalAmountInSAR;
        $initiateOrderResponse->totalAmountInUSD = $orderHdrParams->totalAmountInUSD;

        $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(210, $initiateOrderResponse));
    }

    public function processOrder() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $processOrderRequest = \App\Dto\Requests\ProcessOrderRequestDto::Deserialize($this->postedData);
        $orderHdrTable = new \App\Model\Table\OrderHeaderTable();
        //Get the order details from db and verify if those are correct.
        $orderDetails = $orderHdrTable->getOrderDetails($processOrderRequest->orderId, $this->postedCustomerData->customerId);

        if (!$orderDetails) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(114));
            return;
        }

        //Validate if the values are matching
        $orderAmtMatch = $orderDetails->orderAmountInSAR == $processOrderRequest->orderAmountInSAR;
        $orderAmtUsdMatch = $orderDetails->orderAmountInUSD == $processOrderRequest->orderAmountInUSD;
        $orderStatusMatch = $orderDetails->orderStatus == \App\Utils\QadmniConstants::ORDER_STATUS_INITIATED;
        //If db values are matching with request values then go ahead else throw error
        if ($orderAmtMatch && $orderAmtUsdMatch && $orderStatusMatch) {
            //Update the order status to pending
            $statusUpdated = $orderHdrTable->updateOrderStatus($processOrderRequest->orderId, 
                    \App\Utils\QadmniConstants::ORDER_STATUS_PENDING);

            if (!$statusUpdated) {
                \Cake\Log\Log::error('Order status not updated for order ' . $processOrderRequest->orderId);
            }

            $paymentTable = new \App\Model\Table\PaymentsTable();
            $transactionId = \App\Utils\QadmniUtils::generateTransactionId($this->postedCustomerData->customerId, 
                    $orderDetails->orderId);
            //Create new transaction
            $transactionCreationSuccess = $paymentTable->addNewTransaction($transactionId, $orderDetails->orderId, 
                    $orderDetails->orderAmountInUSD);

            if (!$transactionCreationSuccess) {
                \Cake\Log\Log::error('Transaction could not be created for trans id ' . $transactionId);
            }

            //build response object now
            $processOrderResponse = new \App\Dto\Responses\ProcessOrderResponseDto();
            $processOrderResponse->amount = $orderDetails->orderAmountInUSD;
            $processOrderResponse->currency = \App\Utils\QadmniConstants::PAYMENT_CURRENCY;
            $processOrderResponse->orderId = $orderDetails->orderId;
            $processOrderResponse->transactionId = $transactionId;
            $processOrderResponse->transactionRequired = $orderDetails->transactionRequired;

            //If the transaction is required then go ahead and add paypal information
            if ($orderDetails->transactionRequired) {
                $paypalInfo = \App\Utils\QadmniUtils::buildPaypalInfo($orderDetails->orderAmountInUSD);
                $processOrderResponse->paypalEnvValues = $paypalInfo;
            }
            
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(211, $processOrderResponse));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(115));
        }
    }

    /**
     * Prepares order item list by passing item price list by reference
     * @param \App\Dto\OrderItemPriceDto $itemPriceList
     * @param \App\Dto\OrderItemDto $itemQtyList
     * @return double
     */
    private function prepareOrderItemList(&$itemPriceList, $itemQtyList) {
        $totalAmount = 0;
        foreach ($itemPriceList as $itemRecord) {
            foreach ($itemQtyList as $itemRequested) {
                if ($itemRequested->itemId == $itemRecord->itemId) {
                    $itemRecord->itemQty = $itemRequested->itemQty;
                    $itemRecord->itemTotalPrice = $itemRequested->itemQty * $itemRecord->unitPrice;
                    break;
                }
            }
            $totalAmount += $itemRecord->itemTotalPrice;
        }
        return $totalAmount;
    }

    /**
     * Prepares list of item id
     * @param \App\Dto\OrderItemDto[] $orderItems
     * @return int[] $itemIdList array
     */
    private function prepareItemList($orderItems) {
        $itemIdList = [];
        foreach ($orderItems as $orderItem) {
            array_push($itemIdList, $orderItem->itemId);
        }
        return $itemIdList;
    }

    /**
     * Verifies the producer id of all items and if differ then return 0
     * @param \App\Dto\OrderItemPriceDto $itemPriceList
     */
    private function verifyItemProducer($itemPriceList) {
        $producerId = -1;
        foreach ($itemPriceList as $itemRecord) {
            if ($producerId == -1) {
                $producerId = $itemRecord->producerId;
            } else if ($producerId != $itemRecord->producerId) {
                $producerId = 0;
            }
        }
        return $producerId;
    }

}
