<?php
/**
 * Interface for plugins for model extension plugins
 */
interface interface_model_ext{
    
    /**
     * @param $selected - The object with selected value
     * @param boolean $isAdmin - Is need to show in admin?
     * @return string JavaScript
     */
    function getJS($selected=null,$isAdmin=false);
    
    /**
     * @param struct_forms_valnames $item - Item to show values
     * @param boolean $isAdmin - Is need to show in admin?
     * @return string HTML
     */
    function getHTML(struct_forms_valnames $item,$isAdmin=false);
    
}