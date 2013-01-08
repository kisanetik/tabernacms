<?php
/**
 * Class for managing brands in admin
 * @author Artem Shevchenko
 * @package Taberna
 *
 */
class controller_catalog_managebrands extends rad_controller
{
	private $_hassubcats = true;

	private $_itemsperpage = 300;

	function __construct()
	{
		if($this->getParamsObject()){
			$params = $this->getParamsObject();
			$this->_hassubcats = $params->_get('hassubcats',$this->_hassubcats);
			$this->_itemsperpage = $params->_get('itemsperpage',$this->_itemsperpage);
			$this->setVar('params',$params);
		}
		$this->setVar('hash',$this->hash());
		if($this->request('action')){
			$this->setVar('action',$this->request('action'));
			switch($this->request('action')){
				case 'getjs':
					$this->getjs();
					break;
				case 'getjs_editform':
					$this->getJSEditForm();
					break;
				case 'editform':
					if($this->request('action_sub')){
						$this->saveBrand();
						if($this->request('returntorefferer')>0) {
							$this->editFormBrand();
						}
					}else{
						$this->editFormBrand();
					}
					break;
				case 'getbrands':
					$this->getBrands();
					break;
				case 'delbrand':
					$this->delBrand();
					break;
				case 'newlngpid':
					$this->newLngPID();
					break;
				default:
					$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
				die('action not exists!');
				break;
			}
		}
	}

	/**
	 * Gets the javascript,
	 * @retirn JavaScript
	 */
	function getjs()
	{
	}

	/**
	 * JavaScript module for the edit form
	 * @retirn JavaScript
	 */
	function getJSEditForm()
	{
	}

	/**
	 * Gets the news in tree and show it in table from AJAX
	 * @return html
	 */
	function getBrands()
	{
		$model = rad_instances::get('model_catalog_brands');

		$model->setState('select','count(*)');
		$items_count = $model->getItem();

		$model->unsetState('select');
		$page = (int)$this->request('p',1)-1;
		$limit = ($page*$this->_itemsperpage).','.$this->_itemsperpage;

		$this->setVar('items', $model->getItems($limit));
		$this->setVar('total_rows',$items_count);
		$pages = div((int)$items_count,$this->_itemsperpage);
		$pages+=(mod($items_count,$this->_itemsperpage))?1:0;
		$this->setVar('pages_count',$pages+1);
		$this->setVar('page',$page+1);
	}

	/**
	 * Show page with add news form
	 * @return html page
	 */
	function editFormBrand()
	{
		if($this->request('node_id')) {
		    $this->setVar('selected_category',(int)$this->request('node_id'));
		}
		if($this->request('rcb_id')) {
			$item = rad_instances::get('model_catalog_brands')->getItem((int)$this->request('rcb_id'));
			$this->setVar('item',$item);
		} else {
			$this->setVar('item', new struct_cat_brands());
		}
	}

	/**
	 * Save the one brand or add it from edit_form
	 * @return html page
	 */
	function saveBrand()
	{
	    if($this->request('hash') == $this->hash()) {
    		$model = rad_instances::get('model_catalog_brands');
    		if($this->request('action_sub')=='edit') {
    			$rcb_id = (int)$this->request('rcb_id');
    			if($rcb_id) {
    				$brand_item = $model->getItem($rcb_id);
    				$brand_item->MergeArrayToStruct($this->getAllRequest());
    			} else {
    				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
    				return;
    			}
    		}else{
    			$brand_item = new struct_cat_brands( $this->getAllRequest() );
    		}
    
    		$brand_item->rcb_active = ($this->request('rcb_active')=='on')?'1':'0';
    
    		if($this->request('action_sub')=='add') {
    			$rows = $model->insertItem($brand_item);
    		} elseif($this->request('action_sub')=='edit') {
    			$rows = $model->updateItem($brand_item);
    		}
    
    		if($this->request('returntorefferer')=='0') {
    			$this->redirect(SITE_URL.SITE_ALIAS);
    		}
	    } else {
	        $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
	    }
	}

	/**
	 * Save the tree node and return JS instructions
	 * @return JavaScript
	 */
	function saveNode()
	{
		$node_id = (int)$this->request('node_id');
		if($node_id) {
			rad_instances::get('controller_system_managetree')->save($node_id);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Adds new default node to groups-tree
	 * @return JavaScript code
	 */
	function addNode()
	{
		$node_id = (int)$this->request('node_id');
		if($node_id) {
			rad_instances::get('controller_system_managetree')->addItem($node_id);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Deletes news group from tree
	 * @return JavaScript
	 */
	function deleteNode()
	{
		$node_id = (int)$this->request('node_id');
		if($node_id) {
			rad_instances::get('controller_system_managetree')->deleteItem($node_id);
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}
	/**
	 * Delete brand by it ID
	 * @return JavaScript for AJAX
	 */
	function delBrand()
	{
	    if($this->request('hash') == $this->hash()) {
    		$n_id = (int)$this->request('n_id');
    		if($n_id){
    			$item = rad_instances::get('model_catalog_brands')->getItem($n_id);
    			$model = rad_instances::get('model_catalog_brands');
    			$rows = $model->deleteItem(new struct_cat_brands( array('rcb_id'=>$n_id) )) ;
    			if($rows) {
    				echo 'RADBrand.message("'.$this->lang('deletedrows.catalog.text').': '.$rows.'");';
    			} else {
    				echo 'RADBrand.message("'.$this->lang('deletedrows.catalog.error').': '.$rows.'");';
    			}
    			if($this->_hassubcats) {
    				echo 'RADBrandTree.listBrand(RADBrandTree.getSID());';
    			} else {
    				echo 'RADBrandTree.listBrand(ROOT_PID);';
    			}
    		} else {
    			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
    		}
		} else {
		    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
		}
	}

	/**
	 * Sets the new PID for the tree and return the JS commands
	 * @return JavaScript
	 *
	 */
	function newLngPID()
	{
		$lngid = (int)$this->request('i');
		if($lngid) {
			$params = $this->getParamsObject();
			echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
			echo 'RADNewsTree.refresh();';
		} else {
			$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
		}
	}
}