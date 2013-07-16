<?php
/**
 * Plugin for inserting CKEditor
 * @param array $params:
 * 'name' - input name
 * 'class' - CSS class name
 * 'style' - inline CSS
 * 'value' - default value
 * 'editor' - boolean, WYSIWYG disabled if exists and FALSE
 * 'toolbar' - toolbar name (defined in wysiwyg.js)
 *
 * @param $smarty
 * @return string
 */
function smarty_function_wysiwyg($params, $smarty)
{
    $result = '';
    if (empty($params['name']) || !isset($params['editor']) || $params['editor']) {
        $result .= smarty_function_url(
            array('module' => '', 'file' => 'ckeditor/ckeditor.js', 'type' => 'js'),
            $smarty
        );
        $result .= smarty_function_url(
            array('href' => 'alias=wysiwyg&action=getjs', 'type' => 'js'),
            $smarty
        );
        if (empty($params['name'])) { // Include JS only
            return $result;
        }
    }

    $result .= '<textarea name="'.$params['name'].'" id="'.$params['name'].'"'
        .(isset($params['class']) ? ' class="'.$params['class'].'"' : '')
        .(isset($params['style']) ? ' style="'.$params['style'].'"' : '')
        .'>'
        .(isset($params['value']) ? $params['value'] : '')
        .'</textarea>';

    if (!isset($params['editor']) || $params['editor']) {
        $result .= '<script language="JavaScript" type="text/javascript"> WYSIWYG.create("'.$params['name'].'"'
            .(isset($params['toolbar']) ? ',"'.$params['toolbar'].'"' : '').');</script>';
    }
    return $result;
}