<?php

namespace App\Service;
use App\Exception;
use App\Entity;

class InputHandler {

	public function __construct(private string $inputFilePath) {

		// To check input file existance
	    if (!file_exists($this->inputFilePath)) {
	        throw new Exception\InputFileNotExists();
	    }

	}

	public function inputLoader() : array {

		try {
			
			$inputContent = file_get_contents($this->inputFilePath);
			return explode("\n", $inputContent);
	    
	    } catch (\Exception $e){
	    	throw new Exception\InputLoadingFailed();
	    }

	}

	public function transactionParser(string $row) : Entity\Transaction {

		try {

			// To turn the row (json formatted) into array 
	    	$decodedInput = json_decode($row, true, JSON_THROW_ON_ERROR);

			// To get rid of the "missing index" issue
    		$decodedInput += ['bin' => null, 'amount' => null, 'currency' => null];

	    	return new Entity\Transaction($decodedInput['bin'], $decodedInput['amount'], $decodedInput['currency']);

		}  catch (\JsonException $e) {
		    throw new Exception\InputInvalidJsonFormatted;
		}
	} 

}
