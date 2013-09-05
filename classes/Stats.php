<?php
/**
 * Record the stats of the simuation 
 */
class Stats extends Singleton { 

  const DB_NAME = 'datalot';
  const COLLECTION_NAME = 'sim_stats';

  /**
   * The DB Object
   * @var MongDB/MongoCollection
   */
  protected $db;

  /**
   * The species name of the current stat
   * @var string 
   */
  protected $species; 

  /**
   * The habitat name of the current stat for this simulation
   * @var string
   */
  protected $habitat;

  /**
   * Population of the species on this habitat for this simulation
   * @var int
   */
  protected $population = 0; 

  /**
   * The Max Population of an iteration
   * @var int
   */
  protected $max_population = 0; 

  /**
   * The deaths that have occured in this simulation
   * @var int
   */
  protected $deaths = 0; 

  /**
   * The offspring that have been born in this simulation 
   * @var int
   */
  protected $offspring = 0;

  /**
   * Array of details of the cause of deaths in this simulation 
   * @var array
   */
  protected $die_cause = array(
    'starvation' => 0,
    'age' => 0,
    'thirst' => 0,
    'cold_weather' => 0,
    'hot_weather' => 0,
  );

  public function __construct(){
    $this->setMongoCollection();
  }

  /**
   * Setting up the db mongo connection 
   */
  private function setMongoCollection(){
    $db_name = self::DB_NAME;
    $collection = self::COLLECTION_NAME; 
    $mongo = new Mongo();
    $db = $mongo->$db_name; 
    $this->db = $db->$collection;
    $this->db->drop();
  }

  /**
   * Set the species name
   */
  public function setSpecies($species) { 
    $this->species = $species;
  }

  /**
   * Set the habitat name
   */
  public function setHabitat($habitat) { 
    $this->habitat = $habitat;
  }

  /**
   * Set the iteration name
   */
  public function setIteration($iter) { 
    $this->iter = $iter;
  }

  /**
   * Increment the offspring
   */
  public function incOffspring(){ 
    $this->offspring++;
  }

  /**
   * If the max is higher set the max 
   */
  public function setMax($max){ 
    if($max > $this->max_population){ 
      $this->max_population = $max;
    }
  }

  /**
   * Increment the deaths 
   */
  public function incDeaths(){ 
    $this->deaths++;
  }

  /**
   * Increment death by starvation 
   */
  public function incStarvation(){ 
    $this->die_cause['starvation']++;
  }

  /**
   * Increment death by thirst
   */
  public function incThirst(){ 
    $this->die_cause['thirst']++;
  }

  /**
   * Increment death by too old  
   */
  public function incTooOld(){ 
    $this->die_cause['age']++;
  }
  
  /**
   * Increment death by too hot 
   */
  public function incTooHot(){ 
    $this->die_cause['hot_weather']++;
  }

  /**
   * Increment death by too cold
   */
  public function incTooCold(){ 
    $this->die_cause['cold_weather']++;
  }

  /**
   * Reset the stats 
   */
  public function resetStats() { 
    
    foreach (array_keys($this->die_cause) as $cause) { 
      $this->die_cause[$cause] = 0;
    }

    $this->deaths = 0; 
    $this->offspring = 0;
    $this->population = 0;
    $this->max_population = 0;
  }

  /**
   * Set the population 
   * @param int $pop
   */
  public function setPopulation($pop) { 
    $this->population = $pop;
  }

  /**
   * Insert the stats into the db 
   */
  public function insertStats() { 
    $insert_array = array(
      'species' => $this->species,
      'habitat' => $this->habitat,
      'population' => $this->population,
      'max_population' => $this->max_population,
      'offspring' => $this->offspring,
      'deaths' => $this->deaths,
      'die_cause' => $this->die_cause
    );
    $this->db->insert($insert_array);
  }

  /**
   * Set the stats 
   */
  public function getStats(){ 
    $result = array();
    $group_by = array(
      '$group' => array(
         '_id' => array(
            'species' => '$species',
            'habitat' => '$habitat',
          ),
          'average'  => array( 
            '$avg' => '$population'
          )
      )
    );

    $avg_pop = $this->db->aggregate($group_by);
    foreach ($avg_pop['result'] as $pop){ 
      $species = $pop['_id']['species'];
      $habitat = $pop['_id']['habitat'];

      $result[$species][$habitat]["avg"] = $pop['average'];

      $where =  array(
        'species' => $species, 
        'habitat' => $habitat 
      );

      $cursor = $this->db->find($where);
      
      $deaths = 0;
      $population = 0;
      $starvation = 0;
      $thirst = 0;
      $age = 0;
      $hot_weather = 0;
      $cold_weather = 0;

      $result[$species][$habitat]["max"] = 0;
      foreach ($cursor as $cur) { 
        $deaths += $cur['deaths'];
        $population += $cur['population'];
        $result[$species][$habitat]["max"] = $cur["max_population"];

        foreach ($cur['die_cause'] as $cause => $amount)  { 
          $$cause+=$amount;
        }
      }

      $result[$species][$habitat]["mortality"] = round(($deaths/$population)*100,2);
      $result[$species][$habitat]["deaths"] = $deaths;
      foreach(array_keys($this->die_cause) as $cause) { 
        $percent = $$cause/$deaths*100;
        $result[$species][$habitat]["cause"][$cause] = round($percent, 2); 
      }
    }

    return $result;
  }
}