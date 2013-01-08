<?php
//error_reporting(E_NONE);
error_reporting(E_ALL);
ini_set('display_errors', 0); 
header('Content-type: text/html; charset=UTF-8');
$tmp = explode('/', $_REQUEST['request']);
include_once 'config.php';
if(trim($tmp[0])=='dfiles' and isset($tmp[2])){
	if( isset($tmp[3]) ) {
		$filename = $config['folders']['DOWNLOAD_FILES_DIR'].strtoupper($tmp[2]).DS.$tmp[1];
	} else {
		$filename = $config['folders']['DOWNLOAD_FILES_DIR'].$tmp[1];
	}
	$originalFilename = isset($tmp[3])?$tmp[3]:$tmp[2];
	if(is_file($filename)){
		header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
		header('Content-Type: application/octet-stream');
		header('Last-Modified: '.gmdate('r', filemtime( $filename )));
		header('ETag: '.sprintf('%x-%x-%x', fileinode( $filename ), filesize( $filename ), filemtime( $filename )));
		header('Content-Length: '.(filesize($filename)));
		header('Connection: close');
		header('Content-Disposition: attachment; filename="'.$originalFilename.'";');
		$f = fopen($filename, 'r');
		while(!feof($f)) {
			echo fread($f, 1024);
			flush();
		}
		fclose($f);
		die;
	}else{
		header('Location: '.$config['url'].'404.html');
	}
}else{
	header('Location: '.$config['url'].'404.html');
}
