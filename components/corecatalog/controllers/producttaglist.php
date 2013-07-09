<?php
/**
 * Class for showing the one product
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_producttaglist extends rad_controller
{

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('test');
        return $bco;
    }
    
    function __construct()
    {
        $this->assignTagProductsList();
    
    }
    
    function assignTagProductsList()
    {
        $model = rad_instances::get('model_corecatalog_catalog');
        $products = array();
        if ((int)$this->request('tag')) {
            $model->setState ('tag_id',  (int)$this->request('tag'));
            $products = $model->getProductsList();
            if(is_array($products)) {
                $this->setVar('products', $products);
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName ());
        }
    
    }

}