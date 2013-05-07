<?php
/**
 * Class for showing the one product
*
* @author Yackushev Denys
* @package Taberna
*
*/
class controller_catalog_productsrecommend extends rad_controller
{   
    private $_itemsPerPage = 10;

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_itemsPerPage = (int) $params->itemsperpage;
            $this->setVar('params', $params);
        }
        
        $pId = (int)$this->request('p');
        if($pId) {
            $modelProduct = rad_instances::get('model_catalog_catalog');
            $product = $modelProduct->getItem($pId);
            if($product->cat_id) {
                $modelTags = rad_instances::get('model_resource_tags');
                $modelTags->setState('tag_type', 'product');
                $similarProducts = $modelTags->getItemsWithSimilarTags($product, $this->_itemsPerPage);
                $i = 0;
                $model_images = rad_instances::get('model_system_image');
                foreach($similarProducts as &$product) {
                    $model_images->setState('cat_id', $product->cat_id);
                    $product->images_link = $model_images->getItems();
                }
                $this->setVar('recommendProducts', $similarProducts);
            }
        }
    }
}