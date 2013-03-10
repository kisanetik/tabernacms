<?php
/**
 * Managing settings in system
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_system_settings extends rad_model
{
    function getItem($id=NULL)
    {
        $id = $id or $this->getState('id');
        if($id)
            return new struct_settings( $this->query('SELECT * FROM '.RAD.'settings WHERE recordid='.(int)$id) );
        else
            return NULL;
    }
    
    function getItems()
    {
    	$q = $this->_getListQuery($this->getStates());
        $result = array();
        foreach( $this->queryAll( $q->toString() ) as $key){
            $result[] = new struct_settings($key);
        }
        return $result;
    }
    
    function _getListQuery( $options, $fk=array())
    {
    	$qb = new rad_query();

        if(isset($options['from'])){
            $qb->from($options['from']);
        }else{
            $qb->from(RAD.'settings a');
        }
        if(isset($options['select'])){
            $qb->select($options['select']);
        }else{
            if(count($fk)){
                //if need to join some...
            }else{
                $qb->select('a.*');
            }
        }
    	if( isset($options['id']) ){
            $qb->where('a.recordid='.(int)$options['id']);
        }
    	if(isset($options['order by'])){
        	$qb->order($options['order by']);
        }else{
            $qb->order('position,fldName');
        }
        if(isset($options['name'])){
        	$qb->where('a.fldName="'.$options['name'].'"');
        }
        if(isset($options['name.like'])){
        	$qb->where('a.fldName LIKE "'.$options['name.like'].'"');
        }
        
        return $qb;
    }
    
    public function updateItem(struct_settings $struct)
    {
        return $this->update_struct($struct, RAD.'settings');
    }
    
    function updateItems($array=NULL)
    {
        $return = 0;
        if(count($array)) {
            foreach($array as $id) {
                $return .= $this->updateItem( $id, RAD.'settings' );
            }
        }
        return $return;
    }
    
    function updateItemsByfldName($params=NULL, $type='system')
    {
        $return = 0;
        if(count($params)) {
            foreach($params as $pName => $pValue) {
                $this->setState('name', $pName);
                $items = $this->getItems();
                if(count($items)) {
                    $return += $this->deleteItems($items);
                }
                $item = new struct_settings();
                $item->fldName = $pName;
                $item->fldValue = $pValue;
                $item->rtype = $type;
                $return += $this->insertItem($item);
                unset($item);
            }
        }
        return $return;
    }    
    
    function insertItem(struct_settings $struct)
    {
        return $this->insert_struct( $struct, RAD.'settings' );
    }
    
    function insertItems($array = NULL)
    {
        $return = 0;
        if( count( $array ) )
            foreach( $array as $id ){
                $return .= $this->insert_struct( $id, RAD.'settings' );
            }
        return $return;
    }
    
    function deleteItem(struct_settings $struct=NULL)
    {
        if($struct->getPrimaryKey())
            return $this->delete_struct( $struct, RAD.'settings' );
        else
            return 0;
    }
    
    function deleteItems($array = NULL)
    {
        $return = 0;
        if( count( $array ) )
            foreach( $array as $id ){
                $return .= $this->deleteItem( $id, RAD.'settings' );
            }
        return $return;
    }
}