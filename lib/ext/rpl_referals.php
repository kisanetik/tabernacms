<?php
/*
 * Plugin for parsing and genere get string
 * @package RADCMS
 * @author Denys Yackushev
 */

class rpl_referals extends rpl_base
{
    protected  $_pv_separator = '|';
    protected  $_p_separator = '.';

    protected function _parseRequestMiddle(&$request, &$result){
    }
    protected function _parseRequestEnd($requestString, &$result){
        //TODO: Looks like the work isn't finished yet: only TYPE_INDEX links are parsed.
        if (strlen($requestString) && $requestString[0] == '0') {//Just User.ID
            $result['user_id'] = (int)$requestString;
        }
    }

    protected function _makeUrlMiddle(&$get){
        if(!isset($get['user_id']) && !isset($get['id']) && !isset($get['type'])) {
            return '';
        }
        if (!isset($get['type'])) {
            throw new rad_exception('Not enough actual params "type"');
        }
        if (!isset($get['user_id'])) {
            throw new rad_exception('Not enough actual params "user_id"');
        }
        if (!isset($get['id']) && $get['type'] !== model_coresession_referals::TYPE_INDEX) {
            throw new rad_exception('Not enough actual params "id"');
        }

        switch($get['type']) {
            case model_coresession_referals::TYPE_INDEX:
                $string = '0'.(int)$get['user_id'];
                break;
            case model_coresession_referals::TYPE_ARTICLE:
                $string = (int)$get['user_id'].$this->_p_separator.'a'.(int)$get['id'];
                break;
            case model_coresession_referals::TYPE_CATALOG:
                $string = (int)$get['user_id'].$this->_p_separator.'c'.(int)$get['id'];
                break;
            case model_coresession_referals::TYPE_NEWS:
                $string = (int)$get['user_id'].$this->_p_separator.'n'.(int)$get['id'];
                break;
            case model_coresession_referals::TYPE_PAGE:
                $string = (int)$get['user_id'].$this->_p_separator.'s'.(int)$get['id'];
                break;
            case model_coresession_referals::TYPE_PRODUCT:
                $string = (int)$get['user_id'].$this->_p_separator.'p'.(int)$get['id'];
                break;
            default:
                throw new rad_exception("Unknown type '{$get['type']}' for reflink generation!");
        }
        unset($get['id'], $get['user_id'], $get['type']);
        return $string;
    }
}
