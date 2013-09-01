<?php 

include_once 'spyc.php';

class Import { 

	private $filename; 
  private $import_vars;

	public function __construct() { }

	public function setFilename($filename) { 
		$this->filename = $filename;
	}

	public function runImport() { 
    $this->import_vars = spyc_load_file($this->filename);
	}

  public function getImportVars(){ 
    return $this->import_vars;
  }

}