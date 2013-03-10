<?php
/**
 * manage lang records
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_system_lang extends rad_model
{
    private $_langCache = NULL;

    function getItems()
    {
        if(!$this->_langCache or true){
            $table = new model_system_table(RAD.'lang');
            $table->setState('order by','lng_position,lng_name');
            if($this->getState('where'))
                $table->setState('where',$this->getState('where'));
            $this->_langCache = $table->getItems();
        }
        return $this->_langCache;
    }

    function getItem($id=NULL)
    {
        $id = ($id)?$id:$this->getState('id',$this->getState('lng_id',NULL));
        if($id){
            $table = new model_system_table(RAD.'lang');
            return $table->getItem($id);
        }else{
            $this->badRequest(__LINE__);
        }
    }

    function insertItem(struct_lang $struct)
    {
        return $this->insert_struct($struct, RAD.'lang');
    }

    function insertItems($array = array())
    {
        $cnt = 0;
        if( count( $array ) ){
            foreach($array as $id){
                $this->insertItem($id);
            }
        }
        return $cnt;
    }

    function updateItem(struct_lang $struct)
    {
        return $this->update_struct($struct, RAD.'lang');
    }

    function updateItems( $array = array() )
    {
        $cnt = 0;
        if( count( $array ) ){
            foreach($array as $id){
                $this->updateItem($id);
            }
        }
        return $cnt;
    }

    function deleteItem(struct_lang $struct)
    {
        return $this->delete_struct($struct, RAD.'lang');
    }

    function deleteRow($id)
    {
        return $this->exec('DELETE FROM '.RAD.'lang WHERE lng_id='.(int)$id);
    }

    function deleteItems($array=array())
    {
        $cnt = 0;
        if( count( $array ) ){
            foreach($array as $id){
                $this->deleteItem($id);
            }
        }
        return $cnt;
    }

    /**
     * Get the last ID
     *
     * @return integer
     */
    function getLastID()
    {
        $res = $this->query('SELECT MAX(lng_id) FROM '.RAD.'lang LIMIT 1');
        return ((int)$res['MAX(lng_id)']+1);
    }

    function badRequest($line)
    {
        throw new rad_exception('Bad Request in class "'.$this->getClassName().'"',$line);
    }
}
?>