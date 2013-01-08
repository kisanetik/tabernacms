<?php
function smarty_function_url($params, $smarty)
{
    if( !isset($params['href']) and !isset($params['file'])){
        $smarty->_syntax_error("url: missing 'href' or 'file' parameter", E_USER_WARNING);
    }
    if(isset($params['href'])) {
	    $context = $params['href'];
	    if(mb_strlen($params['href'])>7 && mb_substr($params['href'],0,7)=='http://')
	    	return $params['href'];
	    return rad_input::makeURL($context);
    } elseif(isset($params['file']) and !empty($params['file'])) {
        if(!empty($params['type'])) {
            switch($params['type']) {
                case 'javascript':
                case 'js':
                    if(substr($params['file'], 0, 6)=='jscss/' or substr($params['file'], 0, 4)=='img/') {
                        return '<script type="text/javascript" src="'.SITE_URL.$params['file'].'"></script>';
                    } else {
                        return '<script type="text/javascript" src="'.rad_input::makeURL($params['file']).'"></script>';
                    }
                    break;
                case 'css':
                    return '<link rel="stylesheet" type="text/css" href="'.SITE_URL.$params['file'].'" />';
                    break;
                case 'dfile':
                    if(empty($params['module'])) {
                        throw new RuntimeException('Module is required in {url type="dfile" TAG ', __LINE__);
                    }
                    return DOWNLOAD_FILES.$params['module'].'/'.$params['file'];
                    break;
            }
        } elseif(get_class($params['file'])=='struct_files') {
    		if(!isset($params['module'])) {
    			$smarty->_syntax_error("url: missing 'module' parameter for struct_files class when genere url", E_USER_ERROR);
    		}
    		$module = $params['module'];
    		if( rad_input::getDefine( strtoupper($module.'PATH') ) != strtoupper($module.'PATH') ) {
    			return SITE_URL.str_replace( rad_input::getDefine('rootPath') ,'', rad_input::getDefine( strtoupper($module.'PATH') ));
    		} elseif(rad_input::getDefine('DOWNLOAD_FILES')!='DOWNLOAD_FILES') {
    			return DOWNLOAD_FILES.$params['file']->rfl_filename.'/'.$module.'/'.$params['file']->rfl_name; 
    		} else {
    			throw new rad_exception('DOWNLOAD_FILES_DIR or '.strtoupper($module.'PATH').' not defined in config!');
    		}
        } elseif(is_string($params['file']) and !empty($params['size']) and !empty($params['module']) ) {
            return SITE_URL.'img/'.$params['module'].'+'.$params['size'].'+'.$params['file'];
        } elseif(get_class($params['file'])=='struct_cat_files') {
            return DOWNLOAD_FILES.$params['file']->rcf_filename.'/'.$params['file']->rcf_name;
    	} else {
    		throw new rad_exception('Unknown class in url function "'.get_class($params['file']).'" ', __LINE__);
    	}
    } elseif(empty($params['file'])) {
        throw new rad_exception('url file=[EMPTY]!');
    }
}