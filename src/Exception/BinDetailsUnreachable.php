<?php

namespace App\Exception;

class BinDetailsUnreachable extends \Exception{
	protected $message = "The web-service for getting BIN details is unreachable";
}