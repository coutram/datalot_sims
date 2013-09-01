<?php 

class Animals implements Living { 

  private $hungry = 0;

  private $thirsty = 0;

  private $gender;  

  private $age = 1; 

  public function eats() { 
    return true; 
  }

  public function drinks() { 
    return true;
  }

  public function breeds() { 
    return true; 
  }

  public function surviveWeather() { 
    return true; 
  }

  public function age() { 
    return true; 
  }

}

