<?php
/**
 * Composite structure for the tree with parent_id
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.2
 * @return composite struct
 *
 */
class struct_tree extends rad_struct
{
    /**
     * Id of the node
     *
     * @var integer
     */
    public $tre_id=0;

    /**
     * id of parent node
     *
     * @var integer
     */
    public $tre_pid = 0;

    /**
     * is that node active?
     *
     * @var Boolean (tinyint(1))
     */
    public $tre_active = false;

    /**
     * Lang id of the node
     *
     * @var integer
     */
    public $tre_lang = 0;

    /**
     * String name that shows
     *
     * @var string(255)
     */
    public $tre_name = '';

    /**
     * url of the node to
     *
     * @var string
     */
    public $tre_url = '';

    /**
     * Image of the node
     * Length is the md5 + extension
     *
     * @var string(36)
     */
    public $tre_image = '';

    /**
     * Image of the menu node
     * Length is the md5 + extension
     *
     * @var string(36)
     */
    public $tre_image_menu = '';

    /**
     * Image of the menu node when active
     * Length is the md5 + extension
     *
     * @var string(36)
     */
    public $tre_image_menu_a = '';

    /**
     * Position of an element, ordering
     */
    public $tre_position = 0;

    /**
     * Does the node is last, or have the child
     *
     * @var integer $tre_islast
     */
    public $tre_islast = 1;

    /**
     * Access code for node
     *
     * @var integer
     */
    public $tre_access = 1000;

    /**
     * Type of the node
     * 0 - tree node
     * 1 - group for form
     * 2 - selector for the form
     * @var tinyint
     */
    public $tre_type = 0;

    /**
     * Meta title of the category
     * @var string(255)
     */
    public $tre_metatitle = '';

    /**
     * Meta description of the category
     * @var string(255)
     */
    public $tre_metadesc = '';

    /**
     * Meta keywords of the category
     * @var string(255)
     */
    public $tre_metakeywords = '';

    /**
     * Full description of the category
     * @var string (text)
     */
    public $tre_fulldesc = '';

    /**
     * This is for child elements
     *
     * @var array of struct_tree
     */
    public $child = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'tre_id',array( 'child' ));
    }
}