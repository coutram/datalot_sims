<?php  
/**
 * processes parameters then run loops  
 */
class Iteration { 

  /**
   * Import array vars 
   * @var array
   */
  private $import_array; 

  private $parameters;

	public function __construct() { }

  /**
   * Sets the Import Vars
   * @param array $import_array
   */
	public function setImportVars($import_array) { 
    $this->import_array = $import_array;
  }

  /**
   * Sets the Parameters via the class parser
   */
  public function setParameters() { 
    $this->parameters = new Parameters($this->import_array); 
  }

  /**
   * run loops 
   */
  public function runIterations() {
    $iterations = $this->parameters->getIterations();
    for ($i=1;$i<=$iterations;$i++) { 
      Log::instance()->output("Running $i Iteration");
 
      foreach ($this->parameters->getSpecies() as $sp){ 
        Log::instance()->output("Running for ".$sp->name);

        foreach ($this->parameters->getHabitats() as $hab) { 
          Log::instance()->output("Running for ".$hab->name);

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
      $sim->breed();
      $sim->survive();

      Log::instance()->debug("");
      Log::instance()->debug("");
    }
  }
}