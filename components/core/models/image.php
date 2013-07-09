<?php
/**
 * Ported seld class from extra
 * designed for RAD2
 * Resize images
 * USES GD
 * @package RADCMS
 * @author Yackushev Denys
 */
class model_core_image extends rad_model
{
    function insertItem(struct_corecatalog_cat_images $item)
    {
        return $this->insert_struct($item,RAD.'cat_images');
    }

    function nullMainImages($cat_id=0){
        //return
        //TODO Return the really inserted rows
        $this->exec('UPDATE '.RAD.'cat_images set img_main=0 where img_cat_id='.$cat_id);
        return 1;
    }

    function setDefaultImage($img_id,$cat_id=0)
    {
        $rows = $this->nullMainImages($cat_id);
        //TODO Return the really inserted rows
        $this->exec('UPDATE '.RAD.'cat_images set img_main=1 where '.($img_id?'img_id='.(int)$img_id:'img_cat_id='.$cat_id));
        return 1;
    }

    function deleteItemsByCat($cat_id = NULL, $is_img_id = false)
    {
        if (!$cat_id) return;

        $img_field = $is_img_id ? 'img_id' : 'img_cat_id';
        $res = $this->queryAll('SELECT img_filename FROM '.RAD.'cat_images where '.$img_field.'=?', array($cat_id));
        if (count($res)) {
            foreach($res as $id) $this->deleteImg($id['img_filename']);
            $this->exec('delete from '.RAD.'cat_images where '.$img_field.'='.(int)$cat_id);
        }
    }

    function deleteImg($img){
        @unlink(CORECATALOG_IMG_PATH.$img);
        foreach(glob(CORECATALOG_IMG_GLOB.$img) as $filename) @unlink($filename);
    }

    function getItems()
    {
        $q = $this->_getListQuery($this->getStates());
        $result = array();
        $limit = '';
        if( strlen( $this->getState('limit') ) ){
            $limit = ' LIMIT '.$this->getState('limit');
        }
        foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key){
            $result[] = new struct_corecatalog_cat_images($key);
        }
        return $result;
    }

    /**
     * List query obgect
     * @param array $fields
     * @return rad_query
     */
    private function _getListQuery($fields=array())
    {
        $qb = new rad_query();

        if(isset($fields['select'])){
            $qb->select($fields['select']);
        }else{
            $qb->select('*');
        }
        if(isset($fields['from'])){
            $qb->from($fields['from']);
        }else{
            $qb->from(RAD.'cat_images');
        }
        if(isset($fields['where'])){
            $qb->where($fields['where']);
        }
        if(isset($fields['cat_id'])){
            $qb->where('img_cat_id=:img_cat_id')->value( array('img_cat_id'=>$fields['cat_id']) );
        }
        if(isset($fields['img_main'])){
            $qb->where('img_main=:img_main')->value( array('img_main'=>$fields['img_main']) );
        }
        if(isset($fields['order by'])){
            $qb->order($fields['order by']);
        }else{
            $qb->order('img_main DESC');
        }
        if(isset($fields['group by'])){
            $qb->group($fields['group by']);
        }

        return $qb;
    }
}//class