<?php
/**
 * Votes model
 * @author Yackushev Denys
 * @package RADCMS
 */
class model_others_votes extends rad_model
{
    function getItem($id=null)
    {
        $id=($id)?$id:$this->getState('id',$this->getState('vt_id'));
        if($id){
            $return = new struct_votes($this->query('SELECT * FROM '.RAD.'votes where vt_id='.$id));
            return $return;
        }else{
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function getItems($limit = null)
    {
        $q = $this->_getListQuery( $this->getStates() );
        $limit = ($limit)?' LIMIT '.$limit:'';
        $result = array();
        $ids = array();
        //die($q->toString().$limit);
        foreach( $this->queryAll( $q->toString().$limit ) as $key){
            $result[] = new struct_votes($key);
            $ids[] = $key['vt_id'];
        }
        if( $this->getState('with_questions') and count($ids) ){
            $answers = '';
            if($this->getState('with_answers')){
                $sql = 'SELECT q.*, count(a.vta_id) as cnt_ans FROM '.RAD.'votes_questions q LEFT JOIN '.RAD.'votes_answers as a on vta_vtid=vtq_vtid and vtq_id=vta_vtqid WHERE vtq_vtid IN('.implode(',',$ids).') GROUP BY vtq_id ORDER BY vtq_position, vtq_name';
            }else{
                $sql = 'SELECT * FROM '.RAD.'votes_questions WHERE vtq_vtid IN('.implode(',',$ids).') ORDER BY vtq_position, vtq_name';
            }
            foreach( $this->queryAll($sql) as $vtq){
                for($i=0;$i<count($result);$i++){
                    if($result[$i]->vt_id==$vtq['vtq_vtid']){
                        $result[$i]->vt_answers[] = new struct_votes_questions($vtq);
                        break;
                    }
                }//for
            }//foreach
        }//with questions
        return $result;
    }

    private function _getListQuery($options,$fk=array())
    {
        $qb = new rad_query();

        if(isset($options['from'])){
            $qb->from($options['from']);
        }else{
            $qb->from(RAD.'votes a');
        }
        if(isset($options['select'])){
            $qb->select($options['select']);
        }else{
            $qb->select('a.*');
        }
        if(isset($options['order by'])){
            $qb->order($options['order by']);
        }else{
            $qb->order('a.vt_position');
        }
        if(isset($options['pid'])){
            $val = $options['pid'];
            if(is_array($val)) {
                $treeIds = '';
                //Do NOT use IMPLODE HERE!!! For safe method use foreach and (int)
                foreach($val as $key=>$value) {
                    $treeIds .= (int)$value.',';
                }
                $treeIds = substr($treeIds, 0, -1);
                $qb->where('a.vt_treid IN ('.$treeIds.')');
            } else {
                $qb->where('a.vt_treid='.(int)$val);
            }
        }
        if(isset($options['vt_id'])){
            $qb->where('a.vt_id='.(int)$options['vt_id']);
        }
        if(isset($options['lang'])){
            $qb->where('a.vt_lngid='.(int)$options['lang']);
        }
        if(isset($options['!vta_hash'])){
            $qb->join('LEFT',RAD.'votes_answers va on vta_vtid=vt_id and va.vta_hash="'.$options['!vta_hash'].'"');
            $qb->where('ISNULL(vta_id)');
        }
        if(isset($options['where']))
            $qb->where($options['where']);
        return $qb;
    }

    function getQuestions($limit = NULL)
    {
        $item_id = (int)$this->getState('item_id',$this->getState('vt_id'));
        if($item_id){
            $table = new model_system_table(RAD.'votes_questions');
            $table->setState('where','vtq_vtid='.$item_id);
            return $table->getItems($limit);
        }else{
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }


    /**
     * Insert one row
     * @param struct_votes $item
     */
    function insertItem(struct_votes $item)
    {
        return $this->insert_struct($item,RAD.'votes');
    }

    /**
     * update one row
     * @param struct_votes $item
     */
    function updateItem(struct_votes $item)
    {
        return $this->update_struct($item,RAD.'votes');
    }

    /**
     * Delete one row
     * @param struct_votes $item
     */
    function deleteItem(struct_votes $item)
    {
        $this->query('DELETE FROM '.RAD.'votes_questions WHERE vtq_vtid='.$item->vt_id);
        $this->query('DELETE FROM '.RAD.'votes_answers WHERE vta_vtid='.$item->vt_id);
        return $this->delete_struct($item, RAD.'votes');
    }

    /**
     * Deletes items by tree id(s) in DB
     *
     * @param integer $id or Array
     * @return integer count of deleted rows
     */
    
    function deleteItemsByTreeId($id)
    {
        $rows = 0;
        if(is_array($id)) {
            $ids = array();
            foreach($id as $key=>$value) {
                $ids[] = (int)$value;
            }
            $this->setState('pid', $ids);
            $questions = $this->getItems();
            $questionIds = array();
            foreach($questions as $question) {
                $questionIds[] = $question->vt_id;
            }
            $rows += $this->exec('DELETE FROM '.RAD.'votes_questions WHERE vtq_vtid IN ('.implode(',', $questionIds).')');
            $rows += $this->exec('DELETE FROM '.RAD.'votes_answers WHERE vta_vtid IN ('.implode(',', $questionIds).')');
            $rows += $this->exec('DELETE FROM '.RAD.'votes WHERE vt_id IN ('.implode(',', $questionIds).')');
        } elseif((int)($id)) {
            $rows += $this->exec('DELETE FROM '.RAD.'votes_questions WHERE vtq_vtid='.(int)$id);
            $rows += $this->exec('DELETE FROM '.RAD.'votes_answers WHERE vta_vtid='.(int)$id);
            $rows += $this->exec('DELETE FROM '.RAD.'votes WHERE vt_id='.(int)$id);            
        }
        return $rows;
    }    
    
    function setActive($item_id,$v)
    {
        return $this->exec('UPDATE '.RAD.'votes set vt_active='.$v.' where vt_id='.(int)$item_id);
    }
}//class