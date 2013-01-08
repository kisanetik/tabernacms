<?php
/**
 * Simple access to tables
 * @author Yackushev Denys
 * @package RADCMS
 */
class model_system_table extends rad_model
{
    private $_tablename = NULL;
    private $_struct_name = NULL;

    /**
     * Constructor
     *
     * @param string $tablename - name of the table
     */
    function __construct($tablename)
    {
        $this->_tablename = $tablename;
        $this->_struct_name = 'struct_'.str_replace(RAD,'',$this->_tablename);
    }

    /**
     * gets current instance
     * @return model_system_table
     */
    public static function getInstance($tablename)
    {
        return new model_system_table($tablename);
    }

    function getItem($id = NULL)
    {
        $struct_name = $this->_struct_name;
        $tmp_struct = new $struct_name();
        $id = ($id)?$id:$this->getState($tmp_struct->getPrimaryKey(),NULL);
        if($id){
            $this->setState($tmp_struct->getPrimaryKey(),$id);
            $q = $this->getListQuery( $this->getStates() );
            if($this->getState('dieSQL'))
                die($q->toString());
            $result = $this->query($q->toString().' LIMIT 1', $q->getValues());
            return new $this->_struct_name($result);
        }else{
            $q = $this->getListQuery( $this->getStates() );
            if($this->getState('dieSQL'))
                die($q->toString());
            $struct_name = $this->_struct_name;
            if($this->getState('select')=='count(*)'){
                $res = $this->query( $q->toString(), $q->getValues() );
                if(count($res))
                    return $res['count(*)'];
                return 0;
            }elseif( $this->getState('return')=='mass' ){
                return $this->query( $q->toString(), $q->getValues() );
            }else{
                return new $struct_name( $this->query( $q->toString(), $q->getValues() ) );
            }
        }
    }

    /**
     * Get the items by filters
     *
     * @param $limit
     *
     * return array of objects
     *
     */
    function getItems($limit=NULL)
    {
        $q = $this->getListQuery( $this->getStates() );
        $result = array();
        $limit = ($limit)?' LIMIT '.$limit:'';
        $struct_name = $this->_struct_name;
        if($this->getState('return')=='mass'){
            return $this->queryAll( $q->toString().$limit, $q->getValues() );
        }elseif($this->getState('select')=='count(*)'){
            $result = $this->query($q->toString(), $q->getValues());
            if(count($result))
                return (int)$result['count(*)'];
            else
                return 0;
        }else{
            foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key){
                $result[] = new $struct_name($key);
            }
        }
        return $result;
    }

    /**
     * @return rad_query
     */
    protected function getListQuery($fields)
    {

        $qb = new rad_query;

        if(isset($fields['from'])){
            $qb->from( $fields['from'] );
        }else{
            $qb->from($this->_tablename);
        }
        $struct = $this->_struct_name;
        $struct = new $struct();

        foreach($struct->getKeys('',true) as $id=>$field){
            if( isset( $fields[ $field ] ) )
                $qb->where($field.'=:'.$field)->value( array($field=>$fields[ $field ]) );
        }//foreach
        unset($struct);

        if( isset( $fields['select'] ) ) {
            $qb->select( $fields['select'] );
        } else {
            $qb->select( '*' );
        }
        if( isset( $fields['where'] ) )
            $qb->where( $fields['where'] );
        if( isset( $fields['order by'] ) )
            $qb->order( $fields['order by'] );
        if( isset( $fields['having'] ) )
            $qb->having( $fields['having'] );
        if( isset( $fields['group by'] ) )
            $qb->group($fields['group by']);
        if( isset( $fields['left join'] ) )
            $qb->join('LEFT', $fields['left join'] );
        if( isset( $fields['inner join'] ) )
            $qb->join('INNER', $fields['inner join']);
        if( isset($fields['order']) )
        	$qb->order($fields['order']);
        $struct_name = $this->_struct_name;
        $tmp_struct = new $struct_name();
        if( isset($fields[$tmp_struct->getPrimaryKey()]) ){
        	$pk = $tmp_struct->getPrimaryKey();
        	$qb->where($pk.'='.(int)$fields[$pk]);
        }
        return $qb;
    }

    /**
     * Inserts the struct into table
     *
     * @param rad_struct $item
     * @return integer number of inserted rows
     */
    function insertItem(rad_struct $item)
    {
        return $this->insert_struct($item, $this->_tablename);
    }

    /**
     * Delete the struct from table
     *
     * @param rad_struct $item
     * @return integer number of deleted rows
     */
    function deleteItem(rad_struct $item)
    {
        return $this->delete_struct($item, $this->_tablename);
    }

    /**
     * Alias for deleteItem
     *
     * @param rad_struct $item
     */
    function removeItem(rad_struct $item)
    {
        return $this->deleteItem($item);
    }

    /**
     * Update the struct from table
     *
     * @param rad_struct $item
     * @return integer number of updated rows (for normal eq 1)
     */
    function updateItem(rad_struct $item)
    {
        return $this->update_struct( $item, $this->_tablename );
    }

    /**
     * Search text items from table. Use only varchar and text fields
     * @param string $sw - SearchWord
     * @return rad_struct mixed rray
     */
    function searchTextItems($sw)
    {
        $columns = $this->queryAll('SHOW COLUMNS FROM '.$this->_tablename);
        $result = null;
        if(count($columns)){
            $ex_modules = array();
            foreach($columns as $col){
                if( ($col['Field']!='u_pass') and (substr( $col['Type'],0,4 )=='text' or substr( $col['Type'],0,7 )=='varchar') ){
                    $ex_modules[] = ' '.$col['Field'].' LIKE "%'.$this->escapeString($sw).'%" ';
                }
            }//foreach
            if(count($ex_modules)){
                $select = $this->getState('select','*');
                $sql = 'SELECT '.$select.' FROM '.$this->_tablename.' WHERE ('.implode(' OR ',$ex_modules ).')'.$this->getState('addsql','');
                //echo $sql;
                if($select=='count(*)'){
                    $res = $this->query($sql);
                    if(count($res) and isset($res['count(*)'])){
                        return (int)$res['count(*)'];
                    }else{
                        return null;
                    }
                }else{
                    $struct_name = $this->_struct_name;
                    foreach( $this->queryAll( $sql ) as $key ){
                        $result[] = new $struct_name($key);
                    }
                }
            }
        }//if
        //print_r($result);
        return $result;
    }

    function deleteWhere($where)
    {
        return $this->exec('DELETE FROM '.$this->_tablename.' WHERE '.$where);
    }
}