<?php 

class Animal { 

  const MALE = 'male';

  const FEMALE = 'female';

  private static $valid_genders = array(
    self::MALE, self::FEMALE
  ); 

  private $hungry = 0;

  private $thirsty = 0;

  private $gender; 

  private $species;

  private $type;  

  private $age = 1; 

  public function __construct($species) {
    $this->species = $species; 
    $this->type = $species->name;
  }

  public function setAge($age) {  
    $this->age = $age;
  }

  public function incrementAge(){ 
    $this->age++;
  }

  public function incrementHungry(){ 
    $this->hungry++;
  }

  public function incrementThirsty(){ 
    $this->thirsty++;
  }

  public function notHungry(){ 
    $this->hungry = 0;
  }

  public function setGender($gender){
    if (!in_array($gender, self::$valid_genders)){ 
      throw new Exception('Not a valid gender for the Animal');
    }  

    $this->gender = $gender;
  }

  public function setByRandomBreedAge(){
    return mt_rand($this->species->minimum_breeding_age, $this->species->maximum_breeding_age);
  }

}