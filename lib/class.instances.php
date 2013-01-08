<?php
/**
 * Simple collector of the classes exemplars!
 * @package RADCMS
 */
class rad_instances
{
    protected static $cache = null;

    protected static $current_template = '';

    protected static $current_module = '';

    protected static $modules_messages = array();

    protected static $modules_hash = array();

    function __construct()
    {
    	die('You can\'t create the system class!!!');
    }

    /**
     * Gets the exemplar of the class
     *
     * @param $classname string
     *
     * @return rad_model
     */
    public static function get($classname='')
    {
        if(!isset(self::$cache[$classname])) {
            self::$cache[$classname] = new $classname();
        } else {
            self::$cache[$classname]->clearState();
        }
        return self::$cache[$classname];
    }

    public static function setParamsFor($controller,$params)
    {
    	self::$modules_hash[$controller] = $params;
    }

    /**
     * Gets the params object for controller
     *
     * @param string $controller
     * @return rad_paramsobject
     */
    public static function getParamsFor($controller)
    {
    	if(isset(self::$modules_hash[$controller])){
    		return self::$modules_hash[$controller];
    	}else{
    		return NULL;
    	}
    }

    public static function setCurrentTemplate($tmplname)
    {
        self::$current_template = $tmplname;
    }

    public static function getCurrentTemplate()
    {
        return self::$current_template;
    }

    public static function setCurrentController($module)
    {
        self::$current_module = $module;
    }

    public static function getCurrentController()
    {
        return self::$current_module;
    }

    public static function sentToModule($module,$message)
    {
        self::$modules_messages[$module][] = $message;
    }

    public static function getToModule($module)
    {
        if(isset($module))
            return self::$modules_messages[$module];
        else
            return NULL;
    }
}