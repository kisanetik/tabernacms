<?php
/**
 * Composite structure for the subscribers
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.2
 * @return composite struct
 * @package RADCMS
 *
 */
class struct_coremail_subscribers_activationurl extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $sac_id = 0;

    /**
     * md5 hash for the url
     *
     * @var string(34)
     */
    public $sac_url = '';

    /**
     * subscriber_id
     *
     * @var integer
     */
    public $sac_scrid = 0;

    /**
     * Type of the activation url, if 1 then subscriber, if 2 then users registration
     */
    public $sac_type = 1;


    function __construct($array = NULL)
    {
        parent::__construct($array,'sac_id');
    }
}