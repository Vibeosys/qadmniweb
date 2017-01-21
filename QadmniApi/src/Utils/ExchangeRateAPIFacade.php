<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of ExchangeRateAPIFacade
 *
 * @author anand
 */
class ExchangeRateAPIFacade {
    /**
     * Structure of the RESPONSE
     * {"success":true,
     * "terms":"https:\/\/currencylayer.com\/terms",
     * "privacy":"https:\/\/currencylayer.com\/privacy",
     * "timestamp":1485008168,
     * "source":"USD",
     * "quotes":{"USDSAR":3.750104}}
     */

    /**
     * Calls Exchange rate api to get latest rates
     * @param float $oldExchangeRate
     * @return \App\Dto\ExchangeRateDto 
     */
    public static function getTodaysExchangeRate($oldExchangeRate) {
        $exchangeRateDto = new \App\Dto\ExchangeRateDto();
        $exchangeRateDto->rate = $oldExchangeRate;
        
        if (!QadmniConstants::IS_EXCHANGE_API_CALL_ENABLED) {
            \Cake\Log\Log::info('Exchange rate API is not enabled');
            return $exchangeRateDto;
        }

        $exchangeRate = $oldExchangeRate;
        $endpoint = QadmniConstants::EXCHANGE_RATE_API_URL;
        // Initialize CURL:
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $exchangeRates = json_decode($json, true);

        // Access the exchange rate values, e.g. SAR:
        $usdToSarRate = $exchangeRates['quotes']['USDSAR'];
        if ($usdToSarRate > 0) {
            $exchangeRate = 1 / $usdToSarRate;
            $exchangeRate = number_format((float) $exchangeRate, 2, '.', '');
        }
        $exchangeRateDto->rate = $exchangeRate;
        $exchangeRateDto->dateUpdated = new \Cake\I18n\Time();
        
        return $exchangeRateDto;
    }

}
