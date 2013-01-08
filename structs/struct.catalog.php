<?php
/**
 * Composite structure for the catalog
 * Used by core
 *
 * @author Yackushev Denys
 * @package Taberna
 * @version 0.1
 * @return composite struct
 *
 */
class struct_catalog extends rad_struct
{
    /**
     * Id of the product
     *
     * @var integer
     */
    public $cat_id=0;

    /**
     * Product type id
     *
     * @var integer
     */
    public $cat_ct_id = 0;

    /**
     * Link to the brandid
     * @var integer
     */
    public $cat_brand_id = 0;

    /**
     * Position of the product
     */
    public $cat_position = 0;

    /**
     * Date and time when product created
     *
     * @var datetime in DB
     * @var string
     */
    public $cat_datecreated = '';

    /**
     * Date when product updated in last time
     * @var datetime TIMESTAMP
     */
    public $cat_dateupdated = '';

    /**
     * User ID that created the product
     *
     * @var integer
     */
    public $cat_usercreated = 0;

    /**
     * How many times the product byed
     *
     * @var integer
     */

//    public $cat_byed = 0;

    /**
     * How many times showed product
     *
     * @var integer
     */
//    public $cat_showed = 0;

    /**
     * Access level to the product
     *
     * @var integer
     */
    public $cat_access = 255;

    /**
     * Is the product active and shows in the list?
     *
     * @var Boolean
     */
    public $cat_active = 0;

    /**
     * Type of product (main node-0, variety of product-1 or the attendant-2)
     *
     * @var integer
     */
    public $cat_type = 0;

    /**
     * Parent product, if=0 - has no parent and selfparented, otherwise for variety and attendadt products
     *
     * @var integer
     */
    public $cat_pid = 0;

    /**
     * Cost product
     * or sell price
     *
     * @var double
     */
    public $cat_cost = 0;

    /**
     * Buyed cost
     * or frise for seller (owner) show
     * @var double
     */
    public $cat_buy_cost = 0;

    /**
     * Count of the product
     *
     * @var decimal(10,3)
     */
    public $cat_count = 0;

    /**
     * Link to currency id
     *
     * @var integer
     */
    public $cat_currency_id = 0;

    /**
     * Availability of product, also can be in future count of product
     * (rus) Nalickie na sklade
     * @var integer (mysql)tinyint
     */
    public $cat_availability = 0;

    /**
     * Name of product
     * @var string(255)
     */
    public $cat_name = '';

    /**
     * Article of product
     * @var string(150)
     */
    public $cat_article = '';

    /**
     * Product external code
     * @var string(150)
     */
    public $cat_code = '';

    /**
     * Product short description
     * @var string (text)
     */
    public $cat_shortdesc = '';

    /**
     * Product full desciption
     * @var string (text)
     */
    public $cat_fulldesc = '';

    /**
     * Prduct meta keywords
     * @var string(255)
     */
    public $cat_keywords = '';

    /**
     * Product meta title
     * @var string(255)
     */
    public $cat_metatitle = '';

    /**
     * Product meta description
     * @var string(255)
     */
    public $cat_metatescription = '';

    /**
     * Link to the langid
     * @var integer
     */
    public $cat_lngid = 0;

    /**
     * How much product showed
     * @var integer
     */
    public $cat_showed = 0;

    /**
     * How much product buyed
     * @var integer
     */
    public $cat_buyed = 0;

    /********* VIRTUAL FIELDS!**********/

    /**
     * Internal link to the type selected or joined objects array of rad_tree
     * @var struct_tree
     */
    public $type_link = NULL;

    /**
     * Internal link to the type selected or joined val names and val_values
     * @var struct_val_names
     */
    public $type_vl_link = NULL;

    /**
     * Internal link to the tree selected or joined objects array of rad_tree
     */
    public $tree_link = NULL;

    /**
     * Internal link to the cat_in_tree array from DB if needed
     * @var struct_catin_tre
     */
    public $tree_catin_link = NULL;

    /**
     * Internal link to the images assigned to this product
     * @var struct_cat_images
     */
    public $images_link = NULL;

    /**** VIRTUAL SELECTED OR JOINED FIELDS ******/

    /**
     * Internal from joined currency name
     */
    public $currency_name = '';

    /**
     * Internal from joined currency name
     */
    public $currency_indicate = '';

    /**
     * Price in currency
     * @var float
     */
    public $price = 0;

    /**
     * Filename to image
     * @var string(50)
     */
    public $img_filename = '';

    /**
     * Name of product type
     *
     * @var string
     */
    public $cat_ct_name = '';

    /**
     * Type of the special offers
     * @var boolean
     */
    public $cat_special_sp = false;

    /**
     * If in new products?
     * @var boolean
     */
    public $cat_special_spnews = false;

    /**
     * If in special offers (rasprodazha)
     * @var boolean
     */
    public $cat_special_spoffer = false;

    /**
     * If this is hit sales
     * @var boolean
     */
    public $cat_special_sphit = false;

    /**
     * Array for the tags in product
     * @var array of the struct_tags
     */
    public $tags = array();

    /**
     * Download files array
     * @var array of the struct_cat_files
     */
    public $download_files = array();

    /**
     * Comments for the product
     * @var array of the struct_comments
     */
    public $comments = array();
    
    /**
     * 3D models from 3Dbin
     * @var array of struct_cat_3dimages
     */
    public $models_3d = array(); 

    /**
     * Cost of the product converted to active site currency
     */
    public function __get($key)
    {
        switch ($key) {
            case 'cost':
                return model_catalog_currcalc::calcCours($this->cat_cost, $this->cat_currency_id);
        }
        return null;
    }

    function __construct($array = NULL)
    {
        parent::__construct($array,'cat_id',array( 'type_link', 'tree_link', 'cat_ct_name', 
                'currency_name', 'currency_indicate', 'price', 'img_filename','type_vl_link',
                'images_link','tree_catin_link','cat_dateupdated', 'cat_special_sp', 
                'cat_special_spnews', 'cat_special_spoffer', 'cat_special_sphit', 
                'tags', 'download_files', 'comments', 'models_3d' ));
    }
}