<?php
/**
 * Base exception class for all system
 * exception class owwerides default system Exception
 * sets error and exception handlers ;-)
 * @package RADCMS
 *
 */
class rad_exception extends Exception
{
    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message, (int)$code);
    }

    public static function setHandlers()
    {
        self::setErrorHandler();
        self::setExceptionHandler();
        if(rad_config::getParam('debug.showErrors', true)) {
            ini_set('display_errors', 1);
            error_reporting(rad_config::getParam('debug.reportingLevel', E_ALL));
        } else {
            ini_set('display_errors', 0);
        }
    }

    public static function setErrorHandler()
    {
        set_error_handler(array('rad_exception', 'ErrorHandler'), E_ALL);
    }

    public static function setExceptionHandler()
    {
        set_exception_handler(array('rad_exception', 'ExceptionHandler'));
    }

    public static function ErrorHandler($errno, $errstr='',  $errfile='', $errline='', $errcontext='')
    {
        $errorType = array (
                 E_ERROR                => 'ERROR',
                 E_WARNING                => 'WARNING',
                 E_PARSE                => 'PARSING ERROR',
                 E_NOTICE                => 'NOTICE',
                 E_CORE_ERROR            => 'CORE ERROR',
                 E_CORE_WARNING            => 'CORE WARNING',
                 E_COMPILE_ERROR        => 'COMPILE ERROR',
                 E_COMPILE_WARNING        => 'COMPILE WARNING',
                 E_USER_ERROR            => 'USER ERROR',
                 E_USER_WARNING            => 'USER WARNING',
                 E_USER_NOTICE            => 'USER NOTICE',
                 E_STRICT                 => 'STRICT NOTICE',
                 E_RECOVERABLE_ERROR    => 'RECOVERABLE ERROR'
        );
        if(count($errcontext))
           $errcontext = count($errcontext).' entries';
        if (array_key_exists($errno, $errorType)) {
            $err = $errorType[$errno];
        } else {
            $err = 'CAUGHT EXCEPTION';
        }
        echo $err.'['.$errno.']: '.$errstr.' in file ['.$errfile.'] at line ['.$errline.'] context ['.$errcontext.']'."<hr>";
        if(rad_dbpdo::connected()) {
            rad_dblogger::logerr($err.'['.$errno.']: '.$errstr.' in file ['.$errfile.'] at line ['.$errline.'] context ['.$errcontext.']');
        } else {
            rad_dblogger::logerr2txt($err.'['.$errno.']: '.$errstr.' in file ['.$errfile.'] at line ['.$errline.'] context ['.$errcontext.']');
        }
    }

    public static function ExceptionHandler(Exception $e)
    {
        //TODO: remove trace output or allow in debug mode only
        die('<hr/><b>EXCEPTION:</b>[ '.$e->getMessage().' ]<hr/><pre>'.print_r($e->getTrace(), true).'</pre>');
    }

}