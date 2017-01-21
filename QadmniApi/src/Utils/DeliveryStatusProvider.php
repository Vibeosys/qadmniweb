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

}
