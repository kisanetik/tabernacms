<?php
/**
 * Class for showing themes in menu
 *
 * @author Denys Yackushev
 * @package RADCMS
 *
 */
class controller_menus_themes extends rad_controller
{
    function __construct()
    {
		$this->assignThemes();
    }
    
    /**
     * Assign theme folders
     *
     */
    function assignThemes()
    {
        $d = dir(THEMESPATH);
        $themes = array();
		while (false !== ($entry = $d->read())) {
            if( ($entry!='.') and ($entry!='..') and (is_dir(THEMESPATH.$entry)) and (file_exists(THEMESPATH.$entry.'/description.txt')) and (is_file(THEMESPATH.$entry.'/description.txt')) ) {
                $themes[] = $entry;
            }
        }
        $this->setVar('theme_default', rad_config::getParam('theme.default'));
        $this->setVar('themes',$themes);
        $this->setVar('curr_theme', call_user_func(array(rad_config::getParam('loader_class'),'getCurrentTheme')));
    }
}