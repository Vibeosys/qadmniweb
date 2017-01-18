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
        //Prepare item with price and qty
        $totalOrderAmount = $this->prepareOrderItemList($ItemPriceList, $orderInitiationRequest->productInfo);
        //Get charges available
        $chargeMasterTable = new \App\Model\Table\ChargeMasterTable();
        $orderChargeList = $chargeMasterTable->getAllCharges();
        //Call provider engine to provide detail breakup of charges to be levied
        $orderChargeDetails = \App\Utils\OrderChargeProvider::provideApplicableCharges($totalOrderAmount, $orderChargeList, 
                $orderInitiationRequest->deliveryMethod, $orderInitiationRequest->paymentMethod);

        //Build final response object
        $initiateOrderResponse = new \App\Dto\Responses\InitiateOrderResponseDto();
        $initiateOrderResponse->chargeBreakup = $orderChargeDetails->chargeDetailBreakup;
        $initiateOrderResponse->orderId = 0;
        $initiateOrderResponse->orderedItems = $ItemPriceList;
        $initiateOrderResponse->totalAmount = $orderChargeDetails->orderTotalAmount;

        $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(210, $initiateOrderResponse));
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
        //$itemRecordCounter = 0;
        foreach ($orderItems as $orderItem) {
            array_push($itemIdList, $orderItem->itemId);
            //$itemIdList[$itemRecordCounter++] = $orderItem->itemId;
        }
        return $itemIdList;
    }

}
