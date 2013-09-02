<?php 

class SimTime { 

  const WINTER = 'winter';

  const SPRING = 'spring'; 

  const SUMMER = 'summer';

  const FALL = 'fall';

  private static $season_month_map = array ( 
    1 => self::WINTER,
    2 => self::WINTER,
    3 => self::SPRING,
    4 => self::SPRING,
    5 => self::SPRING,
    6 => self::SUMMER,
    7 => self::SUMMER,
    8 => self::SUMMER,
    9 => self::FALL,
    10 => self::FALL,
    11 => self::FALL,
    12 =>  self::WINTER,
  );

  protected $current_month = 0; 

  protected $current_year = 1;

  protected $years; 

  protected function iterateTime() { 
    if ($this->current_month == 12) { 
      $this->current_year++;
      $this->current_month = 1;
    } else { 
      $this->current_month++;
    }
    Log::instance()->output("Running Simulation for " . $this->getPrintedYear() . " - ". $this->getPrintedMonth());
  }

  protected function isEndOfSimulation(){ 
    if($this->current_year == $this->years && $this->current_month == 12) { 
      return true;
    }
    return false;
  }

  private function getPrintedYear() {
    return $this->current_year; 
  }

  private function getPrintedMonth() { 
    return $this->current_month; 
  }

  protected function getSeason(){ 
    return self::$season_month_map[$this->current_month];
  }

}