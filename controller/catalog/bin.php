<?php
/**
 * Class for managing the bin - for shopping cart
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_catalog_bin extends rad_controller
{
	function __construct()
	{
		if( $this->getParamsObject() ){
			$params = $this->getParamsObject();
			$this->setVar( 'params', $params );
		}
		if($this->request('action')){
			$this->setVar('action', $this->request('action'));
			switch($this->request('action')){
				case 'addtobin':
					$this->addToBin();
					break;
				case 'refreshbin':
					$this->refreshBin();
					break;
				case 'changebincount':
					$this->changeBinCount();
					break;
				case 'delfrombin':
				    $this->delFromBin();
				    break;
				case 'showbinwindow':
					$this->showBinWindow();
					break;
				default:
				    $this->calcBasket();
					break;
			}
		}else{
			$this->calcBasket();
		}
	}//construct

	/**
	 * Add 1 product to bin
	 *
	 */
	function addToBin()
	{
		$cat_id = (int)$this->request('cat_id');
		$count = (float)$this->request('count');
		if($cat_id && ($count>0) ){
			$model = rad_instances::get('model_catalog_bin');
			$model_catalog = rad_instances::get('model_catalog_catalog');
            $product = $model_catalog->getItem( $cat_id );
			$ex_item = $model->getItemCart($cat_id);
			if($ex_item){
				$ex_item->bp_count += $count;
				$rows = $model->updateItem($ex_item);
			}else{
				$item = new struct_bp( array('bp_catid'=>$cat_id,'bp_count'=>$count) );
				$item->bp_curid = $product->cat_currency_id;
	            $item->bp_cost = $product->cat_cost;
	            $item->bp_datetime = now();
	            if($this->getCurrentUser()){
		            $item->bp_userid = $this->getCurrentUser()->u_id;
		            $item->bp_whoadded = $this->getCurrentUser()->u_id;
	            }
	            $item->bp_sessid = $this->getCurrentSessID();
			    $rows = $model->insertItem($item);
			}
			if($rows){
				echo 'RADBIN.message("'.addslashes( $this->lang('productadded.catalog.message') ).'","'.$product->cat_name.'");';
			}else{
				echo 'RADBIN.message("'.addslashes( $this->lang('productnotadded.catalog.error') ).'","'.$product->cat_name.'");';
			}
			echo 'RADBIN.refresh();';
		}else{
			$this->securityHoleAlert( __FILE__, __LINE__ , $this->getClassName() );
		}
	}//function addToBin

	/**
	 * Calcs basket summ and count
	 *
	 */
	function calcBasket()
	{
		$model = rad_instances::get('model_catalog_bin');
		$items = $model->getItemsCart();
		$count = 0;
		$cost = 0;
		model_catalog_currcalc::init();
		if(count($items))
			foreach ($items as $id) {
                // Count of goods
				$count += $id->bp_count;
                $convertedCost = model_catalog_currcalc::calcCours( $id->bp_cost, $id->bp_curid );
				$cost += $id->bp_count * $convertedCost;
			}
		$this->setVar( 'items', $items );
		$this->setVar( 'count', $count );
		$this->setVar( 'cost' , $cost  );
		$this->setVar( 'curr' , model_catalog_currcalc::$_curcours );
	}

	/**
	 * Refresh bin summ and count from AJAX
	 * @return JavaScript
	 *
	 */
	function refreshBin()
	{
		$this->calcBasket();
	}

	/**
	 * Changes count in bin, usually +1 or -1
	 *@return JavaScript to AJAX eval it
	 *
	 */
	function changeBinCount()
	{
		$bp_id = (int)$this->request('bin_id');
		if($bp_id){
			$model = rad_instances::get('model_catalog_bin');
			$item = $model->getItem($bp_id);
			if($this->request('cnt_op')){
				$cnt_op = (int)$this->request('cnt_op');
				if( is_int($cnt_op) ) {
					if( ($item->bp_count+$cnt_op ) > 0){
						$item->bp_count += $cnt_op;
						$model->updateItem($item);
					}else{
						$model->deleteItem($item);
					}
				}
			}
			if($this->request('cnt_set') !== NULL) {
				$cnt_set = (int)$this->request('cnt_set');
			    if( is_int($cnt_set) ) {
			        if($cnt_set != 0) {
			        	if($cnt_set >= 1) {
                            $item->bp_count = $cnt_set;
                        }
                        $model->updateItem($item);
                    } else {
                    	$model->deleteItem($item);
                    }
                }
			}
			echo 'RADBIN.refreshOrder();';
			echo 'RADBIN.refresh();';
		}else{
			$this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
		}
	}

	function delFromBin()
	{
	    $bp_id = (int)$this->request('bin_id');
	    if($bp_id){
	        $model = rad_instances::get('model_catalog_bin');
	        $item = $model->getItem($bp_id);
	        if($item->bp_id){
	            $model->deleteItem($item);
	            echo 'RADBIN.refreshOrder();';
	            echo 'RADBIN.refresh();';
	        }
	    }else{
	        $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
	    }
	}
	
	/**
	 * Shows a bin window at goods addition
	 *
	 */
	function showBinWindow(){
		model_catalog_currcalc::init();
		$this->setVar( 'curr' , model_catalog_currcalc::$_curcours );
		$model = rad_instances::get('model_catalog_bin');
		$ct_showing = ($this->getParamsObject())?$this->getParamsObject()->ct_showing:NULL;
		$items = $model->getCartProducts(NULL,NULL,$ct_showing);
		$bin_pos = $model->getItemsCart();
		$counts = array();
		$bin_ids = array();
		$total_count = 0;
		$total_costs = 0;
		if(count($bin_pos)) {
			foreach($bin_pos as $id){
				$counts[$id->bp_catid] = $id->bp_count;
				$bin_ids[$id->bp_catid] = $id->bp_id;
			}
		}
		for($i=0;$i<count($items);$i++){
			$items[$i]->cost = $items[$i]->cat_cost;
			$items[$i]->cat_cost = model_catalog_currcalc::calcCours( $items[$i]->cat_cost, $items[$i]->cat_currency_id );
			$items[$i]->cat_count = $counts[$items[$i]->cat_id];
			$total_count += $items[$i]->cat_count;
			$total_costs += $items[$i]->cat_cost*$items[$i]->cat_count;
			$items[$i]->bp_id = $bin_ids[$items[$i]->cat_id];
		}
		$this->setVar('items',$items);
		$this->setVar('total_count',$total_count);
		$this->setVar('total_costs',$total_costs);
	}
	
}