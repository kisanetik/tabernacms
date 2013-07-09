<?php
/**
 * Composite structure for the Files in the system
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @deprecated 10 November 2011
 * @return composite struct
 * 
 *
 */
class struct_core_files extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $rfl_id = 0;

    /**
     * Primary key of the item
     * @var integer
     */
    public $rfl_item_id = 0;

    /**
     * System file name
     * @var string(35)
     */
    public $rfl_filename = '';

    /**
     * Original file name
     * @var string(255)
     */
    public $rfl_name = '';
    
    /**
     * Module name
     * @var string(50)
     */
    public $rfl_module = '';
    
    /**
     * Date when file is upload
     * @var DATETIME
     */
    public $rfl_dateupload = '';
    
    /**
     * Link to user, who uploaded this file
     * @var integer
     */
    public $rfl_user_id = '';
    
    /**
     * Access rules for the file
     * @var integer
     */
    public $rfl_access = 1000;

    function __construct($array = NULL)
    {
        parent::__construct($array,'rfl_id');
    }
}