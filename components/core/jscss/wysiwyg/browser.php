<?php
include_once('../../../config.php');
foreach ($config['db_delimiters'] as $id => $value) {
    define($id, $value);
}
foreach ($config['folders'] as $id => $value) {
    define($id, $value);
}
define('SITE_URL', $config['url']);
include_once($config['folders']['LIBPATH'].'simplefunctions.php');
foreach ($config as $id => $value) {
    if (!is_array($value))
        rad_config::setParam($id, $value);
}
rad_config::loadConfig();
//rad_input::init_all();
rad_session::start();

if (rad_session::$user->u_id && rad_session::$user->is_admin) {
    include_once('./class.file_browser.php');

    $browser = new WysiwygFileBrowser();
    $browser->process();
} else {
    header('Location: '.SITE_URL);
}