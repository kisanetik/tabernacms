<?php
/**
 * Composite structure for the settings
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 * @datecreated 05 October 2012 
 */
class struct_settings extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $recordid=0;

    /**
     * Field name
     * @var string(50)
     */
    public $fldName = '';

    /**
     * Field value
     * @var string(255)
     */
    public $fldValue = '';

    /**
     * sort position
     * @var integer
     */
    public $position = 100;

    /**
     * description
     * @var string
     */
    public $description = '';

    /**
     * system or modules
     * @var string('system','modules')
     */
    public $rtype = '';

    /**
     * default value
     * @var string
     */
    public $defValue = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'recordid');
    }
}