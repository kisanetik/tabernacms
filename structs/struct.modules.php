<?php
/**
 * Composite structure for the modules table
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.2
 * @return composite struct
 * @package RADCMS
 *
 */
class struct_modules extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $m_id=0;

    /**
     * Name of the module
     *
     * @var string(150)
     */
    public $m_name = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'m_id');
    }
}