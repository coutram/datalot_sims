<?php
function __autoload($class_name) {
    include_once 'classes/'.$class_name . '.php';
}

define('DEBUG', 0);