<?php 
/**
 * Run the simulation for a single species/habitat
 */
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
    $this->pickStartMonth();
    Stats::instance()->resetStats();

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

  /**
   * eat food, drink water  
   */
  public function consume(){ 
    Log::instance()->debug("Consume resources");
    $this->herd->setMaxCount();
    $this->herd->eats($this->habitat->monthly_food, $this->species->monthly_food_consumption);
    $this->herd->drinks($this->habitat->monthly_water, $this->species->monthly_water_consumption);
    if ($this->isNewYear()) { 
      $this->herd->ages();
    }
  }

  /**
   * darwin decides 
   */
  public function survive(){ 
    Log::instance()->debug("Initialize the simulation");
    $this->herd->survive($this->temp);
  }

  /**
   * mating 
   */
  public function breed() { 
    Log::instance()->debug("Start the breeding");
    $this->herd->breeds();
  }

  /**
   * Make a stats call to record the population at a given time
   */
  public function record() { 
    $number_of_animals = $this->herd->count();
    Log::instance()->debug("Number of animals alive: $number_of_animals");
    Stats::instance()->setPopulation($number_of_animals);
  }
}