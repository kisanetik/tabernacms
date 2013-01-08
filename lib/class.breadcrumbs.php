<?php
/**
 * Breadcrumbs system class
 * @author Yackushev Denys
 * @package RADCMS
 * @datecreated 28.03.2009
 */
class rad_breadcrumbs
{
    /**
     * Value and vals
     * @var array mixed
     */
    private static $_varvals = array();

    /**
     * Title of the page
     * @var string(text)
     */
    private static $_title = null;

    /**
     * META-descriptions of the page
     * @var string(text)
     */
    private static $_description = null;

    /**
     * META-Tags of the page
     * @var string(text)
     */
    private static $_tags = null;

    /**
     * Title script
     * @access public
     * @var string
     */
    public static $title_script = '';

    /**
     * META-title script
     * @access public
     * @var string
     */
    public static $meta_script = '';

    /**
     * Script for breadcrumbs
     * @var string
     * @access public
     */
    public static $breadcrumbs_script = '';

    /**
     * META-Description script
     * @var string
     * @access public
     */
    public static $description_script = '';

    /**
     * Breadcrumbs on the page
     * @var string(text)
     */
    private static $_breadcrumbs = null;



    /**
     * Compille the script and return the string
     * @param string $txt - the script
     * @param Smarty $o - smarty object
     * @access private
     * @return string(text || html)
     */
    private static function _compille($txt,$o)
    {
        $mas = array();
        foreach(self::$_varvals as $classname=>$vrnn) {
            foreach($vrnn as $varname=>$varvalue) {
                if(is_string($varvalue)) {
                    $txt = str_replace('<%'.$classname.'.'.$varname.'%>',$varvalue,$txt);
                }
                $o->assign('<%'.$classname.'.'.$varname.'%>',$varvalue);
            }
            $o->assign($classname,$vrnn);
        }
        $search = array("\r","\n","\t");
        $replace = array('','','');
        $txt = str_replace($search,$replace,$txt);
        return $txt;
    }

    /**
     * Init and gets all the params and make the html strings!
     * @return Boolean - if all is good
     */
    public static function initandmake($title_script,$bc_script,$meta_script,$descr_script)
    {
        $return = true;
        self::$title_script = $title_script;
        self::$meta_script = $meta_script;
        self::$breadcrumbs_script = $bc_script;
        self::$description_script = $descr_script;
        $o = rad_rsmarty::getSmartyObject();
        $o->registerResource('bc', new rad_smartybc());
        $o->assign('lang',call_user_func(array(rad_config::getParam('loader_class'),'getLangContainer')));
        self::$title_script = self::_compille(self::$title_script,$o);
        self::$_title = $o->fetch('bc:title_script');
        self::$breadcrumbs_script = self::_compille(self::$breadcrumbs_script,$o);
        self::$_breadcrumbs = $o->fetch('bc:breadcrumbs_script');
        self::$meta_script = self::_compille(self::$meta_script,$o);
        self::$_tags = $o->fetch('bc:meta_script');
        self::$description_script = self::_compille(self::$description_script,$o);
        self::$_description = $o->fetch('bc:description_script');
        $o->clearAllAssign();
        return $return;
    }

    /**
     * Adds the $varvalue with $varname to breadcrubms cache with $classname
     * @param string $varname
     * @param mixed $varvalue
     * @param string $classname
     */
    public static function add($varname,$varvalue,$classname)
    {
        self::$_varvals[$classname][$varname] = $varvalue;
        return true;
    }

    /**
     * Gets the breadcrumbsobject from classname
     *
     * @param string $classname
     * @return rad_breadcrumbsobject
     */
    public static function getBCOFromClass($classname)
    {
        return call_user_func( array($classname,'getBreadcrumbsVars') );
    }

    /**
     * Title of the page
     * @return string
     */
    public static function getTitle()
    {
        return self::$_title;
    }

    /**
     * Returns the metadescription
     * @return string
     */
    public static function getMetaDescription()
    {
        return self::$_description;
    }

    /**
     * Returns the metatags
     * @return string
     */
    public static function getMetaTags()
    {
        return self::$_tags;
    }

    /**
     * Gets the breadcrumbs
     * @return string html
     */
    public static function getBreadcrumbs()
    {
        return self::$_breadcrumbs;
    }
}