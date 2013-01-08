<?php
/*
 * Simple logger to DB
 * @datecreated 25 june 2008
 * @author Denys Yackushev
 * @package RADCMS
 */

 class rad_dblogger
 {

     /**
      * Simple log now text in param to DB table, also record in table time and other data
      * @param string text
      */
     public static function logerr($text)
     {
         if(rad_config::getParam('logger.loginDB',false)){
             $flush = rad_input::getFlushInput();
             //die(rad_config::getParam('loader_class'));
             $flush['input'] = call_user_func(array(rad_config::getParam('loader_class'),'getFlushData'));
             $flush = serialize($flush);
             $flush = str_replace('"','\\"',$flush);
            rad_dbpdo::exec('insert into '.RAD.'logger(dt,flush,`text`)values(now(),"'.$flush.'","'.$text.'")');
         }
     }

    /**
     * Simple log now text in param to txt file, just text
     */
     public static function logerr2txt($text)
     {
        $h = fopen(rad_config::getParam('log_file'),'a');
        fwrite($h,'['.now().']:'."\t".$text."\r\n");
        fclose($h);
     }
 }