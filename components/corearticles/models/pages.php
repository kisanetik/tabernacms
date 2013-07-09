<?php
class model_corearticles_pages extends rad_model
{
    function getItem($id='')
    {
        $id=($id)?$id:$this->getState('id');
        if($id){
            $result = new struct_corearticles_pages($this->query('SELECT * FROM '.RAD.'pages where pg_id=?', array($id)));
            if($this->getState('with_tags')) {
                $modelTags = rad_instances::get('model_coreresource_tags')->setState('tag_type','pages');
                $modelTags->asignTagsToItem($result);
            }
            return $result;
        } elseif($this->getStates()) {
            $q = $this->_getListQuery( );
            $result = $this->query($q->toString().' LIMIT 1', $q->getValues());
            if($result) {
                return new struct_corearticles_pages($result);
            } else {
                return NULL;
            }
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function getItems()
    {
        $q = $this->_getListQuery( );
        $result = array();
        foreach( $this->queryAll( $q->toString(), $q->getValues() ) as $key){
            $result[] = new struct_corearticles_pages($key);
        }
        return $result;
    }

    /**
     * Gets the query
     *
     * @return rad_query
     */
    function _getListQuery($fk=array())
    {
        $qb = new rad_query();

        if($this->getState('select')) {
          $qb->select($this->getState('select'));
        } else {
            $qb->select('*');
        }
        if($this->getState('from')) {
          $qb->from($this->getState('from'));
        } else {
            $qb->from(RAD.'pages');
        }
        if($this->getState('id')) {
            $qb->where('pg_id=:pg_id')->value( array('pg_id'=>(int)$this->getState('id')) );
        }
        if($this->getState('order by')) {
            $qb->order($this->getState('order by'));
        }
        if($this->getState('where')) {
            $qb->where($this->getState('where'));
        }
        if($this->getState('tre_id')) {
            if(is_array($this->getState('tre_id'))) {
                $treIds = array();
                foreach($this->getState('tre_id') as $key=>$treId) {
                    $treIds[] = (int)$treId;
                }
                $qb->where('pg_tre_id IN ('.implode(',', $treIds).')');
            } else {
                $qb->where('pg_tre_id=:pg_tre_id')->value( array('pg_tre_id'=>(int)$this->getState('tre_id')) );
            }
        }
        if($this->issetState('active')) {
            $qb->where('pg_active=:pg_active')->value( array('pg_active'=>(int)(bool)$this->getState('active')) );
        }
        if($this->getState('title')) {
            $qb->where('pg_title=:pg_title')->value( array('pg_title'=>$this->getState('title')) );
        }
        if($this->getState('name')) {
            $qb->where('pg_name=:pg_name')->value( array('pg_name'=>$this->getState('name')) );
        }
        if($this->getState('lang', $this->getState('lang_id'))) {
            $qb->where('pg_langid=:lang_id')->value(array('lang_id'=>(int)$this->getState('lang', $this->getState('lang_id'))));
        }
        return $qb;
    }//function _getListQuery

    /**
     * Insert one row
     */
    function insertItem(struct_corearticles_pages $item,$binded=false)
    {
        $result = $this->insert_struct($item,RAD.'pages',$binded);
        $item->pg_id = $this->inserted_id();
        $result = $item->pg_id;
        //TAGS
        $modelTags = rad_instances::get('model_coreresource_tags')->setState('tag_type','pages');
        $modelTags->insertTagsToItem($item);
        return $result;
    }

    /**
     * update one row
     */
    function updateItem(struct_corearticles_pages $item,$binded=false)
    {
        //TAGS
        $modelTags = rad_instances::get('model_coreresource_tags')->setState('tag_type','pages');
        $modelTags->updateTagsInItem($item);
        return $this->update_struct($item,RAD.'pages',$binded);
    }

    /**
     * Delete one row
     * @param struct_corearticles_news $item
     */
    function deleteItem(struct_corearticles_pages $item)
    {
        return $this->delete_struct($item, RAD.'pages');
    }

    /**
     * Deletes the page by it ID
     *
     * @param integer $id
     * @return integer
     */
    function deleteItemById($id)
    {
        $modelTags = rad_instances::get('model_coreresource_tags')->setState('tag_type','pages');
        $modelTags->deleteTagsInItem($id);
        return $this->exec('DELETE FROM '.RAD.'pages where pg_id='.(int)$id);
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
            $this->setState('tre_id', $ids);
            $pages = $this->getItems();
            $pageIds = array();
            foreach($pages as $page) {
                $pageIds[] = $page->pg_id;
            }
            return $this->exec('DELETE FROM `'.RAD.'pages` where `pg_id` IN ('.implode(',', $pageIds).')');
        } elseif((int)($id)) {
            return $this->exec('DELETE FROM `'.RAD.'pages` where `pg_id`="'.(int)$id.'"');
        }
    }    
    
    function setActive($item_id,$v)
    {
        return $this->exec('UPDATE '.RAD.'pages set pg_active='.$v.' where pg_id='.(int)$item_id);
    }

    function getPagesForTree($treeFragment=null, $langId = 1)
    {
        if(!empty($treeFragment)) {
            foreach($treeFragment as &$tree) {
                $this->setState('tre_id', $tree->tre_id);
                $this->setState('lang', $langId);
                $this->setState('active', 1);
                $tree->pages = $this->getItems();
                if(!empty($tree->child)) {
                    $this->getPagesForTree($tree->child, $langId);
                }
            }
        }
    }
}
