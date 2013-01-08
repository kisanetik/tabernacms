<?php 
/**
 * Model for tags in system
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_resource_tags extends rad_model
{
/**
	 * Add's the tag or tags into the DB
	 * @param mixed $items - Can be the string or array, or just one string tag
	 * @return mixed array of tag id's
	 */
	function addItems($items) 
	{
		$tags = array();
		$result = array();
		if(is_array($items)) {
			$result = $items;
		}elseif(gettype($items)=='string') {
			$tags = explode(',', $items);
			if(!empty($tags)) {
				foreach($tags as $tagID=>$tagValue) {
					$tagValue = trim($tagValue);
					if(!empty($tagValue)) {
						$result[] = $this->_checkOrAddTag($tagValue);
					}
				}
			}//if !empty tags
		} else {
			throw new rad_exception('Wrong type in class "model_resource_tags" when add new tag!', __LINE__);
		}
		return $result;
	}
	
	/**
	 * Check and add and return new id of the tag, or just return id of the tag 
	 * @param string $tag
	 * @return integer - id of the tag
	 * @access private
	 */
	private function _checkOrAddTag($tag) 
	{
		$tag = trim($tag);
		//$type = $this->getState('tag_type',false);
		$res = $this->query('SELECT t.tag_id FROM '.RAD.'tags t WHERE tag_string=?', array($tag));
		//$res = $this->query('SELECT t.tag_id FROM '.RAD.'tags t INNER JOIN '.RAD.'tags_in_item tii ON tii.tii_tag_id=t.tag_id WHERE tag_string=? AND tii.tii_tag_type=?', array($tag, $type));
		if(!$res){
			$this->query('INSERT INTO '.RAD.'tags(tag_string)VALUES(?)', array($tag));
			$result = $this->inserted_id();
		}else{
			$result = $res['tag_id'];
		}
		return $result;
	}
	
	/**
	 * Assign tags to item (product, news, etc. )
	 *
	 * @param rad_struct $structObj
	 */
	function asignTagsToItem(rad_struct $structObj)
	{
		list($itemId, $type) = $this->_defineIdAndType($structObj);
		if($itemId and $type) {
			$res = $this->queryAll('SELECT t.* FROM '.RAD.'tags_in_item tii INNER JOIN '.RAD.'tags t ON t.tag_id=tii.tii_tag_id AND tii.tii_item_id=? AND tii.tii_tag_type=?', array($itemId,$type));
			if(!empty($res)) {
				foreach($res as $id) {
					$structObj->tags[] = new struct_tags($id);
                }
            }
		}
	}
	
	/**
	 * Insert tags into item (product, news, etc. )
	 *
	 * @param rad_struct $structObj
	 */
	function insertTagsToItem(rad_struct $structObj)
	{
		list($itemId, $type) = $this->_defineIdAndType($structObj);	
		if(!empty($structObj->tags) and $itemId and $type) {
			foreach($structObj->tags as &$tag) {
				$tag->tii_item_id = $itemId;
				$tag->tii_tag_type = $type;
				$tag->insert();
			}
		}
	}
	
	/**
	 * Update tags in item (product, news, etc. )
	 *
	 * @param rad_struct $structObj
	 */
	function updateTagsInItem(rad_struct $structObj)
	{
		list($itemId, $type) = $this->_defineIdAndType($structObj);
		if($itemId and $type) {
			$exist_tags = $this->queryAll('SELECT tii_tag_id FROM '.RAD.'tags_in_item WHERE tii_item_id=?', array($itemId));
		    $sorted_exists_tags = array();
		    if(!empty($exist_tags)) {
		    	foreach($exist_tags as $tags_id) {
		    		$sorted_exists_tags[] = $tags_id['tii_tag_id'];
		    	}
		    }
		    if(!empty($structObj->tags)) {
		    	/* need to insert new tags */
		    	$insert_tags = array();
		    	/* need to delete old tags */
		    	$delete_tags = array();
		    	foreach($structObj->tags as $tag_obj) {
		    		if(get_class($tag_obj)=='struct_tags_in_item') {
		    			$needed_tags[] = $tag_obj->tii_tag_id;
		    		} else {
		    			$needed_tags[] = $tag_obj->tag_id;
		    		}
		    	}
		    	if(empty($sorted_exists_tags)) {//существующих тагов нету, добавляем.
	    			$insert_tags = $needed_tags;
		    	} else {//отдельно собираем массивы что надо удалить, и что надо вставить.
		    		$delete_tags = array_diff($sorted_exists_tags, $needed_tags);
		    		$insert_tags = array_diff($needed_tags, $sorted_exists_tags);
		    	}
		    	if(!empty($insert_tags)) {
			    	foreach($insert_tags as $tag_key=>$tag_id) {
			    		$this->query('INSERT INTO '.RAD.'tags_in_item (tii_item_id,tii_tag_id,tii_tag_type)VALUES(?,?,?)', array($itemId, (int)$tag_id, $type));
			    	}
		    	}
			    if(!empty($delete_tags)) {
			    	foreach($delete_tags as $tag_key=>$tag_id) {
			    		$this->query('DELETE FROM '.RAD.'tags_in_item WHERE tii_item_id=? AND tii_tag_id=? AND tii_tag_type=?', array($itemId, (int)$tag_id, $type));
			    	}
			    }
		    } elseif(!empty($exist_tags)) {//!empty tags
		    	$this->deleteTagsInItem($itemId);
		    }
		}
	}

	/**
	 * Delete tags in item (product, news, etc. )
	 *
	 * @param  (integer) $itemId
	 */
	function deleteTagsInItem($itemId=0)
	{
		$type = $this->getState('tag_type',false);
		if($itemId and $type) {
			$this->query('DELETE FROM '.RAD.'tags_in_item WHERE tii_item_id=? AND tii_tag_type=?', array($itemId, $type));
		} else {
			throw new rad_exception('Items ID or Type is not defined!', __LINE__);
		}
	}
	/**
	 * Define tags item_id and type
	 *
	 * @param rad_struct $structObj
	 * @return array(item_id, item_type)
	 */
	private function _defineIdAndType(rad_struct $structObj)
	{
		$itemId = 0;
		$type = $this->getState('tag_type',false);
		if($structObj and $type) {
			switch(get_class($structObj)) {
				case 'struct_catalog':
					if(isset($structObj->cat_id) and $structObj->cat_id and $type=='product') {
						$itemId = (int)$structObj->cat_id;
					}
					break;
				case 'struct_news':
					if(isset($structObj->nw_id) and $structObj->nw_id and $type=='news') {
						$itemId = (int)$structObj->nw_id;
					}
					break;
				case 'struct_articles':
					if(isset($structObj->art_id) and $structObj->art_id and $type=='articles') {
						$itemId = (int)$structObj->art_id;
					}
					break;
				case 'struct_pages':
					if(isset($structObj->pg_id) and $structObj->pg_id and $type=='pages') {
						$itemId = (int)$structObj->pg_id;
					}				
					break;
			}
		} else {
			throw new rad_exception('Items Structure or Type is not defined!', __LINE__);
		}
		return array($itemId, $type);
	}
	
}