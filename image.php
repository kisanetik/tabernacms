<?php
/**
 * This file needed for showing te picturies and resize its
 * @param w = width of image
 * @param h = height of image
 * @param f = filename
 * @param r = need to recreate the image
 * @param m = module name (sample: catalog)
 * @author Denys Yackushev
 * @deprecated 16 january 2009
 */
include_once('config.php');
// error_reporting(E_ALL);
$file = str_replace('../', '', $_GET['f']);
$module = urldecode( strtoupper($_GET['m']) );

if(strstr($module,'..') or $module[0]=='/' or $module[0]=='\\' or strstr($module,'http') or strstr($module,':') or strstr($module,'@') or $file[0]=='/'){
    die('OUT OF HERE!!!!! Try to hack another site please! Ну пожалуйста... а с меня конфетка на твое мыло ;)');
}
$originalFile = $config['folders'][$module.'ORIGINALPATCH'].$file;
if(file_exists($originalFile)){
    $width = $_GET['w'];
    $height = $_GET['h'];
    $recreate = false;
    if(isset($_GET['r']) and $_GET['r']=='1')
        $recreate = true;
    if ($recreate) {
    } else {
        $resizedFile = $config['folders'][$module.'RESIZEDPATCH'].$width.'_'.$height.'_'.$file;
        if (!file_exists( $resizedFile )) {
            createFile(
                $originalFile,
                $resizedFile,
                $width,
                $height,
                $module
            );
        }
 	switch(strtolower(fileext($config['url'].str_replace($config['rootPath'],'',$config['folders'][$module.'RESIZEDPATCH']).$width.'_'.$height.'_'.$file))) {
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
        }//switch
        readfile($resizedFile);
    }//no recreate from get
} else {
    header("HTTP/1.0 404 Not Found");
    exit;
}

 /**
  * Return file extension
  *
  * @param string $filename
  * @return string
  */
 function fileext($filename)
 {
     return substr(strrchr(basename($filename),"."),1);
 }

 /**
  * Resize and save the image
  *
  * @param string  $fn - filename
  * @param string  $new_fn - new filename
  * @param integer $w - width
  * @param integer $h - height
  * @param string  $m - modulename
  */
function createFile($fn,$new_fn,$w,$h,$m)
{
    global $config;
    include_once($config['folders']['LIBPATH'].'class.gd_image.php');
    include_once('image_config.php');
    if(isset($image_config[$m]['text']) and strlen($image_config[$m]['text'])){
    }else{
        $img = new rad_gd_image();
        $img->set($fn,$new_fn);
        $img->resize($w,$h,fileext($fn));
        return $img->getError();
    }
}