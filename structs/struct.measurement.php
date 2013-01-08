<?php
/**
 * Composite structure for the measurement
 * Used by core
 *
 * @author Denys Yackushev
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_measurement extends rad_struct
{

    /**
     * Id of the measurement
     *
     * @var integer
     */
    public $ms_id=0;

    /**
     * Measurement name
     *
     * @var string(100)
     */
    public $ms_value = '';

    /**
     * position of the element- ordering
     *
     * @var integer
     */
    public $ms_position = 100;

    /**
     * Link to th language
     * @var integer
     */
    public $ms_langid = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'ms_id');
    }
}