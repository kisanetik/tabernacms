<?php
function smarty_function_sendtotpl($params, $template)
{
    if(!isset($params['var'])){
        throw new Exception("currency: missing 'var' parameter", E_USER_WARNING);
    }
    if(!isset($params['value'])){
        throw new Exception("currency: missing 'value' parameter", E_USER_WARNING);
    }
    if(!isset($params['template'])){
        throw new Exception("currency: missing 'template' parameter", E_USER_WARNING);
    }
	call_user_func_array(array(rad_config::getParam('loader_class'),'sendToTemplate'),array($params['template'],$params['var'],$params['value']));
    //rad_ sloader::sendToTemplate($params['template'],$params['var'],$params['value']);
    return '';
}