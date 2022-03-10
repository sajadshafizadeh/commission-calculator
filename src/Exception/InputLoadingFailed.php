<?php

namespace App\Exception;

class InputLoadingFailed extends \Exception{
	protected $message = "Something went wrong in the input file loading";
}