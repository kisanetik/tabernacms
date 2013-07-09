<?php
/**
 * Composite structure for the Catalog Types Showing
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corecatalog_ct_showing extends rad_struct
{
    /**
     * Id of the record
     *
     * @var integer
     */
    public $cts_id=0;

    /**
     * VAlue name id
     *
     * @var integer
     */
    public $cts_vl_id = 0;

    /**
     * Showing in module
     *
     * @var integer
     */
    public $cts_show = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'cts_id');
    }
}