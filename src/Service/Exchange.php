<?php

namespace App\Service;

class Exchange {

	public function __construct(private string $exchangeRatesFile) {}

    public function getExchangeRates(): ?array {

        try {
            $exchangeDetails = file_get_contents($this->exchangeRatesFile);
            $exchangeDetailsDecoded = json_decode($exchangeDetails, true, JSON_THROW_ON_ERROR);
            $exchangeRates = $exchangeDetailsDecoded['rates'];

        } catch (Exception $e){
            throw new RatesUnreachable;
        }

        return $exchangeRates;
    }

}