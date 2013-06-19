<?php
/**
 * Loader class that used the smarty templates
 * @package RADCMS
 * @author Denys Iackushev
 *
 */
class rad_sloader extends rad_loader 
{

    /**
     * For the result html entries
     * @var mixed array
     */
    protected static $_html = null;

    /**
     * Main function to init the loader from request
     *
     */
    public static function init() {
        parent::init();
        self::parseTemplates();
        self::show();
    }

    /**
     * parse templates from alias and assing variables from Controller To Templates
     * Also I think I can do that in function show()
     */
    public static function parseTemplates()
    {
        $o = rad_rsmarty::getSmartyObject();
        if (rad_config::getParam('lang.caching')) {
            $templates = array();
            foreach (self::$_alias->includes as $id) {
                $templates[] = self::$_includes[$id->inc_name];
            }
            self::loadLangCache($templates);
        }
        //No needed - fix to {lang code= in older modules
        rad_instances::setCurrentTemplate('BREADCRUMBS');
        self::$_langContainer->setTemplate('BREADCRUMBS');
        define(rad_config::getParam('bc.title'), rad_breadcrumbs::getTitle());
        define(rad_config::getParam('bc.meta_description'), rad_breadcrumbs::getMetaDescription());
        define(rad_config::getParam('bc.meta_tags'), rad_breadcrumbs::getMetaTags());
        define(rad_config::getParam('bc.breadcrumbs'), rad_breadcrumbs::getBreadcrumbs());
        foreach(self::$_alias->includes as $id) {
            if (isset(self::$_controllerResults[$id->incinal_id]) and (self::$_controllerResults[$id->incinal_id])) {
                if (isset(self::$sendedParams[$id->inc_filename]) and count(self::$sendedParams[$id->inc_filename])) {
                    foreach (self::$sendedParams[$id->inc_filename] as $pkey => $pval) {
                        $o->assign($pkey, $pval);
                    }
                }
                $data = self::$_controllerResults[$id->incinal_id]->getVars();
                if (count($data)) {
                    foreach ($data as $key => $value) {
                        $o->assign($key, $value);
                    }//foreach
                }//if
            }
            if (!isset(self::$_html[$id->rp_name])) {
                self::$_html[$id->rp_name] = '';
            }
            rad_instances::setCurrentTemplate(self::$_includes[$id->inc_name]);
            self::$_langContainer->setTemplate(self::$_includes[$id->inc_name]);
            $o->assign('_CURRENT_LOAD_PATH', dirname(self::$_includes[$id->inc_name]));
            $o->assign('_CURR_LANG_OBJ', rad_lang::getCurrentLanguage());
            self::$_html[$id->rp_name] .= $o->fetch(self::$_includes[$id->inc_name]);
            $o->clearAllAssign();
        }//foreach
    }

    /**
     * Alias for rad_lang_container->_()
     * @param $code string - Language code
     * @param $language string - Language like en,ru,us,uk
     * @return string code value if exists, or code
     */
    public static function lang($code='', $language=NULL) {
        return self::$_langContainer->_($code, $language);
    }

    /**
     * Saves all cached lang codes
     */
    public static function saveLangCache() {
        self::$_langContainer->saveAllCache();
    }

    /**
     * Loads the language cache
     * @param array $templates - filenames
     */
    private static function loadLangCache($templates) {
        self::$_langContainer->loadCacheForTemplates($templates);
    }

    /**
     * Function that called to show al variables and all the page!
     */
    public static function show() {
        $o = rad_rsmarty::getSmartyObject();
        //TODO optimize memory
        if (count(self::$_html)) {
            foreach (self::$_html as $key => $value) {
                $o->assign($key, $value);
            }
        }
        $o->assign('_CURR_LANG_', rad_lang::getCurrentLanguage());
        if (isset(self::$sendedParams[self::$_alias->filename])) {
            foreach (self::$sendedParams[self::$_alias->filename] as $pkey => $pval) {
                $o->assign($pkey, $pval);
            }
        }
        if (defined('SYSTEMMAINTEMPLATESPATH')
            and is_file(SYSTEMMAINTEMPLATESPATH.self::$_alias->filename.'.tpl')
            and (
                 !file_exists(THEMESPATH.self::$theme.DS.'maintemplates'.DS.self::$_alias->filename.'.tpl')
                 or !MAINTEMPLATESPATH.self::$_alias->filename . '.tpl'
                )
        ) {
			$fileName = SYSTEMMAINTEMPLATESPATH.self::$_alias->filename.'.tpl';
        } elseif (file_exists(THEMESPATH.self::$theme.DS.'maintemplates'.DS.self::$_alias->filename.'.tpl')) {
			$fileName = THEMESPATH.self::$theme.DS.'maintemplates'.DS.self::$_alias->filename.'.tpl';
        } else {
			$fileName = MAINTEMPLATESPATH.self::$_alias->filename.'.tpl';
        }
		rad_instances::setCurrentTemplate($fileName, true);
		$o->display($fileName);
    }

}