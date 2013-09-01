<?php 

// Report all PHP errors (see changelog)
error_reporting(E_ALL);

include_once('include.php');

$import = new Import();
$import->setFilename("config.txt");

$import->runImport(); 