<?php
/**
* Composite structure for the catalog 3dimages
* Used by core
*
* @author Yackushev Denys
* @package Taberna
* @link http://3dbin.tabernacms.com
* @version 0.1
* @return composite struct
*
 */
class struct_cat_3dimages extends rad_struct
{
	/**
	 * Id of the image
	 * @var integer autoincremnement
	 */
	public $img_id = 0;
	
	/**
     * Link to the cat_id in rad_catalog
     */
    public $img_cat_id = 0;
	
	/**
	 * Filename of the image
	 * @var string(55)
	 */
	public $img_filename = '';
	
	/**
	 * Is this image the main in catalog
	 * @var boolean (0-false, 1-true)
	 */
	public $img_main = 0;
	
	/**
	 * Position or ordering image
	 * @var integer
	 */
	public $img_position = 100;
	
	/**
	 * Alt and title tag of the image
	 * @var string(255)
	 */
	public $img_alt = '';
	
    function __construct($array = NULL)
    {
        parent::__construct($array,'img_id');
    }
    
}