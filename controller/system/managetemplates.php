<?php
/**
 * system class for managing templates
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_system_managetemplates extends rad_controller
{
    function __construct()
    {
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->getJS();
                    break;
                case 'editnode':
                    $this->editNode();
                    break;
                case 'editfile':
                    $this->editFile();
                    break;
                case 'savefile':
                    $this->saveFile();
                    break;
                case 'selecttree':
                    $this->selectTree();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
                    break;
            }
        } else {//if !$action
            $this->assignTree();
        }
    }

    private function _recursyFolders($dir='', &$result = array())
    {
        if($dir!='..' and $dir!='.' and is_dir($dir)) {
            $d = dir($dir);
            while (false !== ($entry = $d->read())) {
                if($entry=='.' or $entry=='..' or $entry=='.svn' or $entry=='set') {
                    continue;
                }
                if(is_dir($dir.$entry)) {
                    $result[$entry] = $this->_recursyFolders($dir.$entry.DS);
                } else {
                    $result[$entry] = NULL;
                }
            }//while

        }else{//is file

        }
        return $result;
    }
    /**
     * Assign for template the fully dir
     */
    function assignTree()
    {
        $this->setVar('items', $this->_recursyFolders(TEMPLATESPATH) );
    }

    /**
     * Gets the main javascript for the page
     */
    function getJS()
    {
        $this->setVar('ROOT_PID', addslashes(str_replace(rad_config::getParam('rootPath'),'',TEMPLATESPATH)));
        $this->setVar('lang',$this->getCurrentLang());
        $this->header('Content-type: text/javascript');
    }

    /**
     * Edit folders
     * @return html for AJAX
     */
    function editNode()
    {
        $data = $this->request('dpath');
        $data = str_replace('@','/',$data);
        if(is_dir(TEMPLATESPATH.$data)) {

        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Show in new diw edit file window
     * @return html for AJAX
     */
    function editFile()
    {
        $data = $this->request('dpath');
        $data = str_replace('@','/',$data);
        if(is_file(TEMPLATESPATH.$data)) {
            $this->setVar('fcontent', htmlspecialchars( file_get_contents(TEMPLATESPATH.$data) ) );
        }
    }

    /**
     * Try to save the file data from request
     * @return JS for AJAX
     */
    function saveFile()
    {
        if($this->request('hash') == $this->hash()) {
            $content = $this->request('w_code');
            $fn = $this->request('f');
            $search = array('@micros@', '@maintemplates@', '@mail@');
            $replace = array(MICROSPATH, MAINTEMPLATESPATH, MAILTEMPLATESPATH);
            $fn = str_replace($search, $replace, $fn);
            if($fn[0]=='@') {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            } else {
                //simple security
                $fn = str_replace('..@','',$fn);
                $fn = str_replace('@','/',$fn);
                if(is_file($fn) and is_writable($fn)) {
                    file_put_contents($fn,stripslashes($content) );
                    echo 'RADFoldersTree.message("'.$this->lang('-saved').'");';
                    echo 'RADFolders.cancelWindowClick();';
                } else {
                    echo 'alert("'.$this->lang('filenotwritable.system.error').'");';
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Choose - is this a file or directory?!
     * @return JavaScript for AJAX
     */
    function selectTree()
    {
        $data = $this->request('dpath');
        $data = str_replace('@','/',$data);
        if(is_dir(TEMPLATESPATH.$data)) {
            //echo 'RADFoldersTree.showEdit();';
        } else {
            echo 'RADFoldersTree.editFile();';
        }
    }
}