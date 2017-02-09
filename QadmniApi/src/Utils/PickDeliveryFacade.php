<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of PickDeliveryFacade
 *
 * @author anand
 */
class PickDeliveryFacade implements DeliveryInterface {

    const PLACE_ORDER_ENDPOINT = '/orders/';
    const DELIVERY_PROVIDER_ID = 101;

    /**
     * Places order with Pick API
     * @param \App\Dto\DeliveryOrderData\PlaceDeliveryOrderRequestDto $placeOrderRequest
     * @return \App\Dto\DeliveryOrderData\PlaceDeliveryOrderResponseDto 
     */
    public function placeOrder($placeOrderRequest) {
        $pickOrderPlaceRequest = $this->_buildPlaceOrderRequest($placeOrderRequest);
        $placeOrderResponse = null;

        $apiResponse = $this->_sendRequest(self::PLACE_ORDER_ENDPOINT, $pickOrderPlaceRequest, $placeOrderRequest->orderId);
        if ($apiResponse != null) {
            $pickOrderPlaceResponse = \App\Dto\DeliveryOrderData\PickOrderPlaceResponseDto::Deserialize($apiResponse);
            if ($pickOrderPlaceResponse->id != null || $pickOrderPlaceResponse->id != 0) {
                $placeOrderResponse = new \App\Dto\DeliveryOrderData\PlaceDeliveryOrderResponseDto();
                $placeOrderResponse->deliveryRefNo = $pickOrderPlaceResponse->id;
                $placeOrderResponse->deliveryProviderId = self::DELIVERY_PROVIDER_ID;
            }
        }

        return $placeOrderResponse;
    }

    /**
     * Builds place order request for Pick
     * @param \App\Dto\DeliveryOrderData\PlaceDeliveryOrderRequestDto $placeDeliveryOrderRequest
     * @return \App\Dto\DeliveryOrderData\PickOrderPlaceRequestDto
     */
    private function _buildPlaceOrderRequest($placeDeliveryOrderRequest) {
        $pickOrderPlaceRequest = new \App\Dto\DeliveryOrderData\PickOrderPlaceRequestDto();
        $pickOrderPlaceRequest->contact_name = $placeDeliveryOrderRequest->customerName;
        $pickOrderPlaceRequest->pickup_addr = sprintf('%f,%f', $placeDeliveryOrderRequest->vendorLat, $placeDeliveryOrderRequest->vendorLong);
        $pickOrderPlaceRequest->dropoff_addr = sprintf('%f,%f', $placeDeliveryOrderRequest->customerLat, $placeDeliveryOrderRequest->customerLong);
        $pickOrderPlaceRequest->phone = sprintf("%d", $placeDeliveryOrderRequest->customerPhone);
        $pickOrderPlaceRequest->pickup_time = $this->_formatDateTime($placeDeliveryOrderRequest->pickupTime);
        $pickOrderPlaceRequest->dropoff_time = $this->_formatDateTime($placeDeliveryOrderRequest->dropoffTime);
        $pickOrderPlaceRequest->price = $placeDeliveryOrderRequest->price;
        $pickOrderPlaceRequest->items = 'food';
        $pickOrderPlaceRequest->service_type = 'on-demand';
        if ($placeDeliveryOrderRequest->paymentType == QadmniConstants::PAYMENT_METHOD_PAYPAL) {
            $pickOrderPlaceRequest->payment_type = 'Pre-paid';
        } else {
            $pickOrderPlaceRequest->payment_type = 'COD';
        }
        return $pickOrderPlaceRequest;
    }

    /**
     * Formats date and time as per requirement
     * @param \Cake\I18n\Time $dateToFormat
     * @return string
     */
    private function _formatDateTime($dateToFormat) {
        if ($dateToFormat == null)
            return null;

        $formattedTime = $dateToFormat->format('Y-m-d g:i A');
        return $formattedTime;
    }

    private static function _headers() {
        return [ 'headers' =>
            ['X-API-KEY' => QadmniConstants::PICK_API_KEY,
                'Connection' => 'Keep-Alive'],
            'type' => 'json',
            'Accept' => 'application/json'
        ];
    }

    private function _sendRequest($endpoint, $objectData, $orderId) {
        $client = new \Cake\Http\Client();
        $data = json_encode($objectData);
        $url = QadmniConstants::PICK_BASE_URI . $endpoint;
        $options = $this->_headers();

        $httpResponse = null;
        $returnResponse = null;
        $errorOccurred = null;
        $statusCode = 0;
        try {
            $httpResponse = $client->post($url, $data, $options);
            $statusCode = $httpResponse->getStatusCode();
            if ($statusCode == 201) {
                $returnResponse = $httpResponse->json;
            }
        } catch (\Exception $ex) {
            $errorOccurred = $ex->getTraceAsString();
        } finally {
            if ($returnResponse == null) {
                $jsonReceived = json_encode($httpResponse->json);
            }
            \Cake\Log\Log::info('Info received from HTTP response ' . $responseReceived);
            $deliveryLog = new \App\Model\Table\DeliveryLogsTable();
            $deliveryLog->addLog($endpoint, self::DELIVERY_PROVIDER_ID, $orderId, $data, 
                    json_encode($returnResponse), $statusCode, $jsonReceived . ' | ' . $errorOccurred);
        }

        return $returnResponse;
    }

}

interface DeliveryInterface {

    /**
     * Places order with respective APIs
     * @param \App\Dto\DeliveryOrderData\PlaceDeliveryOrderRequestDto $placeOrderRequest
     * @return \App\Dto\DeliveryOrderData\PlaceDeliveryOrderResponseDto 
     */
    function placeOrder($placeOrderRequest);
}
