<?php 

/**
 * 
 *   array(2) {
 *     ["name"]=>
 *     string(4) "bear"
 *     ["attributes"]=>
 *     array(8) {
 *       ["monthly_food_consumption"]=>
 *       int(4)
 *       ["monthly_water_consumption"]=>
 *       int(4)
 *       ["life_span"]=>
 *       int(50)
 *       ["minimum_breeding_age"]=>
 *       int(10)
 *       ["maximum_breeding_age"]=>
 *       int(35)
 *       ["gestation_period"]=>
 *       int(12)
 *       ["minimum_temperature"]=>
 *       int(0)
 *       ["maximum_temperature"]=>
 *       int(95)
 *     }
 *
 **/

class Species { 

  const ATTRIBUTES = 'attributes';

  const NAME = 'name';

  private $name; 

  private $monthly_food_consumption; 

  private $monthly_water_consumption;

  private $life_span;

  private $minimum_breeding_age;

  private $maximum_breeding_age; 

  private $gestation_period; 

  private $minimum_temperature;

  private $maximum_temperature; 

	public function __construct($species_array) { 
    $this->setFromArray($species_array);
	}

  public function __get($key) { 
    return $this->$key;
  }

  public function __set($key, $value) { 
    return $this->$key  = $value;
  }

  private function setFromArray($species_array) { 
    $this->name = $species_array[self::NAME];
    foreach ($species_array[self::ATTRIBUTES] as $index => $attr) {
      $this->$index = $attr;
    }
  }  
}