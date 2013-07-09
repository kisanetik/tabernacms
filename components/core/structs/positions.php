<?php
/**
 * Composite structure for the positions
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_core_positions extends rad_struct
{
    /**
     * Id of the position
     *
     * @var integer
     */
    public $rp_id=0;

    /**
     * The Positions Short Name in the template
     *
     * @var string
     */
    public $rp_name='';

    /**
     * Long descriptions of the position
     *
     * @var string
     */
    public $rp_description='';

    function __construct($array = NULL)
    {
        parent::__construct($array,'rp_id');
    }

}