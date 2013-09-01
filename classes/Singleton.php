<?php 
/**
 * Singleton parent -- extend to build singleton classes 
 */
class Singleton {
    protected static $instance = null;

    protected function __construct(){ }
    
    protected function __clone(){ }

    public static function instance() {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }
}