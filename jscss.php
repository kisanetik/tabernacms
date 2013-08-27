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
 * This file needed for including and caching JS and CSS files (from other JS scripts in major -
 * templates should use {url} tag).
 * @param f = filename
 * @param m = module name (sample: corecatalog)
 * @param t = 'js' or 'css' type
 * @author Alex Ryazanov
 */

$filename = urldecode($_GET['f']);
$module = urldecode($_GET['m']);
$type = urldecode($_GET['t']);

$errorMsgs = array();

if (empty($type) || ($type != 'js' && $type != 'css')) {
    errorMsg('Wrong reference type!');
}
if (empty($module)) {
    errorMsg('Module name is not set!');
}
if (!preg_match('/^[a-zA-Z][a-zA-Z0-9]{2,31}$/', $module)) {
    errorMsg('Module name is incorrect!');
}
if (empty($filename)) {
    errorMsg('File name is not set!');
}
if (!preg_match('~^[a-zA-Z0-9][-_.a-zA-Z0-9]*(?:/[a-zA-Z0-9][-_.a-zA-Z0-9]*)*\.(?:js|css)$~i', $filename)) {
    errorMsg('File name is incorrect!');
}

$theme_name = rad_themer::getCurrentTheme();

$cachedFile = $config['rootPath'].'cache'.DS.$type.DS.$theme_name.DS.$module.DS.$filename;
$cachedPath = dirname($cachedFile);
if (!recursive_mkdir($cachedPath, 0777)) {
    errorMsg('Can not create dir! Path: {$cachedPath}');
}
if (!file_exists($cachedFile) || (time() - filemtime($cachedFile) >= (int)$config['cache.power.time'])) {
    $originalFile = rad_themer::getFilePath($theme_name, 'jscss', $module, $filename);
    if (!$originalFile) {
        errorMsg('File does not exist!');
    }
    try {
        rad_jscss::copyToCache($originalFile, $cachedFile);
    } catch (Exception $e) {
        errorMsg("Could not copy file {$originalFile} to {$cachedFile}");
    }
}
if (!@readfile($cachedFile)) {
    errorMsg("Error reading {$cachedFile}");
}

function errorMsg($msg = null)
{
    header('HTTP/1.0 404 Not Found');
    if($GLOBALS['config']['debug.showErrors']) {
        if(!empty($msg)) {
            print $msg;
            ob_flush();
            flush();
        }
    }
    die();
}
