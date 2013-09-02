<?php 

class Herd implements Living { 

  private $animals; 

  public function addAnimal($animal) { 
    $this->animals[] = $animal;
  }

  public function get() { 
    return $this->animals; 
  }

  public function count() { 
    return count($this->animals);
  }

  public function random() { 
    shuffle($this->animals);
  }

  public function eats() { 
    return true; 
  }

  public function drinks() { 
    return true;
  }

  public function breeds() { 
    return true; 
  }

  public function survive() { 
    return true; 
  }

  public function age() { 
    return true; 
  }

}

