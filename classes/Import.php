<?php 
/**
 * Import the file with spyc library
 */
include_once 'spyc.php';

class Import { 

  /**
   *  filename var
   */
  private $filename; 
  
  /**
   * set the import vars 
   */
  private $import_vars;

	public function __construct() { }

  /**
   * set the filename 
   * @param $filename
   */
	public function setFilename($filename) { 
		$this->filename = $filename;
	}

  /**
   * Run the import 
   */
	public function runImport() { 
    $this->import_vars = spyc_load_file($this->filename);
	}

  /**
   * getter for import vars 
   */
  public function getImportVars(){ 
    return $this->import_vars;
  }
}