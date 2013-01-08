<?php
/**
 * Composite structure for the news
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.2
 * @return composite struct
 *
 */
class struct_news extends rad_struct
{
    /**
     * Id of the news
     *
     * @var integer
     */
    public $nw_id=0;

    /**
     * Date of news created
     * @var DATETIME
     */
    public $nw_datecreated = '';

    /**
     * Current updated date
     * @var TIMESTAMP
     */
    public $nw_dateupdated = '';

    /**
     * user_id that created this news
     * @var integet
     */
    public $nw_usercreated = 0;

    /**
     * ID of tree node with this news
     * @var integer
     */
    public $nw_tre_id = 0;

    /**
     * is the news row active?
     * @var integer
     */
    public $nw_active = 0;

    /**
     * Lang id
     * @var integer
     */
    public $nw_langid = 0;

    /**
     * Is this home news?
     */
    public $nw_ismain = 0;

    /**
     * Title of the news
     * @var string(254)
     */
    public $nw_title = '';

    /**
     * Short description of the news
     * @var string
     */
    public $nw_shortdesc = '';

    /**
     * Full description of the news
     * @var string
     */
    public $nw_fulldesc = '';

    /**
     * Image filename of the news
     * @var string(50)
     */
    public $nw_img = '';

    /**
     * Date of the news
     * @param DATETIME
     */
    public $nw_datenews = '';

    /**
     * Start show news from date
     * @var datetime mysql
     */
    public $nw_datenews_from = '';

    /**
     * End to show news date
     * @var datetime mysql
     */
    public $nw_datenews_to = '';

    /**
     * Meta title of the news
     * @var string(255)
     */
    public $nw_metatitle = '';

    /**
     * Meta keywords of the news
     * @var string(255)
     */
    public $nw_metakeywords = '';

    /**
     * Meta description of the news
     * @var string(255)
     */
    public $nw_metadescription = '';

    /**
     * Url of the source of this news
     * @var string text
     */
    public $nw_source_url = '';

    /**
     * Text for the source
     * @var string(100)
     */
    public $nw_source_text = '';

    /**
     * Is that record need to add to subscribe letters?
     * @var Booelan
     */
    public $nw_subscribe = 0;

    
    /**** VIRTUAL SELECTED OR JOINED FIELDS ******/
    
    /**
     * Array of the
     * @var array of the struct_tags
     */
    public $tags = array();
    
    function __construct($array = NULL)
    {
        parent::__construct($array,'nw_id',array('tags'));
    }
}