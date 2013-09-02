<?php 

class Iteration { 

  private $import_array; 

  private $parameters;

	public function __construct() { }

	public function setImportVars($import_array) { 
    $this->import_array = $import_array;
  }

  public function setParameters() { 
    $this->parameters = new Parameters($this->import_array); 
  }

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

  private function runSimulation($sp, $hab) {
   $sim = new Simulation($hab, $this->parameters->getYears());
   $sim->setSpecies($sp);
   $sim->init();
    while($sim->next()) { 
      $sim->setWeather();
      $sim->consume();
      $sim->survive();
      $sim->breed();

      Log::instance()->debug("");
      Log::instance()->debug("");
    }


  }

}