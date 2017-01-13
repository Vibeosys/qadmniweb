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

    /**
     * Usage: App_Updater_String_Util::utf8_encode( $data );
     *
     * @param mixed $d
     * @return mixed
     * @see http://stackoverflow.com/questions/19361282/why-would-json-encode-returns-an-empty-string
     */
    public static function utf8_encode($d) {
        if (is_array($d)) {
            foreach ($d as $k => $v) {
                $d[$k] = self::utf8_encode($v);
            }
        } elseif (is_object($d)) {
            foreach ($d as $k => $v) {
                $d->$k = self::utf8_encode($v);
            }
        } elseif (is_scalar($d)) {
            $d = \utf8_encode($d);
        }

        return $d;
    }

    protected static $errorDictionary = [
        101 => "No categories found",
        102 => "No items found for the provided category",
        103 => "Merchant registration failed, please try again later"
    ];
    protected static $successDictionary = [
        201 => "List of categories",
        202 => "List of items",
        203 => "Merchant registered successfully"
    ];

}
