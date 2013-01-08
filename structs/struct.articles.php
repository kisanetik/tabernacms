<?php
/**
 * Composite structure for the articles
 * Used by core
 *
 * @author Ivan Deyna
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_articles extends rad_struct
{
    /**
     * ID of the article
     * @var integer autoincremnemant
     */
    public $art_id = 0;

    /**
     * Date of article created
     * @var DATETIME
     */
    public $art_datecreated = '';

    /**
     * Date of last updated record
     * @var TIMESTAMP
     */
    public $art_dateupdated = '';

    /**
     * user_id that created this article
     * @var integet
     */
    public $art_usercreated = 0;

    /**
     * ID of tree node with this article
     * @var integer
     */
    public $art_treid = 0;

    /**
     * is the article shows on main page?
     * @var integer
     */
    public $art_showonmain = 0;

    /**
     * is the article theme of the week?
     * @var integer
     */
    public $art_isweek = 0;

    /**
     * is the article row active?
     * @var integer
     */
    public $art_active = 1;

    /**
     * Lang id of the article
     * @var integer
     */
    public $art_langid = 0;

    /**
     * position of pthe article (ordering)
     * @var integer
     */
    public $art_position = 100;

    /**
     * Title of the article
     * @var string(255)
     */
    public $art_title = '';

    /**
     * Image filename of the article
     * @var string(50)
     */
    public $art_img = '';

    /**
     * Short description of the article
     * @var string
     */
    public $art_shortdesc = '';

    /**
     * Full description of the article - or the self article
     * @var string
     */
    public $art_fulldesc = '';

    /**
     * Meta title of the aricle
     * @var string(255)
     */
    public $art_metatitle = '';

    /**
     * Meta keywords of the article
     * @var string(255)
     */
    public $art_metakeywords = '';

    /**
     * Meta description of the article
     * @var string(255)
     */
    public $art_metadescription = '';

   /**** VIRTUAL SELECTED OR JOINED FIELDS ******/
    
    /**
     * Array of the tags
     * @var array of the struct_tags
     */
    public $tags = array();

    function __construct($array = NULL)
    {
        parent::__construct($array,'art_id',array( 'tags'));
    }
}