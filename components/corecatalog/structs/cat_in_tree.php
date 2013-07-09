<?php
/**
 * Composite structure for the catalog in tree
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corecatalog_cat_in_tree extends rad_struct
{

    /**
     * Primary key
     * @var integer
     */
    public $cit_id = 0;

    /**
     * Product id
     *
     * @var integer
     */
    public $cit_cat_id = 0;

    /**
     * tree id
     *
     * @var integer
     */
    public $cit_tre_id = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'cit_id');
    }
}