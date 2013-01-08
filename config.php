<?php
include_once('config.db.php');
/**
 * <ru>Сокращение константы, путем простого создания алиаса</ru>
 * <en>Make shor alias for constant DIRECTORY_SEPARATOR</en>
 */
define('DS', DIRECTORY_SEPARATOR);
//generate paths
/**
 * <ru>Путь заканчивающийся слешем к папке с файлом конфигурации, принимается за главный путь к файлам</ru>
 * <en>root path to filder with start files and config, which ends with a slash </en>
 * @var string
 */
$config['rootPath'] = dirname(str_replace("////",DS,__FILE__)).DS;
$config['rootPathInclude'] = $config['rootPath'];
/**
 * <en>Uploaded files path for WYSYWIG eitor</en>
 * <ru>Путь для загрузки файлов для WYSYWIG редактора</ru>
 * @var unknown_type
 */
$config['uploadImgPath'] = $config['rootPath'].'img'.DS.'uploaded'.DS;
/**
 * <en>If site is not in root domain, like http://site.com/folder/</en>
 * <ru>Если сайт находится не в корнедомена, пример: http://site.com/folder/</ru>
 * @var string
 */
$config['folder'] = '';
$config['hostname'] = $_SERVER['HTTP_HOST'];
/**
 * <en>For SITE_URL constant</en>
 * <ru>Для константы SITE_URL</ru>
 * @var string
 */
$config['url'] = 'http://'.$config['hostname'].'/'.$config['folder'];

//sessionvalues
//default cookiename and expire time
$config['CookieName'] = 'taberna';
$config['CookieExpireTime'] = 86400;
//Delete the session values when user is loggedout??? 1-Yes,0-No
$config['DeleteSessVarsIfLogout']=1;
//aliases
$config['defaultAlias']='index.html';
$config['mainAlias']='index.html';
//pages
$config['defaultTemplate']='';
$config['defaultAlias']='index.html';
$config['alias.404']='404.html';
$config['alias.access_denited']='accessdenited.html';
$config['alias.loginform']='login';
$config['alias.siteloginform']='login.html';
$config['header.404'] = 'HTTP/1.1 404';
//Folders
/*
//LibPath
$config['folders']['MAINLIBPATH']             = $config['rootPathInclude'].'..'.DS.'base.radcms.svn'.DS;
$config['folders']['SYSTEMTEMPLATESPATH']     = $config['folders']['MAINLIBPATH'].'templates'.DS;
$config['folders']['SYSTEMMICROSPATH']        = $config['folders']['MAINLIBPATH'].'templates'.DS.'micros'.DS;
$config['folders']['SYSTEMMAINTEMPLATESPATH'] = $config['folders']['MAINLIBPATH'].'templates'.DS.'maintemplates'.DS;
$config['folders']['SYSTEMCONTROLLERPATH']    = $config['folders']['MAINLIBPATH'].'controller'.DS;
$config['folders']['SYSTEMMODELSPATH']        = $config['folders']['MAINLIBPATH'].'models'.DS;
$config['folders']['SYSTEMSTRUCTSPATH']       = $config['folders']['MAINLIBPATH'].'structs'.DS;
*/
$config['folders']['LIBPATH']                 = $config['rootPathInclude'].'lib'.DS;
$config['folders']['STRUCTSPATH']             = $config['rootPathInclude'].'structs'.DS;
$config['folders']['CONTROLLERPATH']          = $config['rootPathInclude'].'controller'.DS;
$config['folders']['MODELSPATH']              = $config['rootPathInclude'].'models'.DS;

$config['folders']['MICROSPATH']              = $config['rootPath'].'templates'.DS.'micros'.DS;
$config['folders']['MAINTEMPLATESPATH']       = $config['rootPath'].'templates'.DS.'maintemplates'.DS;
$config['folders']['THEMESPATH']              = $config['rootPath'].'templates'.DS.'themes'.DS;
$config['folders']['TEMPLATESPATH']           = $config['rootPath'].'templates'.DS;
$config['folders']['PLUGINSPATH']             = $config['folders']['LIBPATH'];
$config['folders']['SMARTYPATH']              = $config['folders']['LIBPATH'].'smarty'.DS.'libs'.DS;

$config['folders']['THEMECONTROLLERPATH']     = $config['folders']['THEMESPATH'];

$config['folders']['SMARTYCOMPILEPATH']       = $config['rootPath'].'compiled'.DS;
$config['folders']['SMARTYCACHEPATH']         = $config['rootPath'].'cached'.DS;
$config['folders']['NEWSORIGINALPATCH']       = $config['rootPath'].'img'.DS.'news'.DS.'original'.DS;
$config['folders']['NEWSRESIZEDPATCH']        = $config['rootPath'].'img'.DS.'news'.DS.'resized'.DS;
$config['folders']['PAGESORIGINALPATCH']      = $config['rootPath'].'img'.DS.'pages'.DS.'original'.DS;
$config['folders']['PAGESRESIZEDPATCH']       = $config['rootPath'].'img'.DS.'pages'.DS.'resized'.DS;
$config['folders']['ARTICLESORIGINALPATCH']   = $config['rootPath'].'img'.DS.'articles'.DS.'original'.DS;
$config['folders']['ARTICLESRESIZEDPATCH']    = $config['rootPath'].'img'.DS.'articles'.DS.'resized'.DS;
$config['folders']['MENUORIGINALPATCH']       = $config['rootPath'].'img'.DS.'menu'.DS.'original'.DS;
$config['folders']['MENURESIZEDPATCH']        = $config['rootPath'].'img'.DS.'menu'.DS.'resized'.DS;
$config['folders']['LANGORIGINALPATCH']       = $config['rootPath'].'img'.DS.'lang'.DS.'original'.DS;
$config['folders']['LANGRESIZEDPATCH']        = $config['rootPath'].'img'.DS.'lang'.DS.'resized'.DS;
$config['folders']['CATALOGORIGINALPATCH']    = $config['rootPath'].'img'.DS.'catalog'.DS.'original'.DS;
$config['folders']['CATALOGRESIZEDPATCH']     = $config['rootPath'].'img'.DS.'catalog'.DS.'resized'.DS;
$config['folders']['DOWNLOAD_FILES']          = $config['url'].'dfiles/';
$config['folders']['DOWNLOAD_FILES_DIR']      = $config['rootPath'].'dfiles'.DS;
$config['folders']['MAILTEMPLATESPATH']       = $config['rootPath'].'templates'.DS.'mail'.DS;

//loader name
$config['loader_class'] = 'rad_sloader';

//Ext loader associations
$config['loader_associations']['php'] = 'ext_phploader';
//log settings
$config['log_file'] = $config['rootPath'].'log.txt';
//datetime format in php
$config['datetime.format'] = 'Y-m-d H:i:s';
$config['date.format'] = 'Y-m-d';
$config['datecalt'] = '';
//Smarty datetime formats
$config['smarty.date_format']['en'] = '%B %d, %Y';
$config['smarty.date_format']['ru'] = '%d %B %Y';
$config['smarty.date_format']['ua'] = '%d %B %Y';
$config['smarty.datecal_format']['en'] = '%Y-%m-%d';
$config['smarty.datecal_format']['ru'] = '%d-%m-%Y';
$config['smarty.datecal_format']['ua'] = '%d-%m-%Y';
$config['smarty.datecalt_format']['en'] = '%d-%m-%Y %H:%M';
$config['smarty.datecalt_format']['ru'] = '%d-%m-%Y %H:%M';
$config['smarty.datecalt_format']['ua'] = '%d-%m-%Y %H:%M';
$config['smarty.time_format']['en'] = '%H:%M';
$config['smarty.time_format']['ru'] = '%H:%M';
$config['smarty.time_format']['ua'] = '%H:%M';
$config['smarty.datetime_format']['en'] = '%B %d, %Y %H:%M';
$config['smarty.datetime_format']['ru'] = '%d %B %Y %H:%M';
$config['smarty.datetime_format']['ua'] = '%d %B %Y %H:%M';
$config['smarty.smonth_format']['en'] = '%B';
$config['smarty.smonth_format']['ru'] = '%B';
$config['smarty.smonth_format']['ua'] = '%B';
$config['smarty.nyear_format']['en'] = '%Y';
$config['smarty.nyear_format']['ru'] = '%Y';
$config['smarty.nyear_format']['ua'] = '%Y';

//Smarty options
$config['smarty.compile_check'] = true;
$config['smarty.debugging'] = false;
$config['smarty.caching'] = false;

//Development options
//Redirect Secutity Hole Alert ? if empty, shows SHA, if not - go to the setted alias (usually $config['alias.404'])
$config['debug.showErrors'] = true;
$config['debug.reportingLevel'] = E_ALL;//http://ru.php.net/manual/en/errorfunc.configuration.php#ini.error-reporting
$config['debug.redirectSHA'] = '';

//Language options
$config['lang.class_name'] = 'lang';
//show language at location (example.com/en/alias_name/paramname/) ?
$config['lang.location_show'] = true;

// CACHE OPTIONS
//  $config['lang.caching'] = false;
$config['lang.caching'] = true;
//Store unfinded translates, for download it from main site in managing languages module
$config['lang.cacheunfinded'] = true;
//$config['lang.default'] = 'en';
$config['lang.default'] = 'ru';
$config['lang.cacheDir'] = $config['rootPath'].'cached'.DS;
$config['cache_class'] = 'rad_cache_loader';
$config['cache.use_global_page_caching'] = false;
$config['cache.cacheDir'] = $config['rootPath'].'cached'.DS;
//$config['cache.data_driver'] = 'rad_driver_data_files';
$config['cache.data_driver'] = 'rad_driver_data_memcache';
$config['cache.power'] = true;//if true, the caching is on and works!!!
$config['cache.power.dir'] = $config['lang.cacheDir'];
$config['cache.power.time'] = 3600;
//MEMCACHE OPTIONS - in development for now
$config['cache.memcache.port'] = '11211';
$config['cache.memcache.host'] = '127.0.0.1';
$config['cache.memcache.compression'] = 0;
$config['cache.memcache.expire'] = 86400;

//REGISTRATION SETTINGS
//Mail template for user registration
$config['registration.template'] = 'register.tpl';
//Mail template for action after user registered
$config['registration.after_template'] = 'register_after_thainks.tpl';
//Mail template for admin when user is registered
$config['registration.admin_notify_template'] = 'register_admin_notify.tpl';
//Lang code when activation code not found
$config['registration.code_not_found'] = 'mail_code_not_found.registration.text';
//Lang code when e-mail code is succersfly activated
$config['registration.mailactivated_text'] = 'mailactivated.registration.text';
//Lang code when user is already registered in system
$config['registration.mail_already_registred_text'] = 'mail_alreadyregistred.registration.text';
//Lang code for action when e-mail is sended for user with activation code
$config['registration.mail_regsended_text'] = 'mail_sended.registration.text';
//New post in feedback
$config['feedback.template'] = 'feedback.tpl';
//Mail template for action when need to remember password
$config['remind_password.template'] = 'remind_password.tpl';
//Mail template for new password when need to remember password
$config['new_password.template'] = 'new_password.tpl';
//Mail template for admin when add a new commen
$config['comments.new_comment'] = 'new_comment.tpl';

/*** REFERALS SETTINGS ***/
$config['referals.on'] = true;
$config['referals.cookieName'] = 'sRefCoockieName';
/* percents for partners from order */
$config['referals.percent'] = '5';

//CATALOG SETTINGS
//When quick order try to send - this is mail templates
$config['catalog.new_order'] = 'order_new.tpl';
$config['catalog.new_auth_order'] = 'order_new_auth.tpl';
$config['catalog.new_order_text'] = 'order_new.text';
$config['catalog.new_auth_order_text'] = 'order_new_auth.text';


//Themes
$config['theme.default'] = '';

//breadcrumbs module
$config['bc.title'] = 'RAD_BC_TITLE';
$config['bc.meta_description'] = 'RAD_BC_METADESCRIPTION';
$config['bc.meta_tags'] = 'RAD_BC_METATAGS';
$config['bc.breadcrumbs'] = 'RAD_BC_BREADCRUMBS';

//currency options
$config['currency.precision'] = 2;

//Settings
//$config['page.defaultTitle'] = ' Интернет-магазин хороших и полезных вещей "Taberna-Shop"';
$config['page.defaultTitle'] = 'Your internet shop with "Taberna-Shop"';
//administrator e-mail: to mail of notifications
$config['admin.mail'] = 'admin@example.com';
//system e-mail, to send from send e-mail
$config['system.mail'] = 'no-reply@example.com';