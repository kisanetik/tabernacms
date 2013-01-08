<?php
/**
 * Composite structure for the Vote questions
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_votes_questions extends rad_struct
{
    /**
     * Id of the question
     *
     * @var integer
     */
    public $vtq_id=0;

    /**
     * Link to the Vote id
     *
     * @var integer
     */
    public $vtq_vtid = 0;

    /**
     * Position in list
     *
     * @var integer
     */
    public $vtq_position = 100;

    /**
     * Question answer
     *
     * @var string(2585)
     */
    public $vtq_name = '';

    /**
     * Virtual field
     * Count of the answers
     */
    public $cnt_ans = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'vtq_id',array('cnt_ans'));
    }
}