<?php
/**
 * Composite structure for the Product tags
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package Taberna
 * @return composite struct
 * 
 *
 */
class struct_coreresource_tags_in_item extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $tii_id = 0;

    /**
     * Name of the tag
     * @var string(38)
     */
    public $tii_item_id = 0;

    /**
     * Tag id of the item
     * @var integer
     */
    public $tii_tag_id = 0;
    
    /**
     * Type of the record to which tag
     * @var enum(porduct,news,articles,static pages)
     */
    public $tii_tag_type = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'tii_id');
    }
}