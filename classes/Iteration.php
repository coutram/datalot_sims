<?php  
/**
 * processes parameters then run loops  
 */
class Iteration { 

  /**
   * The Parameters Object
   */
  private $parameters;

	public function __construct() { }

  /**
   * Sets the Parameters via the class parser
   * @var Parameters
   */
  public function setParameters($parameters) { 
    $this->parameters = $parameters; 
  }

  /**
   * run loops 
   */
  public function runIterations() {
    $iterations = $this->parameters->getIterations();

    foreach ($this->parameters->getSpecies() as $sp){ 
      Log::instance()->output("Running for ".$sp->name);
      Stats::instance()->setSpecies($sp->name);

      foreach ($this->parameters->getHabitats() as $hab) { 
        Log::instance()->output("Running for ".$hab->name);
        Stats::instance()->setHabitat($hab->name);
       
          for ($i=1;$i<=$iterations;$i++) { 
            Log::instance()->output("Running $i Iteration");
       
            $this->runSimulation($sp, $hab);
        }
      }
    }
  }

  /**
   * run the simulation 
   * @param Species $sp
   * @param Habiatat $hab
   */
  private function runSimulation($sp, $hab) {
   $sim = new Simulation($hab, $this->parameters->getYears());
   $sim->setSpecies($sp);
   $sim->init();
    while($sim->next()) { 
      $sim->setWeather();
      $sim->consume();
      $sim->survive();
      $sim->breed();
    }
    $sim->record();
    Stats::instance()->insertStats();
  }
}