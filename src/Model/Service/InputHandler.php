<?php

namespace App\Model\Service;
use App\Exception;
use App\Model\Entity;

class InputHandler {

	private $fileContent;

	public function __construct(private string $inputFilePath) {

		// To check file existance
	    if (!file_exists($this->inputFilePath)) {
	        throw new Exception\InputFileNotExists();
	    }

	}

	public function handle() : void {

			// Load the input file
			$this->inputLoader();

			// Looping/parsing the file content (transaction)
			$this->transactionParser();

	}

	private function inputLoader() : void {

		try {
			$this->fileContent = file_get_contents($this->inputFilePath);
	    
	    } catch (\Exception $e){
	    	throw new Exception\InputLoadingFailed();
	    }

	}

	private function transactionParser() : void {

		try {
			foreach (explode("\n", $this->fileContent) as $transaction)  {

				// To decoding each row in json formatted 
		    	$decoded_input = json_decode($transaction, true, JSON_THROW_ON_ERROR);

		        $bin      = $decoded_input['bin'] ?? null;
		        $amount   = $decoded_input['amount'] ?? null;
		        $currency = $decoded_input['currency'] ?? null;

		    	$transactionObject = new Transaction($bin, $amount, $currency);
		    	$isEurope = $transactionObject->isEurope();


		        // TODO transaction entity should be called here

			}

		}  catch (JsonException $e) {
		    throw new EncryptException($e->getMessage());
		}
	} 

}
