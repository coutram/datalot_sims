<?php

interface Living { 
  
  public function eats($habitat_food, $consumption);

  public function drinks($habitat_water, $consumption); 

  public function breeds(); 

  public function survive($temp);

  public function ages(); 

}