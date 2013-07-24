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
    private static $maintpl_files;
    private static $files;
    private static $themeName;

    /**
     * Add html tag to the <head> section
     * @static
     * @param $module
     * @param $filename
     * @param $html
     */
    public static function addFile($module, $filename, $html)
    {
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
        $filename = str_replace('/', DS, $file);

        $cacheFile = CACHEPATH.$type.DS.self::$themeName.DS.$module.DS.$filename;
        $cachePath = dirname($cacheFile);
        if (!file_exists($cachePath))
            recursive_mkdir($cachePath);
        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < rad_config::getParam('cache.power.time')))
            return true;

        if ($fname = getThemedComponentFile($module, 'jscss', $filename)){
            return self::copyToCache($fname, $cacheFile);
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
     * Get link to JavaScript file
     * @static
     * @param string $module
     * @param string $filename
     * @return string
     */
    public static function getLinkToJS($module, $filename)
    {
        $theme = self::checkTheme();
        if ($module) {
            self::_renewCache($module, $filename, 'js');
            return SITE_URL."cache/js/{$theme}/{$module}/{$filename}";
        }
        return SITE_URL."libc/{$filename}";
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
        $theme = self::checkTheme();
        if ($module) {
            self::_renewCache($module, $filename, 'css');
            return SITE_URL."cache/css/{$theme}/{$module}/{$filename}";
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
        return $return;
    }
}