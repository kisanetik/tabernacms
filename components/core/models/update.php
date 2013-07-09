<?php
/**
 * System update
 * @author Denys Yackushev
 * @package RADCMS
 */
class model_core_update extends rad_model
{
    /**
     * Gets the url with params
     * @param string $url - URL string
     * @param array $post - $_POST data
     * @param string $method - Allow GET or POST method
     * @access public
     * @return string content - binary save
     */
    function getURL($url, $post=array(), $method='POST')
    {
        $context = stream_context_create( array(
            'http' => array(
                'method' => $method, 
                'content' => http_build_query(
                        array_merge_recursive( array(
                            'server'=>$_SERVER
                            ), 
                            $post)
                        ),
                'header'=>"Content-type: application/x-www-form-urlencoded\r\n"
            ))
        );
        $b = file_get_contents($url, false, $context);
        return $b;
    }

    /**
     * Creates only recursivelly path with mode=0777
     * @param string $dirname
     * @access public
     */
    public function createRecursDirectory($dirname)
    {
        $path_up = explode(DIRECTORY_SEPARATOR, $dirname);
        array_pop($path_up);
        $path_up = implode(DIRECTORY_SEPARATOR, $path_up);
        if(!file_exists($path_up))
            $this->createRecursDirectory($path_up);
        $old = umask(0);
        mkdir($dirname, 0777, true);
        chmod($dirname, 0777);
        umask($old);
    }

    /**
     * Makes the file in File System and write the $filestring into it
     * Method is binary-safe
     * @param string $filename
     * @param binary-safe string $filestring
     * @param integer $mode
     * @access public
     */
    public function mkFile($filename, $filestring, $mode=0777)
    {
        safe_put_contents($filename, $filestring);
        @chmod($filename, $mode);
    }

    /**
     * Makes the directory
     * @param string $dirname
     * @param integer $mode
     */
    public function mkDir($dirname, $mode=0777)
    {
        $dirname = str_replace('\\',DIRECTORY_SEPARATOR, $dirname);
        $dirname = str_replace('/',DIRECTORY_SEPARATOR, $dirname);
        if(!file_exists($dirname)){
            $old = umask(0);
            mkdir($this->config('rootPath').$dirname, $mode, true);
            chmod($this->config('rootPath').$dirname, $mode);
            umask($old);
        }
    }

    /**
     * Executes the SQL string
     * @param string $sql
     * @return integer - number of updated\inserted rows
     */
    public function execSQLi($sql)
    {
        $return = $this->exec($sql);
        if((int)$this->getPDO()->errorCode()) {
            echo print_h($this->getPDO()->errorInfo(), true);
        }
        return $return;
    }
}