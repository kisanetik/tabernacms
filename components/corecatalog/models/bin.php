<?php
/**
 * for Bin and Cart
 * @author Yackushev Denys
 * @package Taberna
 */
class model_corecatalog_bin extends rad_model
{

    function getItem($id=null)
    {
        if($id){
            return new struct_corecatalog_bp( $this->query('SELECT * FROM '.RAD.'bp WHERE bp_id='.(int)$id ) );
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * If item exist - return existing item, or NULL
     *
     * @param integer $cat_id
     * @param integer_type $user_id
     * @param string $sess_id
     * @return struct_corecatalog_bp
     */
    function getItemCart($cat_id,$user_id = NULL,$sess_id = NULL)
    {
        if(!$user_id and $this->getCurrentUser() )
          $user_id = $this->getCurrentUser()->u_id;
        if(!$sess_id)
          $sess_id = $this->getCurrentSessID();
        $ss = ($user_id)?'bp_userid='.$user_id:'bp_sessid="'.$sess_id.'"';
        $res = $this->query('SELECT * FROM '.RAD.'bp WHERE bp_catid='.(int)$cat_id.' AND '.$ss);
        if( $res ){
            return new struct_corecatalog_bp($res);
        }else{
            return NULL;
        }
    }

    
    /**
     * Merge cart user for authorization
     * @param integer_type $user_id
     * @param string $sess_id
     */
    function mergeCart( $user_id = NULL, $sess_id = NULL ){
        if(!$user_id and $this->getCurrentUser() ) {
            $user_id = $this->getCurrentUser()->u_id;
        }
        if(!$sess_id) {
            $sess_id = $this->getCurrentSessID();
        }
        $this->exec('UPDATE '.RAD.'bp set bp_userid='.(int)$user_id.' WHERE bp_sessid="'.$sess_id.'"');
        $mergeRes = $this->queryAll('SELECT bp_id, bp_catid, bp_count FROM '.RAD.'bp WHERE bp_userid="'.(int)$user_id.'" ORDER BY bp_catid, bp_count DESC');
        $delBp = array();
        $count = count($mergeRes);
        for($k=1;$k<$count;$k++){
            if(($mergeRes[$k-1]['bp_catid'] == $mergeRes[$k]['bp_catid']) && ((int)$mergeRes[$k-1]['bp_count'] > (int)$mergeRes[$k]['bp_count']) ){
                $delBp[] = $mergeRes[$k]['bp_id'];
            }        
        }
        if(count($delBp) > 0){
            $this->exec('DELETE FROM '.RAD.'bp WHERE bp_id IN ('.implode(",",$delBp).')');
        }
    }
    
    /**
     * Gets all position in bin
     *
     * @param integer_type $user_id
     * @param string $sess_id
     * @return struct_corecatalog_bp array
     */
    function getItemsCart($user_id = NULL,$sess_id = NULL)
    {
        if(!$user_id and $this->getCurrentUser() ) {
            $user_id = $this->getCurrentUser()->u_id;
        }
        if(!$sess_id) {
            $sess_id = $this->getCurrentSessID();
        }
        $ss = ($user_id)?'bp_userid='.$user_id:'bp_sessid="'.$sess_id.'"';
        
        $res = $this->queryAll( 'SELECT * FROM '.RAD.'bp bp INNER JOIN '.RAD.'catalog c ON c.cat_id=bp.bp_catid WHERE '.$ss);
        $result = array();
        if( $res ) {
            $model_images = rad_instances::get('model_core_image');
            foreach($res as $id) {
                $result[] = new struct_corecatalog_bp($id);
                $result[count($result)-1]->product = new struct_corecatalog_catalog($id);
                $res_tree = $this->queryAll(
                     'SELECT * FROM '.RAD.'tree t
                         INNER JOIN '.RAD.'cat_in_tree cit
                             ON cit.cit_tre_id=t.tre_id
                             AND cit_cat_id=?',
                     array((int)$id['cat_id'])
                );
                if(!empty($res_tree)) {
                    foreach($res_tree as $id_tree) {
                        $result[count($result)-1]->product->tree_link[] = new struct_coremenus_tree($id_tree);
                    }
                }
                $model_images->setState('cat_id', (int)$id['cat_id']);
                $result[count($result)-1]->product->images_link = $model_images->getItems();
            }
        } else {
            return NULL;
        }
        return $result;
    }

    /**
     * Clear all items cart positions
     * @return count of deleted rows
     */
    function clearItemsCart($user_id = NULL,$sess_id = NULL)
    {
        if(!$user_id and $this->getCurrentUser() ) {
            $user_id = $this->getCurrentUser()->u_id;
        }
        if(!$sess_id) {
            $sess_id = $this->getCurrentSessID();
        }
        $ss = ($user_id)?'bp_userid='.$user_id:'bp_sessid="'.$sess_id.'"';
        return $this->query('DELETE FROM '.RAD.'bp WHERE '.$ss);
    }

    /**
     * Gets the array of product in shopping cart
     *
     * @param integer $user_id
     * @param string $sess_id
     * @return struct_corecatalog_catalog array
     */
    function getCartProducts($user_id = NULL,$sess_id = NULL, $ct_showing = NULL)
    {
        if(!$user_id and $this->getCurrentUser() ) {
            $user_id = $this->getCurrentUser()->u_id;
        }
        if(!$sess_id) {
            $sess_id = $this->getCurrentSessID();
        }
        $ss = ($user_id)?'bp_userid='.$user_id:'bp_sessid="'.$sess_id.'"';
        $sub_query = 'SELECT bp_catid FROM '.RAD.'bp WHERE '.$ss;
        
        $model = rad_instances::get('model_corecatalog_catalog');
        $model->setState('where_condition',' c.cat_id in ('.$sub_query.') ');
        $model->setState('group by',' c.cat_id ');
        return $model->getProductsList(true, $ct_showing);
    }


    function insertItem(struct_corecatalog_bp $item)
    {
        return $this->insert_struct($item, RAD.'bp');
    }

    function updateItem(struct_corecatalog_bp $item)
    {
        return $this->update_struct($item, RAD.'bp');
    }

    function deleteItem(struct_corecatalog_bp $item)
    {
        $this->delete_struct($item, RAD.'bp');
    }
}