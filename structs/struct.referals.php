<?php
/**
 * Composite structure for the referals
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_referals extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rrf_id=0;

    /**
     * user id (partner and referal), link to users table
     * @var integer
     */
    public $rrf_user_id = 0;

    /**
     * refferer string from browser
     * @var string(255)
     */
    public $rrf_refferer = '';

    /**
     * When?
     * @var DATE
     */
    public $rrf_date = '';

    /**
     * When?
     * @var TIME
     */
    public $rrf_time = '';

    /**
     * Cookie name
     * @var string(32)
     */
    public $rrf_cookie = '';

    /**
     * Item type
     * (ENUM OF 'news','product','catalog','page','article')
     * @var string
     */
    public $rrf_item_type = '';

    /**
     * What item unique id?
     * @var integer
     */
    public $rrf_item_id = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rrf_id');
    }
}