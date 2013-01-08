<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @deprecated 20 may 2009
 * @author Yackushev Denys
 */

/**
 * Smarty {jsencode}{/jsencode} block plugin
 *
 * Type:     block function<br>
 * @param array
 * <pre>
 * Params:   t: string (name)
 *           //indent: integer (0)
 *           //wrap: integer (80)
 * </pre>
 * @author Yackushev Denys
 * @param string contents of the block
 * @param Smarty clever simulation of a method
 * @return string string $content re-formatted
 */
function smarty_block_jsencode($params, $content, $smarty, &$repeat)
{
    if (is_null($content)) {
        return;
    }
    $content = str_replace("\r",'',$content);
    $content = str_replace("\n",'',$content);
    $string = 'document.write(\''.$content.'\');';

    if(isset($params['noencode'])) {
        $js_encode = $string;
    } else {
        $js_encode = '';
        for ($x=0; $x < strlen($string); $x++) {
            $js_encode .= '%' . bin2hex($string[$x]);
        }
    }
    return '<script type="text/javascript">eval(unescape('.json_encode($js_encode).'));</script>';
}