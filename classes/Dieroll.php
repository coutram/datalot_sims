<?php
/**
 * get random value from min to max 
 */
class Dieroll { 

  /**
   * max value 
   * @var int
   */
  private $max; 

  /**
   * min value 
   * @var int
   */
  private $min; 

  public function __construct($min = 1, $max = 10){ 
    $this->min = $min;
    $this->max = $max;
  }

  public function roll() { 
    return mt_rand($this->min, $this->max); 
  }
}