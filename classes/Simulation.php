<?php 

class Simulation extends SimEnv { 

  public function __construct($habitat, $years)  { 
    parent::__construct($habitat, $years);
  }

  public function init() { 
    $animals = new Animals();
  }


}