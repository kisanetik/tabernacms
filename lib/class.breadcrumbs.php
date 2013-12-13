<?php
/**
 * Breadcrumbs system class
 * @author Yackushev Denys, Ryazanov Alex
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
     * Breadcrumbs on the page
     * @var string(text)
     */
    private static $_breadcrumbs = null;

    /**
     * Init and gets all the params and make the html strings!
     * @return Boolean - if all is good
     */
    public static function initandmake(struct_core_alias $alias){
        $o = rad_rsmarty::getSmartyObject();
        $o->assign('lang',call_user_func(array(rad_config::getParam('loader_class'),'getLangContainer')));
        foreach(self::$_varvals as $classname => $vrnn) {
            foreach($vrnn as $varname => $varvalue) {
                $o->assign('<%'.$classname.'.'.$varname.'%>', $varvalue);
            }
            $o->assign($classname, $vrnn);
        }
        $srcPrefix = SMARTYBCCACHE.'alias_'.$alias->id.'_';
        self::$_title = self::_fetchSrc($o, $srcPrefix.'title.tpl', $alias->title_script);
        self::$_breadcrumbs = self::_fetchSrc($o, $srcPrefix.'bc.tpl', $alias->navi_script);
        self::$_tags = self::_fetchSrc($o, $srcPrefix.'meta.tpl', $alias->metatitle_script);
        self::$_description = self::_fetchSrc($o, $srcPrefix.'descr.tpl', $alias->metadescription_script);
        $o->clearAllAssign();
        return true;
    }
    private static function _fetchSrc(Smarty $o, $filePath, $content){
        if (!is_file($filePath)) {
            file_put_contents($filePath, $content);
        }
        return $o->fetch($filePath);
    }

    public static function cleanAliasCache($aliasId){
        array_map('unlink', glob(SMARTYBCCACHE.'alias_'.$aliasId.'_*.tpl'));
    }

    /**
     * Adds the $varvalue with $varname to breadcrubms cache with $classname
     * @param string $varname
     * @param mixed $varvalue
     * @param string $classname
     */
    public static function add($varname,$varvalue,$classname){
        self::$_varvals[$classname][$varname] = $varvalue;
        return true;
    }

    /**
     * Gets the breadcrumbsobject from classname
     *
     * @param string $classname
     * @return rad_breadcrumbsobject
     */
    public static function getBCOFromClass($classname){
        return call_user_func(array($classname, 'getBreadcrumbsVars'));
    }

    /**
     * Title of the page
     * @return string
     */
    public static function getTitle(){
        return self::$_title;
    }

    /**
     * Returns the metadescription
     * @return string
     */
    public static function getMetaDescription(){
        return self::$_description;
    }

    /**
     * Returns the metatags
     * @return string
     */
    public static function getMetaTags(){
        return self::$_tags;
    }

    /**
     * Gets the breadcrumbs
     * @return string html
     */
    public static function getBreadcrumbs(){
        return self::$_breadcrumbs;
    }
}