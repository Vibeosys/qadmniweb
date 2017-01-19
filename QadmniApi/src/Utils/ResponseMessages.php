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
        113 => "Cart cannot products from different merchants",
        114 => "Sorry, error occurred while processing your request, please try again"
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
        210 => "Order initiated successfully, please pay and confirm"
    ];

}
