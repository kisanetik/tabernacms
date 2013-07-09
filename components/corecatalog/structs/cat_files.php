<?php
/**
 * Composite structure for the Product downloads
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package Taberna
 * @return composite struct
 *
 */
class struct_corecatalog_cat_files extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rcf_id = 0;

    /**
     * Filename in folder
     * @var string(38)
     */
    public $rcf_filename = '';

    /**
     * Original show name
     * @var string(150)
     */
    public $rcf_name = '';

    /**
     * catalog.cat_id link
     * @var Dinteger
     */
    public $rcf_cat_id = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rcf_id');
    }
}