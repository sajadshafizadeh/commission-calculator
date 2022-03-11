<?php

namespace App\Service;

use App\Entity;
use App\Service;

class Commission{

	private const MAIN_CURRENCY = "EUR";
	private const IS_EUROPE_RATIO = 0.01;
	private const IS_NOT_EUROPE_RATIO = 0.02;
	private const ROUNDING_PRECISION = 2; // fraction

	public function __construct(private Service\Exchange $exchange) {}

	public function calculateCommission(Entity\Transaction $transaction) : string {

        $amount = $transaction->getAmount();
        $currency = $transaction->getCurrency();

        $this->exchange->loadBinDetails($transaction);
        $rate = $this->exchange->getRates()[$currency];

        $isFromEU = $transaction->isFromEU();
        $amountFixed = $this->getAmountFixed($amount, $currency, $rate);

        $commission = $amountFixed * ($isFromEU ? self::IS_EUROPE_RATIO : self::IS_NOT_EUROPE_RATIO);
        return $this->roudUp($commission);
	}


	private function getAmountFixed(float $amount, string $currency, float $rate) : float {

		// Assuming the $rate is always a positive floating point value
        return $currency === self::MAIN_CURRENCY || $rate === 0.0 ? $amount : $amount / $rate;
	}

	protected function roudUp(float $amount) : string {
		$fraction = self::ROUNDING_PRECISION > 0 ? self::ROUNDING_PRECISION : 0; 
		$mult = pow(10, $fraction);
  		$roundedUp = ceil($amount * $mult) / $mult;
  		return number_format($roundedUp, 2);
	}
}