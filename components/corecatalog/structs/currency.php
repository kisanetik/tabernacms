<?php
/**
 * Composite structure for the catalog currency
 * Used by core
 *
 * @author Denys Yackushev
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corecatalog_currency extends rad_struct
{
    /**
     * Autoincremnement ID
     * @var integer
     */
    public $cur_id = 0;

    /**
     * Is default in admin
     * @var boolean
     */
    public $cur_default_admin = 0;

    /**
     * Is default on site
     * @var Boolean
     */
    public $cur_default_site = 0;

    /**
     * Show in this currency on frontend in catalog below each product?
     * @var boolean
     */
    public $cur_show_site = 0;

    /**
     * Currency
     * @var decimal(9,2)
     */
    public $cur_cost = 1;

    /**
     * Ordering or position
     * @var integer
     */
    public $cur_position = 100;

    /**
     * Show currensy on site?
     * @var boolean
     */
    public $cur_showcurs = 0;

    /**
     * Name of currency, as Dollar, Euro etc
     * @var string(100)
     */
    public $cur_name = '';

    /**
     * Short name of currency
     * @var string(32)
     */
    public $cur_shortname = '';

    /**
     * Image filename of the currency
     * @var string(50)
     */
    public $cur_image = '';

    /**
     * Indicator of the currency ( like rub,us,$,grn,eur )
     * @var string(30)
     */
    public $cur_ind = '';

    /**
     * Decimal separator for currency
     * @var string(1)
     */
    public $cur_decimal_separator = '';

    /**
     * Group separator for currency
     * @var string(1)
     */
    public $cur_group_separator = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'cur_id');
    }
}