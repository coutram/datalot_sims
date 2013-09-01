<?php 

class Parameters  { 

  const SPECIES = 'species'; 

  const HABITAT = 'habitats';

  const YEARS = 'years';

  const ITERATIONS = 'iterations';

  private $years; 

  private $iterations; 

  private $species; 

  private $habitats;

	public function __construct($import_vars) { 
    $this->parseImportArray($import_vars); 
  }

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

  public function getIterations() { 
    return $this->iterations;
  }

  public function getYears(){ 
    return $this->years;
  }

  public function getSpecies() { 
    return $this->species;
  }

  public function getHabitats(){ 
    return $this->habitats;
  }

}