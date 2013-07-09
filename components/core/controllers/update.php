<?php
/**
 * For system and components update
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_core_update extends rad_controller
{
    /**
     * Remote url address to access the updates
     * @var string url
     * @todo For future update.rad-cms.ru
     */
    private $_url = 'http://update.rad-cms.ru/';

    /**
     * Filename with system version
     * @var string
     */
    public $sysver_fn = 'sys.ver.json';

    function __construct()
    {
        $this->sysver_fn = LIBPATH.$this->sysver_fn;
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_url = $params->remoteurl;
            $this->setVar('params', $params);
        }
        if($this->request('action')) {
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->setVar('hash', $this->hash() );
                    break;
                case 'getavaliableupdates':
                    $this->getUpdatesList();
                    break;
                case 'installfile':
                    $this->installFile();
                    break;
                case 'installSQL':
                    $this->installSQL();
                    break;
                default:
                    $this->redirect('404');
                    /*
                    $this->header($this->config('header.404'));
                    $this->header('Location: '.SITE_URL.$this->config('alias.404'));
                     */
                    break;
            }//switch
        }
    }

    function getUpdatesList()
    {
        $update = rad_update::getInstance();
        $update->setUrl($this->_url);
        if($update->checkUpdates()) {
            $this->setVar('response', $update->getUpdatesList());
        }
    }

    function installFile()
    {
        $gf = trim($this->request('gf'));
        $ver = $this->request('version');
        if($gf AND $ver AND $this->request('hash')==$this->hash()){
            $update = rad_update::getInstance();
            $update->setUrl($this->_url);
            if($ver < $update->getCurrentVersion()) {
                $this->_cantDowngrade();
            }
            $fileContent = $update->installFile($gf, $ver);
        }else{
            $this->redirect('404');
        }
    }

    function installSQL()
    {
        $ver = $this->request('version');
        if($ver and $this->request('hash')==$this->hash()) {
            $update = rad_update::getInstance();
            $update->setUrl($this->_url);
            $update->setCurrentVersion($ver);
            if($update->checkUpdates()) {
                $response = $update->getUpdatesList();
                if(!empty($response->sql)) {
                    $vars = array('RAD'=>RAD);
                    foreach($response->sql as $sql) {
                        $update->execSQL($sql->sql, $vars);
                        if(!empty($sql->inserted_id)) {
                            $vars[$sql->inserted_id] = rad_dbpdo::lastInsertId();
                        }
                    }
                }
                die('Done!');
            } else {
                die('Have no updates!');
            }
        }else{
            $this->redirect('404');
        }
    }

    private function _cantDowngrade()
    {
        $this->redirect(SITE_URL);
        die;
    }
}
