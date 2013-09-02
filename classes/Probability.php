<?php 
/**
 * Run a probability 
 */
class Probability { 

  private $percent; 
  private $result;

  public function __construct($percent  = 5) { 
    $this->percent = $percent; 
  }

  public function run() { 
    $rand_value = mt_rand(0, 99);
    $this->result =  $rand_value < $this->percent;
  }

  public function hasHappened() { 
  	return $this->result;
  }
}