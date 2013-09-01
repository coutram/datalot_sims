<?php 

class Simulation extends SimulationRules { 

  private $import_array; 

  private $parameters;

	public function __construct() { }

	public function setImportVars($import_array) { 
    $this->import_array = $import_array;
  }

  public function setParameters() { 
    $this->parameters = new Parameters($this->import_array); 
  }

  public function runSimulation() { 
    print_r($this->parameters);
  }

}