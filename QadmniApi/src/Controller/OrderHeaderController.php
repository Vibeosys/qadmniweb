<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderHeader Controller
 *
 * @property \App\Model\Table\OrderHeaderTable $OrderHeader
 */
class OrderHeaderController extends AppController {

    public function getLiveOrderList() {
        $this->apiInitialize();

        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $liveOrderList = $this->OrderHeader->getLiveOrderList($this->postedCustomerData->customerId, $this->languageCode);
        \App\Utils\DeliveryStatusProvider::provideStatus($liveOrderList);

        if ($liveOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(213, $liveOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(118));
        }
    }

    public function getPastOrderList() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $pastOrderList = $this->OrderHeader->getPastOrderList($this->postedCustomerData->customerId, $this->languageCode);
        \App\Utils\DeliveryStatusProvider::providePastDeliveryStatus($pastOrderList);

        if ($pastOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(214, $pastOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(119));
        }
    }

    public function getVendorOrders() {
        $this->apiInitialize();
        $isProducerValidated = $this->validateProducer();
        if (!$isProducerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(104));
            return;
        }

        $vendorOrderList = $this->OrderHeader->getVendorOrderList();
        \App\Utils\DeliveryStatusProvider::provideDeliveryStatusForVendorList($vendorOrderList);
        if ($vendorOrderList) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(215, $vendorOrderList));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(120));
        }
    }

    public function updateDeliveryStatus() {
        $this->apiInitialize();
        $isProducerValidated = $this->validateProducer();
        if (!$isProducerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(104));
            return;
        }

        $isDelivered = false;
        $orderStatusUpdateRequest = \App\Dto\Requests\OrderStatusUpdateRequestDto::Deserialize($this->postedData);
        $completionDeliveryStatusList = \App\Utils\DeliveryStatusProvider::getDeliveredStatusList();
        //update is delivered flag if the status update is one of them
        if (in_array($orderStatusUpdateRequest->deliveryStatusId, $completionDeliveryStatusList)) {
            $isDelivered = true;
        }
        $statusUpdated = $this->OrderHeader->updateDeliveryStatus
                ($orderStatusUpdateRequest->orderId, $orderStatusUpdateRequest->deliveryStatusId, $isDelivered);
        if ($statusUpdated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(218));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(123));
        }
    }

    public function getOrderItemList() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }
        $orderItemDetailRequest = \App\Dto\Requests\OrderItemDetailsRequestDto::Deserialize($this->postedData);

        //Call the order details
        $orderDetailResponse = $this->OrderHeader->getOrderChargeDetails($orderItemDetailRequest->orderId);
        if ($orderDetailResponse) {
            $orderDetailTable = new \App\Model\Table\OrderDtlTable();
            //Get the items for the order then proceed further
            $orderDetails = $orderDetailTable->getOrderItems($orderItemDetailRequest->orderId, $this->languageCode);
            if ($orderDetails) {
                $orderDetailResponse->items = $orderDetails;
            }
        }

        if ($orderDetailResponse != null && $orderDetailResponse->items != null) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(223, $orderDetailResponse));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(131));
        }
    }

}
