<?php
/**
 * Composite structure for the Votes
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_votes extends rad_struct
{
    /**
     * Id of the vote
     *
     * @var integer
     */
    public $vt_id=0;

    /**
     * Link to the tre_id
     *
     * @var integer
     */
    public $vt_treid = 0;

    /**
     * Lang code of the vote
     * @var integer
     */
    public $vt_lngid = 0;

    /**
     * Position on list
     *
     * @var integer
     */
    public $vt_position = 100;

  /**
   * Is vote active
   * @var integer
   */
    public $vt_active = 0;

    /**
     * User, that created this vote
     * @var integer
     */
    public $vt_usercreated = 0;

    /**
     * Date creation
     * @var datetime
     */
    public $vt_datecreated = 0;

    /**
     * Question
     * @var string(255)
     */
    public $vt_question = '';

    /**
     * META title of the vote
     * @var string(255)
     */
    public $vt_metatitle = '';

    /**
     * META keywords
     * @var string(255)
     */
    public $vt_metakeywords = '';

    /**
     * META description of the vote
     * @var string(255)
     */
    public $vt_metadescription = '';

    /**
     * Virtual field
     * @var array mixed
     */
    public $vt_answers = array();

    function __construct($array = NULL)
    {
        parent::__construct($array,'vt_id',array('vt_answers'));
    }
}