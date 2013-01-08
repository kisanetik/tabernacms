<?php 
function smarty_function_config($params, $smarty)
{
    if(!isset($params['get'])) {
        throw new rad_exception('Not enouph actual parameters for tag {config', __LINE__);
    }
    $params['get'] = ($params['get'][0]=='"')?substr($params['get'], 1, -1):$params['get'];
    $params['get'] = ($params['get'][0]=='\'')?substr($params['get'], 1, -1):$params['get'];
    if(!empty($params['assign'])) {
        $params['assign'] = ($params['assign'][0]=='"')?substr($params['assign'], 1, -1):$params['assign'];
        $params['assign'] = ($params['assign'][0]=='\'')?substr($params['assign'], 1, -1):$params['assign'];
        $smarty->assign(trim($params['assign']), rad_config::getParam($params['get']));
        return '';
    } else {
        return rad_config::getParam($params['get']);
    }
}