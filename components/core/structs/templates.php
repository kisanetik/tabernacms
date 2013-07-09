<?php
/**
 * Composite structure for the rad_templates
 *
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_core_templates extends rad_struct
{
    /**
     * Id of template
     *
     * @var integer
     */
    public $id = 0;

    /**
     * Name of file in folder with files
     *
     * @var string
     */
    public $filename = '';

    /**
     * Image that needs to be showed, just for show
     *
     * @var string
     */
    public $image = '';
    /**
     * Description of the template
     */
    public $description = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'id');
    }
}//class