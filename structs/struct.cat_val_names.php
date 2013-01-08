<?php
/**
 * Composite structure for the value names
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_cat_val_names extends rad_struct
{
    /**
     * Id of the value name record
     *
     * @var integer
     */
    public $vl_id=0;

    /**
     * Tree id
     *
     * @var integer
     */
    public $vl_tre_id = 0;

    /**
     * Name of the value name
     *
     * @var string
     */
    public $vl_name = '';

    /**
     * Name of the class to parse the input values
     *
     * @var string(100)
     */
    public $vl_type_in = '';

    /**
     * Name of the class to parse the output values
     *
     * @var string(100)
     */
    public $vl_type_print = '';

    /**
     * Link to the ends measurement
     */
    public $vl_measurement_id = 0;

    /**
     * Position of the ordering of the value name
     *
     * @var integer
     */
    public $vl_position = 100;

    /**
     * Is the value name active and shows in the list?
     * User for: Deleted the valname or not!
     *
     * @var Boolean
     */
    public $vl_active = 1;
    
    /**
     * for filtering in catalog
     * @var Boolean
     */
    public $vl_filter = 0;

    /**
     * Internal link to the values
     *
     * array( struct_val_values );
     * @var struct_val_values
     */
    public $vv_values = NULL;

    /**
     * Internal link for measurement type
     */
    public $ms_value = NULL;

    function __construct($array = NULL)
    {
        parent::__construct($array,'vl_id',array( 'vv_values','ms_value' ));
    }
};