<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of DeliveryStatusProvider
 *
 * @author anand
 */
class DeliveryStatusProvider {

    /**
     * Delivery completion status id list
     * @return array
     */
    public static function getDeliveredStatusList() {
        return [
            QadmniConstants::DELIVERY_STATUS_DELIVERED,
            QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE,
            QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP
        ];
    }

    /**
     * Modifies the status to be sent with each order
     * @param \App\Dto\Responses\LiveOrderResponseDto $liveOrderList
     */
    public static function provideStatus($liveOrderList) {
        $deliveryInitiatedList = array(
            QadmniConstants::DELIVERY_STATUS_INITIATED,
            QadmniConstants::DELIVERY_STATUS_REQUESTED
        );
        $deliveryInProcess = QadmniConstants::DELIVERY_STATUS_IN_PROCESS;
        $pickupInitiated = QadmniConstants::DELIVERY_STATUS_PICKUP_REQUESTED;
        foreach ($liveOrderList as $liveOrder) {
            //For home delivery
            if ($liveOrder->deliveryMode == QadmniConstants::DELIVERY_METHOD_HOME_DELIVERY) {
                if (in_array($liveOrder->deliveryStatus, $deliveryInitiatedList)) {
                    $liveOrder->currentStatusCode = 'ORDER_PLACED_CODE';
                    $liveOrder->stageNo = 1;
                } else if ($liveOrder->deliveryStatus == $deliveryInProcess) {
                    $liveOrder->currentStatusCode = 'DELIVERY_IN_PROGRESS';
                    $liveOrder->stageNo = 2;
                } else if ($liveOrder->deliveryStatus == QadmniConstants::DELIVERY_STATUS_DELIVERED) {
                    $liveOrder->stageNo = 3;
                    $liveOrder->currentStatusCode = 'DELIVERED';
                }
            }

            //For pickup
            if ($liveOrder->deliveryMode == QadmniConstants::DELIVERY_METHOD_PICKUP) {
                if (in_array($liveOrder->deliveryStatus, $deliveryInitiatedList)) {
                    $liveOrder->currentStatusCode = 'ORDER_PLACED_CODE';
                    $liveOrder->stageNo = 1;
                }
                if ($liveOrder->deliveryStatus == $pickupInitiated) {
                    $liveOrder->currentStatusCode = 'READY_TO_PICKUP';
                    $liveOrder->stageNo = 2;
                } else if ($liveOrder->deliveryStatus == QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE) {
                    $liveOrder->currentStatusCode = 'PICKUP_COMPLETE';
                    $liveOrder->stageNo = 3;
                } else if ($liveOrder->deliveryStatus == QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP) {
                    $liveOrder->currentStatusCode = 'TIME_FOR_PICKUP_OVER';
                    $liveOrder->stageNo = 3;
                }
            }
        }
    }

    /**
     * Gets list of past orders
     * @param \App\Dto\Responses\PastOrderListResponseDto $pastOrderList
     */
    public static function providePastDeliveryStatus($pastOrderList) {
        foreach ($pastOrderList as $pastOrderRecord) {
            if ($pastOrderRecord->deliveryStatusCode == QadmniConstants::DELIVERY_STATUS_DELIVERED) {
                $pastOrderRecord->deliveryStatus = "DELIVERY_COMPLETE";
            }
            if ($pastOrderRecord->deliveryStatusCode == QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE) {
                $pastOrderRecord->deliveryStatus = "PICKUP_COMPLETE";
            }
            if ($pastOrderRecord->deliveryStatusCode == QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP) {
                $pastOrderRecord->deliveryStatus = 'TIME_FOR_PICKUP_OVER';
            }
        }
    }

    /**
     * Provides status and stage for the deliveries
     * @param \App\Dto\Responses\VendorOrderListResponseDto $orderList
     */
    public static function provideDeliveryStatusForVendorList($orderList) {
        $deliveryInitiatedList = array(
            QadmniConstants::DELIVERY_STATUS_INITIATED,
            QadmniConstants::DELIVERY_STATUS_REQUESTED
        );
        $deliveryInProcess = QadmniConstants::DELIVERY_STATUS_IN_PROCESS;
        $pickupInitiated = QadmniConstants::DELIVERY_STATUS_PICKUP_REQUESTED;
        foreach ($orderList as $order) {
            $sanitizedPaymentMethod = str_replace('_', ' ', $order->paymentMethod);
            $paymentMethod = ucfirst($sanitizedPaymentMethod);
            $order->paymentMethod = $paymentMethod;

            $order->canUpdateStatus = false;

            //For home delivery
            if ($order->deliveryMethod == QadmniConstants::DELIVERY_METHOD_HOME_DELIVERY) {
                $order->deliveryType = 'HOME_DELIVERY';
                if (in_array($order->deliveryStatusId, $deliveryInitiatedList)) {
                    $order->currentStatusCode = 'ORDER_PLACED_CODE';
                    $order->stageNo = 1;
                } else if ($order->deliveryStatusId == $deliveryInProcess) {
                    $order->currentStatusCode = 'DELIVERY_IN_PROGRESS';
                    $order->stageNo = 2;
                } else if ($order->deliveryStatusId == QadmniConstants::DELIVERY_STATUS_DELIVERED) {
                    $order->stageNo = 3;
                    $order->currentStatusCode = 'DELIVERED';
                }
            }

            //For pickup
            if ($order->deliveryMethod == QadmniConstants::DELIVERY_METHOD_PICKUP) {
                $order->deliveryType = 'PICKUP';
                if (in_array($order->deliveryStatusId, $deliveryInitiatedList)) {
                    $order->canUpdateStatus = true;
                    /* $order->updatableStatusCodes = ['READY_TO_PICKUP',
                      'PICKUP_COMPLETE', 'TIME_FOR_PICKUP_OVER']; */
                    $order->updatableStatusCodes = [
                        new \App\Dto\UpdatableStatusCodeDto(QadmniConstants::DELIVERY_STATUS_PICKUP_REQUESTED, 'READY_TO_PICKUP'),
                        new \App\Dto\UpdatableStatusCodeDto(QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE, 'PICKUP_COMPLETE'),
                        new \App\Dto\UpdatableStatusCodeDto(QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP, 'TIME_FOR_PICKUP_OVER')
                    ];
                    $order->currentStatusCode = 'ORDER_PLACED_CODE';
                    $order->stageNo = 1;
                }
                if ($order->deliveryStatusId == $pickupInitiated) {
                    $order->canUpdateStatus = true;
                    $order->updatableStatusCodes = [
                        new \App\Dto\UpdatableStatusCodeDto(QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE, 'PICKUP_COMPLETE'),
                        new \App\Dto\UpdatableStatusCodeDto(QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP, 'TIME_FOR_PICKUP_OVER')
                    ];
                    $order->currentStatusCode = 'READY_TO_PICKUP';
                    $order->stageNo = 2;
                } else if ($order->deliveryStatusId == QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE) {
                    $order->currentStatusCode = 'PICKUP_COMPLETE';
                    $order->stageNo = 3;
                } else if ($order->deliveryStatusId == QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP) {
                    $order->currentStatusCode = 'TIME_FOR_PICKUP_OVER';
                    $order->stageNo = 3;
                }
            }
        }
    }
    
    /**
     * Updates tracking order
     * @param \App\Dto\Responses\TrackOrderResponseDto $trackingOrderResponse
     */
    public static function provideTrackingStatus($trackingOrderResponse){
        $deliveryInitiatedList = array(
            QadmniConstants::DELIVERY_STATUS_INITIATED,
            QadmniConstants::DELIVERY_STATUS_REQUESTED
        );
        $deliveryInProcess = QadmniConstants::DELIVERY_STATUS_IN_PROCESS;
        $pickupInitiated = QadmniConstants::DELIVERY_STATUS_PICKUP_REQUESTED;
        //For home delivery
            if ($trackingOrderResponse->deliveryMode == QadmniConstants::DELIVERY_METHOD_HOME_DELIVERY) {
                if (in_array($trackingOrderResponse->deliveryStatus, $deliveryInitiatedList)) {
                    $trackingOrderResponse->currentStatusCode = 'ORDER_PLACED_CODE';
                    $trackingOrderResponse->stageNo = 1;
                } else if ($trackingOrderResponse->deliveryStatus == $deliveryInProcess) {
                    $trackingOrderResponse->currentStatusCode = 'DELIVERY_IN_PROGRESS';
                    $trackingOrderResponse->stageNo = 2;
                } else if ($trackingOrderResponse->deliveryStatus == QadmniConstants::DELIVERY_STATUS_DELIVERED) {
                    $trackingOrderResponse->stageNo = 3;
                    $trackingOrderResponse->currentStatusCode = 'DELIVERED';
                }
            }

            //For pickup
            if ($trackingOrderResponse->deliveryMode == QadmniConstants::DELIVERY_METHOD_PICKUP) {
                if (in_array($trackingOrderResponse->deliveryStatus, $deliveryInitiatedList)) {
                    $trackingOrderResponse->currentStatusCode = 'ORDER_PLACED_CODE';
                    $trackingOrderResponse->stageNo = 1;
                }
                if ($trackingOrderResponse->deliveryStatus == $pickupInitiated) {
                    $trackingOrderResponse->currentStatusCode = 'READY_TO_PICKUP';
                    $trackingOrderResponse->stageNo = 2;
                } else if ($trackingOrderResponse->deliveryStatus == QadmniConstants::DELIVERY_STATUS_PICKUP_COMPLETE) {
                    $trackingOrderResponse->currentStatusCode = 'PICKUP_COMPLETE';
                    $trackingOrderResponse->stageNo = 3;
                } else if ($trackingOrderResponse->deliveryStatus == QadmniConstants::DELIVERY_STATUS_NOT_PICKED_UP) {
                    $trackingOrderResponse->currentStatusCode = 'TIME_FOR_PICKUP_OVER';
                    $trackingOrderResponse->stageNo = 3;
                }
            }
    }

}
