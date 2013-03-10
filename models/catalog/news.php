<?php
/**
 * Catalog types
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_catalog_news extends rad_model
{
	
    /**
     * Gets one struct_news by it ID
     * @param integer $id
     */
    function getItem($id=NULL)
    {
        $id=($id)?$id:$this->getState('id', null);
        if($id){
            $return = new struct_news( $this->query('SELECT * FROM '.RAD.'news where nw_id=?',array($id)) );
            if($this->getState('with_tags')) {
            	$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','news');
            	$modelTags->asignTagsToItem($return);
            }
            return $return;
        }else{
            if(count( $this->getStates() ) ){
                $q = $this->_getListQuery( $this->getStates() );
                if($this->getState('select')=='count(*)'){
                    $result = $this->query($q->toString().' LIMIT 1', $q->getValues());
                    if(count($result)){
                        return $result['count(*)'];
                    }else{
                        return NULL;
                    }
                }else{
                    if(!$this->getState('select',false)){
                        return new struct_news( $this->query( $q->toString().' LIMIT 1', $q->getValues() ) );
                    }else{
                        return $this->query( $q->toString().' LIMIT 1', $q->getValues() );
                    }
                }
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        }
    }

    /**
     * Gets the array of struct_news by states
     * @return struct_news
     */
    function getItems($limit=NULL)
    {
        $q = $this->_getListQuery( $this->getStates() );
        $limit = ($limit)?$limit:$this->getState('limit',$limit);
        $result = array();
        $limit = ($limit)?' LIMIT '.$limit:'';
        if($this->getState('showSQL')==true)
            echo $q->toString().$limit;
        if($this->getState('select')!='count(*)'){
            foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key){
                $result[] = new struct_news($key);
            }
        }else{
            $result = $this->query($q->toString(), $q->getValues());
            if(count($result))
                $result = $result['count(*)'];
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

        if(isset($options['from'])){
            $qb->from($options['from']);
        }else{
            $qb->from(RAD.'news a');
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
        if(isset($options['id'])||isset($options['nw_id'])){
            $tmp = (int)(isset($options['id']))?$options['id']:$options['nw_id'];
            $qb->where('a.nw_id=:nw_id')->value(array('nw_id'=>$tmp));
        }
        if(isset($options['order by'])){
            $qb->order($options['order by']);
        }else{
            $qb->order('nw_datenews DESC,nw_dateupdated DESC,nw_title');
        }
        if(isset($options['lang'])){
            $qb->where('nw_langid=:nw_langid')->value(array('nw_langid'=>(int)$options['lang']));
        }
        if(isset($options['nw_datecreated'])){
            $qb->where('nw_datecreated=:nw_datecreated')->value( array('nw_datecreated'=>$options['nw_datecreated']) );
        }
        if(isset($options['nw_dateupdated'])){
            $qb->where('nw_dateupdated=:nw_dateupdated')->value( array('nw_dateupdated'=>$options['nw_dateupdated']) );
        }
        if(isset($options['nw_usercreated'])){
            $qb->where('nw_usercreated=:nw_usercreated')->value( array('nw_usercreated'=>(int)$options['nw_usercreated']) );
        }
        if(isset($options['nw_tre_id']) or isset($options['pid']) or isset($options['tre_id'])) {
            $val = (isset($options['pid'])) ? $options['pid'] : (isset($options['nw_tre_id'])) ? $options['nw_tre_id'] : $options['tre_id'];
            if(is_array($val)) {
                $treeIds = '';
                //Do NOT use IMPLODE HERE!!! For safe method use foreach and (int)
                foreach($val as $key=>$value) {
                    $treeIds .= (int)$value.',';
                }
                $treeIds = substr($treeIds, 0, -1);
                $qb->where('nw_tre_id IN ('.$treeIds.')');
            } else {            
                $qb->where('nw_tre_id=:nw_tre_id')->value(array('nw_tre_id' => (int)$val));
            }
        }
        if(isset($options['nw_active'])){
            $qb->where('nw_active=:nw_active')->value( array('nw_active'=>(int)$options['nw_active']) );
        }
        if(isset($options['nw_datenews'])){
            $qb->where('nw_datenews=:nw_datenews')->value( array('nw_datenews'=>$options['nw_datenews']) );
        }
        if(isset($options['subscribe'])){
            $qb->where('nw_subscribe=:nw_subscribe')->value( array('nw_subscribe'=>(int)$options['subscribe']) );
        }
        if(isset($options['userid'])){
            $qb->where('nw_usercreated = :nw_usercreated')->value( array('nw_usercreated'=>(int)$options['userid']) );
        }
        if(isset($options['where'])){
            $qb->where($options['where']);
        }
        //echo $qb->toString();
        return $qb;
    }

    /**
     * Insert one row
     */
    function insertItem(struct_news $item){
        if(isset($item->nw_ismain) and $item->nw_ismain and !isset($item->nw_langid)){
            $this->exec('update '.RAD.'news set nw_ismain=0');
        }elseif(isset($item->nw_ismain) and $item->nw_ismain and isset($item->nw_langid)){
            $this->exec('update '.RAD.'news set nw_ismain=0 where nw_langid='.(int)$item->nw_langid);
        }
        $result = $this->insert_struct($item,RAD.'news');
        $item->nw_id = $this->inserted_id();
        $result = $item->nw_id;
        //TAGS
        $modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','news');
        $modelTags->insertTagsToItem($item);
        return $result;
    }

    /**
     * update one row
     */
    function updateItem(struct_news $item){
        if(isset($item->nw_ismain) and $item->nw_ismain) {
           $this->exec('update '.RAD.'news set nw_ismain=0');
        }
    	//TAGS
	    $modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','news');
        $modelTags->updateTagsInItem($item);
        return $this->update_struct($item,RAD.'news');
    }

    /**
     * Delete one row
     * @param struct_news $item
     */
    function deleteItem(struct_news $item)
    {
		$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','news');
		$modelTags->deleteTagsInItem($item->nw_id);
        return $this->delete_struct($item, RAD.'news');
    }

    /**
     * Deletes the news by it ID
     *
     * @param integer $id
     * @return integer
     */
    function deleteItemById($id)
    {
    	$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','news');
		$modelTags->deleteTagsInItem($id);
        return $this->exec('DELETE FROM '.RAD.'news where nw_id='.(int)$id);
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
            $this->setState('nw_tre_id', $ids);
            $news = $this->getItems();
            $newsIds = array();
            foreach($news as $nw) {
                $newsIds[] = $nw->nw_id;
            }
            return $this->exec('DELETE FROM `'.RAD.'news` where `nw_id` IN ('.implode(',', $newsIds).')');
        } elseif((int)($id)) {
            return $this->exec('DELETE FROM `'.RAD.'news` where `nw_id`="'.(int)$id.'"');
        }
    }    
    
    /**
     * Unsubscribe news from subscribes array
     * @param mixed array $array_of_ids
     */
    function UnSubscribe($array_of_ids)
    {
        if(is_array($array_of_ids)){
            return $this->exec('UPDATE '.RAD.'news SET nw_subscribe=0 WHERE nw_id IN ('.implode(',', $array_of_ids).')');
        }else{
            return $this->exec('UPDATE '.RAD.'news SET nw_subscribe=0 WHERE nw_id='.$array_of_ids);
        }
    }
    
    function setActive($item_id,$v)
    {
        return $this->exec('UPDATE '.RAD.'news set nw_active='.$v.' where nw_id='.(int)$item_id);
    }

}
