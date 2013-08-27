<?php
/**
 * Class to work with theme files
 * @author Roman Chertov
 */
class rad_themer
{
    /**
     * @var array
     */
    private static $themes_cache;

    private static function getConfigPath($theme_name)
    {
        return THEMESPATH.$theme_name.DS.'config.xml';
    }

    /**
     * Return "true", if theme exists
     * @static
     * @param string $theme_name
     * @return bool
     */
    public static function themeExists($theme_name)
    {
        return is_dir(THEMESPATH.$theme_name) && is_file(self::getConfigPath($theme_name));
    }

    /**
     * Return all available theme names
     * @static
     * @return array
     */
    public static function getThemes()
    {
        $themes = array();
        if (is_dir(THEMESPATH)) {
            $d = dir(THEMESPATH);
            while (false !== ($entry = $d->read())) {
                if (($entry!='.') && ($entry!='..') && self::themeExists($entry)) {
                    $themes[] = $entry;
                }
            }
            $d->close();
        }
        return $themes;
    }

    /**
     * Return theme parameters
     * @static
     * @param string $theme_name
     * @return array|false
     */
    public static function getThemeConfig($theme_name)
    {
        if (!isset(self::$themes_cache[$theme_name])) {
            $theme_config = false;
            if (self::themeExists($theme_name)) {
                $xml = @file_get_contents(self::getConfigPath($theme_name));
                if ($xml) {
                    $xmlObj = simplexml_load_string($xml);
                    $params = $xmlObj->xpath('/theme/params');
                    if (count($params)) {
                        $theme_config = array();
                        foreach($params[0]->param as $id) {
                            foreach($id->attributes() as $k=>$v) {
                                if ($k == 'name') {
                                    $theme_config[ (string)$v ] = (string)$id[0];
                                }
                            }
                        }
                    }
                }
            }
            self::$themes_cache[$theme_name] = $theme_config;
        }
        return self::$themes_cache[$theme_name];
    }

    /**
     * Return path to the file which can be overridden in the theme
     * @static
     * @param string $theme_name
     * @param string $type
     * @param string $module
     * @param string $filename
     * @return string|false
     */
    public static function getFilePath($theme_name, $type, $module, $filename)
    {
        static $noOverrideTypes = array('models', 'structs', 'classes');
        if (in_array($type, $noOverrideTypes)) $theme_name = 'default';

        if (!$theme_name) $theme_name = self::getCurrentTheme();

        $filename = fixPath($filename);
        $tail = $module.DS.$type.DS.$filename;
        $overriddenThemes = array();
        while (!file_exists($originalFile = self::getFilePathInTheme($tail, $theme_name))) {
            if (empty($theme_name) || $theme_name == 'default') return false; //Found nothing!
            $overriddenThemes[] = $theme_name;
            $config = self::getThemeConfig($theme_name);
            $theme_name =
                $config && !empty($config['parent_theme']) && !in_array($theme_name, $overriddenThemes) && self::themeExists($config['parent_theme'])
                ? $config['parent_theme']
                : 'default';
        }
        if (!is_file($originalFile)) {
            throw new rad_exception("Fatal error discovered while trying to find file {$filename} in module {$module}: {$originalFile} is not a file!");
        }
        return $originalFile;
    }

    public static function getFilePathInTheme($fileRelativeToTheme, $themeName){
        if (!empty($themeName) && $themeName != 'default') {
            return THEMESPATH.$themeName.DS.$fileRelativeToTheme;
        } else {
            return COMPONENTSPATH.$fileRelativeToTheme;
        }
    }

    public static function getCurrentTheme() {
        static $theme;
        if (isset($theme)) return $theme;

        if (($theme = @$_SESSION['theme']) && (($theme == 'default') || self::themeExists($theme)))
            return $theme;

        if (!empty($_SERVER['HTTP_REFERER']) && preg_match('~^'.preg_quote($GLOBALS['config']['url']).'cache/(?:js|css)/([a-z0-9]+)/~i', $_SERVER['HTTP_REFERER'], $matches)) {
            $theme = $matches[1];
            if (($theme == 'default') || self::themeExists($theme)) return $theme;
        }

        if (!empty($_GET['th'])) {
            $theme = urldecode($_GET['th']);
            if (($theme == 'default') || self::themeExists($theme)) return $theme;
        }

        $theme = rad_config::getParam('theme.default');
        if (($theme == 'default') || self::themeExists($theme)) return $theme;

        $theme = $GLOBALS['config']['theme.default'];
        if (($theme == 'default') || self::themeExists($theme)) return $theme;

        $theme = 'default';
        return $theme;
    }
}