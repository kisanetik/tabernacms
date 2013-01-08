<?php
/**
 * Composite structure for the aliases
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @deprecated 29 april 2009
 * @return composite struct
 *
 */
class struct_themes extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $theme_id=0;

    /**
     * theme_aliasid
     * @var integer
     */
    public $theme_aliasid = 0;

    /**
     * Theme folder
     * @var string(100)
     */
    public $theme_folder = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'theme_id');
    }
}