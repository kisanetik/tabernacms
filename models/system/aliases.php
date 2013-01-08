<?php
class model_system_aliases extends rad_model
{
    function getItems($limit=NULL)
    {
        $q = $this->getListQuery( $this->getStates() );
        $result = array();
        $limit = ($limit)?' LIMIT '.$limit:'';
        foreach( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key) {
            $result[] = new struct_alias($key);
        }
        return $result;
    }

    function getItem($id=NULL)
    {
        $id = ($id)?$id:$this->getState('id');
        $this->setState('id',$id);
        $limit = ($this->getState('limit'))?' LIMIT '.$this->getState('limit'):'';
        $q = $this->getListQuery( $this->getStates() );
        $item = new struct_alias( $this->query( $q->toString(), $q->getValues() ) );
        $theme_id = ($item->themeid)?$item->themeid:0;
        $theme2_id = $theme_id;
        if($item->group_id) {
			$theme2_id = rad_dbpdo::query('SELECT theme_id FROM '.RAD.'themes WHERE theme_aliasid=? AND theme_folder=?', array($item->group_id,$item->themefolder));
            $theme2_id = (!empty($theme2_id['theme_id']))?(int)$theme2_id['theme_id']:$theme_id;
        }
        if($this->getState('join.aliasgroup')) {
            $table = new model_system_table(RAD.'aliases');
            $ali_item = $table->getItem($id);
        }
        if(!$this->getState('without_joins')) {
            foreach( $this->queryAll( 'select params_presonal,inc_id,inc_name,inc_filename,controller,order_sort,rp_name,rp_id,id_module,m_name,ia.id as incinal_id, ia.params_hash as params_hash, 0 as is_ga '
                                        .($this->getState('join.original_params',false)?', ip_params AS original_params ':'')
                                        .'from '.RAD.'includes_in_aliases ia '
                                        .'inner join '.RAD.'includes on include_id=inc_id '
                                        .'inner join '.RAD.'modules m on m.m_id=id_module '
                                        .'inner join '.RAD.'positions p on position_id=p.rp_id '
                                        .($this->getState('join.original_params',false)?' left join '.RAD.'includes_params ip ON ip.ip_incid=ia.include_id ':'')
                                        .'where alias_id='.$id
                                        .' and ia.theme_id='.$theme_id
                                        .( ($this->getState('join.aliasgroup') AND isset($ali_item) AND $ali_item->group_id)?' UNION ('
                                        .'select params_presonal,inc_id,inc_name,inc_filename,controller,order_sort,rp_name,rp_id,id_module,m_name,ia.id as incinal_id, ia.params_hash as params_hash, 1 as is_ga '
                                        .($this->getState('join.original_params',false)?', ip_params AS original_params ':'')
                                        .'from '.RAD.'includes_in_aliases ia '
                                        .'inner join '.RAD.'includes on include_id=inc_id '
                                        .'inner join '.RAD.'modules m on m.m_id=id_module '
                                        .'inner join '.RAD.'positions p on position_id=p.rp_id '
                                        .($this->getState('join.original_params',false)?' left join '.RAD.'includes_params ip ON ip.ip_incid=ia.include_id ':'')
                                        .'where alias_id='.$ali_item->group_id
                                        .' and ia.theme_id='.$theme2_id
                                        .')':'')
                                        .' order by rp_name, order_sort')
                         as $idi) {
                             $item->includes[] = new struct_include($idi);
                             $item->includes[count($item->includes)-1]->is_ga = (boolean)$idi['is_ga'];
                         }
        }
        if( $this->getState('join_description') ) {
            $wlangid = $this->getState('ald_langid');
            $wlangid = ($wlangid)?' AND ald_langid='.$wlangid:'';
            foreach( $this->queryAll('SELECT * FROM '.RAD.'aliases_description where ald_aliasid='.$id.$wlangid) as $idd) {
               $item->description[$idd['ald_langid']] = new struct_aliases_description($idd);
            }
        }
        return $item;
    }

    /**
     * List query
     *
     * @param array $options
     * @param Boolean $fk
     * @return rad_query
     */
    function getListQuery($options, $fk=true)
    {
        $qb = new rad_query();

        $qb->from(RAD.'aliases a');
        $descr = (isset($options['join_description.one']))?' ,d.ald_txt as description ':'';
        $descr .= (isset($options['theme']))?' ,th.theme_folder as themefolder, th.theme_id as themeid ':'';
        if(isset($options['select'])) {
            $qb->select($options['select']);
        } else {
            if($fk) {
                $qb->select('a.*,t.filename as filename'.$descr);
            } else {
                $qb->select('a.*'.$descr);
            }
        }
        if(isset($options['template_id'])) {
            $qb->where('a.template.id='.(int)$this->escapeString($options['template_id']));
        }
        if(isset($options['id'])) {
            $qb->where('a.id='.(int)$this->escapeString($options['id']));
        }
        if(isset($options['order by'])) {
            $qb->order($options['order by']);
        }
        if( isset( $options['where'] ) ) {
            $qb->where( $options['where'] );
        }
        if(isset( $options['is_admin'] )) {
            $qb->where('ali_admin='.(int)$options['is_admin']);
        }

        if($fk) {
           $qb->join('LEFT', RAD.'templates t on a.template_id = t.id ');
        }
        if(isset($options['join_description.one'])) {
            $ald_lang = (isset($options['join_description.lang']))?(int)$options['join_description.lnag']:$this->getCurrentLangID();
            $qb->join('LEFT', RAD.'aliases_description d on ald_aliasid=a.id and ald_langid='.$ald_lang);
        }
        if(isset($options['theme'])){
            $qb->join('LEFT', RAD.'themes th on th.theme_aliasid=a.id and th.theme_folder="'.$options['theme'].'"');
        }

        //die($qb->toString());
        return $qb;
    }

    /**
     * for the searching aliases
     *
     * @param string $sw
     */
    function search($sw='')
    {
         $q = new rad_query();
         $q->select('a.*,t.filename as filename');
         $q->from(RAD.'aliases a');
         $q->join('LEFT',RAD.'templates t on t.id = a.template_id');
         $q->where('a.ali_admin='.(int)$this->getState('is_admin',0),'AND');
         $sql = $q->toString();
         $sql.=' AND(alias like "%'.$sw.'%" OR filename like "%'.$sw.'%" OR description like "%'.$sw.'%")';
//    	 $q->where('alias like "%'.$sw.'%"','OR');
//    	 $q->where('filename like "%'.$sw.'%"','OR');
//    	 $q->where('description like "%'.$sw.'%"','OR');
         $result = array();
         //die();
//    	 foreach( $this->queryAll( $q->toString() ) as $key){
         foreach( $this->queryAll( $sql ) as $key) {
             $result[] = new struct_alias($key);
         }
         return $result;
    }

    public function insertItem(struct_alias $struct)
    {
        return $this->insert_struct( $struct, RAD.'aliases' );
    }

    public function updateItem(struct_alias $struct)
    {
        return $this->update_struct($struct, RAD.'aliases');
    }

    function getModules()
    {
        return $this->queryAll('select * from '.RAD.'modules' );
    }
    /**
     * Get all includes
     *
     * @param boolean $joinModules - Join modules?
     * @param boolean $module_id - Where module_id=?
     * @return array()
     */
    function getIncludes($joinModules=false, $module_id=null)
    {
        if($joinModules) {
            return $this->queryAll('select i.*,m_name from '.RAD.'includes i inner join '.RAD.'modules on id_module=m_id');
        } else {
            if($module_id) {
                return $this->queryAll('SELECT * FROM '.RAD.'includes WHERE id_module=?', array( (int)$module_id ));
            } else {
                return $this->queryAll('select * from '.RAD.'includes');
            }
        }
    }

    /**
     * Gets the include object by it ID
     *
     * @param integer $id
     */
    function getIncludeById($id)
    {
        return $this->query('select * from '.RAD.'includes inner join '.RAD.'modules on id_module=m_id where inc_id="'.(int)$id.'" LIMIT 1');
    }

    function deleteAlias($id=NULL)
    {
        $id = ($id)?$id:$this->getState('id');
        if(is_numeric($id)) {
            $cnt = $this->exec('delete from '.RAD.'includes_in_aliases where alias_id='.$id);
            $cnt += $this->exec('delete from '.RAD.'aliases where id='.$id);
            return $cnt;
        }
        $this->securityHoleAlert(__FILE__,__LINE__,get_class($this));
        return 0;
    }

    function setParamsHash($inc_id,$hashstring)
    {
        //die('UPDATE '.RAD.'includes_in_aliases set params_hash=\''.$hashstring.'\' where id=\''.$inc_id.'\'');
        return $this->exec('UPDATE '.RAD.'includes_in_aliases set params_hash=\''.$hashstring.'\' where id=\''.$inc_id.'\'');
    }

}