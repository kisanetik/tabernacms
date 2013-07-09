<?php
header('Content-type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (file_exists('install/test_connect.php')) {
    if (include 'install/test_connect.php') {
        echo '<p style="color:red;">Вам необходимо удалить папку "install"</p>';
    } else {
        header('Location: install/');
    }
    exit;
}

$mem = memory_get_usage();
require 'config.php';
foreach ($config['db_delimiters'] as $id => $value) {
    define($id, $value);
}
foreach ($config['folders'] as $id => $value) {
    define($id, $value);
}
define('SITE_URL', $config['url']);
require $config['folders']['LIBPATH'].'simplefunctions.php';
$time_start = microtime_float();
foreach ($config as $id => $value) {
    if (!is_array($value))
        rad_config::setParam($id, $value);
}
rad_config::loadConfig();
rad_exception::setHandlers();
rad_input::init_all();
rad_session::start();
define( 'SITE_ALIAS', rad_input::get('alias', rad_config::getParam('defaultAlias', 'index.html')) );
rad_lang::init();
call_user_func(array(rad_config::getParam('loader_class'),'init'));
if(rad_config::getParam('lang.caching')) {
    call_user_func(array(rad_config::getParam('loader_class'),'saveLangCache'));
}
/*
$time_end = microtime_float();
$time = $time_end - $time_start;
*/