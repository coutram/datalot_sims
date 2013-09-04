<?php 
/**
 * Singleton parent -- extend to build singleton classes 
 */
class Singleton {
 
    private static $instances = array( );
 
    protected function __construct(){  }
 
    protected function __clone(){  }

    public static function instance(){
        $cls = get_called_class();
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }
        return self::$instances[$cls];
    }
}