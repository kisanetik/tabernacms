<?php
/**
 * Managing files
 * @package RADCMS
 * @author Denys Yackushev
 */
class model_system_files extends rad_model
{
    function insertItem(struct_cat_images $item)
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
    	$this->exec('UPDATE '.RAD.'cat_images set img_main=1 where img_id='.(int)$img_id);
    	return 1;
    }

    function deleteFilesByCat($cat_id=NULL,$is_file_id=false)
    {
    	$rows = 0;
   		$items = $count = $this->queryAll('SELECT * FROM '.RAD.'cat_files WHERE '.($is_file_id?'rcf_id':'rcf_cat_id').'=?', array($cat_id));
    	if(!empty($items)){
    		foreach($items as $id) {
    			if(is_file(DOWNLOAD_FILES_DIR.$id['rcf_filename']))
    				unlink(DOWNLOAD_FILES_DIR.$id['rcf_filename']);
    			if($is_file_id)
    				$rows = $this->exec('DELETE FROM '.RAD.'cat_files WHERE rcf_id='.(int)$id['rcf_id']);
    		}
    		if(!$is_file_id)
    			$rows = $this->exec('DELETE FROM '.RAD.'cat_files WHERE rcf_cat_id='.(int)$cat_id);
    	}
    	return $rows;
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
            $result[] = new struct_cat_images($key);
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
    
    /**
     * Uploads the file
     * @example
     * 		model_system_files::uploadFile($_FILE['fieldName'], 'tracker', $item->tra_id, 700);
     * @param array $file
     * @param string $module
     * @param integer $itemId
     * @param integer $access
     * @return struct_files
     */
    public static function uploadFile($file, $module, $itemId=0, $access = 1000)
    {
    	if(file_exists($file['tmp_name']) and !empty($file['name'])) {
    		$userId = (rad_session::$user->u_id?rad_session::$user->u_id:0);
    		$originalName = $file['name'];
    		$filename = md5().'.'.fileext($file['name']);
    		if( rad_input::getDefine(strtoupper($module.'PATH')) ) {
    			$filename = rad_input::getDefine(strtoupper($module.'PATH')).$filename;
    		} elseif(rad_input::getDefine('DOWNLOAD_FILES_DIR')) {
    			if(!is_dir(rad_input::getDefine('DOWNLOAD_FILES_DIR').strtoupper($module))) {
    				$oldumask = umask(0);
    				if(!mkdir(rad_input::getDefine('DOWNLOAD_FILES_DIR').strtoupper($module), 0777) ) {
    					umask($oldumask);
    					throw new rad_exception('Can\'t create the dir "'.rad_input::getDefine('DOWNLOAD_FILES_DIR').strtoupper($module).'". Check the permissions pls.');
    				} 
    				umask($oldumask);
    			}
    			$filename = rad_input::getDefine('DOWNLOAD_FILES_DIR').strtoupper($module).DS.$filename;
    		} else {
    			throw new rad_exception('Folder for module '.$module.' does not setted! Check pls. config.php and set the folder for that module!');
    		}
    	} else {
    		$this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
    	}
    	if(!move_uploaded_file($file['tmp_name'], $filename)) {
    		throw new rad_exception('Some error when try to move uploaded file "'.$file['tmp_name'].'" to "'.$filename.'"!');
    	}
    	$item = new struct_files(array(
    		'rfl_module'	=> strtoupper($module),
    		'rfl_access'	=> $access,
    		'rfl_item_id'	=> $itemId,
    		'rfl_filename'	=> basename($filename),
    		'rfl_name'		=> $originalName,
    		'rfl_user_id'	=> $userId,
    		'rfl_dateupload'=> now()
    	));
    	$item->save();
    	return $item;
    }
}//class