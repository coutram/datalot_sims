<?php 
/**
 * Breeds new animals -- mating and birth and the rules of both 
 */
class Breeding { 

  const MATE_RATE_WITH_FULL_FOOD_WATER = 1; 
  const MATE_RATE_WITH_NOT_ENOUGH_FOOD_WATER = .05; 

  /**
   * @var Animal 
   */
  private $current_animal; 

  /**
   * @var boolean
   */
  private $supportive_habitat = false; 

	public function __construct(){  } 

  /**
   * 
   * @param Animal $animal
   */
  public function setAnimal($animal){ 
    $this->current_animal = $animal; 
  }

  /**
   * 
   * @param int $food_left
   * @param int $water_left
   */
  public function setSupportiveHabitat($food_left, $water_left){ 
    if($food_left < $this->current_animal->getSpecies()->monthly_food_consumption){ 
      $this->supportive_habitat = false;
      return false;
    }

    if($water_left < $this->current_animal->getSpecies()->monthly_water_consumption){ 
      $this->supportive_habitat = false;
      return false;
    }

    $this->supportive_habitat = true;
    return true; 
  }

  /**
   * getter for supportive_habitat
   */
  private function getSupportiveHabitat() { 
    return $this->supportive_habitat;
  }

  /**
   * chooses correcting mating
   */
  public function mate(){ 
    if ($this->getSupportiveHabitat()){ 
      $this->runMating(self::MATE_RATE_WITH_FULL_FOOD_WATER);
    } else { 
      $this->runMating(self::MATE_RATE_WITH_NOT_ENOUGH_FOOD_WATER);
    }
  } 

  /**
   * run mating 
   */
  private function runMating($percent_mate){
    $prob = new Probability($percent_mate);
    $prob->run();
    if($prob->hasHappened()){
      $this->current_animal->incrementPregnancy();
    }
  }

  /**
   * give birth 
   */
  public function birth(){ 
    if($this->inGestation()) { 
      $this->current_animal->incrementPregnancy();
    }

    if($this->current_animal->getPregnant() == $this->current_animal->getSpecies()->gestation_period){ 
      $this->current_animal->giveBirth();
      return true;
    }
    return false;
  } 

  /**
   * Rules of Breeding 
   */
  public function canBreed($animals){ 
    switch (true) { 
      case $this->isMale():
        // Log::instance()->debug("Can't Breed: Male");
        return false;
      case $this->inGestation():
        // Log::instance()->debug("Can't Breed: Gestation");
        return false;
      case $this->isLessThanMinumimBreedingAge():
        // Log::instance()->debug("Can't Breed: Too Young");
        return false;
      case $this->isGreaterThanMaximumBreedingAge():
        // Log::instance()->debug("Can't Breed: Too Old");
        return false;
      case $this->hasNoMalesInHerd($animals):
        // Log::instance()->debug("Can't Breed: No Males Left");
        return false;
    }

    Log::instance()->debug("Breeding new kid"); 
    return true;
  }

  /**
   * is the current animal male
   */
  private function isMale(){ 
    return $this->current_animal->getGender() == Animal::MALE;
  }

  /**
   * is the current animal in gestation
   */
  private function inGestation(){
    return $this->current_animal->getPregnant() > 0;
  }

  /**
   * is the current animals age less than the minumim breeding age 
   */
  private function isLessThanMinumimBreedingAge(){ 
    return $this->current_animal->getAge() < $this->getMinumimBreedAge();
  }

  /**
   * is the current animals age greater than the maximum breeding age 
   */
  private function isGreaterThanMaximumBreedingAge(){ 
    return $this->current_animal->getAge() > $this->getMaximumBreedAge();
  }

  /**
   * are there any males left in the herd for breeding to occur
   */
  private function hasNoMalesInHerd($animals){ 
    foreach ($animals as $animal){ 
      if($animal->getGender()==Animal::MALE){ 
        return false;
      }
    }
    return true;
  }

  /**
   * getter for min breeding age
   *
   */
  private function getMinumimBreedAge() { 
    return $this->current_animal->getSpecies()->minimum_breeding_age;
  }

  /**
   * getter for max breeding age
   */
  private function getMaximumBreedAge() { 
    return $this->current_animal->getSpecies()->maximum_breeding_age;
  }
}