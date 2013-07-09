<?php
require_once('config.php');
require_once($config['folders']['LIBPATH'].'class.jscss.php');

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
else {
    try{
        $db_config = $config['db_config'];
        $dbc = new PDO($db_config['db_server'].':host='.$db_config['db_hostname'].';port='.$db_config['db_port'].';dbname='.$db_config['db_databasename'],$db_config['db_username'],$db_config['db_password'],null);
        $dbc->exec($config['setNames']);
        $rq = $dbc->query("SELECT `fldValue` FROM `rad_settings` WHERE `fldName` = 'theme.default' LIMIT 1");
        if ($rq) {
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

$cachedFile = $config['rootPath'].'cache'.DS.$type.DS.$theme_name.DS.$module.DS.$type.DS.$filename;
$cachedPath = dirname($cachedFile);
if (!recursive_mkdir($cachedPath, 0777)) {
    errorMsg('Can not create dir! Path: {$cachedPath}');
}
if (!file_exists($cachedFile) || (time() - filemtime($cachedFile) >= (int)$config['cache.power.time'])) {
    $originalFile = $config['folders']['THEMESPATH'].$theme_name.DS.$module.DS.'jscss'.DS.$filename;
    if (!file_exists($originalFile)) {
        $originalFile = $config['folders']['COMPONENTSPATH'].$module.DS.'jscss'.DS.$filename;
    }
    if (!file_exists($originalFile)) {
        errorMsg('File does not exist!');
    }
    copy($originalFile, $cachedFile);
}
readfile($cachedFile);

function errorMsg($msg = null)
{
    header('HTTP/1.0 404 Not Found');
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
