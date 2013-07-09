<?php
/**
 * Class for update the system or component
 *
 * @author Denys Yackushev
 * @package RADCMS
 */

final class rad_update extends rad_singleton
{
    /**
     * Versions of system components
     * @var mixed - versions of different system components
     * @example:
     * array(
     *     'system': array (
     *         'version': 0.22
     *         'date': 1298149200
     *         'files': rad_files Object
     *     ),
     *     'controller': rad_files Object
     * )
     */
    private $_versions = null;

    private $_defaultVersion = '0.23';

    /**
     * Url to check updates
     * @var string url
     */
    private $_url = 'http://update.taberna.com';

    /**
     * Updates list from remote server
     * @var mixed
     */
    private $_rupdates = array();

    protected function __construct()
    {
        $this->_loadVersions();
    }

    /**
     * Sets the update url string
     * @param string $url - must be valid url with method (via http://)
     * @return rad_update
     */
    public function setUrl($url)
    {
        if(filter_var($url, FILTER_VALIDATE_URL)) {
            $this->_url = $url;
        } else {
            throw new rad_exception('Wrong url: "'.$url.'"');
        }
        return $this;
    }

    /**
     * Return singleton class rad_update exemplar
     * @return rad_update
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    private function _loadVersions()
    {
        if(is_file(LIBPATH.'sys.ver.json')) {
            try {
                $ver = json_decode( file_get_contents(LIBPATH.'sys.ver.json') );
            } catch (Exception $e) {
                throw new rad_exception('Wrong file format: "'.LIBPATH.'sys.ver.json" !');
            }
            $this->_versions = array(
                'system' => (array)$ver->system
            );
        } else {
            try {
                $sys_ver = new stdClass();
                $sys_ver->system = new stdClass();
                $sys_ver->system->version = $this->_defaultVersion;
                $sys_ver->system->date = 1324460685;
                safe_put_contents(LIBPATH.'sys.ver.json', json_encode($sys_ver));
                $this->_versions = array(
                    'system' => (array)$sys_ver->system
                );
            } catch (Exception $e) {
                throw new rad_exception($e->getMessage());
            }
        }
    }

    /**
     *
     * @return mixed
     * @see rad_update::$_versions
     */
    public function getVersions()
    {
        return $this->_versions;
    }

    /**
     * Gets the current version of the system
     * @return float
     */
    public function getCurrentVersion()
    {
        static $_currVersion = null;
        if(!$_currVersion) {
            $_currVersion = $this->_versions['system']['version'];
        }
        return $_currVersion;
    }

    private function _getURL($url, $post=array(), $method='POST')
    {
        foreach($post as $key=>$value) {
            if(is_array($value)) {
                foreach($value as $pdK=>$pdV) {
                    $postdataOK[$key.'['.$pdK.']'] = $pdV;
                }
            } else {
                $postdataOK[$key] = $value;
            }
        }
        
        $context = stream_context_create( array(
            'http' => array(
                'method' => $method, 
                'content' => http_build_query($postdataOK),
                'header'=>"Content-type: application/x-www-form-urlencoded\r\n"
            ))
        );
        $postResult = file_get_contents($url, false, $context);
        return $postResult;
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
        
        $root='';
        foreach(explode(DIRECTORY_SEPARATOR,$dirname) as $cat){
            $root.=$cat.DIRECTORY_SEPARATOR;

            if(!file_exists($root)){
                $old = umask(0);
                mkdir(/*rad_config::getParam('rootPath').*/$root, $mode, true);
                chmod(/*rad_config::getParam('rootPath').*/$root, $mode);
                umask($old);
            }
        }
    }

    /**
     * Makes the file in File System and write the $filestring into it
     * Method is binary-safe
     * @param string $filename
     * @param binary-safe string $filestring
     * @param integer $mode
     * @access public
     */
    public function mkFile($filename, $filestring, $mode='0770')
    {
        if(!is_dir(dirname($filename))) {
            $this->mkDir(dirname($filename));
        }
        safe_put_contents($filename, $filestring);
        /*@chmod($filename, $mode);*/
    }

    /**
     * Check the system for avaliable updates
     * @return boolean
     */
    public function checkUpdates()
    {
        $response = $this->_getURL($this->_url, array('action'=>'check', 'version'=>$this->_versions['system']['version']));
        if($response!='null') {
            $this->_rupdates = json_decode($response);
            return true;
        }
        return false;
    }

    /**
     * Gets the updates list after checkUpdates function
     * @return mixed
     */
    public function getUpdatesList()
    {
        return $this->_rupdates;
    }

    /**
     * Install the file
     * @param string $filename - specified filename with @CONSTANT@ without root start path to RADCMS
     * @param float $version
     */
    public function installFile($filename, $version)
    {
        $fileContent = $this->_getURL($this->_url, array('action'=>'getfile', 'version'=>$version, 'filename'=>$filename));
        if(strlen($fileContent)) {
            $search = array('@LIBPATH@', '@COMPONENTSPATH@', '@THEMESPATH@', '@SMARTYPATH@', '@ROOTPATH@');
            $replace = array( LIBPATH,     COMPONENTSPATH,     THEMESPATH,     SMARTYPATH, rad_config::getParam('rootPath'));
            $fullFileName = str_replace($search, $replace, $filename);
            $this->mkFile($fullFileName, $fileContent, 0777);
        } else {
            throw new rad_exception('File "'.$filename.'" with version "'.$version.'" is empty');
        }
    }

    /**
     * Ovveride the current version
     * @param string $ver
     * @return boolean - if system version is exists and ovverride is succersfull
     */
    public function setCurrentVersion($ver)
    {
        if(!empty($this->_versions['system']['version'])) {
            $this->_versions['system']['version'] = $ver;
            return true;
        }
        return false;
    }

    /**
     * Executes the SQL with vars
     * @param string $sql
     * @param mixed $vars
     * @example
     * rad_update::execSQL('INSERT INTO @RAD@settings(fldName, fldValue, position, description, rtype, defValue)VALUES("test", "test",100,"description","modules","@value@")', array('value'=>'defValue'));
     * @return rad_update
     */
    public function execSQL($sql, $vars=null)
    {
        if(!empty($vars) and is_array($vars)) {
            foreach($vars as $key=>$value) {
                if(is_scalar($value)) {
                    $sql = str_replace('@'.$key.'@', $value , $sql);
                }
            }
        }
        echo $sql."\r\n";
        rad_dbpdo::exec($sql);
        if((int)rad_dbpdo::errorCode()) {
            echo "\r\n".(int)rad_dbpdo::errorCode();
            print_r(rad_dbpdo::errorInfo());
            echo "\r\n";
        }
        return $this;
    }

}
