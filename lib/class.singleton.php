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

//NB: used for PHP 5.0-5.2 compatibility
//TODO: remove after dropping 5.2 support
if(!function_exists('get_called_class')) {
    function get_called_class($bt = false,$l = 1)
    {
        if (!$bt) $bt = debug_backtrace();
        if (!isset($bt[$l])) throw new Exception("Cannot find called class -> stack level too deep.");
        if (!isset($bt[$l]['type'])) {
            throw new Exception ('type not set');
        }
        else switch ($bt[$l]['type']) {
            case '::':
                $lines = file($bt[$l]['file']);
                $i = 0;
                $callerLine = '';
                do {
                    $i++;
                    $callerLine = $lines[$bt[$l]['line']-$i] . $callerLine;
                } while (stripos($callerLine,$bt[$l]['function']) === false);
                preg_match('/([a-zA-Z0-9\_]+)::'.$bt[$l]['function'].'/',
                            $callerLine,
                            $matches);
                if (!isset($matches[1])) {
                    // must be an edge case.
                    throw new Exception ("Could not find caller class: originating method call is obscured.");
                }
                switch ($matches[1]) {
                    case 'self':
                    case 'parent':
                        return get_called_class($bt,$l+1);
                    default:
                        return $matches[1];
                }
                // won't get here.
            case '->': switch ($bt[$l]['function']) {
                    case '__get':
                        // edge case -> get class of calling object
                        if (!is_object($bt[$l]['object'])) throw new Exception ("Edge case fail. __get called on non object.");
                        return get_class($bt[$l]['object']);
                    default: return $bt[$l]['class'];
                }

            default: throw new Exception ("Unknown backtrace method type");
        }
    }
}