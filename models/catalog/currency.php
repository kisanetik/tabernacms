<?php
/**
 * Currency model
 * @author Denys Yackushev
 * @package Taberna
 */
class model_catalog_currency extends rad_model
{
	function getItem($id=NULL)
	{
		if($id) {
            $this->setState('cur_id',$id);
		}
        $q = $this->_getListQuery( $this->getStates() );
        return new struct_currency( $this->query( $q->toString().' LIMIT 1' ) );
	}

	function getItems()
	{
		$q = $this->_getListQuery($this->getStates());
	    $result = array();
        foreach( $this->queryAll( $q->toString() ) as $key) {
            $result[] = new struct_currency($key);
        }
        return $result;
	}

    function insertItem(struct_currency $item)
    {
    	$this->insert_struct($item,RAD.'currency');
    	$lastid = $this->inserted_id();
    	return $lastid;
    }

    function deleteItem(struct_currency $item)
    {
        return $this->delete_struct($item, RAD.'currency');;
    }

    function updateItem(struct_currency $item)
    {
        return $this->update_struct($item, RAD.'currency');
    }

	private function _getListQuery($fields)
	{
		$qb = new rad_query();

        if(isset($fields['select'])) {
            $qb->select($fields['select']);
        } else {
            $qb->select('*');
        }
        if(isset($fields['where'])) {
            $qb->where($fields['where']);
        }
        if(isset($fields['cur_id']) or isset($fields['id'])) {
            $val = (isset($fields['cur_id']))?$fields['cur_id']:$fields['id'];
            $qb->where('cur_id="'.(int)$this->escapeString($val).'"');
        }
	    if(isset($fields['order by'])) {
            $qb->order($fields['order by']);
	    }

        $qb->from(RAD.'currency');

        return $qb;
	}
}