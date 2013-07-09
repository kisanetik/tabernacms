<?php
/**
 * Collector of JS and CSS-files
 * @author Roman Chertov
 *
 * @example
 * rad_jscss::includeJS('wysiwyg.js', 'sync');
 *  * ...
 * rad_jscss::getHeaderCode();
 */
class rad_jscss
{
    private static $maintpl_files;
    private static $files;
    private static $inline_js;
    private static $themeName;

    private static function addFile($module, $filename, $html) {
        //TODO: decide what should we do if the same $module/$filename is called multiple times with different $html.
        //TODO: Looks like we have to refactor this class.
        if (rad_instances::isMainTemplate()) {
            if (isset(self::$maintpl_files[$module][$filename])) {
                self::$maintpl_files[$module][$filename]['template'][] = rad_instances::getCurrentTemplate();
            } else {
                self::$maintpl_files[$module][$filename] = array(
                    'html' => $html,
                    'template' => array(rad_instances::getCurrentTemplate())
                );
            }
        } else {
            if (isset(self::$files[$module][$filename])) {
                self::$files[$module][$filename]['template'][] = rad_instances::getCurrentTemplate();
            } else {
                self::$files[$module][$filename] = array(
                    'html' => $html,
                    'template' => array( rad_instances::getCurrentTemplate() )
                );
            }
        }
    }

    private static function _renewCache($module, $file, $type){
        $filename = str_replace('/', DS, $file);

        $cacheFile = CACHEPATH.$type.DS.self::$themeName.DS.$module.DS.$filename;
        $cachePath = dirname($cacheFile);
        if (!file_exists($cachePath))
            recursive_mkdir($cachePath);
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < rad_config::getParam('cache.power.time')))
            return true;

        if ($fname = getThemedComponentFile($module, 'jscss', $filename)){
            return copy($fname, $cacheFile);
        }
        return false;
    }

    private static function checkTheme(){
        if (empty(self::$themeName)) {
            self::$themeName = rad_loader::getCurrentTheme();
            if (empty(self::$themeName)) self::$themeName = 'default';
        }
        return self::$themeName;
    }
    /**
     *
     * @static
     * @param $filename
     * @param string $mode - defer|async|sync, default value is "defer"
     */
    public static function includeJS($module, $filename, $mode='defer', $tag=1)
    {
        $theme = self::checkTheme();
        if ($module) {
            self::_renewCache($module, $filename, 'js');
            $url = SITE_URL."cache/js/{$theme}/{$module}/{$filename}";
        } else {
            $url = SITE_URL."libc/{$filename}";
        }
        //TODO: is this code really needed?
        //$url = (substr($filename, 0, 6)=='jscss/' || substr($filename, 0, 4)=='img/')
        //    ? SITE_URL.$filename
        //    : rad_input::makeURL($filename);

        $load = '';
        switch ($mode) {
            case 'async':
                $load .= " async='true'";
            case 'defer': //NB: also for "async" mode for IE compatibility
                $load .= " defer='true'";
        }
        $html = "<script type='text/javascript' src='{$url}'{$load}></script>";

        if ($tag) {
            self::addFile($module, $filename, $html);
            return '';
        }
        return $html;
    }

    public static function inlineJS($code, $dom_ready=false)
    {
        if (!self::$inline_js) {
            self::$inline_js = '';
        }
        if ($dom_ready) {
            $code = ' $(function() {'.$code.'});';
        }
        self::$inline_js.= $code;
    }

    public static function includeCSS($module, $filename)
    {
        $theme = self::checkTheme();
        self::_renewCache($module, $filename, 'css');
        $url = SITE_URL."cache/css/{$theme}/{$module}/{$filename}";
        self::addFile($module, $filename, "<link rel='stylesheet' type='text/css' href='{$url}' />");
    }

    /**
     * Return HTML code to insert in <head> section
     * @static
     * @return string
     */
    public static function getHeaderCode()
    {
        $return = '';
        if (!empty(self::$maintpl_files)) {
            foreach (self::$maintpl_files as $module => $files) {
                foreach($files as $filename => $file){
                    $return .= $file['html'];
                }
            }
        }
        if (!empty(self::$files)) {
            foreach (self::$files as $module => $files) {
                foreach($files as $filename => $file){
                    if (!isset(self::$maintpl_files[$module][$filename])) {
                        $return .= $file['html'];
                    }
                }
            }
        }
        if (!empty(self::$inline_js)) {
            $return .= "<script language='JavaScript' type='text/javascript'>\n".self::$inline_js."\n</script>";
        }
        return $return;
    }
}