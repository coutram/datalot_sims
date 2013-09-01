<?php 

include_once 'spyc.php';

class Import { 

	private $filename; 

	public function __construct() {

	}

	public function setFilename($filename) { 
		$this->filename = $filename;
	}

	public function runImport() { 
    $import = spyc_load_file($this->filename);
    var_dump($import);
	}



}