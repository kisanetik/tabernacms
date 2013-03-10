<?php
/**
 * @author Denys Yackushev
 * @datecreated 27.01.2009
 * @package RADCMS
 */
class model_system_users extends rad_model
{
    /**
     * Gets one item by ID
     */
    function getItem($id=NULL)
    {
        $id = ((int)$id)?$id:$this->getState('id',$this->getState('u_id',NULL));
        if($id) {
            if( $res = $this->query('SELECT * FROM '.RAD.'users WHERE u_id=?', array($id)) ) {
                return new struct_users( $res );
            } else {
                return null;
            }
        } elseif(count($this->getStates())) {
            $q = $this->_getListQuery( $this->getStates() );
            if($this->getState('select')=='count(*)') {
                $res = $this->query( $q->toString().' LIMIT 1', $q->getValues() );
                if(count($res) and isset($res['count(*)'])) {
                    return (int)$res['count(*)'];
                } else {
                    return 0;
                }
            } else {
                if($this->getState('showSQL')) {
                    die($q->toString().' LIMIT 1'. print_h($q->getValues(), true));
                }
                $res = $this->query( $q->toString().' LIMIT 1', $q->getValues() );
                return ($res)?new struct_users( $res ):NULL;
            }
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        return NULL;
    }

    /**
     * Gets the users items by params and states
     * @return array of struct_users
     */
    function getItems($limit = null)
    {
        $q = $this->_getListQuery($this->getStates());
        $result = array();
        $limit = ($limit)?$limit:$this->getState('limit',$limit);
        $limit = ($limit)?' LIMIT '.$limit:'';
        if($this->getState('showSQL')) {
            die($q->toString().$limit.print_h($q->getValues(), true));
        }
        foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key){
            $result[] = new struct_users($key);
            if($this->getState('join.group')) {
                $result[count($result)-1]->group = new struct_tree($key);
            }
        }
        return $result;
    }

    /**
     * Gets the list query
     * @param array mixed $options
     * @param array mixed $fk
     * @return rad_query
     */
    private function _getListQuery ( $options, $fk=array())
    {
        $qb = new rad_query();

        if(isset($options['from'])) {
            $qb->from($options['from']);
        } else {
            $qb->from(RAD.'users a');
        }
        if(isset($options['select'])) {
            $qb->select($options['select']);
        } else {
            if(count($fk)) {
                //if need to join some...
            } else {
                $qb->select('a.*');
            }
        }
        if(isset($options['id'])||isset($options['u_id'])) {
            $tmp = (int)(isset($options['id']))?$options['id']:$options['u_id'];
            $qb->where('a.id=:a_id')->value(array('a_id'=>$tmp));
        }
        if(isset($options['order by'])) {
            $qb->order($options['order by']);
        } else {
            $qb->order('u_active,u_email,u_login,u_group,u_access');
        }
        if(isset($options['u_group'])){
            if(is_array($options['u_group'])) {
            	foreach($options['u_group'] as $key=>$value) {
    				$grIds[(int)$key] = (int)$value;
				}
				$qb->where('u_group IN ('.implode(',', $grIds).')');
            } else {
                $qb->where('u_group=:u_group')->value(array('u_group'=>(int)$options['u_group']));
            }
        }
        if(isset($options['u_active'])) {
            $qb->select('g.*');
            $qb->join('INNER', RAD.'tree g ON g.tre_id=a.u_group');
        }
        if(isset($options['u_active'])) {
            $qb->where('u_active=:u_active')->value( array('u_active'=>$options['u_active']) );
        }
        if(isset($options['u_id'])) {
            $qb->where('u_id=:u_id')->value(array('u_id'=>(int)$options['u_id']));
        }
        if(isset($options['u_login'])) {
            $qb->where('u_login=:u_login')->value(array('u_login'=>$options['u_login']));
        }
        if(isset($options['u_pass'])) {
            $qb->where('u_pass=:u_pass')->value(array('u_pass'=>$options['u_pass']));
        }
        if(isset($options['is_admin'])) {
            $qb->where('is_admin=:is_admin')->value(array('is_admin'=>(int)$options['is_admin']));
        }
        if(isset($options['u_email'])) {
            $qb->where('u_email=:u_email')->value(array('u_email'=>$options['u_email']));
        }
        if(isset($options['u_access'])) {
            $qb->where('u_access<:u_access')->value(array('u_access'=>(int)$options['u_access']));
        }
        if(isset($options['u_email_confirmed'])) {
            $qb->where('u_email_confirmed=:u_confirmed')->value( array('u_confirmed'=>$options['u_email_confirmed']) );
        }
        if(isset($options['u_subscribe_active'])) {
            $qb->where('u_subscribe_active=:u_subscribe_active')->value(array('u_subscribe_active'=>(int)$options['u_subscribe_active']));
        }
        if(isset($options['u_subscribe_langid'])) {
            $qb->where('u_subscribe_langid=:u_subscribe_langid')->value(array('u_subscribe_langid'=>(int)$options['u_subscribe_langid']));
        } // SOCIAL SITE's USER ACCOUNT ID:
        if(isset($options['u_facebook_id'])) {
            $qb->where('u_facebook_id=:u_facebook_id')->value(array('u_facebook_id'=>$options['u_facebook_id']));
        }
        if(isset($options['u_twitter_id'])) {
            $qb->where('u_twitter_id=:u_twitter_id')->value(array('u_twitter_id'=>$options['u_twitter_id']));
        } // ---
        if(isset($options['where'])) {
            $qb->where($options['where']);
        }
        if(isset($options['code'])) {
            $qb->join('INNER',RAD.'subscribers_activationurl on sac_scrid=a.u_id and sac_url=:sac_url and sac_type=2')
               ->value(array('sac_url'=>$options['code']));
        }
        return $qb;
    }

    /**
     * Insert one item to table from struct
     *
     * @param $struct struct_users
     * @return number of inserted rows
     * @access public
     */
    //TODO Check the object like is_object, but for struct_permissions and maybe something other
    public function insertItem(struct_users $struct)
    {
        return $this->insert_struct( $struct, RAD.'users' );
    }

    /**
     * Update one item
     * @param struct_users $struct
     * @return integer - number of updated rows
     */
    public function updateItem(struct_users $struct)
    {
        return $this->update_struct( $struct, RAD.'users' );
    }

    function deleteItem(struct_users $struct=NULL)
    {
        if($struct->getPrimaryKey()) {
            return $this->delete_struct( $struct, RAD.'users' );
        }
        return 0;
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
            $this->setState('u_group', $ids);
            $users = $this->getItems();
            $userIds = array();
            foreach($users as $user) {
                $userIds[] = $user->u_id;
            }
            return $this->exec('DELETE FROM `'.RAD.'users` where `u_id` IN ('.implode(',', $userIds).')');
        } elseif((int)($id)) {
            return $this->exec('DELETE FROM `'.RAD.'users` where `u_id`="'.(int)$id.'"');
        }
    }
    
    /**
     * Changes password in user with u_id to new_pass
     * @param integer $user_id
     * @param string $new_pass
     * @return integer 1 or 0 (number of updated rows)
     */
    function changePassword($user_id, $new_pass)
    {
        return $this->exec('UPDATE '.RAD.'users SET u_pass="'.$new_pass.'" WHERE u_id='.(int)$user_id);
    }

}//class