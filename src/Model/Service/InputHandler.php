<?php

namespace App\Model\Service;
use App\Exception;
use App\Model\Entity;

class InputHandler {

	public function __construct(private string $inputFilePath) {

		// To check input file existance
	    if (!file_exists($this->inputFilePath)) {
	        throw new Exception\InputFileNotExists();
	    }

	}

	public function inputLoader() : string {

		try {
			return file_get_contents($this->inputFilePath);
	    
	    } catch (\Exception $e){
	    	throw new Exception\InputLoadingFailed();
	    }

	}

	public function transactionParser(string $row) : Entity\Transaction {

		try {
			
			// To turn the row (json formatted) into array 
	    	$decoded_input = json_decode($row, true, JSON_THROW_ON_ERROR);

	        $bin      = $decoded_input['bin'] ?? null;
	        $amount   = $decoded_input['amount'] ?? null;
	        $currency = $decoded_input['currency'] ?? null;

	    	return new Entity\Transaction($bin, $amount, $currency);

		}  catch (\JsonException $e) {
		    throw new EncryptException($e->getMessage());
		}
	} 

}
