<?php
/**
 * Composite structure for the Comments
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_coreresource_comments extends rad_struct
{
    /**
     * Id of the Record (autoincremnemant)
     *
     * @var integer
     */
    public $rcm_id=0;

    /**
     * Parent comment
     * @var integer
     */
    public $rcm_parent_id = 0;

    /**
     * Type of the record to which comment
     * @var enum(news,articles, folknews, tracker)
     */
    public $rcm_type = '';

    /**
     * Link to the item (news_id or articles_id)
     * @var integer
     */
    public $rcm_item_id = 0;

    /**
     * link to the user_id who leave the comment
     * @var integer
     */
    public $rcm_user_id = 0;

    /**
     * Date and time, when leave the comment
     * @var string
     */
    public $rcm_datetime = '';

    /**
     * Is comment needs to show?
     * @var boolean
     */
    public $rcm_active = 0;

    /**
     * Nickname of the writer
     * @vars string(255)
     */
    public $rcm_nickname = '';

    /**
     * Self the comment
     * @var string(text)
     */
    public $rcm_text = '';


    /*VIRTUAL FIELDS*/


    public $subcomments = array();

    function __construct($array = NULL)
    {
        parent::__construct($array,'rcm_id', array('subcomments'));
    }
}