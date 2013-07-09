<?php
/**
 * Menus class for simple trees on parent_id
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_coremenus_tree extends rad_model
{
    /**
     * Cache for only pid values
     * @access private
     * @var array
     */
    private $_pidArray = array();

    //public $sql = '';

    /**
     * Get the one Node
     * If id is not getted - use just the states of object
     *
     * @param integer $id
     * @return struct_coremenus_tree
     */
    function getItem($id=null)
    {
        $states = $this->getStates();
        if(!is_null($id)) {
            $states['tre_id'] = $id;
        }
        if(count( $states )) {
            $q = $this->getListQuery( $states );
            return new struct_coremenus_tree( $this->query( $q->toString(), $q->getValues() ) );
        }else{
            return null;
        }
    }

    /**
     * Only private function for recursive get the items and subitems
     */
    private function _getRecursive($pid=NULL)
    {
        $nodes = array();
        $states = $this->getStates();
        if(isset($states['tre_active']) and isset($states['pid']) and count($states)<=2) {
            if(isset($this->_pidArray[(int)$states['pid']])) {
                return $this->_pidArray[(int)$states['pid']];
            }
        }

        if($pid) {
            $states['pid'] = $pid;
            if(isset($states['tre_id'])) {
                unset($states['tre_id']);
            }
        }

        $q = $this->getListQuery($states);
        if (isset($states['showSQL'])) {
            print $q->toString()."\n".print_h($q->getValues() ,true);
        }

        foreach( $this->queryAll( $q->toString(), $q->getValues() ) as $key) {
            $nodes[] = new struct_coremenus_tree($key);
        }

        for($i=0; $i < count($nodes); $i++) {
            if( !$nodes[$i]->tre_islast and $nodes[$i]->tre_pid!=$nodes[$i]->tre_id) {
                $nodes[$i]->child = $this->_getRecursive( $nodes[$i]->tre_id );
            }
        }

        if(isset( $states['tre_active'] ) and isset($states['pid']) and count($states) <= 2) {
            $this->_pidArray[(int) $states['pid']] = $nodes;
        }

        return $nodes;
    }

    /**
     * Get items count by params
     * @return integer
     */
    function getItemsCount($recursive=false)
    {
        $states = $this->getStates();
        $states['select'] = 'count(*)';
        $q = $this->getListQuery($states);
        $result = $this->queryAll( $q->toString(), $q->getValues() );
        if(count($result)) {
            if(isset($result[0]['count(*)'])) {
                $result = $result[0]['count(*)'];
            } else {
                $result = $result[0][1];
            }
        } else {
            $result = 0;
        }
        return $result;
    }

    /**
     * Get the nodes
     *
     * @return array of objects
     */
    function getItems($recursive=false)
    {
        $q = $this->getListQuery($this->getStates());
        $result = array();
        if($this->getState('showSQL')) {
            echo ($q->toString().print_r($q->getValues(),true));
        }
        if(!$recursive) {
            foreach( $this->queryAll( $q->toString(), $q->getValues() ) as $key) {
                $result[] = new struct_coremenus_tree($key);
            }
            return $result;
        } else {
            return $this->_getRecursive();
        }
    }

    /**
     * Insert one node
     *
     * @param struct_coremenus_tree $item
     *
     * @return array of struct_coremenus_tree
     */
    function insertItem(struct_coremenus_tree $item)
    {
        $item->tre_active = (int)$item->tre_active;
        return $this->insert_struct($item,RAD.'tree');
    }

    function deleteItem(struct_coremenus_tree $item)
    {
        return $this->delete_struct($item,RAD.'tree');
    }

    function deleteItemById($id)
    {
        if(is_array($id)) {
            $ids = array();
            foreach($id as $key=>$value) {
                $ids[] = (int)$value;
            }
            return $this->exec('DELETE FROM `'.RAD.'tree` where `tre_id` IN ('.implode(',', $ids).')');
        } elseif((int)($id)) {
            return $this->exec('DELETE FROM `'.RAD.'tree` where `tre_id`="'.(int)$id.'"');
        }
        return NULL;
    }
    
    function getRecurseNodeIDsList($nodes, &$treeIds)
    {
        foreach($nodes as $id) {
            if(is_array($id->child)) {
                $treeIds = $this->getRecurseNodeIDsList($id->child, $treeIds);
            }
            $treeIds[] = $id->tre_id;
        }
        return $treeIds;
    }

    function updateImage($fn, $id)
    {
        $id = (int)$id;
        if($id) {
            $old_img = $this->getItem($id);
            $this->deleteImages($old_img->tre_image);
            $fn = basename($fn);
            return $this->exec('UPDATE '.RAD.'tree SET `tre_image`="'.$fn.'" WHERE `tre_id`="'.$old_img->tre_id.'"');
        }
    }

    function updateItem(struct_coremenus_tree $item)
    {
        $item->tre_active = (int)$item->tre_active;
        return $this->update_struct($item,RAD.'tree');
    }

    /**
     * Uploads the image and return the fn of the image
     * @param string $field
     * @return string filename
     */
    function uploadImage($field)
    {
        if(count( $_FILES[$field] )) {
            if(file_exists($_FILES[$field]['tmp_name'])) {
                if (!file_exists(COREMENUS_IMG_PATH)) {
                    mkdir(COREMENUS_IMG_PATH, 0777);
                }
                $newname = COREMENUS_IMG_PATH.md5( microtime_float() ).'.'.strtolower( fileext( $_FILES[$field]['name'] ) );
                return ( move_uploaded_file($_FILES[$field]['tmp_name'], $newname ) )?$newname:NULL;
            } else {
                throw new rad_exception('SOME ERROR ON SERVER WITH UPLOAD FILES!!! CHECK RULES AND PERMISSIONS!',__LINE__);
            }
        } else {
            return NULL;
        }
    }

    function deleteImages($img){
        if (empty($img)) return;
        $files = array_merge(glob(COREMENUS_IMG_PATH.$img), glob(COREMENUS_IMG_GLOB.$img));
        foreach($files as $file) @unlink($file);
    }
/**
     * Get path category to root
     * @return array categoryes
     */
    function getCategoryPath (struct_coremenus_tree $currCategory, $root_treid, $active=1)
    {
        $root_nodes = array ();
        if($currCategory->tre_id != $root_treid) {
            if ($active == 1) {
               $this->setState('active', $active);
            }
            $item = $this->getItem($currCategory->tre_pid);
            if ($item->tre_id != 0) {
                $root_nodes[] = $item;
                if( ($currCategory->tre_pid != $root_treid) and ($root_nodes[0]->tre_pid != 0) ) {
                    while( ($root_nodes[0]->tre_id != $root_treid) and ($root_nodes[0]->tre_pid != 0) ) {
                        $new = $this->getItem($root_nodes[0]->tre_pid);
                        if ($new->tre_id > 0) {
                            array_unshift($root_nodes, $new);
                        } else {
                            break;
                        }
                    }//while
                }//if
            } //if
        }//if
        return $root_nodes;
    }

    protected function getListQuery($fields)
    {
        $qb = new rad_query();

        if(isset($fields['select'])) {
            $qb->select(isset($fields['select']));
        } else {
            $qb->select('*');
        }
        if( isset( $fields['pid']) ) {
            $qb->where('tre_pid=:tre_pid')->value( array('tre_pid'=>(int)$fields['pid']) );
        }
        if( isset( $fields['order']) ) {
            $qb->order( $fields['order'] );
        } else {
            $qb->order( 'tre_position,tre_name' );
        }
        if(isset($fields['access'])) {
            $qb->where('tre_access>=:tre_access')->value( array('tre_access'=>(int)$fields['access']) );
        }
        if( isset( $fields['tre_id'] ) ) {
           if( is_array($fields['tre_id']) and count($fields['tre_id']) ) {
                $qb->where('tre_id in ('. implode(',',$fields['tre_id']) .')');
           } else {
                $qb->where('tre_id=:tre_id')->value( array('tre_id'=>(int)$fields['tre_id']) );
           }
        }
        if( isset( $fields['tre_active'] ) or isset( $fields['active'] ) ) {
            $active = (isset($fields['tre_active'])) ? $fields['tre_active'] : $fields['active'];
            $qb->where('tre_active=:tre_active')->value( array('tre_active'=>$active) );
        }

        if( isset($fields['lang']) or isset($fields['lngid']) or isset($fields['lang_id']) or isset($fields['tre_lang']) ) {
            $lngid = (isset($fields['lang']))?$fields['lang']: ( (isset($fields['lngid']))?$fields['lngid']: ( (isset($fields['lang_id']))?$fields['lang_id']: ( (isset($fields['tre_lang']))?$fields['tre_lang']:0 ) ) ) ;
            if(((int)$lngid)) {
                $qb->where('tre_lang=:tre_lang')->value( array('tre_lang'=>$lngid) );
            } else {
                throw new rad_exception('Unknown type of lng_id',__LINE__);
            }
        }
        $qb->from(RAD.'tree');
        return $qb;
    }

    function checkForClosing($treeItem1, $pid2=0)
    {
        $isOK = true;
        $treeItem2 = $this->getItem($pid2);
        if($treeItem1->tre_id > 0 and $treeItem2 != null) {
            if($treeItem1->tre_id == $treeItem2->tre_id) {
                $isOK = false;
            } else {
                $nodesPath = $this->getCategoryPath($treeItem2, $treeItem1->tre_id, 0);
                if(!empty($nodesPath) and count($nodesPath)) {
                    foreach($nodesPath as $node) {
                        if($node->tre_id == $treeItem1->tre_id) {
                            $isOK = false;
                            break;
                        }
                    }
                }
            }
        } else {
            $isOK = false;
        }
        return $isOK;
    }
    
}