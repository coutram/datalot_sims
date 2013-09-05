<?php 
/**
 * Time Simulation functions 
 */
class SimTime { 

  const WINTER = 'winter';
  const SPRING = 'spring'; 
  const SUMMER = 'summer';
  const FALL = 'fall';

  /**
   * season map 
   */
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

  /**
   * The current month of the iteration
   */
  protected $current_month = 0; 

  /**
   * The current year of the iteration 
   */
  protected $current_year = 1;

  /**
   * the amount of years the species can live 
   */
  protected $years; 

  /**
   * Randomly select month to start the 
   * simulation to not let winter weather influence results
   * @var int
   */
  protected $start_month;

  /**
   * Month behind the start month so we can appropriately simulation end
   * @var int 
   */
  protected $end_month;

  /**
   * Is this a new year 
   */
  protected $new_year = false; 

  /**
   * randomly choose the start month so we can run an unbiased sim
   */
  public function pickStartMonth() { 
    $dr = new Dieroll(1,12);
    $this->start_month = $dr->roll();
    $this->setEndMonth();
    $this->current_month = $this->start_month;
  }

  /**
   * set the end month behind the month start (increment years if sim doens't start in jan)
   */
  protected function setEndMonth(){
    if($this->start_month == 1){ 
      $this->end_month = 12;
    } else { 
      $this->end_month = $this->start_month; 
      $this->years++;
    }
  }

  /**
   * getter for end month
   */
  protected function getEndMonth(){ 
    return $this->end_month;
  }

  /**
   * increment time 
   */
  protected function incrementTime() {
    if ($this->current_month == 12) { 
      $this->current_year++;
      $this->current_month = 1;
    } else { 
      $this->current_month++;
    }
  }

  /**
   * is this a new year 
   */
  protected function isNewYear(){ 
    return $this->new_year;
  }

  protected function isEndOfSimulation(){ 
    if($this->current_year == $this->years && $this->current_month == $this->getEndMonth()) { 
      return true;
    }
    return false;
  }

  protected function getPrintedYear() {
    return $this->current_year; 
  }

  protected function getPrintedMonth() { 
    return $this->current_month; 
  }

  protected function getSeason(){ 
    return self::$season_month_map[$this->current_month];
  }
}