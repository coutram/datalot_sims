<?php 

/**
 * very simple controller that does the import
 * then runs the iterations of the simulation
 */

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

include_once('include.php');

$import = new Import();
$import->setFilename("config.txt");
$import->runImport(); 

$import_array = $import->getImportVars(); 


$parameters = new Parameters(); 
$parameters->parseImportArray($import_array); 

$iter = new Iteration(); 
$iter->setParameters($parameters);
$iter->runIterations(); 

$export = new Export(); 
$export->openFile();
$export->setIterations($parameters->getIterations());
$export->setYears($parameters->getYears());
$export->outputToFile();
$export->closeFile();