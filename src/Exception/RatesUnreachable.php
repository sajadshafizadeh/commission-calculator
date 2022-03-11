<?php

namespace App\Exception;

class RatesUnreachable extends \Exception{
	protected $message = "The web-service for exchange rates is unreachable";
}