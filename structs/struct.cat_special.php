<?php
/**
* Composite structure for the catalog specials
* Used by core
*
* @author Yackushev Denys
* @package Taberna
* @version 0.1
* @return composite struct
*
 */
class struct_cat_special extends rad_struct
{
	/**
	 * Id
	 * @var integer autoincremnement
	 */
	public $cs_id = 0;
	
	/**
	 * Type of the special, is it new=1 of special offer=2 e.t.c.
	 * @var integer
	 */
	public $cs_type = 0;
	
	/**
	 * id of the product (rad_catalog.cat_id)
	 * @var integer
	 */
	public $cs_catid = 0;
	
	/**
	 * ordering
	 * @var integer
	 */
	public $cs_order = 0;
    
    function __construct($array = NULL)
    {
        parent::__construct($array,'cs_id');
    }
    
}