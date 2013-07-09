<?php
/**
 * Composite structure for the language values
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @return composite struct
 * @package RADCMS
 *
 */
class struct_core_langvalues extends rad_struct
{
    /**
     * Id of the language value
     *
     * @var integer
     */
    public $lnv_id=0;

    /**
     * Code of langvalue
     *
     * @var string(70)
     */
    public $lnv_code = '';

    /**
     * UTF Full value in current lang
     *
     * @var string text
     */
    public $lnv_value = '';

    /**
     * Code of the language -> lng_id
     *
     * @var integer
     */
    public $lnv_lang = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'lnv_id');
    }
}