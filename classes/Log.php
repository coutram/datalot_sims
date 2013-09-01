<?php

/**
 * Singleton class to do logging
 */
class Log extends Singleton { 

  public function output($msg) { 
    echo $msg."\n"; 
  }

  public function debug($msg) { 
    if(DEBUG) { 
      $this->output($msg);
    }
  }

}