<?php
/**
 * Composite structure for the users
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @return composite struct
 * @package RADCMS
 *
 */
class struct_users extends rad_struct
{
	/**
	 * @var integer
	 */
	public $u_id = 0;

	/**
	 * @var string
	 */
	public $u_login = '';

	/**
	 * @var string (md5 hash)
	 */
	public $u_pass = '';

	/**
	 * @var Boolean
	 */
	public $is_admin = false;

	/**
	 * @var string
	 */
	public $u_email = '';

	/**
	 * @var Boolean
	 */
	public $u_active = true;

	/**
	 * @var integer
	 */
	public $u_access = 1000;

	/**
	 * User froup id
	 *
	 * @var integer
	 */
	public $u_group = 0;

	/**
	 * For saving params
	 * @var string(text)
	 */
	public $u_params = '';

	/**
	 * Is e-mail is confirmed?
	 * @var boolean
	 */
	public $u_email_confirmed = 0;
	
	/**
	 * Должность
	 * @var string(150)
	 */
	public $u_position = '';

    /**
     * User's first name & last name
     * @var string(150)
     */
    public $u_fio = '';
    
	/**
     * User's address
     * @var string(255)
     */
    public $u_address = '';
    
	/**
     * User's phone number
     * @var string(16)
     */
    public $u_phone = '';
	
	/**
     * Is user's subscribe activated
     * @var boolean
     */
    public $u_subscribe_active = 1;

	/**
     * User's subscribe lang_id
     * @var integer
     */
    public $u_subscribe_langid = 0;
    
    /**
     * User's facebook account id
     * @var integer
     */
    public $u_facebook_id = 0;
    
    /**
     * User's twitter account id
     * @var integer
     */
    public $u_twitter_id = 0;
    
    /** Virtual Fields **/
    
    /**
     * User group, link to rad_tree table
     * @var struct_tree
     */
    public $group = 0;
    
        //public $u_is_referer = false;

    function __construct($array = NULL)
    {
        parent::__construct($array,'u_id', array('group'));
    }
}