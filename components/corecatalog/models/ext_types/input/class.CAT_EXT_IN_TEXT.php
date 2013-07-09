<?php
/**
 * Extension plugin for catalog
 * improve types extension for <input type="text" fields
 * @author Denys Yackushev
 * @package Taberna
 *
 */
class CAT_EXT_IN_TEXT extends rad_states { //TODO: implements interface_model_ext
    /**
     * Returns the JS code for the contol
     * @access public
     * @return string JavaScript code
     */
    public static function getJS($selected=null,$isAdmin=false)
    {
        return '';
    }

    /**
     * Returns the html code with conrol
     * @access public
     * @return string html
     */
    public static function getHTML(struct_corecatalog_cat_val_names $obj)
    {
        $vv = '';
        $vi = '';
        if(count($obj->vv_values)) {
            if(strlen($obj->vv_values[0]->vv_value)){
                $vv = $obj->vv_values[0]->vv_value;
            }
            $vi = '['.$obj->vv_values[0]->vv_id.']';
        }
        return '&nbsp;<input type="text" name="val_name['.$obj->vl_id.']'.$vi.'" id="val_name_'.$obj->vl_id.'" value="'.$vv.'" style="width: 98%;" />';
    }

}