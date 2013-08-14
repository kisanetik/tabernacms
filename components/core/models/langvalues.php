<?php
/**
 * Managing language values
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_core_langvalues extends rad_model
{
    function getItems()
    {
        if($this->getState('type', 'translated')=='translated') {
            $q = $this->_getListQuery();
            $limit = $this->getState('limit')?'LIMIT '.$this->getState('limit'):'';
            $result = array();
            foreach( $this->queryAll($q->toString().$limit, $q->getValues()) as $id) {
                $result[] = new struct_core_langvalues($id);
            }
        } else {
            return $this->getUntranslated();
        }
        return $result;
    }

    function getUntranslated()
    {
        $result = array();
        $files = glob(rad_config::getParam('lang.cacheDir')."*.cachenf");
        if(!empty($files)) {
            foreach($files as $file) {
                if($this->getState('lang', $this->getState('lang_id'))) {
                    $res = json_decode(file_get_contents($file));
                    foreach($res as $url=>&$d1) {
                        foreach($d1 as $lngId=>&$d2) {
                            if( $this->getState('lang', $this->getState('lang_id'))!=$lngId ) {
                                unset($res->$url->$lngId);
                            }
                        }
                        if(empty($res->$url)) {
                            unset($res->$url);
                        }
                    }
                } else {
                    $result[] = json_decode(file_get_contents($file));
                }
            }
        }
        return $result;
    }

    /**
     * @return rad_query
     */
    protected function _getListQuery()
    {
        $q = new rad_query();

        if($this->getState('code')) {
            $q->where('lnv_code=:code')->value(array('code'=>$this->getState('code')));
        }
        if( $this->getState('group by') ) {
            $q->group($this->getState('group by'));
        }
        if( $this->getState('select') ) {
            $q->select( $this->getState('select') );
        } else {
            $q->select('a.*');
        }
        if($this->getState('from')) {
            $q->from( $this->getState('from') );
        } else {
            $q->from(RAD.'langvalues a');
        }
        if($this->getState('id')) {
            $q->where('lnv_id=:id')->value(array('id'=>(int)$this->getState('id')));
        }
        if($this->getState('lang', $this->getState('lang_id'))) {
            if(is_array('lang')) {
                die('array='.__FILE__.'line:'.__LINE__);
            } else {
                $q->where('lnv_lang=:lang')->value(array('lang'=>$this->getState('lang', $this->getState('lang_id'))));
            }
        }
        if($this->getState('value')){
            $q->where('lnv_value=:value')->value(array('value'=>$this->getState('value')));
        }
        if ($this->getState('order by', $this->getState('order'))) {
            $q->order($this->getState('order by', $this->getState('order')));
        } else {
            $q->order('lnv_code');
        }
        if($this->getState('search.code')) {
            $q->where('lnv_code LIKE :searchcode')->value(array(':searchcode'=>'%'.$this->getState('search.code').'%'));
        }
        if($this->getState('search')) {
            $q->where('lnv_code LIKE :search OR lnv_value LIKE :search')->value(array(':search'=>'%'.$this->getState('search').'%'));
        }

        return $q;
    }

    function getItemsGrouped($count = false)
    {
         //SELECT 1 FROM rad_langvalues WHERE lnv_lang in (1,2) GROUP BY lnv_code ORDER BY lnv_code LIMIT 6,3
        if(!$count) {
            $first_sql = 'SELECT lnv_code from '.RAD.'langvalues ';
        } else {
            $first_sql = 'SELECT count(*) from '.RAD.'langvalues ';
        }
        $andneeded = false;
        if($this->getState('langs')) {
            $first_sql.= ' WHERE lnv_lang in ('.implode(',',$this->getState('langs')).')';
            $andneeded = true;
        }
        if($this->getState('search')){
            $first_sql.= ($andneeded)?' and ':'';
            $searchword = $this->getState('search');
            $first_sql.= '( lnv_code like "%'.$searchword.'%" or lnv_code like "'.$searchword.'" or lnv_value like "%'.$searchword.'%" or lnv_value like "'.$searchword.'")';
        }
        $first_sql.= ' GROUP BY lnv_code';
        if(!$count)
            $first_sql.=' ORDER BY lnv_code';
        if($this->getState('limit')and (!$count)){
            $first_sql.=' LIMIT '.$this->getState('limit');
        }
        $first_res = $this->queryAll($first_sql);
        if($count){
            return count($first_res);
        }
        if(!count($first_res)) {
            return ;
        }
        $fel = true;
        $in = '';
        foreach($first_res as $id) {
            foreach($id as $key=>$value) {
                if(!$fel) {
                    $in.=',';
                }
                $in.='"'.$value.'"';
                $fel = false;
            }
        }
        $sql = 'SELECT * FROM '.RAD.'langvalues WHERE `lnv_code` in('.$in.') ';
        $result = array();
        foreach($this->queryAll($sql) as $row) {
            $result[] = new struct_core_langvalues($row);
        }
        return $result;
    }

    function getItem($id=null)
    {
        $id = ($id)?$id:$this->getState('id');
        $table = new model_core_table('langvalues');
        if($this->getState('lang_id')){
            $table->setState('lnv_id',$id);
        }
        return $table->getItem($id);
    }

    public function updateItem(struct_core_langvalues $struct)
    {
        return $this->update_struct($struct, RAD.'langvalues');
    }

    function insertItem(struct_core_langvalues $struct){
        return $this->insert_struct( $struct, RAD.'langvalues' );
    }

    function deleteByCode($code='')
    {
        return $this->query('DELETE FROM '.RAD.'langvalues where lnv_code=?', $code);
    }

    function deleteItem(struct_core_langvalues $struct)
    {
           return $this->delete_struct( $struct, RAD.'langvalues' );
    }

    function deleteByLang($lang_id)
    {
        return $this->exec('DELETE FROM '.RAD.'langvalues where lnv_lang="'.(int)$lang_id.'"');
    }

    function deleteRow($lnv_id)
    {
        return $this->exec('DELETE FROM '.RAD.'langvalues where lnv_id='.(int)$lnv_id );
    }
}