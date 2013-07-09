<?php
/**
 * Composite structure for the catalog brands
 * Used by core
 *
 * @author Shevchenko Artem
 * @version 0.2
 * @return composite struct
 *
 */
class struct_corecatalog_cat_brands extends rad_struct
{
    /**
     * Id of the brands
     *
     * @var integer
     */
    public $rcb_id=0;

    /**
     * Title of the news
     * @var string(255)
     */
    public $rcb_name = '';
    /**
     * is the news row active?
     * @var integer
     */
    public $rcb_active = 0;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rcb_id');
    }
}