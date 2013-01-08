<?php
/**
 * For managing order
 * @author Yackushev Denys
 * @package Taberna
 */
class model_catalog_order extends rad_model
{
	/**
	 * Insert order to order table and inserts the order positions, without delete the original positions
	 *
	 * @param struct_orders $item
	 * @return integer
	 */
    function insertItem(struct_orders $item,$insertPositions = true)
    {
    	$return = $this->insert_struct($item,RAD.'orders');
    	$order_id = $this->inserted_id();
    	$model = rad_instances::get('model_catalog_bin');
    	//get current positions
    	if($insertPositions){
	    	$positions = $model->getItemsCart();
	    	if( count( $positions ) and $order_id ){
	    		$model_catalog = rad_instances::get('model_catalog_catalog');
	    		$model_catalog->setState('with_vv',true);
	    		model_catalog_currcalc::init();
	    		$rows = 0;
	    		foreach($positions as $id){
	    			$item_full = $model_catalog->getItem( $id->bp_catid );
	    			$item = new struct_order_positions();
	    			$item->orp_catid = $id->bp_catid;
	    			$item->orp_orderid = $order_id;
	    			$item->orp_count = $id->bp_count;
	    			$item->orp_cost = model_catalog_currcalc::calcCours( $id->bp_cost, $id->bp_curid );
	    			$item->orp_curid = model_catalog_currcalc::$_curcours->cur_id;
	    			$item->orp_currency = model_catalog_currcalc::$_curcours->cur_ind;
	    			/*
	    			$item->orp_cost = $id->bp_cost;
	    			$item->orp_curid = $id->bp_curid;
	    			$item->orp_currency = model_catalog_currcalc::getCurrencyByID($id->bp_curid);
	    			*/
	    			$item->orp_name = $item_full->cat_name;
	    			$item->orp_article = $item_full->cat_article;
	    			$item->orp_code = $item_full->cat_code;
	    			$item->orp_dump = serialize($item_full);
	    			$rows += $this->insert_struct($item, RAD.'order_positions');
	    		}
	    		$return = $rows;
	    	}else{
	    		//вы уже делали заказ и в вашей корзине пусто
	    		$return = false;
	    	}
    	}
    	return $order_id;
    }

    function addToPositions($order_id, $product_ids)
    {
        $order = $this->getItem($order_id, true);
        $model_catalog = rad_instances::get('model_catalog_catalog');
        $model_catalog->setState('with_vv',true);
        model_catalog_currcalc::init();
        $rows = 0;
        $add_summ = 0;
        foreach($product_ids as $product_id) {
            $prid = (int) $product_id['id'];
            $product_full = $model_catalog->getItem( $prid );
            $pos_id = 0;
            foreach($order->order_positions as $orpos) {
                $orpos->orp_catid = (int) $orpos->orp_catid;
                if($orpos->orp_catid === $prid) {
                    $pos_id = $orpos->orp_id;
                    break;
                }
            }
            if($pos_id > 0) { //if positions exists in order
                $position = new struct_order_positions(array('orp_id'=>$pos_id));
                $position->load();
                $position->orp_count = (float)$position->orp_count + 1;
                $add_summ += model_catalog_currcalc::calcCours( $product_full->cat_cost, $product_full->cat_currency_id );
                $position->save();
            } else { //new position
                $position = new struct_order_positions();
                $position->orp_catid = $product_full->cat_id;
                $position->orp_orderid = $order->order_id;
                $position->orp_count = 1;
                $position->orp_cost = model_catalog_currcalc::calcCours( $product_full->cat_cost, $product_full->cat_currency_id );
                $add_summ += $position->orp_cost;
                $position->orp_curid = model_catalog_currcalc::$_curcours->cur_id;
                $position->orp_currency = model_catalog_currcalc::$_curcours->cur_ind;
                $position->orp_name = $product_full->cat_name;
                $position->orp_article = $product_full->cat_article;
                $position->orp_code = $product_full->cat_code;
                $position->orp_dump = serialize($product_full);
                $this->insert_struct($position, RAD.'order_positions');
            }
        }
        $order->order_summ += $add_summ;
        $this->updateItem($order);
    }

    /**
     * Gets the order items
     *
     */
    function getItems($limit=NULL)
    {
    	$q = $this->_getListQuery();
    	$limit = ($limit)?$limit:$this->getState('limit',$limit);
    	$result = array();
    	$limit = ($limit)?' LIMIT '.$limit:'';
    	foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key) {
            $order = new struct_orders($key);
            if( $this->getState('positions') ) {
                $this->assignPositions($order->order_positions, $order->order_id);
            }
            $result[] = $order;
    	}
        if( $this->getState('positions') ) {
            //$this->assignPositions($result);
        }
        return $result;
    }

    /**
     * Gets one order
     *
     * @param integer $order_id
     * @param boolean $with_positions
     * @return struct_orders
     */
    function getItem($order_id=NULL, $with_positions=false)
    {
    	if($order_id) {
	    	$result = new struct_orders( $this->query('SELECT * FROM '.RAD.'orders WHERE order_id=?', array((int)$order_id)) );
	    	if( $result->order_id and $with_positions ) {
	    	    $this->assignPositions($result->order_positions, $result->order_id);
	    	} else {
	    		//some error, order not found
	    		return $result;
	    	}
    	} else {
			if(count( $this->getStates() ) ){
                $q = $this->_getListQuery( $this->getStates() );
                if($this->getState('select')=='count(*)') {
                    $result = $this->query($q->toString().' LIMIT 1', $q->getValues());
                    if(count($result)) {
                        return $result['count(*)'];
                    } else {
                        return NULL;
                    }
                }else {
                    if(!$this->getState('select',false)) {
                        return new struct_orders( $this->query( $q->toString().' LIMIT 1', $q->getValues() ) );
                    } else {
                        return $this->query( $q->toString().' LIMIT 1', $q->getValues() );
                    }
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
    	}
    	return $result;
    }

    function assignPositions(&$result, $orderId)
    {
        foreach( $this->queryAll('SELECT * FROM '.RAD.'order_positions where orp_orderid=?', array((int)$orderId)) as $id) {
            $result[] = new struct_order_positions($id);
        }
    	return $result;
    }

    private function _getListQuery()
    {
    	$q = new rad_query();
    	if($this->getState('select')) {
    		$q->select( $this->getState('select') );
    	} else {
    		$q->select('*');
    	}
    	if($this->getState('where')) {
    		$q->where( $this->getState('where') );
    	}
    	if( $this->getState('order by') ) {
    		$q->order( $this->getState('order by') );
    	}
    	if( $this->getState('group by') ) {
    		$q->group( $this->getState('group by') );
    	}
    	if( $this->getState('pid') ) {
    		$q->where('order_status = :order_status' )->value( array('order_status'=>(int)$this->getState('pid')) );
    	}
        if( $this->getState('order_type') ){
    		$q->where('order_type = :order_type' )->value( array('order_type'=>(int)$this->getState('order_type')) );
    	}
    	if($this->getState('user_id')) {
            $q->where('order_userid = :order_userid')->value( array('order_userid'=>(int)$this->getState('user_id')) );
    	}
    	if($this->getState('lang', $this->getState('lang_id'))) {
    	    $q->where('order_langid=:lang_id')->value( array('lang_id'=>(int)$this->getState('lang', $this->getState('lang_id'))) );
    	}
        $q->from(RAD.'orders');
    	return $q;
    }

    function updateItem(struct_orders $item)
    {
        return $this->update_struct($item,RAD.'orders');
    }

    function deleteItemById($id)
    {
    	$rows = $this->exec( 'DELETE FROM '.RAD.'orders WHERE order_id='.(int)$id );
    	$rows += $this->exec( 'DELETE FROM '.RAD.'order_positions WHERE orp_orderid='.(int)$id );
    	return $rows;
    }

    function deletePositionFromOrder($order_id, $cat_id)
    {
        $order = $this->getItem($order_id, true);
        $cat_summ = 0;
        $pos_id = 0;
        if(!empty($order->order_positions)) {
            foreach($order->order_positions as $orpos) {
                $orpos->orp_catid = (int) $orpos->orp_catid;
                if($orpos->orp_catid === $cat_id) {
                    $pos_id = (int)$orpos->orp_id;
                    break;
                }
            }
            if($pos_id > 0) {
                $position = new struct_order_positions(array('orp_id'=>$pos_id));
                $position->load();
                $cat_summ = (float)$position->orp_cost * (float)$position->orp_count;
                $order->order_summ = (float)$order->order_summ - $cat_summ;
                $this->updateItem($order);
                return $position->remove();
            }
        }
        return 0;
    }

    function changePositionCount($order_id, $cat_id, $count)
    {
        $order = $this->getItem($order_id, true);
        if(!empty($order->order_positions)) {
            $pos_id = 0;
            foreach($order->order_positions as $orpos) {
                $orpos->orp_catid = (int) $orpos->orp_catid;
                if($orpos->orp_catid === $cat_id) {
                    $pos_id = (int)$orpos->orp_id;
                    break;
                }
            }
            if($pos_id > 0) {
                $position = new struct_order_positions(array('orp_id'=>$pos_id));
                $position->load();
                if((float)$position->orp_count != $count) {
                    $model_catalog = rad_instances::get('model_catalog_catalog');
                    $model_catalog->setState('with_vv',true);
                    $product = $model_catalog->getItem( $cat_id );
                    $pos_summ = (float)$position->orp_count * (float)$position->orp_cost;
                    $new_pos_summ = $count * (float)$product->cat_cost;
                    $new_pos_summ = model_catalog_currcalc::calcCours( $new_pos_summ, $order->order_curid );
                    $order->order_summ = $order->order_summ - ($pos_summ - $new_pos_summ);
                    $position->orp_count = ''.$count;
                    $this->updateItem($order);
                    return $position->save();
                }
            }
        }
        return 0;
    }

}