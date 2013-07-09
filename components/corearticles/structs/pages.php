<?php
/**
 * Composite structure for the static pages
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_corearticles_pages extends rad_struct
{
    /**
     * ID of the page
     * @var integer autoincremnemant
     */
    public $pg_id = 0;

    /**
     * Date of page created
     * @var DATETIME
     */
    public $pg_datecreated = '';

    /**
     * Date of last updated record
     * @var TIMESTAMP
     */
    public $pg_dateupdated = '';

    /**
     * user_id that created this page
     * @var integet
     */
    public $pg_usercreated = 0;

    /**
     * ID of tree node with this page
     * @var integer
     */
    public $pg_tre_id = 0;

    /**
     * is the page row active?
     * @var integer
     */
    public $pg_active = 1;

    /**
     * Lang id of the page
     * @var integer
     */
    public $pg_langid = 0;

    /**
     * Show this record in list?
     * @var integer
     */
    public $pg_showlist = 0;

    /**
     * position of pthe page (ordering)
     * @var integer
     */
    public $pg_position = 100;

    /**
     * Title of the page
     * @var string(255)
     */
    public $pg_title = '';

    /**
     * name of the page for url? if empty and not uniqe - use the ID of the page
     * @var string(255)
     */
    public $pg_name = '';

    /**
     * Image filename of the page
     * @var string(50)
     */
    public $pg_img = '';

    /**
     * Short description of the page
     * @var string
     */
    public $pg_shortdesc = '';

    /**
     * Full description of the page - or the self page
     * @var string
     */
    public $pg_fulldesc = '';

    /**
     * Meta title of the page
     * @var string(255)
     */
    public $pg_metatitle = '';

    /**
     * Meta keywords of the page
     * @var string(255)
     */
    public $pg_metakeywords = '';

    /**
     * Meta description of the page
     * @var string(255)
     */
    public $pg_metadescription = '';
    
    /********* VIRTUAL FIELDS!**********/

    /**
     * Array for the tags in page
     * @var array of the struct_coreresource_tags
     */
    public $tags = array();

    function __construct($array = NULL)
    {
        parent::__construct($array,'pg_id',array('tags'));
    }
}