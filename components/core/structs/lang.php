<?php
/**
 * Composite structure for the languages
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.2
 * @return composite struct
 *
 */
class struct_core_lang extends rad_struct
{
    /**
     * Id of the language
     *
     * @var integer
     */
    public $lng_id=0;

    /**
     * Name of the language? maximumlength is 70
     *
     * @var string(70)
     */
    public $lng_name = '';

    /**
     * Language short code?length is 4
     *
     * @var string(4)
     */
    public $lng_code = '';

    /**
     * is the language active? 0-no, if else - yes
     *
     * @var Bit (tinyint(1))
     */
    public $lng_active = 1;

    /**
     * For ordering
     *
     * @var integer
     */
    public $lng_position = 0;

    /**
     * Lang image - flag of the language
     *
     * @var string
     */
    public $lng_img = '';

    /**
     * Is this lang main on the site?
     * @var integer(tinyint)
     */
    public $lng_mainsite = 0;

    /**
     * Is this main language for the admin panel?
     * @var integer(tinyint)
     */
    public $lng_mainadmin = 0;


    /**
     * Is this main language for the content in admin?
     * @var integer(tinyint)
     */
    public $lng_maincontent = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'lng_id');
    }
}