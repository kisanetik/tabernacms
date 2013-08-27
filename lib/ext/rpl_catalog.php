<?php
/*
 * Plugin for parsing and genere get string
 * @package RADCMS
 * @author Denys Yackushev
 */

class rpl_catalog extends rpl_base
{
    protected  $_pv_separator = '~';
    protected  $_p_separator = '^';

    protected function _parseRequestMiddle(&$request, &$result){
        if (count($request) <= 1) return;
        $tmp = array_shift($request);
        if ($tmp == 'search') {
            $result['search'] = array_shift($request);
        } else {
            $result['cat'] = (int)$tmp;
        }
    }

    protected function _makeUrlMiddle(&$get){
        $string = '';
        if(isset($get['cat'])) {
            $string .= $get['cat'].'/';
            unset($get['cat']);
        } elseif(isset($get['search'])) {
            $string .= 'search/'.$get['search'].'/';
            unset($get['search']);
        }
        return $string;
    }
}
