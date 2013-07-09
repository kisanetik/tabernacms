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
    if (empty($params['name'])) {
        rad_jscss::includeJS('', 'ckeditor/ckeditor.js', 'sync');
        rad_jscss::includeJS('core', 'wysiwyg/wysiwyg.js', 'sync');
        return '';
    }

    $result = '<textarea name="'.$params['name'].'" id="'.$params['name'].'"'
        .(isset($params['class']) ? ' class="'.$params['class'].'"' : '')
        .(isset($params['style']) ? ' style="'.$params['style'].'"' : '')
        .'>'
        .(isset($params['value']) ? $params['value'] : '')
        .'</textarea>';

    if (!isset($params['editor']) || $params['editor']) {
        //rad_jscss::includeJS('jscss/components/jquery/jquery.js');
        rad_jscss::includeJS('', 'ckeditor/ckeditor.js', 'sync');
        rad_jscss::includeJS('core', 'wysiwyg/wysiwyg.js', 'sync');
        //rad_jscss::inlineJS('WYSIWYG.create("'.$params['name'].'_id");', true);

        $result.= '<script language="JavaScript" type="text/javascript"> WYSIWYG.create("'.$params['name'].'"'
            .(isset($params['toolbar']) ? ',"'.$params['toolbar'].'"' : '').');</script>';
    }
    return $result;
}