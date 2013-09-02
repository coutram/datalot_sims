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
$iter = new Iteration(); 
$iter->setImportVars($import_array);
$iter->setParameters();
$iter->runIterations(); 

