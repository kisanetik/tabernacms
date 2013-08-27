<?php
/*
 * Plugin for parsing and genere get string
 * @package RADCMS
 * @author Denys Yackushev
 */

class rpl_staticpages extends rpl_base
{
    protected $_pv_separator = '.';
    protected $_p_separator = '+';

    protected function _parseRequestMiddle(&$request, &$result){
        if ($request[0] == 'search') {
            array_shift($request);
            $result['search'] = array_shift($request);
        }
    }
}
