<?php

namespace App\Model\Entity;

class Exchange {

	CONST EXCHANGE_RATES_PATH = "http://api.exchangeratesapi.io/latest?access_key=83e75e5b7793d79b4b7087dfab274276";
    CONST EXCHANGE_RATES_FILE = "rates.json"; // I use this for tests, because the API has a limitation reach (500 call per month)


    public function getExchangeRates(): ?array {

        try {
            $exchangeDetails = file_get_contents(self::EXCHANGE_RATES_FILE);
            $exchangeDetailsDecoded = json_decode($exchangeDetails, true, JSON_THROW_ON_ERROR);
            $exchangeRates = $exchangeDetailsDecoded['rates'];

        } catch (Exception $e){
            throw new RatesUnreachable;
        }

        return $exchangeRates;
    }

}
