<?php
/**
 * Composite structure for the order
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package Taberna
 * @return composite struct
 *
 */
class struct_orders extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $order_id=0;

    /**
     * Order user id
     * @var integer rad_users.u_id
     */
    public $order_userid = 0;

    /**
     * session_id
     * @var string(32)
     */
    public $order_sessid = '';

    /**
     * Number of order
     * @var string(50)
     */
    public $order_num = '';

    /**
     * Date time of order
     * @var datetime
     */
    public $order_dt = '';

    /**
     * Status of the order - link to the rad_tree.tre_id
     * @var integer
     */
    public $order_status = 0;

    /**
     * Type of the order ( 0-fast order, 1-registred order ... )
     * @var integer
     */
    public $order_type = 0;

    /**
     * Shipping address
     * @var string (text)
     */
    public $order_address = '';

    /**
     * Email of order
     * @var string(255)
     */
    public $order_email = '';

    /**
     * First and the Last name of user
     * @var string(255)
     */
    public $order_fio = 0;

    /**
     * Client contact phone
     * @var string(14)
     */
    public $order_phone = '';

    /**
     * Comments to order
     * @var string (text)
     */
    public $order_comments = '';

    /**
     * Summ or order
     * @var float (decimal 9,2)
     */
    public $order_summ = 0;

    /**
     * Order currency for the summ (Like US, grn, $ e.t.c.)
     * @var string(30)
     */
    public $order_currency = '';

    /**
     * link to the currency_id
     * @var integer
     */
    public $order_curid = 0;

    /**
     * Link to delivery id
     * @var integer
     */
    public $order_delivery = 0;

    /**
     * On What lang id of the site ordered
     * @var integer(5)
     */
    public $order_langid = 0;

    /***********   EXTERNAL LINKS     ******************/
    public $order_positions = NULL;

    /**
     * delivery info if exists
     * @var struct_delivery
     */
    public $delivery = NULL;

    function __construct($array = NULL)
    {
        parent::__construct($array,'order_id',array('order_positions', 'delivery'));
    }
}