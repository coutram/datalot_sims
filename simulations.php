<?php 

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

include_once('include.php');

$import = new Import();
$import->setFilename("config.txt");
$import->runImport(); 

$import_array = $import->getImportVars(); 
$simulation = new Simulation(); 
$simulation->setImportVars($import_array);
$simulation->setParameters();
$simulation->runIterations(); 

