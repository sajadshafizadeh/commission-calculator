<?php

namespace App\Service;

use App\Entity;

class Commission{

	private const MAIN_CURRENCY = "EUR";
	private const IS_EUROPE_RATIO = 0.01;
	private const IS_NOT_EUROPE_RATIO = 0.02;
	private const ROUNDING_PRECISION = 2; // fraction

	public function __construct(private object $transaction, private array $exchangeRates) {}

	public function calculateCommission() : float {

        $amount = $this->transaction->getAmount();
        $currency = $this->transaction->getCurrency();
        $rate = $this->exchangeRates[$currency];

        $amountFixed = $this->getAmountFixed($amount, $currency, $rate);
        $isEurope = $this->transaction->isEurope();

        $commission = $amountFixed * ($isEurope ? self::IS_EUROPE_RATIO : self::IS_NOT_EUROPE_RATIO);
        return $this->roudUp($commission);
	}


	private function getAmountFixed(float $amount, string $currency, float $rate) : float {

		// Assuming the $rate is always a positive floating point value
        return $currency === self::MAIN_CURRENCY || $rate === 0.0 ? $amount : $amount / $rate;
	}

	protected function roudUp(float $amount) : float {
		$fraction = self::ROUNDING_PRECISION > 0 ? self::ROUNDING_PRECISION : 0; 
		$mult = pow(10, $fraction);
  		return ceil($amount * $mult) / $mult;
	}
}