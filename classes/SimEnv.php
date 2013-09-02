<?php 

class SimEnv extends SimTime { 

  protected $habitat;

	public function __construct($habitat, $years) { 
    $this->habitat = $habitat; 
    $this->years = $years;
  }

  public function next() {
    if ($this->isEndOfSimulation()) { 
      return false; 
    }

    $this->iterateTime();

    return true;
  }

  public function setWeather() { 
    $season = $this->getSeason(); 

    $avg_temp = $this->habitat->average_temperature[$season]; 

    $prob = new Probability(.5);
    $prob->run(); 
    if ($prob->hasHappened()) {  
      $this->setTemp($avg_temp, 15);
    } else { 
      $this->setTemp($avg_temp, 5);
    }
  }

  private function setTemp($avg_temp, $degrees_delta) { 
    $dr = new Dieroll(0, $degrees_delta*2);
    $rand_val = $dr->roll(); 

    $change = ($degrees_delta) - $rand_val; 
    $this->temp =  $avg_temp+$change;

    Log::instance()->debug("avg temp: $avg_temp");
    Log::instance()->debug("degrees delta: $degrees_delta");
    Log::instance()->debug("rand: $rand_val");
    Log::instance()->debug("change: $change");
    Log::instance()->debug("temp: ". $this->temp );
  }


}