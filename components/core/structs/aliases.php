<?php
/**
 * Composite structure for the aliases
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_core_aliases extends rad_struct
{
    /**
     * Id of the alias
     *
     * @var integer
     */
    public $id=0;

    /**
     * Alias name - like first param before / in the url or by name alias_id in the post params
     *
     * @var string
     */
    public $alias = '';

    /**
     * Template id
     *
     * @var integer
     */
    public $template_id='';

     /* Template Image File Name
     *
     * @var string
     */
    public $image='';

    /**
     * Is alias is active
     *
     * @var Boolean
     * @default false
     */
    public $active=false;

    /**
     * for another input class for parse the GET request
     * @var string(70)
     */
    public $input_class = '';

    /**
     * Script for making title for the page
     * @var string (text)
     */
    public $title_script = '';

    /**
     * Script for making navigation string with href for the page
     * @var string (text)
     */
    public $navi_script = '';

    /**
     * Script for making meta-title string with href for the page
     * @var string (text)
     */
    public $metatitle_script = '';

    /**
     * Script for making meta-description string with href for the page
     * @var string (text)
     */
    public $metadescription_script = '';

    /**
     * Template filename
     *
     * @var string
     */
    public $filename='';

    /**
     * Array of includes (structs) in alias
     *
     * @var array of structs
     */
    public $includes=array();

    /**
     * Template id from RAD_templates
     */
    //public $id=0;

    /**
     * If exist theme - its id for specific rules of used includes
     * @var integer
     */
    public $themeid = 0;

    /**
     * Is this admin alias?
     * @var tinyint
     */
    public $ali_admin = 0;

    public $caching = false;

    /**
     * If that alias uses the groups of the aliases (aliases templates)
     * @var integer
     */
    public $group_id = 0;

    /**
     * If exist theme - its folder for specific rules of used includes
     * @var string(100)
     */
    public $themefolder = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'id',array( 'image','filename','includes','themeid','themefolder' ));
    }
}