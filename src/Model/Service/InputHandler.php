<?php

namespace App\Model\Service;
use App\Exception;

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

			// Looping/parsing the file content
			$this->inputParser();

	}

	private function inputLoader() : void {

		try {
			$this->fileContent = file_get_contents($this->inputFilePath);
	    
	    } catch (\Exception $e){
	    	throw new Exception\InputLoadingFailed();
	    }

	}

	private function inputParser() : void {

		try {
			foreach (explode("\n", $this->fileContent) as $transaction)  {

				// To decoding each row in json formatted 
		    	$decoded_input = json_decode($transaction, true, JSON_THROW_ON_ERROR);

		        $bin      = $decoded_input['bin'];
		        $amount   = $decoded_input['amount'];
		        $currency = $decoded_input['currency'];


		        // TODO transaction entity should be called here

			}

		}  catch (JsonException $e) {
		    throw new EncryptException($e->getMessage());
		}
	} 

}
