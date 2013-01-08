<?php

/****************************************************************************/
/*                                                                          */
/* YOU MAY WISH TO MODIFY OR REMOVE THE FOLLOWING LINES WHICH SET DEFAULTS  */
/*                                                                          */
/****************************************************************************/

// Sets the default charset so that setCharset() is not needed elsewhere
Swift_Preferences::getInstance()->setCharset('utf-8');

// Without these lines the default caching mechanism is "array" but this uses a lot of memory.
// If possible, use a disk cache to enable attaching large attachments etc.
// You can override the default temporary directory by setting the TMPDIR environment variable.
if(!function_exists('upload_tmp_dir')) {
    function upload_tmp_dir()
    {
        if(is_writable(ini_get('upload_tmp_dir'))) {
            return ini_get('upload_tmp_dir');
        } else {
            return substr(rad_config::getParam('cache.cacheDir'), 0, -1);
        }
    }
}
if(function_exists('upload_tmp_dir') and is_writable(upload_tmp_dir())) {
    Swift_Preferences::getInstance()
    -> setTempDir(upload_tmp_dir())
    -> setCacheType('disk');
} elseif (function_exists('sys_get_temp_dir') && is_writable(sys_get_temp_dir())) {
    Swift_Preferences::getInstance()
        -> setTempDir(sys_get_temp_dir())
        -> setCacheType('disk');
}

Swift_Preferences::getInstance()->setQPDotEscape(false);
