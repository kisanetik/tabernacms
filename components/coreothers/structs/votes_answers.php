<?php
/**
 * Composite structure for the Vote answers
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_coreothers_votes_answers extends rad_struct
{
    /**
     * Id of the Answer
     *
     * @var integer
     */
    public $vta_id=0;

    /**
     * Link to the Vote id
     *
     * @var integer
     */
    public $vta_vtid = 0;

    /**
     * Link to the question that voted
     *
     * @var integer
     */
    public $vta_vtqid = 0;

    /**
     * Id of user, that voted, if user not logged - just zero
     *
     * @var integer
     */
    public $vta_userid = 0;

    /**
     * Date, when voted
     * @var datetime
     */
    public $vta_datevote = 0;

    /**
     * Remote user ip
     * @var string(47)
     */
    public $vta_ip = '';

    /**
     * User Browser hash
     * @var string(255)
     */
    public $vta_browser = '';

    /**
     * Hash with input data and vote fully record
     * var string
     */
    public $vta_hash = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'vta_id');
    }
}