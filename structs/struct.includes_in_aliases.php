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
class struct_includes_in_aliases extends rad_struct
{
    /**
     * Id - Autoincremnemant
     *
     * @var integer
     */
    public $id=0;

    /**
     * Alias ID
     *
     * @var int
     */
    public $alias_id = 0;

    /**
     * Include id
     *
     * @var integer
     */
    public $include_id=0;

     /* Position id from RAD_positions
     *
     * @var integer
     */
    public $position_id = 0;

    /**
     * Theme ID if include for some theme
     * @var integer
     */
    public $theme_id = 0;

    /**
     * Order to sort on page
     *
     * @var integer
     */
    public $order_sort = 100;

    /**
     * Controller
     *
     * @var string
     */
    public $controller = '';

    /**
     * Hash for params - serialized options!
     *
     * @var string - serialized array()
     */
    public $params_hash = '';

    /**
     * Use personal params, or all
     * @var tinyint(4)
     */
    public $params_presonal = 0;

    //VIRTUAL FIELDS
    /**
     * Joined from rad_includes_params as original modules params
     */
    public $original_params = '';

    function __construct($array = NULL)
    {
        parent::__construct($array,'id',array('original_params'));
    }
}