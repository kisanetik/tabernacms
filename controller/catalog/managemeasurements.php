<?php
/**
 * Class for managing measurements
 *
 * @author Denys Yackushev
 * @package Taberna
 *
 */
class controller_catalog_managemeasurements extends rad_controller
{

	function __construct()
	{
		if($this->getParamsObject()){
		    $params = $this->getParamsObject();
		    $this->setVar('params',$params);
		}
		$this->setVar('hash', $this->hash());
		if( $this->request('a') ){
	    	$this->setVar('action', $this->request('a') );
	    	switch($this->request('a')){
		    	case 'l':
	    			$this->getItems();
		    	case 'addw':
		    		if( (int)$this->request('i') or $this->request('adda')=='add' and $this->request('hash')==$this->hash() ){
		    			$this->saveItem();
		    			$this->getItems();
		    			$this->setVar('showItems',true);
		    		}else
		    			$this->setVar('item', new struct_measurement());
		    		break;
		    	case 'editw':
		    		$this->assignItem();
		    		break;
		    	case 'd':
		    		if($this->request('hash')==$this->hash()) {
		    			$this->deleteItem();
		    		} else {
		    		    $this->redirect(SITE_URL);
		    		}
		    		break;
		    	case 'getjs':
		    		break;
	        	default:
		            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
	            break;
	    	}//switch
		}else{
			$this->getItems();
		}
	}

	function getItems()
	{
		$model = new model_system_table(RAD.'measurement');
		$model->setState('where', 'ms_langid='.(int)$this->getContentLangID());
		$this->setVar('items', $model->getItems());
	}

	function saveItem()
	{
		if((int)$this->request('i')) {
			$item = new struct_measurement( array('ms_id'=>(int)$this->request('i')) );
			$item->load();
			$item->CopyToStruct($this->getAllRequest());
			$item->save();
		} elseif($this->request('adda')=='add') {
			$item = new struct_measurement( $this->getAllRequest() );
			$item->ms_langid = $this->getContentLangID();
			$item->insert();
		}
	}

	function deleteItem()
	{
		if((int)$this->request('i'))
		{
			$item = new struct_measurement( array('ms_id'=>(int)$this->request('i')) );
			$item->remove();
		}
	}

	function assignItem()
	{
		if((int)$this->request('i')) {
			$item = new struct_measurement( array('ms_id'=>(int)$this->request('i')) );
			$this->setVar('item', $item->load());
		}
	}

}//class