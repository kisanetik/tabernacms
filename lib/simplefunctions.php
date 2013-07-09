<?php
/**
 * ***********************
 *
 * @author Yackushev Denys
 * @datecreated 10.11.2007
 * @package RADCMS
 * @version 0.2.1
 * @description Just some simple functions that used by Core
 */

function rad_autoload_register($function)
{
    //die('afjj;slkjfs;lfj;lsks');
    spl_autoload_unregister('_autoloadFinal');
    //print_r($function);die();
    spl_autoload_register($function);
    spl_autoload_register('_autoloadFinal');
}

function _autoload($class_name)
{
    if (trim($class_name) == '') {
        return false;
    }
    if(class_exists($class_name)) {
        return true;
    }

    $classParts = explode('_', $class_name);
    if (count($classParts) < 2)
        return false;

    switch ($classType = array_shift($classParts)){
        case 'rad':
            $file = LIBPATH.'class.'.implode('_', $classParts).'.php';
            break;
        case 'interface':
            $file = LIBPATH.'interfaces'.DS.'interface.'.implode('_', $classParts).'.php';
            break;
        case 'rpl':
            $file = LIBPATH.'ext/'.strtolower($class_name).'.php';
            break;
        case 'struct':
        case 'model':
        case 'controller':
            $plural = $classType . 's';
            $component = array_shift($classParts);
            $className = implode('_', $classParts);
            $file = getThemedComponentFile($component, $plural, $className.'.php');
            break;
        default:
            return;
    }
    if (!empty($file)) {
        @include_once($file);
        if (class_exists($class_name, false)) {
            return true;
        }
        throw new RuntimeException("Could not find the class '{$class_name}' in {$file}!", 11348);
    }
}

/**
 * Final autoload with error when class of interface not exists!
 * @param string $class_name
 * @return StdClass
 */
function _autoloadFinal($className)
{
    echo "FATAL ERROR RAD2: Class or Interface '{$className}' not exist!!!<hr/>";
    debug_print_backtrace();
    die();
}

function xmlDepth($vals, &$i)
{
    $children = array();

    if ( isset($vals[$i]['value']) )
    {
        array_push($children, $vals[$i]['value']);
    }
    while (++$i < count($vals)) {
        switch ($vals[$i]['type']) {
            case 'open':
                if ( isset ( $vals[$i]['tag'] ) )
                {
                    $tagname = $vals[$i]['tag'];
                } else {
                    $tagname = '';
                }
                if ( isset ( $vals[$i]['attributes'] ) ) {
                    $children[$tagname]['@'] = $vals[$i]["attributes"];
                }
                $children[$tagname] = xmlDepth($vals, $i);
                break;
            case 'cdata':
                array_push($children, $vals[$i]['value']);
                break;

            case 'complete':
                $tagname = $vals[$i]['tag'];

                if( isset ( $vals[$i]['value'] ) )
                {
                    $children[$tagname] = $vals[$i]['value'];
                } else {
                    $children[$tagname] = '';
                }

                if ( isset ($vals[$i]['attributes']) ) {
                    $children[$tagname]['@'] = $vals[$i]['attributes'];
                }

                break;

            case 'close':
                return $children;
                break;
        }

    }
    return $children;
}

function XML2ARRAY($data, $WHITE=1)
{
    $data = trim($data);
    if((!empty($data))and(strlen($data)>7)) {
        if(strtolower(substr($data,0,4))!='<xml')
            $data='<xml>'.$data;
        $tmp=strlen($data)-1;
        if (strripos($data, '</xml>') !== $tmp - strlen('</xml>'))
            $data=$data.'</xml>';
        $vals = $index = $array = array();
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, $WHITE);
        if ( !xml_parse_into_struct($parser, $data, $vals, $index) ){
            echo 'XML2ARRAY.XMLError '.xml_error_string(xml_get_error_code($parser)).' at line '.xml_get_current_line_number($parser);
            echo 'XML2ARRAY.err.XMLError ',xml_error_string(xml_get_error_code($parser)).' at line '.xml_get_current_line_number($parser);
            return false;
        }
        xml_parser_free($parser);
        $i = 0;
        $tagname = $vals[$i]['tag'];
        if ( isset ($vals[$i]['attributes'] ) ){
            $array[$tagname]['@'] = $vals[$i]['attributes'];
        }else{
            $array[$tagname]['@'] = array();
        }
        $array[$tagname] = xmlDepth($vals, $i);

        return $array['xml'];
    }else{
        return false;
    }
}

function ARRAY2XML($value)
{
    $result = '';
    if(is_array($value)){
        foreach($value as $key=>$row){
            $result .= '<'.$key.'>';
            if(is_array($row)){
                $xml = ARRAY2XML($row);
                $result .= $xml;
            }else{
                $result .= $row;
            }
            $result .= '</'.$key.'>';
        }
    }
    return $result;
}

function config($key){
    global $config;
    return $config[$key];
}

function microtime_float(){
    return microtime(true);
}

function print_h($data, $return = false)
{
    if( is_bool($data) ) {
        $result = $data ? '[true]' : '[FALSE]';
    } elseif( is_null($data) ) {
        $result = '[NULL]';
    } elseif(is_string($data) and $data == '') {
        $result = '[EMPTY STRING]';
    } else {
        $result = print_r($data, true);
        $result = str_replace(' ', '&nbsp;', $result);
        $result = str_replace("\n", "<br/>\n", $result);
    }
    if ($return) {
        return $result;
    }
    echo $result;
}

function now($timestamp=null)
{
    global $config;
    if(!$timestamp)
        $timestamp=time();
    return date($config['datetime.format'],$timestamp);
}

function fileext($filename){
    return substr(strrchr(basename($filename),"."),1);
}

function div($int,$del)
{
    if ($del == 0){
        rad_dblogger::logerr('Division by zerro found in params! file: '.__FILE__.' line: '.__LINE__);
        return 0;
    }
    $res = $int / $del;
    return $res >= 0 ? floor($res) : ceil($res);
}

function mod($int, $del)
{
    return  $int % $del;
}

function php_mail_check($mail)
{
    return (bool)filter_var($mail, FILTER_VALIDATE_EMAIL);
}

/*
function isValidURL($url)
{
    return true;
    if(function_exists('checkdnsrr')){
        return (checkdnsrr($url,'A'));
    }
    if(function_exists('curl_init')){
        ob_start();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_exec($ch);
        curl_close($ch);
        $head = ob_get_contents();
        ob_end_clean();
        preg_match('/HTTP\/1\.1\s([0-9]{3})/', $head, $code);
        $code = isset($code[1]) ? (int)$code[1] : -1;
        return $code==200 || $code==302;
    }
    if(function_exists('fsockopen')){
        $url1 = parse_url($url);
        $url1['port'] = isset($url1['port']) ? $url1['port'] : 80;
        $url1['query'] = isset($url1['query']) ? "?".$url1['query'] : "";
        if(in_array($url1['scheme'],stream_get_transports())){
            if($f=fsockopen($url1['scheme'].$url1['host'],$url1['port'])){
                $url1['path'] = (isset($url1['path'])?$url1['path']:'');
                fputs($f,"HEAD ".$url1['path'].$url1['query']." HTTP/1.1\r\nHost: ".$url1['host']."\r\n\r\n");
                while($line=fgets($f)){
                    if(preg_match('/HTTP\/1\.1\s([0-9]{3})/',$line,$code)){
                        $code = isset($code[1]) ? (int)$code[1] : -1;
                        return $code==200 || $code==302;
                    }
                }
                fclose($f);
            }
        }//in_array
    }
    if(function_exists('stream_get_contents') && @$stream=fopen($url,'r')){
        $response = stream_get_contents($stream,1);
        fclose($stream);
        return $response!==FALSE;
    }
    return @file_get_contents($url)!==FALSE;
}
*/

function recursive_mkdir($path, $mode = 0777)
{
    $dirs = explode(DIRECTORY_SEPARATOR , $path);
    if (substr($dirs[0], strlen($dirs[0])-1, 1) == ':') array_shift($dirs); //Patch for Windows paths
    $count = count($dirs);

    $path = '';
    for ($i = 0; $i < $count; ++$i) {
        $path .= DIRECTORY_SEPARATOR . $dirs[$i];
        if (!is_dir($path) && !mkdir($path, $mode)) {
            return false;
        }
    }
    return true;
}

function safe_put_contents($filename, $data, $flags = 0){
    if (!recursive_mkdir(dirname($filename))) return false;
    return file_put_contents($filename, $data, $flags) !== false;
}

function is_link_absolute($link){
    return preg_match('~^(https?:)?//~', $link) ? true : false;
}
function is_link_external($link){
    return is_link_absolute($link) && !preg_match("~^(https?:)?//{$_SERVER['HTTP_HOST']}~", $link) ? true : false;
}

function getThemedComponentFile($module, $type, $file){
    $tail = $module.DS.$type.DS.str_replace('/', DS, $file);
    //NB: only controllers are allowed to override, no model or struct can be overriden!
    $allowOverride = (
        ($type = 'models')
        && ($type != 'structs')
    );
    if ($allowOverride && is_file($fname = THEMESPATH.rad_loader::getCurrentTheme().DS.$tail))
        return $fname;
    if (is_file($fname = COMPONENTSPATH.$tail))
        return $fname;
    return false;
}

//Register forst autoload function
spl_autoload_register('_autoload');
spl_autoload_unregister('_autoloadFinal');

if (!function_exists('mb_ucfirst') && function_exists('mb_substr')) {
    function mb_ucfirst($string) {
        $string = mb_ereg_replace("^[\ ]+","", $string);
        $string = mb_strtoupper(mb_substr($string, 0, 1, "UTF-8"), "UTF-8").mb_substr($string, 1, mb_strlen($string), "UTF-8" );
        return $string;
    }
}