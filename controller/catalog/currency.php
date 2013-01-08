<?php
/**
 * Class for manipulating currency
 * 
 * @author Denys Yackushev
 * @package Taberna
 *
 */
class controller_catalog_currency extends rad_controller
{
	function __construct()
	{
		if($this->getParamsObject()){
		    $this->setVar('params',$this->getParamsObject());
		}
		$model = rad_instances::get('model_catalog_currency');
		$items = $model->getItems();
		foreach($items as $id){
		    if($id->cur_default_site){
		        $this->setVar('currCurrency',$id);
		        break;
		    }
		}
        $this->setVar('items',$items);
	}
}