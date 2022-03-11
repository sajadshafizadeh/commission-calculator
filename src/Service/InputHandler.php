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
	    	$decoded_input = json_decode($row, true, JSON_THROW_ON_ERROR);

	        $bin      = $decoded_input['bin'] ?? throw new Exception\InputInvalidJsonFormatted;
	        $amount   = $decoded_input['amount'] ?? throw new Exception\InputInvalidJsonFormatted;
	        $currency = $decoded_input['currency'] ?? throw new Exception\InputInvalidJsonFormatted;

	    	return new Entity\Transaction($bin, $amount, $currency);

		}  catch (\JsonException $e) {
		    throw new EncryptException($e->getMessage());
		}
	} 

}
