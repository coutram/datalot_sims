<?php 
/**
 * 
 */
class Breeding { 

  /**
   * 
   * @var array
   */
	private $animals;

  /**
   * @var Animal $current_animal
   */
  private $current_animal; 

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
   */
  public function mate(){ 
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
    return $this->current_animal->gender == Animal::MALE;
  }

  /**
   * is the current animal in gestation
   */
  private function inGestation(){
    return $this->current_animal->pregnant > 0;
  }

  /**
   * is the current animals age less than the minumim breeding age 
   */
  private function isLessThanMinumimBreedingAge(){ 
    return $this->current_animal->age < $this->getMinumimBreedAge();
  }

  /**
   * is the current animals age greater than the maximum breeding age 
   */
  private function isGreaterThanMaximumBreedingAge(){ 
    return $this->current_animal->age > $this->getMaximumBreedAge();
  }

  /**
   * are there any males left in the herd for breeding to occur
   */
  private function hasNoMalesInHerd($animals){ 
    foreach ($animals as $animal){ 
      if($animal->gender==Animal::MALE){ 
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
    return $this->current_animal->species->minimum_breeding_age;
  }

  /**
   * getter for max breeding age
   */
  private function getMaximumBreedAge() { 
    return $this->current_animal->species->maximum_breeding_age;
  }
}