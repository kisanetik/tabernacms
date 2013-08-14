<?php
/**
 * Catalog types
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class model_corecatalog_types extends rad_model
{
    function getItem($id=NULL)
    {
         if($id)
            $this->setState('vl_id',$id);
         $q = $this->getListQuery( $this->getStates() );
         return new struct_corecatalog_cat_val_names( $this->query( $q->toString().' LIMIT 1', $q->getValues() ) );
    }

    /**
     * Gets the fields
     *
     * @param Boolean $joinMeasurement - need to join measurement table?
     * @return array of struct_corecatalog_cat_val_names
     */
    function getItems($joinMeasurement=false,$ct_showing=false, $node_id=0, $pid_types=0)
    {
        $fk['measurement'] = $joinMeasurement;
        $fk['ct_showing'] = $ct_showing;
        $node_id = ($node_id) ? $node_id : ($this->getState('node_id')) ? $this->getState('node_id') : ($this->getState('vl_tre_id')) ? $this->getState('vl_tre_id') : ( ($this->getState('tre_id')) ? $this->getState('tre_id') : 0 );
        $pid_types = ($pid_types) ? $pid_types : ($this->getState('pid_types',0)) ? $this->getState('pid_types') : 0;
        $result = array();
        if(!$this->getState('without_parents') and $node_id > 0  and $pid_types > 0) {
            $modelTree = rad_instances::get('model_coremenus_tree');
            $currTree = $modelTree->getItem($node_id);
            $treeToRoot = $modelTree->getCategoryPath($currTree, $pid_types, 0);
            $ids = array();
            foreach($treeToRoot as $ttr) {
                if($ttr->tre_id == $pid_types) {
                    continue;
                } else {
                    $ids[] = (int)$ttr->tre_id;
                }
            }
            $ids[] = $node_id;
            $this->setState('vl_tre_id', $ids);
        }
        $q = $this->getListQuery($this->getStates(),$fk);
        if($this->getState('showSQL')) {
            print_h($q->getValues());
            die($q->toString());
        }
        if($this->getState('return.array')) {
            return $this->queryAll( $q->toString(), $q->getValues() );
        }
        foreach( $this->queryAll( $q->toString(), $q->getValues() ) as $key) {
            $result[] = new struct_corecatalog_cat_val_names($key);
            if($joinMeasurement) {
                $result[count($result)-1]->ms_value = new struct_corecatalog_measurement($key);
            }
        }
        //Join the rad_cat_val_values
        if((int)$this->getState('cat_id')) {
            $values = $this->getValValues((int)$this->getState('cat_id'));
            if(count($values)) {
                foreach($values as $id){
                    for($i=0;$i<count($result);$i++) {
                        if($result[$i]->vl_id==$id->vv_name_id) {
                            $result[$i]->vv_values[] = $id;
                        }
                    }//for $i
                }//foreach
            }
        }//if cat_id
        return $result;
    }

    function insertItem(struct_corecatalog_cat_val_names $item)
    {
        return $this->insert_struct($item,RAD.'cat_val_names');
    }

    function deleteItem(struct_corecatalog_cat_val_names $item)
    {
        return $this->deleteItemById($item->vl_id);
    }

    function updateItem(struct_corecatalog_cat_val_names $item)
    {
        return $this->update_struct($item,RAD.'cat_val_names');
    }

    /**
     * Deletes item by it ID in DB
     *
     * @param integer $id
     * @return integer count of deleted rows
     */
    function deleteItemById($id)
    {
        $id = (int)$id;
        $rows = $this->query('DELETE FROM '.RAD.'cat_val_names WHERE vl_id=?', array($id))->rowCount();
        $rows += $this->query('DELETE FROM '.RAD.'cat_val_values WHERE vv_name_id=?', array($id))->rowCount();
        return $rows;
    }
    
    /**
     * Deletes items by tree id(s) in DB
     *
     * @param integer $id or Array
     * @return integer count of deleted rows
     */    
    
    function deleteItemsByTreeId($id)
    {
        if(is_array($id)) {
            $ids = array();
            foreach($id as $key=>$value) {
                $ids[] = (int)$value;
            }
            $this->setState('vl_tre_id', $ids);
            $this->setState('without_parents', true);
            $types = $this->getItems();
            $typeIds = array();
            foreach($types as $type) {
                $typeIds[] = $type->vl_id;
            }
            return $this->exec('DELETE FROM `'.RAD.'cat_val_names` where `vl_id` IN ('.implode(',', $typeIds).')');
        } elseif((int)($id)) {
            return $this->exec('DELETE FROM `'.RAD.'cat_val_names` where `vl_id`="'.(int)$id.'"');
        }
    }
    
    /**
     * List query
     *
     * @param array $fields
     * @param array $fk
     * @return rad_query
     */
    function getListQuery($fields, $fk=array())
    {
        $qb = new rad_query();

        if(isset($fields['select'])) {
            $qb->select($fields['select']);
        } else {
            $qb->select('*');
        }
        if( isset( $fields['vl_id'] ) ) {
            $qb->where('vl_id=:vl_id')->value( array('vl_id'=>(int)$fields['vl_id']) );
        }
        if( ( isset( $fields['pid']) ) or ( isset( $fields['vl_tre_id'] ) ) or( isset( $fields['tre_id'] ) ) ) {
            $val = ( isset( $fields['pid']) )?$fields['pid']:(isset($fields['vl_tre_id']))?$fields['vl_tre_id']:$fields['tre_id'];
            if(is_array($val)) {
                $treeIds = '';
                //Do NOT use IMPLODE HERE!!! For safe method use foreach and (int)
                foreach($val as $key=>$value) {
                    $treeIds .= (int)$value.',';
                }
                $treeIds = substr($treeIds, 0, -1);
                $qb->where('vl_tre_id IN ('.$treeIds.')');
            } else {
                $qb->where('vl_tre_id=:vl_tre_id')->value( array('vl_tre_id'=>(int)$val) );
            }
        }
        if( isset( $fields['vl_name'] ) or isset( $fields['name'] ) ) {
            $val = isset( $fields['vl_name'] )?$fields['vl_name']:$fields['name'];
            $qb->where('vl_name=:vl_name')->value( array('vl_name'=>$val) );
        }
        if( isset( $fields['vl_type_in'] ) or isset( $fields['type_in'] ) ) {
            $val = (isset($fields['vl_type_in']))?$fields['vl_type_in']:$fields['type_in'];
            $qb->where('vl_type_in=:vl_type_in')->value( array('vl_type_in'=>$val) );
        }
        if( isset( $fields['vl_type_print'] ) or isset( $fields['type_print'] ) ) {
            $val = (isset($fields['vl_type_print']))?$fields['vl_type_print']:$fields['type_print'];
            $qb->where('vl_type_print=:vl_type_print')->value( array('vl_type_print'=>$val) );
        }
        if( isset( $fields['vl_measurement_id'] ) or isset( $fields['measurement_id'] ) ) {
            $val = (isset($fields['vl_measurement_id']))?$fields['vl_measurement_id']:$fields['measurement_id'];
            $qb->where('vl_measurement_id=:vl_measurement_id')->value( array('vl_measurement_id'=>$val) );
        }
        if( isset( $fields['active'] ) or isset( $fields['vl_active'] ) ) {
            $val = isset( $fields['active'] )?$fields['active']:$fields['vl_active'];
            $qb->where('vl_active=:vl_active')->value( array('vl_active'=>$val) );
        }
        if( isset( $fk['measurement'] ) ) {
            $qb->join('LEFT',RAD.'measurement as m on m.ms_id=a.vl_measurement_id');
        }
        if( isset( $fk['ct_showing'] ) and isset( $fields['cts_show'] ) ) {
            $val =(isset($fk['ct_showing']))?$fk['ct_showing']:$fields['cts_show'];
            $qb->join('LEFT', RAD.'ct_showing as cts on cts.cts_vl_id=a.vl_id WHERE cts_show=:cts_show')->value( array('cts_show'=>$val) );
        }
        if( !empty($fields['filter']) ) {
            $qb->where('vl_filter=1');
            $qb->join('RIGHT', RAD.'cat_val_values ON vv_name_id=vl_id');
            if(!empty($fields['cat_id'])) {
                if(is_array($fields['cat_id'])) {
                    $catIds = array();
                    foreach($fields['cat_id'] as $idN=>$idV) {
                        $catIds[] = (int)$idV;
                    }
                    $qb->where('vv_cat_id IN ('.implode(',', $catIds).')');
                } else {
                    $qb->where('vv_cat_id=:cat_id')->value( array('cat_id'=>$fields['cat_id']) );
                }
            }
        }
        if( isset( $fields['order']) ) {
            $qb->order( $fields['order'] );
        } else {
            $qb->order('a.vl_position');
        }
        if( !empty($fields['group by']) ) {
            $qb->group($fields['group by']);
        }

        $qb->from(RAD.'cat_val_names a');

        return $qb;
    }

    public static function autoloadPlugins($classname)
    {
        if(strstr($classname,'CAT_EXT_')) {
            if(!class_exists($classname,false)) {
                if(strstr($classname,'CAT_EXT_IN_')) {
                    include_once(__DIR__.DS.'ext_types'.DS.'input'.DS.'class.'.$classname.'.php');
                    if(!class_exists($classname)) {
                        throw new model_corecatalog_types_exception('The file "'.__DIR__.DS.'ext_types'.DS.'input'.DS.'class.'.$classname.'.php'.'" don\'t contain class "'.$classname.'"!',__LINE__);
                    }
                    return ;
                } elseif(strstr($classname,'CAT_EXT_OUT_')) {
                    include_once(__DIR__.DS.'ext_types'.DS.'output'.DS.'class.'.$classname.'.php');
                    if(!class_exists($classname)) {
                        throw new model_corecatalog_types_exception('The file "'.__DIR__.DS.'ext_types'.DS.'outut'.DS.'class.'.$classname.'.php'.'" don\'t contain class "'.$classname.'"!',__LINE__);
                    }
                    return ;
                } else {
                    throw new model_corecatalog_types_exception('Can\'t found class "'.$classname.'" in extensions for catalog!',__LINE__);
                }
            }else{
                //die('class '.$classname.' is exists!');
            }
        }
        return ;
    }

    /**
     * Gets the input fields types from ext
     *
     * @return array mixed
     */
    function getInputTypes($subfolder='input')
    {
        $d = dir(__DIR__.DS.'ext_types'.DS.$subfolder.DS);
        $types = array();
        while( false !== ( $filename = $d->read() ) ) {
            if( ($filename!='.') and ($filename!='..') and ( !is_dir($filename) ) ) {
                $types[] = str_replace('class.','',str_replace('.php','',$filename));
            }
        }//while
        return $types;
    }

    /**
     * Insert cat_val_values item
     *
     * @param struct_corecatalog_cat_val_values $item
     * @return integer - count of inserted items, as usually need to be 1, otherwise some mirracle :-P
     */
    function insertTypeValues(struct_corecatalog_cat_val_values $item)
    {
        return $this->insert_struct($item,RAD.'cat_val_values');
    }

    /**
     * Update one val_value item
     * @param struct_corecatalog_cat_val_values $item
     * @return integer number of updated items (usualy without errors 1)
     */
    function updateTypeValue(struct_corecatalog_cat_val_values $item)
    {
        return $this->update_struct($item,RAD.'cat_val_values');
    }

    /* Delete one val_value item
     * @param struct_corecatalog_cat_val_values $item
     * @return integer number of delete items (usualy without errors 1)
     */
    function deleteTypeValue(struct_corecatalog_cat_val_values $item)
    {
        return $this->delete_struct($item, RAD.'cat_val_values');
    }
    
    /* Delete one val_value item
     * @param struct_corecatalog_cat_val_values $item
    * @return integer number of delete items (usualy without errors 1)
    */
    function deleteTypeValuesByCatId($cat_id=0)
    {
        if($cat_id > 0) {
            $rows = $this->exec('DELETE FROM '.RAD.'cat_val_values WHERE vv_cat_id='.(int)$cat_id );
            return $rows;
        }
    }

    /**
     * Gets the output fields types from ext
     *
     * @return array mixed
     */
    function getOutputTypes()
    {
        return $this->getInputTypes('output');
    }

    /**
     * Gets the values of val_names where product_id = cat_id
     * @param integer $cat_id
     * @return struct_corecatalog_cat_val_values array
     */
    function getValValues($cat_id)
    {
        $res = $this->queryAll('SELECT * FROM '.RAD.'cat_val_values WHERE vv_cat_id=?', array((int)$cat_id));
        $result = array();
        if(count($res)) {
            foreach($res as $id) {
                $result[] = new struct_corecatalog_cat_val_values($id);
            }//foreach
        }//if count
        return $result;
    }
}

class model_corecatalog_types_exception extends rad_exception
{
    function __construct($message, $line, Exception $previous = null)
    {
        parent::__construct("{$message}( FILE: ".__FILE__.", LINE: {$line}", $line, $previous);
    }
}