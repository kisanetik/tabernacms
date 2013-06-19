<?php
function delSVN($dir,$all=false)
{
    $d = dir($dir);
    while (false !== ($entry = $d->read())) {
        if( $entry!='.' and $entry!='..' ){
            if( is_dir($dir.DIRECTORY_SEPARATOR.$entry) ){
	            if($entry=='.svn'){
	                delSVN($dir.DIRECTORY_SEPARATOR.$entry,true);
	                echo 'rmdir: '.$dir.DIRECTORY_SEPARATOR.$entry;
	                rmdir($dir.DIRECTORY_SEPARATOR.$entry);
	            }else{
	                delSVN($dir.DIRECTORY_SEPARATOR.$entry,$all);
	                if($all){
	                   echo 'rmdir: '.$dir.DIRECTORY_SEPARATOR.$entry;
	                   rmdir($dir.DIRECTORY_SEPARATOR.$entry);
	                }
	            }
            }elseif($all){//file
                echo 'unlink: '.$dir.DIRECTORY_SEPARATOR.$entry.'<br />'; 
                unlink($dir.DIRECTORY_SEPARATOR.$entry);
            }
        }
    }
    $d->close();
}

delSVN(dirname(__FILE__));