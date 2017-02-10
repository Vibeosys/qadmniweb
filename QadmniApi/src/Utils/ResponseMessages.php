<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of ResponseMessages
 *
 * @author anand
 */
class ResponseMessages {

    //format {"errorCode":"100", "message":"User is not authenticated"}
    public static function prepareError($errorcode) {
        $baseResponse = new \App\Dto\BaseResponseDto();
        $baseResponse->errorCode = $errorcode;
        $baseResponse->message = self::$errorDictionary[$errorcode];
        return json_encode($baseResponse);
    }

    public static function prepareSuccessMessage($successCode, $data = null) {
        $baseResponse = new \App\Dto\BaseResponseDto();
        $baseResponse->errorCode = 0;
        $baseResponse->message = self::$successDictionary[$successCode];
        $baseResponse->data = $data;
        return json_encode($baseResponse);
    }

    public static function prepareJsonSuccessMessage($successCode, $data = null) {
        $baseResponse = new \App\Dto\BaseResponseDto();
        $baseResponse->errorCode = 0;
        $baseResponse->message = self::$successDictionary[$successCode];
        $baseResponse->data = $data != null ? json_encode($data, JSON_UNESCAPED_UNICODE) : "";
        return json_encode($baseResponse);
    }

    protected static $errorDictionary = [
        101 => "No categories found",
        102 => "No items found for the provided category",
        103 => "Merchant registration failed, please try again later",
        104 => "Sorry, authentication failed, please try again",
        105 => "Sorry, You are not authorised for this operation, please login again",
        106 => "You haven't added any products yet, Go ahead add new products",
        107 => "Sorry, registration failed, please try again",
        108 => "This email already exists, try using another one or use forgot password",
        109 => "Sorry, login was not successful, please try again",
        110 => "Product could not be added at this moment, please try again",
        111 => "Image could not be uploaded, please try again later",
        112 => "You are not authorized for this request, please login and try again",
        113 => "Cart cannot have products from different merchants",
        114 => "Sorry, error occurred while processing your request, please try again",
        115 => "Sorry, something went wrong, please try again with fresh order",
        116 => "This transaction requires paypal id, please provide and proceed",
        117 => "Order status has to be pending and transaction status to be initiated",
        118 => "No live orders found, please order now",
        119 => "You do not have any past orders, order now",
        120 => "Sorry, No orders found",
        121 => "Sorry, we could not find your email id in our records",
        122 => "Sorry, this email id is already registered with us",
        123 => "Delivery status could not be updated, please try again later",
        124 => "Sorry, product information could not be updated, please try again",
        125 => "Last favorite operation was unsuccessful, please try again",
        126 => "Product could not be removed from your favorites",
        127 => "There are no favorite items, please add one now",
        128 => "No details found for the requested product",
        129 => "No products found for the requested order",
        130 => "Sorry, could not submit the feedback, please try again",
        131 => "No products found in the requested order",
        132 => "Sorry, profile could not be updated, please try again",
        133 => "Sorry, the transaction was denied, please try again with fresh order"
    ];
    
    protected static $successDictionary = [
        201 => "List of categories",
        202 => "List of items",
        203 => "Merchant registered successfully",
        204 => "Merchant logged in successfully",
        205 => "List of items for a provided Merchant id",
        206 => "You have registered successfully",
        207 => "You have logged in successfully",
        208 => "Product added successfully",
        209 => "Image for the product added or updated successfully",
        210 => "Order initiated successfully, please proceed to confirmation",
        211 => "Order is processed successfully, please confirm to proceed further",
        212 => "Yalla! your order is confirmed",
        213 => "LIVE order deliveries",
        214 => "Past order deliveries",
        215 => "Deliveries for Producer",
        216 => "Password has been sent on your registered email id",
        217 => "Email Id does not exist, go ahead",
        218 => "Order status updated successfully",
        219 => "Product information updated successfully",
        220 => "Last favorite operation was successful",
        221 => "Product has been removed from your favorites",
        222 => "List of favorite items",
        223 => "Item details",
        224 => "Product list for the provided order",
        225 => "Feedback submitted successfully",
        226 => "Profile updated successfully"
    ];

}
