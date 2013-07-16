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
        self::_renewCache($module, $filename, 'css');
        return SITE_URL."cache/css/{$theme}/{$module}/{$filename}";
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