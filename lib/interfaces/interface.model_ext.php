<?php
/**
 * Interface for plugins for model extension plugins
 */
interface interface_model_ext{
    
    /**
     * @param $selected The object with selected value
     * @param boolean $isAdmin Is need to show in admin?
     * @return string JavaScript
     */
    function getJS($selected = null, $isAdmin = false);

    /**
     * @param struct_corecatalog_cat_val_names $item Item to show values
     * @param bool $isAdmin Is need to show in admin?
     * @return string HTML
     */
    function getHTML(struct_corecatalog_cat_val_names $item, $isAdmin = false);
}