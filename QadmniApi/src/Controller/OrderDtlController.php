<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * OrderDtl Controller
 *
 * @property \App\Model\Table\OrderDtlTable $OrderDtl
 */
class OrderDtlController extends AppController {

    public function getOrderItemDetails() {
        $this->apiInitialize();
        //Validate customer first
        $isCustomerValidated = $this->validateCustomer();
        if (!$isCustomerValidated) {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(112));
            return;
        }

        $orderItemDetailsRequest = \App\Dto\Requests\OrderItemDetailsRequestDto::Deserialize($this->postedData);
        $orderItemsDetails = $this->OrderDtl->getOrderItemDetails($orderItemDetailsRequest->orderId, $this->languageCode);

        if (count($orderItemsDetails) > 0) {
            $this->response->body(\App\Utils\ResponseMessages::prepareJsonSuccessMessage(224, $orderItemsDetails));
        } else {
            $this->response->body(\App\Utils\ResponseMessages::prepareError(129));
        }
    }

}
