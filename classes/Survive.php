<?php 
/**
 * Survival functions
 * Can run at once during month because the animal must be subjected to 
 * full month of kill conditions
 */
class Survive { 

  const MONTHS_HUNGRY_DEAD = 3;
  const MONTHS_THIRSTY_DEAD = 1;

  /**
   * The current temp
   */
  private $temp; 

  /**
   * The animal object to check for survival factors
   */
  private $animal; 

  /**
   * @var Animal $animal
   */
  public function __construct($animal) {  
    $this->animal = $animal; 
  }

  /**
   * Set the current Temperature
   * @var int $temp
   */
  public function setTemp($temp) {
    $this->temp = $temp;
  }

  /**
   * Run the survival conditions on animal
   */
  public function run(){ 
    $this->survive = true;
    switch(true){ 
      case $this->isDieAge():
        Log::instance()->debug("Animal Died: Age condition");
        $this->survive = false;
        break; 

      case $this->isDieWeather():
        Log::instance()->debug("Animal Died: Weather condition");
        $this->survive = false;
        break;

      case $this->isThirsty():
        Log::instance()->debug("Animal Died: Thirsty condition");
        $this->survive = false;
        break;

      case $this->isHungry():
        Log::instance()->debug("Animal Died: Hungry condition");
        $this->survive = false;
        break;
    }
  }

  /**
   * Did the animal survive a lookup on kill conditions? 
   */
  public function hasSurvived(){ 
    return $this->survive;
  }

  /**
   * Animal dies when they are older than their lifespan
   */
  private function isDieAge(){ 
    return $this->animal->getAge() > $this->animal->getSpecies()->life_span;
  }

  /**
   * Animal dies when the temperature is less than species
   * min temp and greater than species max temp 
   */
  private function isDieWeather(){
    if ($this->temp < $this->animal->getSpecies()->minimum_temperature) { 
      return true;
    }

    if ($this->temp > $this->animal->getSpecies()->maximum_temperature){ 
      return true;
    }

    return false; 
  }

  /**
   * Animal is thirsty when they have a month of not drinking
   */
  private function isThirsty(){ 
    return $this->animal->getThirsty() == self::MONTHS_THIRSTY_DEAD;
  }
	
  /**
   * Animal is hungry when they have a month of not eating
   */
  private function isHungry(){
    return $this->animal->getHungry() == self::MONTHS_HUNGRY_DEAD;
  }
}