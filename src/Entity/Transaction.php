<?php

namespace App\Entity;

class Transaction {

	private $binDetails;

	public function __construct(private int $bin, private float $amount, private string $currency){}

	public function isFromEU() : bool {

		// To part the result, Get the country name (card-issuer) 
		$cardIssuerCoutnryName = $this->getBinBelongsToCountry();

		// To check if the country is one of the European ones
		return in_array($cardIssuerCoutnryName, self::EUROPE_CONTRIES);
	}

	public function getBin() : string {
		return $this->bin;
	}

	public function getAmount() : string {
		return $this->amount;
	}

	public function getCurrency() : string {
		return $this->currency;
	}

	public function setBinDetails($details) : void {
		$this->binDetails = $details;
	}

	private function getBinBelongsToCountry() : ?string {
		return $this->binDetails['country']['alpha2'] ?? throw new \Exception("Contry not exists in Bin details");
	} 


	private const EUROPE_CONTRIES = [
    	'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
    ];

}