<?php

namespace App\Exception;

class InputFileNotExists extends \Exception{
	protected $message = "The given name as input file name doesn not look correct";
}