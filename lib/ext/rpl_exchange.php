<?php

class rpl_exchange extends rpl_base
{
    protected $_ending = ''; //Suppress ending since the string generated includes query string

    protected function _parseRequestMiddle(&$request, &$result){
        $result['_exchange_provider'] = array_shift($result);
    }
    protected function _parseRequestEnd($requestString, &$result){
    }

    protected function _makeUrlMiddle(&$get){
        $provider = isset($get['_exchange_provider']) ? $get['_exchange_provider'] : '';
        unset($get['_exchange_provider']);
        return $provider.'?';
    }
    protected function _makeUrlEnd(&$get){
        return implode('&', $get);
    }
}
