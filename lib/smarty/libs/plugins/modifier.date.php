<?php
/**
* Модификатор date: unix_timestamp, date, datetime => дата на человеческом языке
*
* @param string $string
* @param string $format — 'date', 'time', 'datetime'
* @return string
*/
function smarty_modifier_date($string, $format='datetime')
{
    if (!isset($GLOBALS['config']['smarty.'.$format.'_format'][rad_lang::getCurrentLanguage()])) {
        trigger_error('Modifier date: invalid format specified in config!');
        return '';
    }
    $format = $GLOBALS['config']['smarty.'.$format.'_format'][rad_lang::getCurrentLanguage()];
    if (!is_numeric($string)) {
        // try to read date and datetime
        $timestamp = strtotime($string);
        if ($timestamp !== FALSE){
            $string = $timestamp;
        }
    }
    // is this like unix_timestamp?
    if (is_numeric($string)) {
        // Month on human language
        $format = str_replace('%B', rad_lang::lang('-'.date('F', $string)), $format);
        return strftime($format, $string);
    }
    // we are still here? Something wrong...
    trigger_error('Invalid data for date modifier!');
    return '';
}