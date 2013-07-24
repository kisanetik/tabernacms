<?php

/**
 * For simply create Singleton pattern
 *
 * @author Denys Yackushev
 * @datecreated 19 December 2011
 * @package RADCMS
 */
abstract class rad_singleton 
{
    protected static $instances = array();

    protected function __construct(){ }
    
    protected function __clone(){ }

    protected function __wakeup(){}

    /**
     * Return exemplar of of object from called class 
     * @return rad_singleton
     */
    public static function getInstance() 
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
}
