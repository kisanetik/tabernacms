<?php

require_once('config.php');
require_once($config['folders']['LIBPATH'].'class.gd_image.php');

/**
 * This file needed for showing te picturies and resize its
 * @param f = filename
 * @param m = module name (sample: corecatalog)
 * @param p = preset name from image config
 * @author Denys Yackushev
 * @author Tereshchenko Viacheslav
 */

$filename = urldecode($_GET['f']);
$module = urldecode($_GET['m']);
$preset = urldecode($_GET['p']);

$presetsList = include('image_config.php');

$errorMsgs = array();

if(empty($preset)) {
    errorMsg("preset is not set!");
}
if(!is_array($presetsList) or empty($presetsList[$preset])){
    errorMsg("preset does not exist!");
}

if(empty($module)) {
    errorMsg("Module name is not set!");
}
if(!preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,31}$/', $module)) {
    errorMsg("Module name is incorrect!");
}

if(empty($filename)) {
    errorMsg("File name is not set!");
}
if (!preg_match(
    '~^[a-zA-Z0-9][-_.a-zA-Z0-9]*(?:/[a-zA-Z0-9][-_.a-zA-Z0-9]*)*\.(?:jp(?:e?g|e|2)|gif|png|gd)$~i',
    $filename)
) { //filename is a correct image file name
    errorMsg("File name is incorrect!");
}

if (!empty($_SERVER['HTTP_REFERER']) && preg_match('~^'.preg_quote($config['url']).'cache/(?:js|css)/([a-z0-9]+)/~i', $_SERVER['HTTP_REFERER'], $matches)) {
    $theme_name = $matches[1];
}
else {
    try{
        $db_config = $config['db_config'];
        $dbc = new PDO($db_config['db_server'].':host='.$db_config['db_hostname'].';port='.$db_config['db_port'].';dbname='.$db_config['db_databasename'],$db_config['db_username'],$db_config['db_password'],null);
        $dbc->exec($config['setNames']);
        $rq = $dbc->query("SELECT `fldValue` FROM `rad_settings` WHERE `fldName` = 'theme.default' LIMIT 1");
        if($rq) {
            $result = $rq->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                $theme_name = $result[0]['fldValue'];
            } elseif (!empty($config['theme.default'])) {
                $theme_name = $config['theme.default'];
            }
        }
    } catch(Exception $e){
        //errorMsg($e->getMessage());
    }
}
if (empty($theme_name)) $theme_name = 'default';

$originalFile = $config['rootPath'].'themes'.DS.$theme_name.DS.$module.DS.'img'.DS.$filename;
if (!file_exists($originalFile)) {
    $originalFile = $config['rootPath'].'components'.DS.$module.DS.'img'.DS.$filename;
}
if(!file_exists($originalFile)) {
    errorMsg("File does not exist!");
}

$resizedFile = $config['rootPath'].'cache'.DS.'img'.DS.$theme_name.DS.$module.DS.$preset.DS.$filename;
$resizedPath = dirname($resizedFile);
if(!recursive_mkdir($resizedPath, 0777)) {
    errorMsg("Can not create dir! Path: {$resizedPath}");
}
if (!file_exists($resizedFile) || (time() - filemtime($resizedFile) >= (int)$config['cache.power.time'])) {
    $img = new rad_gd_image();
    if($img->set($originalFile, $resizedFile, $presetsList[$preset])) {
        $r = $img->resize();
        if(!$r) {
            errorMsg($img->getError());
        }
    } else {
        errorMsg($img->getError());
    }
}
switch(rad_gd_image::getFileExtension($resizedFile)) {
    case 'jpg':
    case 'jpeg':
    case 'jpe':
        header('Content-type: image/jpeg');
        break;

    case 'png':
        header('Content-type: image/png');
        break;

    case 'gif':
        header('Content-type: image/gif');
        break;

    case 'gd':
        header('Content-type: image/gd');
        break;
}
readfile($resizedFile);

function errorMsg($msg = null)
{
    header("HTTP/1.0 404 Not Found");
    if(!empty($msg)) {
        print $msg;
        ob_flush();
        flush();
    }
    die();
}

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
