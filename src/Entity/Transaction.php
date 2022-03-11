<?php

namespace App\Entity;

class Transaction {

	CONST BIN_DETAILS_BASE_URL = "https://lookup.binlist.net/";

	private $binDetails;

	public function __construct(private int $bin, private float $amount, private string $currency){}

	public function isEurope() : bool{

		// To call the APi, Get the result, Set it to the property
		$this->setBinDetails();

		// To part the result, Get the country name (card-issuer) 
		$cardIssuerCoutnryName = $this->getBinBelongsToCountry();

		// To check if the country is one of the European ones
		return in_array($cardIssuerCoutnryName, $this->EuropeContries());
	}

	public function getCurrency() : string {
		return $this->currency;
	}

	public function getAmount() : string {
		return $this->amount;
	}

	private function setBinDetails() : void {

		try {

			$binDetailsContent = file_get_contents(self::BIN_DETAILS_BASE_URL . $this->bin);
			
			if($binDetailsContent === false || empty($binDetailsContent)) {
				throw new Exception\BinDetailsUnreachable();
			}
			
			$this->binDetails = json_decode($binDetailsContent, true, JSON_THROW_ON_ERROR);


		} catch(\Exception $e){
			throw new \Exception("Something went wrong in getting bin details");
		}

	}

	private function getBinBelongsToCountry() : ?string {
		return $this->binDetails['country']['alpha2'] ?? throw new \Exception("Contry not exists in Bin details");
	} 


	private function EuropeContries(): array {

        return [
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'
        ];
    }

}