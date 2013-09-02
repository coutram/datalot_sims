<?php 
/**
 * The Species Object
 * Example for the form of the data after parsing the YAML file
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

  /**
   * animal type 
   * @var string
   */
  private $name; 

  /**
   * monthly food consumption of animal
   * @var int
   */
  private $monthly_food_consumption; 

  /**
   * monthly water consumption of animal 
   * @var int
   */
  private $monthly_water_consumption;

  /**
   * life span of animal in years 
   * @var int
   */
  private $life_span;

  /**
   * breeding low range 
   * @var int
   */
  private $minimum_breeding_age;

  /**
   * breeding high range
   * @var int
   */
  private $maximum_breeding_age; 

  /**
   * how long before gestation 
   * @var int
   */
  private $gestation_period; 

  /**
   * minimum temperature 
   * @var int
   */
  private $minimum_temperature;

  /**
   * maximinu temperature 
   * @var int
   */
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

  /**
   * Set the value of the species array
   */
  private function setFromArray($species_array) { 
    $this->name = $species_array[self::NAME];
    foreach ($species_array[self::ATTRIBUTES] as $index => $attr) {
      $this->$index = $attr;
    }
  }  
}