<?php
function smarty_function_lang($params, $smarty)
{
    if(!isset($params['code'])){
        throw new rad_exception("lang: missing 'code' parameter", E_USER_WARNING);
    }
    if($params['code'][0]=='"' or $params['code'][strlen($params['code'])-1]=="'") {
        $params['code'] = substr($params['code'], 1);
    }
    if($params['code'][strlen($params['code'])-1]=="'" or $params['code'][strlen($params['code'])-1]=='"') {
        $params['code'] = substr($params['code'], 0, -1);
    }
    if(isset($params['assign'])) {
        if( isset( $params['lang'] ) ) {
            $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code'],$params['lang']));
        } else {
            $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code']));
        }
        if(!empty($params['ucf'])) {
            $val = mb_ucfirst($val);
        }
        $smarty->assign($params['assign'], $val);
    } else {
        if( isset( $params['lang'] ) ) {
            $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code'],$params['lang']));
        } else {
            $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code']));
        }
        if(!empty($params['ucf'])) {
            $val = mb_ucfirst($val);
        }
        return $val;
    }
}