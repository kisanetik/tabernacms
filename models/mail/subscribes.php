<?php
/**
 * For subscribes admin
 * @author Denys Yackushev
 * @package Taberna
 */
class model_mail_subscribes extends rad_model
{
    private $_cached_settings = null;

    function getSettings()
    {
        return $this->_cached_settings;
    }

    function getItem($id = NULL)
    {
        $id = ($id)?$id:$this->getState('id',$id);
        if($id){
            return new struct_subscribers( $this->query('SELECT * FROM '.RAD.'subscribers WHERE scr_id='.(int)$id) );
        }elseif(count($this->getStates())){
            $q = $this->_getListQuery( $this->getStates() );
            return new struct_subscribers( $this->query( $q->toString().' LIMIT 1' ) );
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function getItems($limit=NULL)
    {
        $q = $this->_getListQuery( $this->getStates() );
        $limit = ($limit)?$limit:$this->getState('limit',$limit);
        $result = array();
        $limit = ($limit)?' LIMIT '.$limit:'';
        if($this->getState('showSQL')==true)
            echo $q->toString().$limit;
        foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key){
            $result[] = new struct_subscribers($key);
        }
        return $result;
    }

    /**
     *
     * @param array $options
     * @return rad_query
     */
    function _getListQuery($options,$fk=array())
    {
        $qb = new rad_query();

        if(isset($options['from'])){
            $qb->from($options['from']);
        }else{
            $qb->from(RAD.'subscribers a');
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
        if(isset($options['code'])){
            $qb->join('INNER',RAD.'subscribers_activationurl on sac_scrid=a.scr_id and sac_url = :code')->value( array('code'=>$options['code']));
        }
        if(isset($options['order by'])){
            $qb->order($options['order by']);
        }else{
            $qb->order('scr_email,scr_name');
        }
        if(isset($options['email'])){
            $qb->where('scr_email = :email')->value( array('email'=>$options['email']) );
        }
        if(isset($options['sac_type'])){
            $qb->where('sac_type = :sac_type')->value( array('sac_type'=>(int)$options['sac_type']) );
        }
        if(isset($options['acturl'])){
            $qb->where('sac_url = :acturl')->value( array('acturl'=>$options['acturl']) );
        }        
        if(isset($options['active'])){
            $qb->where('scr_active = :active')->value( array('active'=>(int)$options['active']) );
        }
        if(isset($options['where'])){
            $qb->where($options['where']);
        }
        if(isset($options['name.like'])){
            $qb->where('scr_name like "%:name.like%"')->value( array('name.like'=>$options['name.like']) );
        }
        if(isset($options['name'])){
            if(is_array($options['name'])){
                $qb->where('scr_name in (":name")')->value( array('name'=>implode('","',$options['name'])) );
            }else{
                $qb->where('scr_name=":name"')->value(array('name'=>$options['name']));
            }
        }

        return $qb;
    }

    /**
     * Insert one row
     * @param struct_subscribers $item
     */
    function insertItem(struct_subscribers $item){
        return $this->insert_struct($item,RAD.'subscribers');
    }

    /**
     * update one row
     * @param struct_subscribers $item
     */
    function updateItem(struct_subscribers $item){
        return $this->update_struct($item,RAD.'subscribers');
    }

    /**
     * Delete one row
     * @param struct_subscribers $item
     */
    function deleteItem(struct_subscribers $item)
    {
        return $this->delete_struct($item, RAD.'subscribers');
    }

    function deleteActivationURL($code)
    {
        return $this->exec('DELETE FROM '.RAD.'subscribers_activationurl WHERE sac_url="'.$code.'"');
    }
    
    /**
     * 
     * 
     * @return struct_subscribers_activationurl
     */
    function getActivationUrl()
    {
    	$q = new rad_query(); 
    	$q->from(RAD.'subscribers_activationurl'); 
    	$q->select('*');
    	if($this->getState('sac_type')) {
            $q->where('sac_type = :sac_type')->value( array( 'sac_type'=>(int)$this->getState('sac_type') ) );
    	}
    	if($this->getState('sac_url')) {
            $q->where('sac_url = :sac_url')->value( array( 'sac_url'=>$this->getState('sac_url') ) );
    	}
    	if($this->getState('sac_scrid')) {
    	   $q->where('sac_scrid = :sac_scrid')->value( array( 'sac_scrid'=>$this->getState('sac_scrid') ) );
        }
        if( $res = $this->query($q->toString(), $q->getValues()) ){
            $result = new struct_subscribers_activationurl($res);
            return $result;
        } else {
        	return 0;
        }
    }

}