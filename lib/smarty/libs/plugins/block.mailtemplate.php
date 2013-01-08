<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @ddatecreated 12 December 2011
 * @author Yackushev Denys
 */

/**
 * Smarty {mailtemplate}{/mailtemplate} block plugin
 *
 * Type:     block function<br>
 * @param array
 * <pre>
 * Params:   name: string (name)
 *           type: string - type of the mail
 * </pre>
 * @author Yackushev Denys
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string string $content re-formatted
 */
function smarty_block_mailtemplate($params, $content, $smarty, &$repeat)
{
    if(empty($params['name']) or empty($params['type'])) {
        throw new rad_exception('Not enouph actual params for {mailtemplate block!');
    }
    $lang = !empty($params['lang'])?$params['lang']:null;
    rad_mailtemplate::setBlockContent($params['name'], $params['type'], $content, $lang);
    return '';
}