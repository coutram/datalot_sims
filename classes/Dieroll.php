<?php

class Dieroll { 

  private $max; 

  private $min; 

  public function __construct($min = 1, $max = 10){ 
    $this->min = $min;
    $this->max = $max;
  }

  public function roll() { 
    return mt_rand($this->min, $this->max); 
  }

}