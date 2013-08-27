<?php
function smarty_function_currency($params, $smarty)
{
    if( isset($params['get']) ){
        switch($params['get']){
            case 'ind':
                if(!empty($params['id']) and (int)$params['id']) {
                    return model_corecatalog_currcalc::getCurrencyByID($params['id']);
                } else {
                    return model_corecatalog_currcalc::currInd();
                }
                break;
            case 'shortname':
                return model_corecatalog_currcalc::currShortName();
                break;
            case 'name':
                return model_corecatalog_currcalc::currName();
                break;
            default:
                throw new rad_exception("currency: wrong argument for 'get' parameter", E_USER_WARNING);
                break;
        }//switch
    }
    if(!isset($params['cost'])){
        throw new rad_exception("currency: missing 'cost' parameter", E_USER_WARNING);
    }
    if(!isset($params['curid'])){
        throw new rad_exception("currency: missing 'curid' parameter", E_USER_WARNING);
    }
    return model_corecatalog_currcalc::calcCours($params['cost'], (int)$params['curid']);
}