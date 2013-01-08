<?php
/**
 * Composite structure for tags
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package RADCMS
 * @return composite struct
 * 
 *
 */
class struct_tags extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $tag_id = 0;

    /**
     * Name of the tag
     * @var string(38)
     */
    public $tag_string = '';

    /**
     * Tag type of the item (1-produc catalogs type, 2-news type, 3-articles type, 4-static pages type)
     * @var tinyint
     */
    public $tag_type = 1;

    function __construct($array = NULL)
    {
        parent::__construct($array,'tag_id');
    }
}