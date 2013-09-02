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
  protected $food_left_over = 0;

  /**
   * Water left over 
   * @var int
   */
  protected $water_left_over = 0;

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
   * roll through animals and drink 
   */
  public function drinks($habitat_water, $consumption) {
    $water_count = 0;
    $this->water_left_over = $habitat_water; 
    $this->random();
    foreach ($this->get() as $animal){ 
      if ($habitat_water > 0){ 
        $this->water_left_over-=$consumption;
      } else { 
        $this->water_left_over = 0; // half eaten food -- still gets eaten
        $animal->incrementHungry();
        $water_count++;
      }
    }
    Log::instance()->debug("Water Left Over: ".$this->water_left_over);
    Log::instance()->debug("Thirsty: ".$water_count);
    return $habitat_water;
  }

  /**
   * roll through animals and eat 
   */
  public function eats($habitat_food, $consumption) { 
    $hungry_count = 0; 
    $this->food_left_over = $habitat_food;
    $this->random();

    foreach ($this->get() as $animal){ 
      if ($habitat_food > 0){ 
        $this->food_left_over-=$consumption;
        $animal->notHungry();
      } else { 
        $this->food_left_over = 0; // half eaten food -- still gets eaten
        $animal->incrementHungry();
        $hungry_count++;
      }
    }
    Log::instance()->debug("Food Left Over: ".$this->food_left_over);
    Log::instance()->debug("Hungry: ".$hungry_count);
    return $habitat_food;
  }

  /**
   * Do the breeding 
   */
  public function breeds() { 
    $breed = new Breeding();
    foreach ($this->animals as $animal) { 
      $breed->setAnimal($animal); 

      if($breed->canBreed($this->animals)){ 
        $breed->mate();
        $breed->birth();
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

      if ($survive->hasSurvived()){ 
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

