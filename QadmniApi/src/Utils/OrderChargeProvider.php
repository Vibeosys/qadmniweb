<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of OrderChargeProvider
 *
 * @author anand
 */
class OrderChargeProvider {

    /**
     * Provides charges with list of applicable items
     * @param float $itemOrderAmount
     * @param \App\Dto\OrderChargeDto $orderChargeList
     * @param string $deliveryMethod
     * @param string $paymentMethod
     * @return \App\Dto\OrderApplicableChargesDto 
     */
    public static function provideApplicableCharges($itemOrderAmount, $orderChargeList, 
            $deliveryMethod, $paymentMethod) {
        $orderApplicableCharges = new \App\Dto\OrderApplicableChargesDto();

        //Filter charge types applicable for the payment n delivery
        $applicableChargeTypes = static::filterApplicableCharges($deliveryMethod, $paymentMethod);
        $chargeBreakupList = [];
        $totalSurchargeAmount = 0;

        //Iterate through all the charge types and add only relevant charges
        foreach ($orderChargeList as $orderCharge) {
            if (in_array($orderCharge->chargeType, $applicableChargeTypes)) {
                $calculatedAmount = static::calculateCharges($itemOrderAmount, $orderCharge->percentage, $orderCharge->amount);
                $totalSurchargeAmount += $calculatedAmount;

                //Create final breakup DTO
                $chargeDetailBreakup = new \App\Dto\ChargeDetailBreakupDto();
                $chargeDetailBreakup->chargeId = $orderCharge->chargeId;
                $chargeDetailBreakup->chargeDetails = $orderCharge->chargeDetails;
                $chargeDetailBreakup->amount = $calculatedAmount;

                array_push($chargeBreakupList, $chargeDetailBreakup);
            }
        }

        //Create response DTO with amount and breakup list
        $orderApplicableCharges->orderSubTotal = $itemOrderAmount;
        $orderApplicableCharges->orderTotalAmount = $itemOrderAmount + $totalSurchargeAmount;
        $orderApplicableCharges->chargeDetailBreakup = $chargeBreakupList;

        return $orderApplicableCharges;
    }

    /**
     * Calculates amount based on percentage and amount to be levied
     * @param float $orderAmount
     * @param float $percentage
     * @param float $chargeAmount
     * @return float
     */
    private static function calculateCharges($orderAmount, $percentage, $chargeAmount) {
        $calculatedAmount = 0;
        if ($percentage > 0) {
            $calculatedAmount = ($orderAmount * $percentage) / 100;
        } else {
            $calculatedAmount = $chargeAmount;
        }
        return $calculatedAmount;
    }

    /**
     * Filters applicable charge TYPES based on payment method and delivery method
     * @param string $deliveryMethod
     * @param string $paymentMethod
     * @return array
     */
    private static function filterApplicableCharges($deliveryMethod, $paymentMethod) {
        $applicableChargeTypes = [];

        array_push($applicableChargeTypes, QadmniConstants::CHARGE_TYPE_MANDATORY);

        if ($deliveryMethod == QadmniConstants::DELIVERY_METHOD_HOME_DELIVERY) {
            switch ($paymentMethod) {
                case QadmniConstants::PAYMENT_METHOD_CASH:
                    array_push($applicableChargeTypes, QadmniConstants::CHARGE_TYPE_CASH_ON_DELIVERY);
                    break;
                case QadmniConstants::PAYMENT_METHOD_PAYPAL:
                    array_push($applicableChargeTypes, QadmniConstants::CHARGE_TYPE_PREPAID_DELIVERY);
                    break;
            }
        }

        if ($paymentMethod == QadmniConstants::PAYMENT_METHOD_PAYPAL) {
            array_push($applicableChargeTypes, QadmniConstants::CHARGE_TYPE_ONLINE);
        }
        return $applicableChargeTypes;
    }

}
