<?php 
/**
 * 
 */
class Breeding { 

  const MATE_RATE_WITH_FULL_FOOD_WATER = 1; 
  const MATE_RATE_WITH_NOT_ENOUGH_FOOD_WATER = .05; 

  /**
   * 
   * @var array
   */
	private $animals;

  /**
   * @var Animal $current_animal
   */
  private $current_animal; 

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
    if($food_left < $this->current_animal->species->monthly_food_consumption){ 
      $this->supportive_habitat = false;
      return false;
    }

    if($water_left < $this->current_animal->species->monthly_water_consumption){ 
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
   * 
   */
  public function mate(){ 
    if ($this->getSupportiveHabitat()){ 
      $this->runMating(self::MATE_RATE_WITH_FULL_FOOD_WATER);
    } else { 
      $this->runMating(self::MATE_RATE_WITH_NOT_ENOUGH_FOOD_WATER);
    }
  } 

  private function runMating($percent_mate){
    $prob = new Probability($precent_mate);

    $this->current_animal->incrementPregnancy();

  }

  /**
   * 
   */
  public function birth(){ 
  } 

  /**
   * Rules of Breeding 
   */
  public function canBreed($animals){ 
    switch (true) { 
      case $this->isMale():
        return false;
      case $this->inGestation():
        return false;
      case $this->isLessThanMinumimBreedingAge():
        return false;
      case $this->isGreaterThanMaximumBreedingAge():
        return false;
      case $this->hasNoMalesInHerd($animals):
        return false;
    }

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