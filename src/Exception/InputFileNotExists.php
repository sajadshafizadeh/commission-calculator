<?php

namespace App\Exception;

class InputFileNotExists extends \Exception{
	protected $message = "Use the correct input file path as an option for your command, like this --input_file_path=path/to/file";
}