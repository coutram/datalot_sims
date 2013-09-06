<?php 

class Export { 

  const OUTPUT_FILE = 'output.txt';

  /**
   *  filename var
   */
  private $filename; 

  /**
   * 
   */
  private $fp; 

  /**
   * 
   */
  private $iter;

  /**
   * 
   */
  private $years;

  public function __construct() {   }
 
  /**
   * 
   */
  public function openFile() { 
    $this->setFilename();

    if(file_exists($this->filename)) { 
      @unlink($this->filename);
    } 

    $this->fp = fopen($this->filename, 'w');
  }

  /**
   * Sets the iterations
   */
  public function setIterations($iter){
    $this->iter = $iter; 
  }

  /**
   * Get the iterations 
   */
  private function getIterations(){ 
    return $this->iter;
  }

  /**
   * Sets the years 
   */
  public function setYears($years){
    $this->years = $years; 
  }

  /**
   * Get the years 
   */
  private function getYears(){
    return $this->years;
  }

  /**
   * 
   */
  public function outputToFile(){ 
    $title = "Simulation ran for ".$this->getIterations()." iterations at ".$this->getYears()." years per iteration";
    $this->writeFile($title);

    $stats = Stats::instance()->getStats();

    foreach ($stats as $species => $species_array) { 
      $this->writeFile($species.":");

      foreach ($species_array as $habitat => $habitat_array) { 
        $this->writeFile("\t".$habitat.":");
        $this->writeFile("\t\tAverage Population: ".$habitat_array['avg']);
        $this->writeFile("\t\tMax Population: ".$habitat_array['max']);
        $this->writeFile("\t\tMortality Rate: ".$habitat_array['mortality']."%");
        $this->writeFile("\t\tCause of Death: ");
        
        foreach ($habitat_array['cause'] as $cause => $percentages){ 
          $this->writeFile("\t\t\t$percentages%: $cause");
        }
      }
    }
  }

  /**
   * 
   */
  public function writeFile($msg){
    fwrite($this->fp, $msg.PHP_EOL);
  }

  /**
   * close the file 
   */
  public function closeFile(){ 
    fclose($this->fp);
  }

  /**
   * set the filename 
   * @param $filename
   */
  private function setFilename() { 
    $this->filename = self::OUTPUT_FILE;
  }
}