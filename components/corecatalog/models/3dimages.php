<?php
/**
 * Catalog product 3D Images
 * @author Denys Yackushev
 * @package Taberna
 * @datecreated 15 November 2012
 */
class model_corecatalog_3dimages extends rad_model
{
    /**
     * Saves item and check other fields
     * @param struct_corecatalog_cat_3dimages $item
     * @return Ambigous <number, number> - saved Rows count
     */
    public function insertItem(struct_corecatalog_cat_3dimages $item)
    {
        $res = $this->queryAll('SELECT img_main FROM '.RAD.'cat_3dimages WHERE img_cat_id=?', array($item->img_cat_id));
        $item->img_main = 1;
        if(!empty($res)) {
            foreach($res as $id) {
                if($id['img_main']==1) {
                    $item->img_main = 0;
                    break;
                } 
            }
        }
        return $item->save();
    }
    
    /**
     * Gets 3dImages
     * @return multitype:struct_corecatalog_cat_3dimages
     */
    public function getItems()
    {
        $q = new rad_query();
        $q->select('*')->from(RAD.'cat_3dimages');
        if($this->getState('cat_id')) {
            $q->where('img_cat_id=:cat_id')->value(array('cat_id'=>$this->getState('cat_id')));
        }
        $res = $this->queryAll($q->toString(), $q->getValues());
        $result = array();
        if(count($res)) {
            foreach($res as $id) {
                $result[] = new struct_corecatalog_cat_3dimages($id);
            }
        }
        return $result;
    }
    
    /**
     * Sets the main image
     * @param integer $imgId
     * @param integer $catId
     */
    public function setMain($imgId=null, $catId=null)
    {
        $imgId = $this->getState('img_id', $imgId);
        $catId = $this->getState('cat_id', $catId);
        if(!$imgId or !$catId) {
            throw new RuntimeException('cat_id or img_id can\'t be null', __LINE__+10000);
        }
        $this->query('UPDATE '.RAD.'cat_3dimages SET img_main=0 WHERE img_cat_id=?', array($catId));
        $this->query('UPDATE '.RAD.'cat_3dimages SET img_main=1 WHERE img_id=?', array($imgId));
    }
    
    /**
     * Assign to products list 3lImages
     * @param array of struct_corecatalog_catalog $items
     */
    public function assign3Dimages($items)
    {
        if(count($items)) {
            foreach($items as &$id) {
                $id->models_3d = $this->assign3Dimage($id);
            }
        }
    }
    
    /**
     * Assign 3D models to one product
     * @param struct_corecatalog_catalog $item
     */
    public function assign3Dimage(struct_corecatalog_catalog $item)
    {
        $res = $this->queryAll('SELECT * FROM '.RAD.'cat_3dimages WHERE img_cat_id=?', array($item->cat_id));
        if(!empty($res)) {
            foreach($res as $id) {
                $item->models_3d[] = new struct_corecatalog_cat_3dimages($id);
            }
        }
    }
    
    public function delete3Dimage($id)
    {
        $item = new struct_corecatalog_cat_3dimages(array('img_id'=>$id));
        $item->load();
        $fn = DOWNLOAD_FILES_DIR.'3dbin'.DS.$item->img_filename;
        if(is_file($fn)) {
            unset($fn);
            $item->remove();
        }
        return $this;
    }
}