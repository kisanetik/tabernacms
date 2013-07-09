<?php
/**
 * Composite structure for the referals orders
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 * @datecreated 17 Agust 2012
 *
 */
class struct_coresession_referals_orders extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rro_id=0;

    /**
     * user id (partner and referal), link to referals table
     * @var integer
     */
    public $rro_referals_id = 0;

    /**
     * link to the orders table
     * @var integer
     */
    public $rro_order_id = 0;

    /**
     * Percent for partner
     * @var float
     */
    public $rro_percent = 0;

    /**
     * Link to currency table
     * @var integer
     */
    public $rro_currency_id = 0;

    /**
     * Copy for history order sum
     * @var float
     */
    public $rro_order_sum = 0;

    /**
     * If order is deleted
     * @var bit
     */
    public $rro_order_deleted = 0;

    /*** Virtual fields ***/

    /**
     * Status of the original order, link to the tree.id table
     * @var integer
     */
    public $order_status = 0;

    /**
     * Date of the original order
     * @var datetime
     */
    public $order_dt = '';

    /**
     * Original currency of the order
     * @var integer
     */
    public $order_currency = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rro_id', array('order_status', 'order_dt', 'order_currency'));
    }
}