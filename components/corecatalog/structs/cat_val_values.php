<?php
/**
 * Composite structure for the values
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corecatalog_cat_val_values extends rad_struct
{
    /**
     * Id of the value
     *
     * @var integer
     */
    public $vv_id=0;

    /**
     * Link to the value name
     *
     * @var integer
     */
    public $vv_name_id = 0;

    /**
     * Link to the product_id
     *
     * @var integer
     */
    public $vv_cat_id = 0;

    /**
     * Main value
     *
     * @var string
     */
    public $vv_value = '';

    /**
     * Second value for intervals
     *
     * @var string
     */
    public $vv_value2 = '';

    /**
     * Position of the value
     */
    public $vv_position = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'vv_id');
    }
}