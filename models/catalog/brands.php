<?php
/**
 * Catalog brands
 * @author Artem Shevchenko, Denys Yackushev
 * @package Taberna
 */
class model_catalog_brands extends rad_model
{

	/**
	 * Gets one struct_cat_brands by it ID
	 * @param integer $id
	 */
	function getItem($id=NULL)
	{
		$id=($id)?$id:$this->getState('id', null);
		if($id) {
			return new struct_cat_brands( $this->query('SELECT * FROM '.RAD.'cat_brands where rcb_id=?',array($id)) );
		} else {
			if(count( $this->getStates() ) ) {
				$q = $this->_getListQuery( $this->getStates() );
				if($this->getState('select')=='count(*)'){
					$result = $this->query($q->toString().' LIMIT 1', $q->getValues());
					if(count($result)) {
						return $result['count(*)'];
					} else {
						return NULL;
					}
				}else{
					if(!$this->getState('select',false)) {
						return new struct_news( $this->query( $q->toString().' LIMIT 1', $q->getValues() ) );
					} else {
						return $this->query( $q->toString().' LIMIT 1', $q->getValues() );
					}
				}
			}else{
				$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
			}
		}
	}

	/**
	 * Gets the array of struct_cat_brands by states
	 * @return struct_cat_brands
	 */
	function getItems($limit=NULL)
	{
		$q = $this->_getListQuery( $this->getStates() );

		$limit = ($limit)?$limit:$this->getState('limit',$limit);
		$result = array();

		$limit = ($limit)?' LIMIT '.$limit:'';
		if($this->getState('showSQL')==true) {
		    echo $q->toString().$limit;
		}
		if($this->getState('select') != 'count(*)') {
			foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key) {
				$result[] = new struct_cat_brands($key);
			}
		} else {
			$result = $this->query($q->toString(), $q->getValues());
			if(count($result)) {
			    $result = $result['count(*)'];
			}
		}

		return $result;
	}

	/**
	 *
	 * @param array $options
	 * @return rad_query
	 */
	private function _getListQuery($options,$fk=array())
	{
		$qb = new rad_query();

		if(isset($options['from'])) {
			$qb->from($options['from']);
		} else {
			$qb->from(RAD.'cat_brands a');
		}
		if(isset($options['select'])) {
			$qb->select($options['select']);
		} else {
			if(count($fk)) {
				//if need to join some...
			} else {
				$qb->select('a.*');
			}
		}
		if(!empty($options['id']) and is_array($options['id'])) {
		    $rcbId = '';
		    //Do NOT use IMPLODE HERE!!! For safe method use foreach and (int)
		    foreach($options['id'] as $key=>$value) {
		        $rcbId .= (int)$value.',';
		    }
		    $rcbId = substr($rcbId, 0, -1);
		    $qb->where('a.rcb_id IN ('.$rcbId.')');
	    } elseif(isset($options['id']) || isset($options['rcb_id'])) {
			$tmp = (int)(isset($options['id']))?$options['id']:$options['rcb_id'];
			$qb->where('a.rcb_id=:rcb_id')->value(array('rcb_id'=>$tmp));
		}
		if(isset($options['order by'])) {
			$qb->order($options['order by']);
		} else {
			$qb->order('rcb_name ASC');
		}
		if(isset($options['active'])) {
		    $qb->where('a.rcb_active=:active')->value(array('active'=>(int)(bool)$options['active']));
		}

		if(isset($options['where'])) {
			$qb->where($options['where']);
		}
		//echo $qb->toString();
		return $qb;
	}

	/**
	 * Insert one row
	 */
	function insertItem(struct_cat_brands $item) 
	{
		//print_h ($item); die ('ddd');
		return $this->insert_struct($item,RAD.'cat_brands');
	}

	/**
	 * update one row
	 */
	function updateItem(struct_cat_brands $item)
	{
		return $this->update_struct($item,RAD.'cat_brands');
	}

	/**
	 * Delete one row
	 * @param struct_cat_brands $item
	 */
	function deleteItem(struct_cat_brands $item)
	{
		return $this->delete_struct($item, RAD.'cat_brands');
	}
	
    function getListBrands()
    {
        $q = "SELECT * FROM ".RAD."cat_brands ORDER BY rcb_name ASC";
        $r = $this->queryAll($q);
        if($r !== FALSE){
            return (object) $r;
        }else{
            return 0;
        }
    }

}
