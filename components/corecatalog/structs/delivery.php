<?php
/**
 * Composite structure for the Delivery
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package Taberna
 * @return composite struct
 *
 */
class struct_corecatalog_delivery extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rdl_id=0;

    /**
     * active or not?
     * @var boolean
     */
    public $rdl_active = 0;

    /**
     * Link to the rad_lang.id table
     * @var integer
     */
    public $rdl_lang = 0;

    /**
     * Delivery name
     * @var string(127)
     */
    public $rdl_name = '';

    /**
     * Description
     * @var string
     */
    public $rdl_description = '';

    /**
     * currency_id link
     * @var integer
     */
    public $rdl_currency = 0;

    /**
     * cost of the delivery
     * @var double
     */
    public $rdl_cost = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rdl_id');
    }
}