<?php 
/**
 * The groups of animals being simulated
 */
class Herd implements Living { 

  /**
   * The hash of animals 
   */
  private $animals; 

  /**
   * Food left over 
   * @var int
   */
  protected $food_left = 0;

  /**
   * Water left over 
   * @var int
   */
  protected $water_left = 0;

  /**
   * Add a new animal to the array 
   * @param Animal $animal 
   */
  public function addAnimal($animal) { 
    $this->animals[] = $animal;
  }

  /**
   * The animal hash getter
   */
  public function get() { 
    return $this->animals; 
  }

  /**
   * Count the animals
   */
  public function count() { 
    return count($this->animals);
  }

  /**
   * Randomize the array of animals
   */
  private function random() { 
    shuffle($this->animals);
  }

  /**
   * Set the max count for the herd 
   */
  public function setMaxCount(){ 
    Stats::instance()->setMax($this->count());
  }

  /**
   * roll through animals and drink 
   */
  public function drinks($habitat_water, $consumption) {
    $water_count = 0;
    $this->water_left = $habitat_water; 
    $this->random();
    foreach ($this->get() as $animal){ 
      if ($this->water_left > $consumption){ 
        $this->water_left-=$consumption;
      } else { 
        $this->water_left = 0; // half eaten food -- still gets eaten
        $animal->incrementThirsty();
        $water_count++;
      }
    }
    Log::instance()->debug("Water Left Over: ".$this->water_left);
    Log::instance()->debug("Thirsty: ".$water_count);
  }

  /**
   * roll through animals and eat 
   */
  public function eats($habitat_food, $consumption) { 
    $hungry_count = 0; 
    $this->food_left = $habitat_food;
    $this->random();

    foreach ($this->get() as $animal){ 
      if ($this->food_left > $consumption){ 
        $this->food_left-=$consumption;
        $animal->notHungry();
      } else { 
        $this->food_left = 0; // half eaten food -- still gets eaten
        $animal->incrementHungry();
        $hungry_count++;
      }
    }
    Log::instance()->debug("Food Left Over: ".$this->food_left);
    Log::instance()->debug("Hungry: ".$hungry_count);
  }

  /**
   * Do the breeding 
   */
  public function breeds() { 
    $breed = new Breeding();
    foreach ($this->animals as $animal) { 
      $breed->setAnimal($animal); 

      if($breed->canBreed($this->animals)){ 
        $breed->setSupportiveHabitat($this->food_left, $this->water_left); 
        $breed->mate();
      }

      if ($breed->birth()){
        Log::instance()->debug("Give birth to new kid");
        Stats::instance()->incOffspring();
        $kid = new Animal($animal->getSpecies());
        $kid->setAge(0);
        $kid->setRandomGender();
        $this->addAnimal($kid);
      }
    }
  }

  /**
   * who survives
   */
  public function survive($temp) { 
    foreach ($this->get() as $index => $elem) { 
      $survive = new Survive($elem);
      $survive->setTemp($temp);
      $survive->run();

      if (!$survive->hasSurvived()){ 
        Stats::instance()->incDeaths();
        $this->kill($index);
      }
    }
  }

  /**
   * kill the animal =( 
   * @param int $index
   */
  private function kill($index){ 
    unset($this->animals[$index]);
  }

  /**
   * Age them 
   */
  public function ages() { 
    foreach ($this->get() as $animal){ 
      $animal->incrementAge();
    }
  }

}

