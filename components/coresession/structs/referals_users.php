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
class struct_coresession_referals_users extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rru_id=0;

    /**
     * user id (partner), who cited this referer. Link to users table
     * @var integer
     */
    public $rru_partner_id = 0;

    /**
     * link to the users table
     * @var integer
     */
    public $rru_user_id = 0;

    /**
     * Link to referals table
     * @var integer
     */
    public $rru_referal_id = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rru_id');
    }
}