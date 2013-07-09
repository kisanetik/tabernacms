<?php
/**
 * Composite structure for the rad_includes, rad_modules
 *
 * Used by core
 *
 * @author Yackushev Denys
 * @package RADCMS
 * @version 0.1
 * @return composite struct
 *
 */
class struct_core_include extends rad_struct
{
/**
     * include ID
     *
     * @var integer
     */
    public $inc_id=0;

    /**
     * Include name
     *
     * @var string
     */
    public $inc_name='';

    /**
     * Filename and path to include file
     *
     * @var string
     */
    public $inc_filename='';

    /**
     * Controller - Function that need's to be called before template is included
     * This function returns to the include the data that include need to show
     *
     * @var string
     */
    public $controller='';

    /**
     * Position of include
     *
     * @var integer
     */
    public $inc_position=0;

    /**
     * Id module
     * Module needs to structure the controller and BL
     *
     * @var integer
     */
    public $id_module=0;

    /**
     * Module name, also the folder name
     *
     * @var string(not long)
     */
    public $m_name='';

    /**
     * Sort and ordering
     * @var integer just.number
     */
    public $order_sort='';

    /**
     * Position in template, as left,top,center etc.
     */
    public $rp_name='';

    /**
     * Position id in template
     */
    public $rp_id = 0;

    /**
     * Autoincremnemant include in alias id
     */
    public $incinal_id = 0;

    /**
     * Hash of the params
     */
    public $params_hash = '';

    //VIRTUAL FIELDS
     /**
     * Use personal params, or all
     * @var tinyint(4)
     */
    public $params_presonal = 0;

    /**
     * Joined from rad_includes_params as original modules params
     */
    public $original_params = '';

   function __construct($array = NULL)
    {
        parent::__construct($array,'inc_id',array('incinal_id','params_personal','original_params'));
    }

}