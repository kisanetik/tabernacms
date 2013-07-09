<?php
/**
 * Composite structure for the shopping cart
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corecatalog_bp extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $bp_id=0;

    /**
     * session_id
     * @var string(32)
     */
    public $bp_sessid = '';

    /**
     * rad_catalog.cat_id field
     * @var integer
     */
    public $bp_catid = '';

    /**
     * ount product
     * @var DECIMAL(10,3)
     */
    public $bp_count = 1;

    /**
     * cost product
     * @var DECIMAL(9,2)
     */
    public $bp_cost = 0;

    /**
     * currency_id of added product
     * @var integer
     */
    public $bp_curid = 0;

    /**
     * When added to cart?
     * @var timestamp
     */
    public $bp_datetime = 0;

    /**
     * User id who(to) added
     * @var integer
     */
    public $bp_userid = '';

    /**
     * rad_users.u_id Who added the position
     * @var integer
     */
    public $bp_whoadded = 0;
    
    /* Virtual fields */
    public $product = array();

    function __construct($array = NULL)
    {
        parent::__construct($array,'bp_id', array('product'));
    }
}