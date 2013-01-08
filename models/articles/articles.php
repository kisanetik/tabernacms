<?php
/**
 * Articles
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_articles_articles extends rad_model
{
    function getItem($id='')
    {
        $id=($id)?$id:$this->getState('id');
        if($id) {
        	$result = new struct_articles($this->query('SELECT * FROM '.RAD.'articles where art_id=?', array($id)));
            if($this->getState('with_tags')) {
            	$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','articles');
            	$modelTags->asignTagsToItem($result);
            }
            return $result;
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function getItems($limit = null)
    {
        $q = $this->_getListQuery( $this->getStates() );
        $result = array();
        $limit = ($limit)?' LIMIT '.$limit:'';
        if($this->getState('select')!='count(*)') {
            foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key) {
                $result[] = new struct_articles($key);
                if($this->getState('with_tree')) {
                    $result[count($result)]->tree = new struct_tree($key);
                }
            }
        } else {
            $result = $this->query($q->toString(), $q->getValues());
            if(count($result))
                $result = $result['count(*)'];
        }
        return $result;
    }

    /**
     * Get count of products in tree_id
     * @return integer
     */
    function getCount($treid=null)
    {
        $art_treid =($treid)?$treid:(int)$this->getState('tre_id', $this->getState('art_treid') );
        $active = ' and art_active= '.(int)$this->getState('active', 1);

        if($art_treid) {
            $sql = 'SELECT count(*) '
                 .' FROM '.RAD.'articles'
                 .' WHERE art_treid="'.(int)$art_treid.'"'.$active;

        } else {
            throw new rad_exception('Not setted the "art_treid" in class "'.$this->getClassName().'" at line: '.__LINE__,500);
        }
        $result = $this->query($sql);
        if(count($result)) {
            return $result['count(*)'];
        }
        return null;
    }

    /**
     * Gets the query
     *
     * @return rad_query
     */
    function _getListQuery($fields, $fk=array())
    {
        $qb = new rad_query();

        if(isset($fields['select'])) {
          $qb->select($fields['select']);
        } else {
            $qb->select('*');
        }
        if(isset($fields['from'])) {
          $qb->from($fields['from']);
        } else {
            $qb->from(RAD.'articles');
        }
        if(isset($fields['id'])) {
            $qb->where('art_id=:art_id')->value( array('art_id'=>(int)$fields['id']) );
        }
        if(isset($fields['isweek'])) {
            $qb->where('art_isweek=:art_isweek')->value( array('art_isweek'=>$fields['isweek']) );
        }
        if(isset($fields['order by'])) {
            $qb->order($fields['order by']);
        } else {
            $qb->order('art_position ASC,art_dateupdated DESC,art_title');
        }
        if(isset($fields['where'])) {
            $qb->where($fields['where']);
        }
        if(isset($fields['active'])) {
            $qb->where('art_active = :art_active')->value(array('art_active'=>$fields['active']));
        }
        if(isset($fields['tre_id'])) {
            if (is_array ($fields['tre_id']) and count ($fields['tre_id'])) {
                $ids = array();
                foreach($fields['tre_id'] as $id=>$val) {
                    $ids[] = (int)$val;
                }
                $qb->where('art_treid in ('.implode(',',$ids).')');
            } else {
                $qb->where('art_treid=:tre_id')->value(array('tre_id'=>(int)$fields['tre_id']));
            }
        }
        if(isset($fields['lang']) or isset($fields['lang_id'])) {
            $langId = (isset($fields['lang'])?$fields['lang']:$fields['lang_id']);
            $qb->where('art_langid=:lang_id')->value(array('lang_id'=>(int)$langId));
        }

        return $qb;
    }//function _getListQuery

    /**
     * Insert one row
     */
    function insertItem(struct_articles $item,$binded=false)
    {
    	$result = $this->insert_struct($item,RAD.'articles',$binded);
        $item->art_id = $this->inserted_id();
        $result = $item->art_id;
        //TAGS
        $modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','articles');
        $modelTags->insertTagsToItem($item);
        return $result;
    }

    /**
     * update one row
     */
    function updateItem(struct_articles $item,$binded=false)
    {
    	//TAGS
		$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','articles');
        $modelTags->updateTagsInItem($item);
        return $this->update_struct($item,RAD.'articles',$binded);
    }

    /**
     * Delete one row
     * @param struct_news $item
     */
    function deleteItem(struct_articles $item)
    {
        return $this->delete_struct($item, RAD.'articles');
    }

    /**
     * Deletes the article by it ID
     *
     * @param integer or array $id
     * @return integer
     */
    function deleteItemById($id)
    {
        if(is_array($id)) {
            return $this->exec('DELETE FROM '.RAD.'articles where art_id in '.implode(',',$id));
        } else {
			$modelTags = rad_instances::get('model_resource_tags')->setState('tag_type','articles');
			$modelTags->deleteTagsInItem($id);
            return $this->exec('DELETE FROM '.RAD.'articles where art_id='.(int)$id);
        }
    }

    /**
     * Deletes the articles by it art_treid
     * @return integer node_id
     */
    function deleteByNodeID($id)
    {
        $this->exec('DELETE FROM '.RAD.'articles WHERE art_treid='.(int)$id);
    }


    function setActive($id,$v)
    {
        return $this->exec('UPDATE '.RAD.'articles set art_active='.$v.' where art_id='.(int)$id);
    }

}