<?php
/**
 * Catalog model
 * @author Yackushev Denys
 * @package Taberna
 */
class model_catalog_catalog extends rad_model
{

    /**
     * Gets the items by standart scheme,
     * for getting products for the catalog
     * use the getProductsList() function!
     * @param string $limit
     * @return mixed array of struct_catalog | mixed array | NULL
     */
	function getItems($limit=NULL)
	{
		$q = $this->_getListQuery();
		$limit = ($limit)?$limit:$this->getState('limit', $limit);
		$limit = ($limit)?' LIMIT '.$limit:'';
		if($this->getState('showSQL')) {
		    print_h($q->getValues());
		    die($q->toString());
		}
		$result = $this->queryAll($q->toString().$limit, $q->getValues());
		if($this->getState('return.array')) {
		    return $result;
		}
		if(count($result)) {
		    $return = array();
		    foreach($result as $id) {
		        $return[] = new struct_catalog($id);
		        if($this->getState('join.mainimage') and !empty($id['img_filename'])) {
		            $return[count($return)-1]->img_filename = $id['img_filename'];
		        }
		        if($this->getState('join.tree') and !empty($id['tre_id'])) {
		            $return[count($return)-1]->tree_link = new struct_tree($id);
		        }
		        if(!empty($id['price'])) {
		            $return[count($return)-1]->price = $id['price'];
		        }
		    }
		    return $return;
		}
		return NULL;
	}

	/**
	 * Get one product object
	 *
	 * @param integer $id - or product
	 * @return struct_catalog
	 */
	function getItem($id=NULL)
	{
		$id = (int)$id;
		if($id or $this->getStates()) {
			if($id) {
				$this->setState('id',$id);
			}
			$q = $this->_getListQuery();
			$return = new struct_catalog($this->query( $q->toString().' LIMIT 1', $q->getValues() ));
			if($id) {
				$return->tree_catin_link = $this->getCatalogTreeEntries($id);
	            $model_images = rad_instances::get('model_system_image');
	            $model_images->setState('cat_id',$id);
	            $return->images_link = $model_images->getItems();
			}
            if($this->getState('with_vv', false)) {
                $ct_showing = $this->getState('ct_showing', 0);
                $return = array($return);
                $this->getValValues($return, $ct_showing);
                $return = $return[0];
            } elseif( (int)$return->cat_ct_id and !$this->getState('without_catalog_types')) {
                $return->type_link = rad_instances::get('model_catalog_types')->getItem($return->cat_ct_id);
            }
            if(!$this->getState('without_special')) {
                $this->assignSpecial($return);
            }
            if($this->getState('with_download_files')) {
            	$this->assignDownloadFiles($return);
            }
            if($this->getState('with_tags',false)) {
            	$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','product');
            	$modelTags->asignTagsToItem($return);
            }
            if($this->getState('join.comments')) {
                $this->assignComments($return);
            }
            return $return;
		}
		return NULL;
	}

	/**
	 * Assign special to product
	 *
	 * @param struct_catalog $item
	 */
	function assignSpecial(struct_catalog $item)
	{
	    $table = new model_system_table(RAD.'cat_special');
	    /*$lang = $this->getState('lang');
	    $lang = ($lang)?' and cat_lngid='.(int)$lang:'';*/
	    $table->setState('where', 'cs_catid='.$item->cat_id/*.$lang*/);
	    $table->setState('order by', 'cs_order');
	    $items = $table->getItems();
	    if(count($items)) {
	        foreach($items as $id){
	           switch($id->cs_type){
	               case 1:
	                   $item->cat_special_spnews = true;
	                   break;
	               case 2:
	                   $item->cat_special_sp = true;
	                   break;
	               case 3:
	                   $item->cat_special_spoffer = true;
	                   break;
	               case 4:
	                   $item->cat_special_sphit = true;
	                   break;
	           }
	        }
	    }
	}

    /**
     * Get count of products in tree_id
     * @return integer
     */
    function getProductsListCount()
    {
		$q = new rad_query();
		$q->select('cat_id');
        if( ($this->getState('active',2)==1) or ($this->getState('active',2)==0) ) {
            $q->where('cat_active='.(int)$this->getState('active'));
        }
        if((int)$this->getState('lang')) {
            $q->where('cat_lngid=:lang_id')->value(array('lang_id'=>(int)$this->getState('lang')));
        }
		if((int)$this->getState('cit_tre_id', $this->getState('tre_id') )) {
		    $q->from(RAD.'cat_in_tree c');
		    $q->join('INNER', RAD.'catalog on cit_cat_id=cat_id');
		    $q->where('cit_tre_id=:cit_tre_id')->value(array('cit_tre_id'=>(int)$this->getState('cit_tre_id', $this->getState('tre_id') )));
		} elseif((int)$this->getState('special_offer')) {
		    $q->from(RAD.'catalog c');
		    $q->join('INNER', RAD.'cat_special cs on cs.cs_catid=c.cat_id and cs.cs_type=:cs_type')->value(array('cs_type'=>(int)$this->getState('special_offer')));
        }else{
			throw new rad_exception('Not setted the "cit_tre_id" or "tre_id!" in class "'.$this->getClassName().'" at line: '.__LINE__,500);
		}
		if( $this->getState('cat_id') AND is_array($this->getState('cat_id')) ) {
		    $q->where('cat_id IN (:cat_id_in)')->value(array('cat_id_in'=>implode(',', $this->getState('cat_id')) ));
		}
		if ($this->getState ('tag_id')){
		    $q->join('INNER', RAD.'tags_in_cat tic ON tic.tic_cat_id = c.cat_id AND tic.tic_tag_id=:tic_tag_id');
		    $q->value(array ('tic_tag_id'=>$this->getState ('tag_id')));
		}
		if((int)$this->getState('brand_id')) {
		    $q->where('cat_brand_id=:brand_id')->value(array('brand_id'=>(int)$this->getState('brand_id')));
		}
		if($this->getState('currency')) {
		    $q->join('LEFT', RAD.'currency cr ON cat_currency_id=cr.cur_id');
		    $q->join('INNER', RAD.'currency cur ON cur.cur_id=:currency')->value(array('currency'=>$this->getState('currency')));
		    $q->select('(cat_cost*cr.cur_cost/cur.cur_cost) AS price');
		}
		if($this->getState('cost.from')) {
		    $q->having('price >= :costfrom')->value(array('costfrom'=>$this->getState('cost.from')));
		}
		if($this->getState('cost.to')) {
		    $q->having('price <= :costto')->value(array('costto'=>$this->getState('cost.to')));
		}
		if($this->getState('val_values')) {
		    foreach($this->getState('val_values') as $vvId=>$vvVal) {
		        $q->where('EXISTS ( SELECT * FROM rad_cat_val_values WHERE vv_cat_id=cat_id AND vv_name_id='.(int)$vvId.' AND vv_value=:val_'.(int)$vvId.' )')
		        ->value(array('val_'.(int)$vvId=>$vvVal));
		    }
		}
		$result = $this->query('SELECT COUNT(*) AS cnt FROM ('.$q->toString().') AS tbl', $q->getValues());
		if(count($result)) {
		    return $result['cnt'];
		}
		return null;
    }

    /**
     * Special for search
     * @todo JOIN the main image!
     */
    function searchItems($searchword = '',$ct_showing = 0)
    {
    	$q = new rad_query();
    	$withvals = $this->getState('withvals');
    	$where_like = array();
    	$limit = $this->getState('limit','0,20');
    	$limit = ' LIMIT '.$limit;
    	$order = $this->getState('order by','cat_position, cat_name, cat_datecreated, cat_usercreated');
    	$order = ' ORDER BY '.$order.' ';
    	if($this->getState('count')){
    		$q->select('count(c.cat_id)');
        }elseif($withvals){
    		$q->select('c.*, tps.*, i.img_filename as img_filename');
    	}else{
    		$q->select('c.*, i.img_filename as img_filename');
    	}
    	$q->from(RAD.'cat_val_values vl ');
    	$q->join('INNER',RAD.'cat_val_names vn ON vl.vv_name_id = vn.vl_id');
    	$q->join('INNER',RAD.'catalog c ON c.cat_id = vl.vv_cat_id AND c.cat_ct_id = vn.vl_tre_id');
    	$q->join('INNER',RAD.'tree tps ON tps.tre_id = c.cat_ct_id');
    	$q->join('LEFT',RAD.'cat_images i on img_cat_id=cat_id and img_main=1');
    	$cat_in_tree = $this->getState('cat_in_tre');
    	if($cat_in_tree){
    		$q->join('LEFT',RAD.'cat_in_tree cit ON cit.cit_cat_id = c.cat_id');
    		if( is_array($cat_in_tree) and count($cat_in_tree) ){
    			$where = ' WHERE cit.cit_tre_id in ('.implode(',',$cat_in_tree).') ';
    		}else{
    			$where = ' WHERE cit.cit_tre_id="'.(int)$cat_in_tree.'" ';
    		}
    	}else{
    		$where =' WHERE 1';
    	}
        if( ($this->getState('active',2)==1) or ($this->getState('active',2)==0) )
            $where .= ' and cat_active='.$this->getState('active');
    	if($this->getState('with_vv',true)){
    		$where_like[] = '(vl.vv_value LIKE "%'.$searchword.'%")';
    		$where_like[] = '(vl.vv_value2 LIKE "%'.$searchword.'%") ';
    	}
    	if($this->getState('with_cat_name',true)){
    		$where_like[] = '(c.cat_name LIKE "%'.$searchword.'%")';
    	}
    	if($this->getState('with_cat_fulldesc',true)){
    		$where_like[] = '(c.cat_fulldesc LIKE "%'.$searchword.'%")';
    	}
        if($this->getState('with_cat_shortdesc',true)){
            $where_like[] = '(c.cat_shortdesc LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_cat_article',true)){
            $where_like[] = '(c.cat_article LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_cat_code',true)){
            $where_like[] = '(c.cat_code LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_cat_keywords',true)){
            $where_like[] = '(c.cat_keywords LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_cat_metatitle',true)){
            $where_like[] = '(c.cat_metatitle LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_cat_metatescription',true)){
            $where_like[] = '(c.cat_metatescription LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_vl_name',true)){
            $where_like[] = '(vn.vl_name LIKE "%'.$searchword.'%")';
        }
        if($this->getState('with_tre_name',true)){
        	$q->join('LEFT', RAD.'tree t on t.tre_id = cit.cit_tre_id ');
            $where_like[] = '(t.tre_name LIKE "%'.$searchword.'%")';
        }
        if($this->getState('lang')){
            $where.=' and c.cat_lngid='.(int)$this->getState('lang').' ';
        }
        if($this->getState('cost_from') or $this->getState('cost_to')){
            $q->join('LEFT', RAD.'currency cr on cat_currency_id=cur_id');

            $where.=' and ( ( c.cat_cost*(cr.cur_cost/'.model_catalog_currcalc::currCours().')>='.(int)$this->getState('cost_from').') ';
            if((int)$this->getState('cost_to')>0){
                $where.=' and ( c.cat_cost*(cr.cur_cost/'.model_catalog_currcalc::currCours().')<='.(int)$this->getState('cost_to').')';
            }
            $where.=' ) ';
        }
        $sql = $q->toString().$where.' AND ('.implode(' or ', $where_like).') '.' GROUP BY c.cat_id '.$order.$limit;
        $result = array();
        if($this->getState('count')) {
        	$result = $this->queryAll($sql);
        	$result = count($result);
        } else {
	        foreach( $this->queryAll($sql) as $id) {
	        	$result[] = new struct_catalog($id);
	        	if($withvals) {
	        	   $result[count($result)-1]->type_link = new struct_tree($id);
	        	}
	        }
	        if( $withvals and $ct_showing) {
	        	$this->getValValues($result, $ct_showing);
	        }
        }
    	return $result;
    }

    /**
     * Return the products list
     * @param boolean $withvals
     * @param integer $ct_showing
     * @return struct_catalog array
     */
	function getProductsList($withvals=false,$ct_showing=0)
	{
		$tre_id = (int)$this->getState('cit_tre_id', $this->getState('tre_id') );
		if($tre_id or $this->getState('where_condition') or $this->getState ('cat_id') or $this->getState('tag_id')) {
			$result = array();
			$q = new rad_query();
			$q->select('c.*,cr.cur_name AS currency_name, cr.cur_cost AS currency_cost, cr.cur_ind AS currency_indicate, ct.tre_name AS cat_ct_name, ct.*, i.img_filename AS img_filename');
			if ($this->getState('tag_id')) {
			    $q->from(RAD.'catalog c');
			} else {
			    $q->from(RAD.'cat_in_tree');
			    $q->join('LEFT', RAD.'catalog c ON cit_cat_id=cat_id');
			}
			$q->join('LEFT', RAD.'currency cr ON cat_currency_id=cr.cur_id');
			$q->join('LEFT', RAD.'tree ct ON cat_ct_id=tre_id');
			$q->join('LEFT', RAD.'cat_images i ON img_cat_id=cat_id AND img_main=1');
			$orderj = '';
			if($this->getState('special_offer')) {
				$q->join('INNER', RAD.'cat_special cs ON cs.cs_catid=c.cat_id AND cs.cs_type=:cs_type')->value( array('cs_type'=>(int)$this->getState('special_offer')) );
                $orderj = ($this->getState('order by'))?' '.$this->getState('order by'):' cs.cs_order,';
			}
			if($this->getState('where_condition')) {
				$q->where( $this->getState('where_condition') );
			} elseif (!$this->getState('tag_id')) {
				$q->where( 'cit_tre_id=:cit_tre_id' )->value( array('cit_tre_id'=>$tre_id) );
			}
			if( ($this->getState('active',2)==1) or ($this->getState('active',2)==0) ) {
				$q->where('cat_active=:cat_active')->value( array('cat_active'=>$this->getState('active')) );
			}
			if( $this->getState('lang') ) {
				$q->where('cat_lngid=:cat_lngid')->value( array('cat_lngid'=>$this->getState('lang')) );
			}
			if( $this->getState('cat_id') AND is_array($this->getState('cat_id')) ) {
			    $q->where('cat_id IN (:cat_id_in)')->value(array('cat_id_in'=>implode(',', $this->getState('cat_id')) ));
			}
			if ($this->getState ('tag_id')){
			    $q->join('INNER', RAD.'tags_in_cat tic ON tic.tic_cat_id = c.cat_id AND tic.tic_tag_id=:tic_tag_id');
			    $q->value(array ('tic_tag_id'=>$this->getState ('tag_id')));
			}
			if($this->getState('group by')) {
				$q->group($this->getState('group by'));
			} else {
				$q->group('cat_id');
			}
			if($this->getState('order by')) {
				$q->order( $this->getState('order by') );
			} else {
				$q->order( $orderj.'cat_position,cat_name' );
			}
			if((int)$this->getState('brand_id')) {
			    $q->where('c.cat_brand_id=:brand_id')->value(array('brand_id'=>(int)$this->getState('brand_id')));
			}
			if($this->getState('val_values')) {
			    foreach($this->getState('val_values') as $vvId=>$vvVal) {
			        $q->where('EXISTS ( SELECT * FROM rad_cat_val_values WHERE vv_cat_id=c.cat_id AND vv_name_id='.(int)$vvId.' AND vv_value=:val_'.(int)$vvId.' )')
			          ->value(array('val_'.(int)$vvId=>$vvVal));
			    }
			}
			if($this->getState('currency')) {
			    $q->join('INNER', RAD.'currency cur ON cur.cur_id=:currency')->value(array('currency'=>$this->getState('currency')));
			    $q->select('(c.cat_cost*cr.cur_cost/cur.cur_cost) AS price');
			}
			if($this->getState('cost.from')) {
			    $q->having('price >= :costfrom')->value(array('costfrom'=>$this->getState('cost.from')));
			}
			if($this->getState('cost.to')) {
			    $q->having('price <= :costto')->value(array('costto'=>$this->getState('cost.to')));
			}
			$limit = $this->getState('limit');
            $limit = ($limit)?' LIMIT '.$limit:'';
            $i=0;
            if($this->getState('showSQL')) {
                print_h($q->getValues());
                die($q->toString());
            }
            foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $row) {
            	$result[$i] = new struct_catalog($row);
				$this->assignSpecial($result[$i]);
            	if($withvals) {
                    $result[$i]->type_link = new struct_tree($row);
            	}
            	$i++;
            }//foreach
            if(($withvals or $this->getState('val_values')) and count($result)) {
                $this->getValValues($result, $ct_showing);
            }
            return $result;
		}else{
			throw new rad_exception('Not setted the "cit_tre_id" or "tre_id!" in class "'.$this->getClassName().'" at line: '.__LINE__,500);
		}
	}

    /**
     * Gets the val values for products
     * @param struct_catalog array $result
     * @param integer $ct_showing
     * @return type_vl_link into $result
     * @todo optimize to prevent SQL Injection
     */
    function getValValues(&$result,$ct_showing=0)
    {
        if(count($result)) {
        	$q = new rad_query();
        	$q->select('*')
        	  ->from(RAD.'cat_val_names')
        	  ->order('vl_position');
        	if($ct_showing) {
        		$q->join('INNER', RAD.'ct_showing on cts_vl_id = vl_id and cts_show=:cts_show')
        		  ->value( array('cts_show'=>$ct_showing) );
        	}
            for($i=0;$i<count($result);$i++) {
            	$q1 = clone $q;
            	$q1->where('vl_tre_id=:vl_tre_id')->value( array('vl_tre_id'=>$result[$i]->cat_ct_id) );
            	foreach($this->queryAll($q1->toString(), $q1->getValues()) as $id) {
            		$result[$i]->type_vl_link[] = new struct_cat_val_names($id);
            	}
                if( count($result[$i]->type_vl_link) ) {
                    for($k=0;$k<count($result[$i]->type_vl_link);$k++ ) {
                        foreach( $this->queryAll('SELECT * FROM '.RAD.'cat_val_values WHERE vv_name_id='.$result[$i]->type_vl_link[$k]->vl_id.' AND vv_cat_id='.$result[$i]->cat_id.' ORDER BY vv_position') as $idv) {
                            $result[$i]->type_vl_link[$k]->vv_values[] = new struct_cat_val_values($idv);
                        }//foreach
                    }//for
                }
            }//for
            return true;
        }else{
            return false;
        }
    }

	 /**
     * Gets the query
     *
     * @return rad_query
     */
	function _getListQuery()
	{
		$qb = new rad_query();

		if($this->getState('select')) {
		    $qb->select($this->getState('select'));
        } else {
            $qb->select('a.*');
        }
		if($this->getState('from')) {
		    $qb->from($this->getState('from'));
        } else {
            $qb->from(RAD.'catalog a');
        }
		if($this->getState('id')) {
		    $qb->where('cat_id=:cat_id')->value(array('cat_id'=>$this->getState('id')));
		}
        if($this->getState('order by')) {
            $qb->order($this->getState('order by'));
        }
        if($this->getState('cat_code')) {
            $qb->where('cat_code=:cat_code')->value(array('cat_code'=>$this->getState('cat_code')));
        }
        if($this->getState('tre_id')) {
            if(is_array($this->getState('tre_id'))) {
                $treIds = array();
                foreach($this->getState('tre_id') as $key=>$treId) {
                    $treIds[] = (int)$treId;
                }
                $treIds = implode(',', $treIds);
                $qb->join('INNER', RAD.'cat_in_tree cit ON cit.cit_cat_id=a.cat_id AND cit_tre_id IN ('.$treIds.')');
            } else {
                $qb->join('INNER', RAD.'cat_in_tree cit ON cit.cit_cat_id=a.cat_id AND cit_tre_id=:tre_id');
                $qb->value(array('tre_id'=>$this->getState('tre_id')));
            }
        }
        if($this->getState('join.tree')) {
            $qb->join('LEFT', RAD.'cat_in_tree cit_j ON cit_j.cit_cat_id=a.cat_id');
            $qb->join('LEFT', RAD.'tree cit_jt ON cit_jt.tre_id=cit_j.cit_tre_id');
            $qb->select('cit_jt.*');
        }
        if($this->getState('active')) {
            $qb->where('cat_active=1');
        }
        if($this->getState('group by')) {
            $qb->group($this->getState('group by'));
        }
        if($this->getState('currency')) {
            $qb->join('INNER', RAD.'currency cur ON cur.cur_id=a.cat_currency_id')
               ->join('INNER', RAD.'currency cr ON cr.cur_id=:currency')->value(array('currency'=>$this->getState('currency')))
               ->select('(a.cat_cost*cur.cur_cost)/cr.cur_cost AS price');
        }
        if($this->getState('join.mainimage')) {
            $typeJoin = $this->getState('only.withimages')?'INNER':'LEFT';
            $qb->join($typeJoin, RAD.'cat_images i ON img_cat_id=cat_id AND img_main=1');
            $qb->select('i.img_filename');
        }
        if($this->getState('lang', $this->getState('lang_id'))) {
            $qb->where('a.cat_lngid=:cat_lngid')->value(array('cat_lngid'=>$this->getState('lang', $this->getState('lang_id'))));
        }
        if($this->getState('cat_usercreated')) {
            $qb->where('a.cat_usercreated=:usercreated')->value(array('usercreated'=>$this->getState('cat_usercreated')));
        }

		if($this->getState('where')) {
		    $qb->where($this->getState('where'));
		}
        return $qb;
	}//function _getListQuery

	function insertItem(struct_catalog $item)
	{
		//$cat_id = $this->query('SELECT MAX(cat_id)+1 as cat_id FROM '.RAD.'catalog');
		//$item->cat_id = ((int)$cat_id['cat_id'])?(int)$cat_id['cat_id']:1;
		try {
			$item->insert();
			if(!isset($item->cat_id)) {
			    $item->cat_id = $this->$this->inserted_id();
			}
			if(empty($item->cat_id) or !((int)$item->cat_id)) {
			    $item->cat_id = 1;
			}
			//ADD PRODUCT IN TREES
			if(count($item->tree_link)) {
				foreach($item->tree_link as &$cit) {
					$cit->cit_cat_id = $item->cat_id;
					$cit->insert();
				}
			}//if count
			//ADD val_values in types
			if(count($item->type_vl_link)) {
				foreach($item->type_vl_link as &$vl_name) {
					foreach($vl_name->vv_values as &$val_value) {
						$val_value->vv_cat_id = $item->cat_id;
						$val_value->insert();
					}
				}
			}
			//SPECIAL OFFERS!
			if( $this->getState('sp_offers') ) {
				$this->updateOffers($item);
			}
			//IMAGES
			if(count($item->images_link)) {
				foreach($item->images_link as &$image) {
					$image->img_cat_id = $item->cat_id;
					$image->insert();
				}
			}
			//DOWNLOAD FILES
			if(!empty($item->download_files)) {
				foreach($item->download_files as $download_file) {
					$download_file->rcf_cat_id = $item->cat_id;
					$download_file->insert();
				}
			}
			//TAGS
			$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','product');
			$modelTags->insertTagsToItem($item);
		} catch(PDOException $e) {
			if($this->hasActiveTransaction()) {
				$this->rollBackTransaction();
			}
			try {
				print_r($e);
			} catch(Exception $e2) {
				print_r($e2);
			}
			die('Error');
		}
		return $item;
	}//function insertItem

	/**
	 * Updates only struct of item
	 * @param struct_catalog $item
	 * @return integer - number of updated fields
	 */
	function updateStruct(struct_catalog $item)
	{
		$item->addFieldToIgnoresList('cat_datecreated');
        $item->addFieldToIgnoresList('cat_dateupdated');
        $item->addFieldToIgnoresList('cat_usercreated');
        return $this->update_struct($item, RAD.'catalog');
	}

	function updateItem(struct_catalog $item)
	{
	    //update product here
	    $rows = $this->updateStruct($item);
	    //Update type values
	    if(count($item->type_vl_link)) {
	        $rows += rad_instances::get('model_catalog_types')->deleteTypeValuesByCatId($item->cat_id);
	        foreach($item->type_vl_link as $tvl) {
	            if(count($tvl->vv_values)) {
	                foreach($tvl->vv_values as $vv) {
	                    $vv->vv_value = trim($vv->vv_value);
	                    $vv->vv_value2 = trim($vv->vv_value2);
	                    if( strlen($vv->vv_value) or strlen($vv->vv_value2) ) {
	                        if(!$vv->vv_cat_id) {
	                            $vv->vv_cat_id = $item->cat_id;
	                        }
	                        $rows += rad_instances::get('model_catalog_types')->insertTypeValues($vv);
	                    }
	                }//foreach vv
	            }
	        }//foreach tvl
	    }//if count type_vl_link
	    //ADD PRODUCT TO TREE
	    /*
	     $tmp_sql_part = '';
	    if(count($item->tree_link))
	    {
	    $tre_ids = array();
	    foreach($item->tree_link as $id){
	    $tre_ids[] = $id->cit_tre_id;
	    }
	    $tmp_sql_part = ' AND cit_tree_id NOT IN ('.implode(',', $tre_ids).')';
	    }
	    $this->exec('DELETE FROM '.RAD.'cat_in_tree WHERE cit_cat_id='.(int)$item->cat_id.$tmp_sql_part);
	    */
	    //TODO Optimize that
	    $this->deleteProductFromTree($item->cat_id);
	    if(count($item->tree_link)) {
	        foreach($item->tree_link as $id){
	            $rows += $this->addProductToTree($item->cat_id, $id->cit_tre_id);
	        }//fireach
	    }
	    //IMAGES
	    if( count($item->images_link) ) {
	        foreach($item->images_link as $img_id) {
	            rad_instances::get('model_system_image')->nullMainImages($item->cat_id);
	            rad_instances::get('model_system_image')->insertItem($img_id);
	            $img_id->img_id = $this->inserted_id();
	        }
	    }
	    //SPECIAL OFFERS!
	    if( $this->getState('sp_offers') ) {
	        $this->updateOffers($item);
	    }
	    //TAGS
	    $modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','product');
	    $modelTags->updateTagsInItem($item);
	    //TODO DOWNLOAD FILES
	    //Insert new files
	    if(!empty($item->download_files)) {
	        //$exist_files = $this->queryAll('SELECT rcf_id FROM '.RAD.'cat_files WHERE rcf_cat_id=?', array($item->cat_id));
	        foreach($item->download_files as $df) {
	            $df->rcf_cat_id = $item->cat_id;
	            $df->insert();
	        }
	    }
	    return $item;
	}

	/**
	 * Special offers module, for New products, Sales, hit of sales e t.c.
	 *
	 * @param unknown_type $item
	 */
	function updateOffers(struct_catalog $item)
	{
	   $table = new model_system_table(RAD.'cat_special');
       $table->setState('where','cs_catid='.(int)$item->cat_id);
       $offers = $table->getItems();
       $exist_offers = array();
       if( count($offers) ){
           for($i=0;$i<count($offers);$i++)
            $exist_offers[$offers[$i]->cs_type] = &$offers[$i];
       }
       //NEW PRODUCT
       if( ($item->cat_special_spnews) and (!isset($exist_offers[1])) ){
           $exist_offers[1] = new struct_cat_special();
           $exist_offers[1]->cs_type = 1;
           $exist_offers[1]->cs_catid = $item->cat_id;
           $exist_offers[1]->insert();
       }elseif( (!$item->cat_special_spnews) and (isset($exist_offers[1])) ){
           $exist_offers[1]->remove();
       }
       //SPECIAL OFFER
	   if( ($item->cat_special_sp) and (!isset($exist_offers[2])) ){
           $exist_offers[2] = new struct_cat_special();
           $exist_offers[2]->cs_type = 2;
           $exist_offers[2]->cs_catid = $item->cat_id;
           $exist_offers[2]->insert();
       }elseif( (!$item->cat_special_sp) and (isset($exist_offers[2])) ){
           $exist_offers[2]->remove();
       }
       //SALES
	   if( ($item->cat_special_spoffer) and (!isset($exist_offers[3])) ){
           $exist_offers[3] = new struct_cat_special();
           $exist_offers[3]->cs_type = 3;
           $exist_offers[3]->cs_catid = $item->cat_id;
           $exist_offers[3]->insert();
       }elseif( (!$item->cat_special_spoffer) and (isset($exist_offers[3])) ){
           $exist_offers[3]->remove();
       }
       //HIT OF SALES
	   if( ($item->cat_special_sphit) and (!isset($exist_offers[4])) ){
           $exist_offers[4] = new struct_cat_special();
           $exist_offers[4]->cs_type = 4;
           $exist_offers[4]->cs_catid = $item->cat_id;
           $exist_offers[4]->insert();
       }elseif( (!$item->cat_special_sphit) and (isset($exist_offers[4])) ){
           $exist_offers[4]->remove();
       }
	}

	/**
	 * Assign some product_id with some tree_id
	 *
	 * @param integer $product_id
	 * @param integer $tree_id
	 * @return number of inserted rows
	 */
	function addProductToTree($product_id,$tree_id)
	{
		return $this->exec('INSERT INTO '.RAD.'cat_in_tree(`cit_cat_id`,`cit_tre_id`)VALUES('.(int)$product_id.','.(int)$tree_id.')');
	}

	/**
	 * Deletes product from tree
	 * if only $product_id - delete full product_id from tree, except deletes $product_id from only $tree_id
	 *
	 * @param int $product_id
	 * @param int $tree_id
	 * @return number of deleted records
	 */
	function deleteProductFromTree($product_id,$tree_id = NULL)
	{
		if($tree_id){
			return $this->exec('DELETE FROM '.RAD.'cat_in_tree where cit_cat_id='.(int)$product_id.' and cit_tre_id='.(int)$tree_id);
		}else{
			return $this->exec('DELETE FROM '.RAD.'cat_in_tree where cit_cat_id='.(int)$product_id);
		}
	}

	/**
	 * Deletes the product and all it entries and files from DB and FS
	 *
	 * @param integer $id
	 * @return number of deleted entries
	 */
	function deleteProductById($id='')
	{
		if((int)$id){
		    $itemCat = new struct_catalog(array('cat_id'=>$id));
		    $itemCat->load();
			rad_instances::get('model_system_image')->deleteItemsByCat($id);
			$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','product');
			$modelTags->deleteTagsInItem($id);
			$res = $this->query('DELETE FROM '.RAD.'cat_in_tree where cit_cat_id=?', array($id));
			$res += $this->query('DELETE FROM '.RAD.'cat_special where cs_catid=?', array($id));
			$res += $this->query('DELETE FROM '.RAD.'cat_val_values where vv_cat_id=?', array($id));
			$res += $this->query('DELETE FROM '.RAD.'cat_files where rcf_cat_id=?', array($id));
			//DELETE COMMENTS
			$itemsComments = rad_instances::get('model_resource_comments')
			                    ->setState('rcm_type', model_resource_comments::TYPE_PRODUCT)
			                    ->setState('item_id', $id)
			                    ->getItems();
			if(!empty($itemsComments)) {
			    foreach($itemsComments as $itemComment) {
			        $res += $itemComment->remove();
			    }
			}
			$res += $itemCat->remove();
			return $res;
		}
	}

	/**
	 * Deletes all item and assigned records with ir
	 * @param struct_catalog $item
	 * @return integer - count of deleted intems
	 */
	function deleteItem(struct_catalog $item)
	{
	    return $this->deleteProductById($item->cat_id);
	}

	/**
	 * Sets product with cat_id = $cat_id active or not, if $a eq 0 then not active, otherwise - active
	 *
	 * @param integer $cat_id
	 * @param integer(boolean) $a
	 * @return integer(boolean)
	 */
	function setActive($cat_id,$a)
	{
	    $a = ($a)?1:0;
	    $cat_id = (int)$cat_id;
	    if($cat_id){
	        return $this->exec('UPDATE '.RAD.'catalog set cat_active='.(int)$a.' WHERE cat_id='.(int)$cat_id);
	    }else{
	        $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName() );
	        return NULL;
	    }
	}

	/**
	 * Gets the catalog entries in tree
	 *
	 * @param int $cat_id
	 * @return struct_catin_tre
	 */
	function getCatalogTreeEntries($cat_id)
	{
		$rows = $this->queryAll('SELECT * FROM '.RAD.'cat_in_tree where cit_cat_id=?', array($cat_id));
		$return = NULL;
		if(count($rows))
            foreach($rows as $id)
                $return[] = new struct_cat_in_tree($id);
	    return $return;
	}

	function getMinMaxPrices()
	{
	    if(!$this->getStates('currency')) {
	        throw new rad_exception('Not enouph actual parameters "currency" for getting minimal man maximum prices!');
	    }
	    $q = $this->_getListQuery();
	    $qb = new rad_query();
	    $qb->select('MIN(price) as minprice, MAX(price) AS maxprice')
	       ->from('('.$q->toString().')tbl');
	    return $this->query($qb->toString(), $q->getValues());
	}

	/**
	 * Assign download files to product
	 *
	 * @param struct_catalog $item
	 */
	function assignDownloadFiles(struct_catalog &$item)
	{
		if($item and $item->cat_id) {
			$res = $this->queryAll('SELECT * FROM '.RAD.'cat_files WHERE rcf_cat_id=?', array($item->cat_id));
			if(!empty($res)) {
				foreach($res as $id) {
					$item->download_files[] = new struct_cat_files($id);
				}
			}
		}
	}

    function assignComments(struct_catalog $item)
    {
        if($item and $item->cat_id) {
            $res = $this->queryAll('SELECT t.* FROM '.RAD.'comments c WHERE rcm_type=\'product\' AND rcm_item_id=?', array($item->cat_id));
			if(!empty($res)) {
				foreach($res as $id) {
					$item->comments[] = new struct_comments($id);
                }
            }
        }
    }

    /**
	 * Assign tags to product
	 *
	 * @return integer
	 */
    function getTagCount()
    {
        $sql = "SELECT count(*) FROM ".RAD."tags";
        $result = $this->query($sql);
        if(count($result)) {
		    return $result['count(*)'];
        }
		return null;
    }

}