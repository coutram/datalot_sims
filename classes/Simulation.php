<?php 

class Simulation extends SimEnv implements SimActions { 

  /**
   * The Species in this simulation
   * @var Species
   */
  private $species; 

  /**
   * The herd(array of animals) in this simulation
   * @var Herd
   */
  private $herd; 

  /**
   * Call parent to set up the environment 
   */
  public function __construct($habitat, $years)  { 
    parent::__construct($habitat, $years);
  }

  /**
   * Sets the species for this Simulation
   * @param Species $species  
   */
  public function setSpecies($species) { 
    $this->species = $species;
  }

  /**
   * The initial set up for the simulation
   */
  public function init() { 
    Log::instance()->debug("Initialize the simulation");
    $this->herd = new Herd(); 

    $male = new Animal($this->species);
    $male->setByRandomBreedAge();
    $male->setGender(Animal::MALE);

    $this->herd->addAnimal($male);

    $female = clone $male; 
    $female->setByRandomBreedAge();
    $female->setGender(Animal::FEMALE);

    $this->herd->addAnimal($female);
  }

  public function consume(){ 
    Log::instance()->debug("Consume resources");
    $this->consumeFood();
    $this->consumeWater();


  }

  private function consumeFood(){
    $hungry_count = 0; 
    $this->food_left_over = $this->habitat->monthly_food;
    $this->herd->random();

    foreach ($this->herd->get() as $animal){ 

      if ($this->habitat->monthly_food > 0){ 
        $this->food_left_over-=$this->species->monthly_food_consumption;
        $animal->notHungry();
      } else { 
        $this->food_left_over = 0; // half eaten food -- still gets eaten
        $animal->incrementHungry();
        $hungry_count++;
      }
    }
    Log::instance()->debug("Food Left Over:".$this->food_left_over);
    Log::instance()->debug("Hungry:".$hungry_count);
  }

  private function consumeWater() {
    return true; 
  }


  public function survive(){ 
    Log::instance()->debug("Initialize the simulation");



  }

  public function breed() { 
    Log::instance()->debug("Start the breeding");
  }


}