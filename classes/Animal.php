<?php 
/**
 * A single animal object
 */
class Animal { 

  const MALE = 'male';
  const FEMALE = 'female';

  /**
   * Valid genders 
   * @var array
   */
  private static $valid_genders = array(
    self::MALE, self::FEMALE
  ); 

  /**
   * counter for the animal able to eat if food is avail  
   */
  private $hungry = 0;

  /**
   * was the animal thirsty 
   * @var int 
   */
  private $thirsty = 0;

  /**
   * gender of the animal 
    * @var string
   */
  private $gender; 

  /**
   * species object of the animal 
   * @var string
   */
  private $species;

  /**
   * type of animal 
   * @var string
   */
  private $type;  

  /**
   * age of animal 
   * @var int 
   */
  private $age = 1; 

  /**
   * Months pregnant
   * @var int
   */
  private $pregnant = 0; 

  /**
   * @param Species $species
   */
  public function __construct($species) {
    $this->species = $species; 
    $this->type = $species->name;
  }

  /**
   * setter for age
   * @param int $age 
   */
  public function setAge($age) {  
    $this->age = $age;
  }

  /**
   * getter for age
   */
  public function getAge(){
    return $this->age; 
  }

  /**
   * getter for species
   */
  public function getSpecies(){ 
    return $this->species;
  }

  /**
   * getter for thirsty
   */
  public function getThirsty(){ 
    return $this->thirsty;
  }

  /**
   * getter for hungry
   */
  public function getHungry(){
    return $this->hungry;
  }

  /**
   * getter for gender
   */
  public function getGender(){
    return $this->gender;
  }

  /**
   * increments age 
   */
  public function incrementAge(){ 
    $this->age++;
  }

  /**
   * increment for hungry 
   */
  public function incrementHungry(){ 
    $this->hungry++;
  }

  /**
   * increment for thirsty
   */
  public function incrementThirsty(){ 
    $this->thirsty++;
  }

  /**
   * reset hungry counter if animal ate 
   */
  public function notHungry(){ 
    $this->hungry = 0;
  }

  /**
   * setter for gender
   */
  public function setGender($gender){
    if (!in_array($gender, self::$valid_genders)){ 
      throw new Exception('Not a valid gender for the Animal');
    }  

    $this->gender = $gender;
  }

  /**
   * setter for age by a random breeding age for initial sim
   */
  public function setByRandomBreedAge(){
    $dr = new Dieroll($this->species->minimum_breeding_age, $this->species->maximum_breeding_age);
    return $dr->roll();
  }
}