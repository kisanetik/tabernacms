<?php
function smarty_function_lang($params, $smarty)
{
    if (!isset($params['code'])) {
        throw new rad_exception("lang: missing 'code' parameter", E_USER_WARNING);
    }
    $params['code'] = trim($params['code'], " \t\0\"'");
    if (isset($params['lang'])) {
        $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code'],$params['lang']));
    } else {
        $val = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array($params['code']));
    }
    if (isset($params['find']) && isset($params['replace'])) {
        if (!is_array($params['find']))
            $params['find'] = array($params['find']);
        if (!is_array($params['replace']))
            $params['replace'] = array($params['replace']);
        if (count($params['find']) != count($params['replace'])) {
            throw new rad_exception('lang: find/replace params should either be both scalar or be arrays of the same size');
        }
        $find = reset($params['find']);
        $replace = reset($params['replace']);
        while ($find) {
            $val = mb_str_replace($val, $find, $replace);
            $find = next($params['find']);
            $replace = next($params['replace']);
        }
    }
    if (!empty($params['htmlchars'])) {
        $val = mb_str_replace($val, '"', '&quot;');
    }
    if (!empty($params['ucf'])) {
        $val = mb_ucfirst($val);
    }
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $val);
    } else {
        return $val;
    }
}