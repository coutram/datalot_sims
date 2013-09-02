<?php 
/**
 * Parse the values of from the YAML config 
 */
class Parameters  { 

  const SPECIES = 'species'; 
  const HABITAT = 'habitats';
  const YEARS = 'years';
  const ITERATIONS = 'iterations';

  /**
   * var from the YAML 
   * @var int 
   */
  private $years; 

  /**
   * var from the YAML 
   * @var int 
   */
  private $iterations; 

  /**
   * var from the YAML 
   * @var array
   */
  private $species; 

  /**
   * var from the YAML 
   * @var array
   */
  private $habitats;

	public function __construct($import_vars) { 
    $this->parseImportArray($import_vars); 
  }

  /**
   * parse the values into our parameters 
   * @var array 
   */
  private function parseImportArray($import_vars) { 
    $this->years = $import_vars[self::YEARS];
    $this->iterations = $import_vars[self::ITERATIONS];

    // how i love dealing with a word that's singular and plural =) 
    foreach ($import_vars[self::SPECIES] as $species)  { 
      $this->species[] = new Species($species);
    }

    foreach ($import_vars[self::HABITAT] as $habitat)  { 
      $this->habitats[] = new Habitat($habitat);
    }
  } 

  /**
   * getter for iterations
   */
  public function getIterations() { 
    return $this->iterations;
  }

  /**
   * getter for years
   */
  public function getYears(){ 
    return $this->years;
  }

  /**
   * getter for species
   */
  public function getSpecies() { 
    return $this->species;
  }

  /**
   * getter for habitat
   */
  public function getHabitats(){ 
    return $this->habitats;
  }

}