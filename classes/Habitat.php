<?php 
/**
 * The Habitat Object
 * Example for the form of the data after parsing the YAML file
 * 
 *      ["name"]=>
 *       string(9) "mountains"
 *      ["monthly_food"]=>
 *      int(80)
 *      ["monthly_water"]=>
 *      int(100)
 *      ["average_temperature"]=>
 *      array(4) {
 *        ["summer"]=>
 *        int(75)
 *        ["spring"]=>
 *        int(60)
 *        ["fall"]=>
 *        int(50)
 *        ["winter"]=>
 *        int(20)
 *      } 
 *    }
 * 
 **/


class Habitat { 

  /**
   * index of name in YAML parsed array
   */ 
  const NAME = 'name';

  /**
   * index of monthly_food in YAML parsed array
   */ 
  const FOOD = 'monthly_food';

  /**
   * index of monthly_water in YAML parsed array
   */ 
  const WATER = 'monthly_water';

  /**
   * index of average_temperature in YAML parsed array
   */ 
  const TEMPERATURE = 'average_temperature';

  /**
   * Name of Habitat 
   * @var string
   */
  private $name; 

  /**
   * Monthly Food Available in Habitat 
   * @var int
   */
  private $monthly_food; 

  /**
   * Monthly Water Available in Habitat 
   * @var int
   */
  private $monthly_water;

  /**
   * Average Temperature in Habitat 
   * @var array
   */
  private $average_temperature = array(
    'summer' => 0,
    'spring' => 0,
    'fall' => 0,
    'winter' => 0
  );

  /**
   * @var array - the habitat array from YAML parsed file 
   */
  public function __construct($habitat_array) { 
    $this->setFromArray($habitat_array);
  }

  public function __get($key) { 
    return $this->$key;
  }

  /**
   * map array to member vars
   * @var array
   */
  private function setFromArray($habitat_array) { 
    $this->name = $habitat_array[self::NAME];
    $this->monthly_food = $habitat_array[self::FOOD];
    $this->monthly_water = $habitat_array[self::WATER];
    $this->average_temperature = $habitat_array[self::TEMPERATURE];
  }  
}