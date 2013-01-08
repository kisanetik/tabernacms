<?php
class model_system_includes extends rad_model
{
    function getItem($id)
    {
        $id = ($id)?$id:$this->getState('id');
        if(!$id){
            $this->badRequest();
        }else{
            $table = new model_system_table(RAD.'includes_in_aliases');
            if($this->getState('lang_id')){
                $table->setState('lnv_id',$id);
            }
            return $table->getItem($id);
        }
    }
    
    function getItems($limit = NULL)
    {
        $table = new model_system_table(RAD.'includes');
        $table->setState('left join', RAD.'modules m on m.m_id = id_module');
        return $table->getItems( $limit );
    }
    
    function insertItem(struct_includes_in_aliases $struct)
    {
        if( ($struct->alias_id>0) and ($struct->include_id>0) and($struct->position_id>0) and ( is_numeric($struct->order_sort) ) ){
            return $this->insert_struct($struct, RAD.'includes_in_aliases');
        }else{
            $this->badRequest(__LINE__);
        }
    }
    
    /**
     * Delete include in alias by it ID
     *
     * @param struct_includes_in_aliases $struct
     * 
     * @return integer number of deleted records
     */
    function deleteItem(struct_includes_in_aliases $struct)
    {
        return $this->delete_struct($struct, RAD.'includes_in_aliases');
    }
    
    function updateItem(struct_includes_in_aliases $struct)
    {
        return $this->update_struct($struct, RAD.'includes_in_aliases');
    }
    
    /**
     * Deletes the includes by it ID
     *
     * @param array $ids
     * 
     * @return count deleted rows
     */
    function deleteRows($ids = array())
    {
        //print_r($ids);
        //die('DELETE FROM '.RAD.'includes_in_aliases WHERE `id` IN('.implode(',',$ids).')');
        return $this->exec('DELETE FROM '.RAD.'includes_in_aliases WHERE `id` IN('.implode(',',$ids).')');
    }
    
    function badRequest($code='0')
    {
        die('BAD REQUEST!!! in file: '.__FILE__.' line: '.__LINE__.' code='.$code);
    }
}//class
?>