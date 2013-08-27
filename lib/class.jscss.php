<?php
/**
 * Collector of JS and CSS-files
 * @author Roman Chertov
 *
 * @example
 * {url type="js" module="core" file="..." load="sync"}
 * ...
 * rad_jscss::getHeaderCode();
 */
class rad_jscss
{
    private static $files = array(0 => array(), 1 => array()); //0 - main template, 1 - component templates.
    private static $file_info = array();
    private static $themeName;

    /**
     * Add html tag to the <head> section
     * @static
     * @param $module
     * @param $filename
     * @param $html
     */
    public static function addFile($module, $filename, $html, $priority = 0)
    {
        //TODO: decide what should we do if the same $module/$filename is called multiple times with different $html.
        $isMain = rad_instances::isMainTemplate();
        $_isMain = $isMain ? 0 : 1; //Main template files first!
        if (isset(self::$file_info[$module][$filename])) {
            self::$file_info[$module][$filename]['templates'][] = rad_instances::getCurrentTemplate();
            if ($_isMain > self::$file_info[$module][$filename]['main'])
                return;
            //NB: We don't need to update priority, since files added in the main template are always loaded
            //before files, added in other templates.
            $old = self::$file_info[$module][$filename];
            if (($old['priority'] > $priority) || ($old['main'] > $_isMain)) {
                self::$file_info[$module][$filename]['main'] = $_isMain;
                self::$file_info[$module][$filename]['priority'] = $priority;
                unset(self::$files[ $old['main'] ][ $old['priority'] ][$module][$filename]);
                self::$files[$_isMain][$priority][$module][$filename] = $html;
            }
        } else {
            self::$file_info[$module][$filename] = array(
                'templates' => array(rad_instances::getCurrentTemplate()),
                'main' => $_isMain,
                'priority' => $priority
            );
            self::$files[$_isMain][$priority][$module][$filename] = $html;
        }
    }

    /**
     * Copy JS/CSS file to cache with replace code:
     * ~~~URL~TYPE=<type>~MODULE=<module>~FILE=<file>~PRESET=<preset>~TAG=<tag>~ATTR=<attr>~~~
     * @static
     * @param string $origFile
     * @param string $cachedFile
     * @return int
     */
    public static function copyToCache($origFile, $cachedFile)
    {
        //TODO: it's not a good method to extract theme name back from $cachedFile path
        $_ = str_replace('\\', '\\\\', DS);
        if (preg_match('~'.$_.'cache'.$_.'(?:js|css|img)'.$_.'([a-zA-Z][a-zA-Z0-9]{2,31})'.$_.'~', $cachedFile, $matches)) {
            $themeName = $matches[1];
        } else {
            throw new rad_exception("Incorrect cached file name: {$cachedFile} - cannot extract theme name!");
        }
        //TODO: maybe it'd be much better to process source file line by line to reduce memory cosumption.
        $s = file_get_contents($origFile);
        if (!function_exists('smarty_function_url')) {
            rad_rsmarty::getSmartyObject()->loadPlugin('smarty_function_url');
        }
        $s = preg_replace_callback(
            '/~~~URL~~(.+)~~~/iU',
            function($match){
                $rows = explode('~~', trim($match[1], '~'));
                $params = array('load' => 'inplace');
                foreach ($rows as $row) {
                    $parts = explode('=', $row, 2);
                    if (count($parts) == 2) {
                        $key = strtolower($parts[0]);
                        if (!isset($params[$key])) {
                            $params[$key] = $parts[1];
                        }
                    }
                }
                return smarty_function_url($params, null);
            },
            $s
        );
        $s = preg_replace('/~~~THEMENAME~~~/', $themeName, $s);
        return file_put_contents($cachedFile, $s);
    }

    private static function _renewCache($module, $file, $type){
        $filename = fixPath($file);

        $cacheFile = CACHEPATH.$type.DS.self::$themeName.DS.$module.DS.$filename;
        $cachePath = dirname($cacheFile);
        if (!file_exists($cachePath))
            recursive_mkdir($cachePath);
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < rad_config::getParam('cache.power.time')))
            return true;

        if ($fname = rad_themer::getFilePath(self::$themeName, 'jscss', $module, $filename)){
            return self::copyToCache($fname, $cacheFile);
        }
        return false;
    }

    private static function checkTheme(){
        if (empty(self::$themeName)) {
            self::$themeName = rad_themer::getCurrentTheme();
        }
        return self::$themeName;
    }

    /**
     * Get link to JavaScript file
     * @static
     * @param string $module
     * @param string $filename
     * @return string
     */
    public static function getLinkToJS($module, $filename)
    {
        return self::_getLinkTo($module, $filename, 'js');
    }

    /**
     * Get link to CSS file
     * @static
     * @param string $module
     * @param string $filename
     * @return string
     */
    public static function getLinkToCSS($module, $filename)
    {
        return self::_getLinkTo($module, $filename, 'css');
    }

    private static function _getLinkTo($module, $filename, $type){
        $theme = self::checkTheme();
        if ($module) {
            self::_renewCache($module, $filename, $type);
            return SITE_URL."cache/{$type}/{$theme}/{$module}/{$filename}";
        }
        return SITE_URL."libc/{$filename}";
    }

    /**
     * Return HTML code to insert in <head> section
     * @static
     * @return string
     */
    public static function getHeaderCode()
    {
        $return = '';
        //DEBUG: $return .= '<!--'.print_r(self::$files, true).'-->';
        for ($i=0; $i<=1; $i++) {
            ksort(self::$files[$i], SORT_NUMERIC); //Sort by priority
            foreach(self::$files[$i] as $files1){  //All modules/files with given priority
                foreach($files1 as $files2){       //All files with given priority/module
                    $return .= implode('', $files2);
                }
            }
        }
        return $return;
    }
}