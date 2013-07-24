<?php
/**
 * Class for showing themes in menu
 *
 * @author Denys Yackushev
 * @package RADCMS
 *
 */
class controller_coremenus_themes extends rad_controller
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
        $this->setVar('theme_default', rad_config::getParam('theme.default'));
        $this->setVar('themes', rad_themer::getThemes());
        $this->setVar('curr_theme', call_user_func(array(rad_config::getParam('loader_class'),'getCurrentTheme')));
    }
}