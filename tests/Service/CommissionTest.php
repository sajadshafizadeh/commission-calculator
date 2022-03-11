<?php

use PHPUnit\Framework\TestCase;
use App\Service;
use App\Entity;

class CommissionTest extends TestCase{

	public function testCalculateCommission() : void {

		$transactionObject = new Entity\Transaction("45717360", "100.00", "EUR");
		$commisionObject = new Service\Commission;
		$exchangeObject = new Service\Exchange("rates.json", "https://lookup.binlist.net/");
		$exchangeObject->loadBinDetails($transactionObject);
		$commision = $commisionObject->calculateCommission($transactionObject, ["EUR"=> 1]);

		$this->assertEquals("1.00", $commision);
	}
}