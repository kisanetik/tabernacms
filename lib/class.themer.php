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
        $filename = fixPath($filename);
        $tail = $module.DS.$type.DS.$filename;
        $originalFile = THEMESPATH.$theme_name.DS.$tail;
        $overrided_themes = array();
        while (!file_exists($originalFile)) {
            $config = self::getThemeConfig($theme_name);
            if ($config && !empty($config['parent_theme']) && ($config['parent_theme'] != $theme_name) && !in_array($theme_name, $overrided_themes)) {
                $overrided_themes[] = $theme_name;
                $theme_name = $config['parent_theme'];
                $originalFile = THEMESPATH.$theme_name.DS.$tail;
            } else {
                $originalFile = COMPONENTSPATH.$tail;
                if (!file_exists($originalFile)) return false; //Found nothing!
                break;
            }
        }
        if (!is_file($originalFile)) {
            throw new rad_exception("Fatal error discovered while trying to find file {$filename} in module {$module}: {$originalFile} is not a file!");
        }
        return $originalFile;
    }
}