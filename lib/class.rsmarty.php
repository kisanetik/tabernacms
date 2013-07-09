<?php
 /**
  * Internal class for smarty for RAD CMS
  * @package RADCMS
  *
  */
 class rad_rsmarty
 {
    /**
    * Smarty object
    *
    * @var Smarty class
    */
    protected static $object = null;

    private function __construct(){}

    /**
     * Returns Smarty Object or null
     * @var Smarty
     * @return Smarty
     */
    public static function getSmartyObject()
    {
        if(!self::$object) {
            if (!class_exists('Smarty', false)) {
                if (!file_exists(SMARTYPATH.'Smarty.class.php')) {
                    die(SMARTYPATH.'Smarty.class.php does not exists!');
                }
                include_once SMARTYPATH.'Smarty.class.php';
            }
            self::$object=new Smarty;
            self::$object->compile_check = rad_config::getParam('smarty.compile_check',true);
            self::$object->debugging     = rad_config::getParam('smarty.debugging;',false);
            self::$object->template_dir  = rad_config::getParam('rootPath'); //NB: Looks like this parameter is never used since we use absolute adressing.
            self::$object->compile_dir   = SMARTYCOMPILEPATH;
            self::$object->caching       = rad_config::getParam('smarty.caching',false);
            self::$object->cache_dir     = SMARTYCACHEPATH;
            self::$object->muteExpectedErrors();
            self::$object->loadPlugin('smarty_compiler_switch');
        }
        return self::$object;
    }
}