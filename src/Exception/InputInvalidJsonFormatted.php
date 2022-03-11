<?php

namespace App\Exception;

class InputInvalidJsonFormatted extends \Exception{
	protected $message = "The input file is not paressed correctly. Looks invalid json formatted";
}