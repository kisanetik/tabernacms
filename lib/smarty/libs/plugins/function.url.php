<?php
/**
 * @example
 * {url type="js" module="core" file="..." load="sync|defer|async|inplace" tag="0"}
 *
 * Parameter "tag" is used only with type="js|css|image":
 * tag="0" - return only link
 * tag="1" - return html code
 * for type="image" default value is "0", for type="js|css" default value is "1"
 *
 * Parameter "load" is used only with type="js":
 * load="defer" - the script will not run until after the page has loaded (default value)
 * load="async" - the script will be run asynchronously
 * load="inplace" - the script will be insert into template where {url} tag was placed
 * load="sync" - the script will be run in order during the page rendering
 *
 * Parameter "attr" contains a list of additional attributes, that will be inserted into the tag
 * @example
 * {url type="css" module="core" file="..." attr="media=screen"}
 * {url type="image" module="core" file="..." attr="border=0&class=preview"}
 */
function smarty_function_url($params, $smarty)
{
    $valid_attributes = array( // Available attributes
        'css' => array('media'),
        'image' => array('class', 'border'),
    );

    $params += array( //Default values for some params
        'load' => false,
        'type' => '',
        'tag' => ((isset($params['type']) && ($params['type'] == 'image')) ? 0 : 1),
        'priority' => 0,
    );

    if (isset($params['href']) != empty($params['file'])) {
        //Either both params are set or both ain't.
        if(rad_config::getParam('debug.showErrors')) {
            throw new rad_exception('url file=[EMPTY]!');
        } else {
            return '';
        }
    }
    if (isset($params['href'])) {
        $url = $params['href'];
        if (!is_link_absolute($url)) {
            if (!empty($params['canonical'])) {
                if (empty($url)) {
                    $url = SITE_URL.'index.php?lang='.rad_lang::getCurrentLanguage();
                } else {
                    $url = SITE_URL.'index.php?lang='.rad_lang::getCurrentLanguage().'&'.$url;
                }
            } else {
                $url = rad_input::makeURL($url, true);
            }
        }
    } else {
        if (!empty($params['type'])) {
            if (!isset($params['module'])) {
                if (rad_config::getParam('debug.showErrors')) {
                    throw new RuntimeException("Module is required in {url type='{$params['type']}' TAG");
                } else {
                    return '';
                }
            }
            try {
                switch($params['type']) {
                    case 'js':
                        $url = rad_jscss::getLinkToJS($params['module'], $params['file']);
                        break;
                    case 'css':
                        $url = rad_jscss::getLinkToCSS($params['module'], $params['file']);
                        break;
                    case 'dfile':
                        //TODO: implement per-component dfiles folders and dfiles caching.
                        return DOWNLOAD_FILES.$params['module'].'/'.$params['file'];
                    case 'image':
                        $url = rad_gd_image::getLinkToImage($params['module'], $params['file'], $params['preset']);
                        break;
                    default:
                        throw new rad_exception("Wrong parameter type in {url type='{$params['type']}'}");
                }
            } catch (Exception $e) {
                if (rad_config::getParam('debug.showErrors')) {
                    throw $e;
                } else {
                    return '';
                }
            }
        /* TODO: some draft for future #850 implementation
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
        } elseif(get_class($params['file'])=='struct_corecatalog_cat_files') {
            return DOWNLOAD_FILES.$params['file']->rcf_filename.'/'.$params['file']->rcf_name;
        } else {
            if(rad_config::getParam('debug.showErrors')) {
                throw new rad_exception('Unknown class in url function "'.get_class($params['file']).'" ', __LINE__);
            } else {
                return '';
            }
        }
    }

    if (!empty($params['type']) && $params['tag']) {
        $attributes = '';
        if (!empty($params['attr']) && !empty($valid_attributes[$params['type']])) {
            parse_str($params['attr'], $attr_array);
            $attributes_array = array_intersect_key($attr_array, array_flip($valid_attributes[$params['type']]));
            foreach ($attributes_array as $k=>$v) {
                $v = htmlspecialchars($v);
                $attributes .= " {$k}='{$v}'";
            }
        }
        switch($params['type']) {
            case 'js':
                switch ($params['load']) {
                    case 'async':
                        $attributes .= " async='true'";
                    case 'defer': //NB: also for "async" mode for IE compatibility
                        $attributes .= " defer='true'";
                }
                $html = "<script type='text/javascript' src='{$url}'{$attributes}></script>";
                if ($params['load'] == 'inplace') {
                    return $html;
                }
                if (isset($params['href'])) {
                    rad_jscss::addFile('--EXTERNAL--', $params['href'], $html, (int)$params['priority']);
                } else {
                    rad_jscss::addFile($params['module'], $params['file'], $html, (int)$params['priority']);
                }
                return '';
            case 'css':
                $html = "<link rel='stylesheet' type='text/css' href='{$url}'{$attributes} />";
                if (isset($params['href'])) {
                    rad_jscss::addFile('--EXTERNAL--', $params['href'], $html, (int)$params['priority']);
                } else {
                    rad_jscss::addFile($params['module'], $params['file'], $html, (int)$params['priority']);
                }
                return '';
            case 'image':
                return "<img src='{$url}'{$attributes} />";
        }
    }
    return $url;
}