<?php

/**
 * Hybridauth class for authorisation and registration with socials
*
* @author Tereshchenko Viacheslav
* @package Taberna
*/

class rad_hybridauth
{
    protected static $_instance;
    
    /**
     * Gets the hybridauth class
     */
    public static function getHybridAuth($config=NULL) 
    {
        if(self::$_instance === NULL) {
            if(!class_exists('Hybrid_Auth') and $config) {
                include_once LIBPATH.'hybridauth'.DS.'Hybrid'.DS.'Auth.php';
                self::$_instance = new Hybrid_Auth($config);
            }
        }
        return self::$_instance;
    }
    
}