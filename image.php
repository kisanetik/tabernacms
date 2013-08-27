<?php
require_once('config.php');
//TODO: remove after moving all config stuff to a separate class
foreach ($config['db_delimiters'] as $id => $value) {
    define($id, $value);
}
foreach ($config['folders'] as $id => $value) {
    define($id, $value);
}
define('SITE_URL', $config['url']);
require LIBPATH.'simplefunctions.php';

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

$theme_name = rad_themer::getCurrentTheme();
$originalFile = rad_themer::getFilePath($theme_name, 'img', $module, $filename);
if (!$originalFile) {
    errorMsg("File does not exist!");
}

$resizedFile = $config['rootPath'].'cache'.DS.'img'.DS.$theme_name.DS.$module.DS.$preset.DS.$filename;
$resizedPath = dirname($resizedFile);
if(!recursive_mkdir($resizedPath, 0777)) {
    errorMsg("Can not create dir! Path: {$resizedPath}");
}
if (!file_exists($resizedFile) || (time() - filemtime($resizedFile) >= (int)$config['cache.power.time'])) {
    $img = new rad_gd_image();
    if($img->set($originalFile, $resizedFile, $preset)) {
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

function errorMsg( $msg = null )
{
    header("HTTP/1.0 404 Not Found");
    if($GLOBALS['config']['debug.showErrors']) {
        if (!empty($msg)) {
            print $msg;
            ob_flush();
            flush();
        }
    }
    die();
}
