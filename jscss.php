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

if (!empty($_SERVER['HTTP_REFERER']) && preg_match('~^'.preg_quote($config['url']).'cache/(?:js|css)/([a-z0-9]+)/~i', $_SERVER['HTTP_REFERER'], $matches)) {
    $theme_name = $matches[1];
}
if (empty($theme_name) && !empty($_GET['th'])) {
    $theme_name = urldecode($_GET['th']);
    if (!rad_themer::themeExists($theme_name)) unset($theme_name);
}
if (empty($theme_name)) {
    try{
        $db_config = $config['db_config'];
        $dbc = new PDO($db_config['db_server'].':host='.$db_config['db_hostname'].';port='.$db_config['db_port'].';dbname='.$db_config['db_databasename'],$db_config['db_username'],$db_config['db_password'],null);
        $dbc->exec($config['setNames']);
        $rq = $dbc->query("SELECT `fldValue` FROM `rad_settings` WHERE `fldName` = 'theme.default' LIMIT 1");
        if ($rq) {
            $result = $rq->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($result)) {
                $theme_name = $result[0]['fldValue'];
            }
        }
    } catch(Exception $e){
        //Just suppress errors when DB connection is unavailable and try to get image anyway.
    }
}
if (empty($theme_name) && !empty($config['theme.default'])) {
    $theme_name = $config['theme.default'];
}
if (empty($theme_name)) {
    $theme_name = 'default';
}

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
