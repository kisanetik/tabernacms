<?php
/**
 * @example
 * {url type="js" module="core" file="..." load="sync|defer|async"}
 *
 * Parameter "load" is used only with type="js":
 * load="defer" - a script that will not run until after the page has loaded (default value)
 * load="async" - a script that will be run asynchronously
 */
function smarty_function_url($params, $smarty)
{
    $params += array( //Default values for some params
        'load' => false,
        'type' => '',
        'tag' => ((isset($params['type']) && ($params['type'] == 'image')) ? 0 : 1),
    );
    if (isset($params['href'])) {
        $url = $params['href'];
        if (!is_link_absolute($url)) {
            if (isset($params['canonical']) && $params['canonical'] == true) {
                if(empty($url)) {
                    $url = SITE_URL.'index.php?lang='.rad_lang::getCurrentLanguage();
                } else {
                    $url = SITE_URL.'index.php?lang='.rad_lang::getCurrentLanguage().'&'.$url;
                }
            } else {
                $url = rad_input::makeURL($url);
            }
        }
        if (!empty($params['type'])) {
            //TODO: remove code duplication
            //TODO: use rad_jscss
            switch($params['type']) {
                case 'javascript':
                case 'js':
                    return "<script type='text/javascript' src='{$url}'></script>";
                case 'css':
                    return "<link rel='stylesheet' type='text/css' href='{$url}' />";
            }
        }
        return $url;
    }
    if (!empty($params['file'])) {
        if (!empty($params['type'])) {
            if (empty($params['module'])) {
                throw new RuntimeException("Module is required in {url type='{$params['type']}' TAG ");
            }
            switch($params['type']) {
                case 'js':
                    return rad_jscss::includeJS($params['module'], $params['file'], $params['load'], $params['tag']);
                case 'css':
                    rad_jscss::includeCSS($params['module'], $params['file']);
                    return '';
                case 'dfile':
                    //TODO: implement per-component dfiles folders and dfiles caching.
                    return DOWNLOAD_FILES.$params['module'].'/'.$params['file'];
                case 'image':
                    return rad_gd_image::getLinkToImage($params['module'], $params['file'], $params['preset']);
            }
        /* TODO: ����� �� �������
        } elseif(get_class($params['file'])=='struct_core_files') {
            if(!isset($params['module'])) {
                $smarty->_syntax_error("url: missing 'module' parameter for struct_core_files class when genere url", E_USER_ERROR);
            }
            $module = $params['module'];
            if( rad_input::getDefine( strtoupper($module.'PATH') ) != strtoupper($module.'PATH') ) {
                return SITE_URL.str_replace( rad_input::getDefine('rootPath') ,'', rad_input::getDefine( strtoupper($module.'PATH') ));
            } elseif(rad_input::getDefine('DOWNLOAD_FILES')!='DOWNLOAD_FILES') {
                return DOWNLOAD_FILES.$params['file']->rfl_filename.'/'.$module.'/'.$params['file']->rfl_name;
            } else {
                throw new rad_exception('DOWNLOAD_FILES_DIR or '.strtoupper($module.'PATH').' not defined in config!');
            }
        */
        } elseif(is_string($params['file']) and !empty($params['size']) and !empty($params['module']) ) {
            return SITE_URL.'img/'.$params['module'].'+'.$params['size'].'+'.$params['file'];
        } elseif(get_class($params['file'])=='struct_corecatalog_cat_files') {
            return DOWNLOAD_FILES.$params['file']->rcf_filename.'/'.$params['file']->rcf_name;
        } else {
            throw new rad_exception('Unknown class in url function "'.get_class($params['file']).'" ', __LINE__);
        }
    }
    throw new rad_exception('url file=[EMPTY]!');
}