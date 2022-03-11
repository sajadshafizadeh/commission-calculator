<?php

namespace App\Service;

use App\Entity;

class Exchange {

	public function __construct(private string $exchangeRatesFile, private string $binDetailsBaseUrl) {}

    public function getRates(): ?array {

        try {
            $exchangeDetails = file_get_contents($this->exchangeRatesFile);
            $exchangeDetailsDecoded = json_decode($exchangeDetails, true, JSON_THROW_ON_ERROR);
            $exchangeRates = $exchangeDetailsDecoded['rates'];

        } catch (Exception $e){
            throw new RatesUnreachable;
        }

        return $exchangeRates;
    }

    public function loadBinDetails(Entity\Transaction $transaction): void {

    	try {

			$binDetailsContent = file_get_contents($this->binDetailsBaseUrl . $transaction->getBin());
			
			if($binDetailsContent === false || empty($binDetailsContent)) {
				throw new Exception\BinDetailsUnreachable();
			}
			
			$transaction->setBinDetails(json_decode($binDetailsContent, true, JSON_THROW_ON_ERROR));

		} catch (Exception $e){
            throw new $e->getMessage();
        }
    }

}