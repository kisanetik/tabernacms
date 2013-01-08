<?php
/**
 * Composite structure for the includes_in_aliases
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_includes_params extends rad_struct
{
    /**
     * Id - Autoincremnemant
     *
     * @var integer
     */
    public $ip_id=0;

    /**
     * nclude id
     *
     * @var int
     */
    public $ip_incid = 0;

    /**
     * params hash
     *
     * @var string
     */
    public $ip_params='';

    function __construct($array = NULL)
    {
        parent::__construct($array,'ip_id');
    }
}