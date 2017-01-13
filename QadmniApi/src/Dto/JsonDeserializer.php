<?php

namespace App\Dto;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonDeserializer
 *
 * @author Anand
 */
abstract class JsonDeserializer {

    public static function Deserialize($json) {

        $className = get_called_class();
        $classInstance = new $className();
        if (is_string($json)) {
            $json = json_decode($json);
        }
        foreach ($json as $key => $value) {
            if (!property_exists($classInstance, $key)) {
                continue;
            }

            $classInstance->{$key} = $value;
        }
        return $classInstance;
    }

    public static function DeserializeArray($json) {
        $json = json_decode($json);
        $items = [];
        foreach ($json as $item) {
            $items[] = self::Deserialize($item);
        }
        return $items;
    }

}
