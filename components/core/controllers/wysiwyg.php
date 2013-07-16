<?php
/**
 * System class for upload and browse files
 * @author Roman Chertov
 */

class controller_core_wysiwyg extends rad_controller
{
    private $image_extensions = array('gif', 'jpeg', 'jpg', 'png', 'swf', 'psd', 'bmp', 'iff');
    private $command;
    private $resource_type;
    private $current_folder;
    private $error;
    private $filename;

    function __construct()
    {
        if (!$this->isPermitted()) {
            header('Location: '.SITE_URL);
        }
        if($this->request('action')){
            switch($this->request('action')) {
                case 'upload':
                    $this->processUpload();
                    break;
                case 'browse':
                    $this->getBrowser();
                    break;
                case 'getjs':
                    $this->getJS();
                    break;
            }
            $this->setVar('action',$this->request('action'));
        }
        else {
            $this->badRequest(__LINE__);
        }
    }

    private function isPermitted()
    {
        return (($this->request('action') == 'getjs') || (rad_session::$user->u_id && rad_session::$user->is_admin));
    }

    /**
     * Show edit node form
     */
    function getBrowser()
    {
        if ($this->get('Command') && $this->get('Type') && $this->get('CurrentFolder')) {
            $this->command = $this->get('Command');
            $this->resource_type = $this->get('Type');
            $this->current_folder = $this->getCurrentFolder();
            if (!$this->current_folder) {
                $this->xmlSendError(102);
            }
            if (!$this->isAllowedCommand()) {
                $this->xmlSendError(1, 'The "'.$this->command.'" command isn\'t allowed');
            }
            if (!$this->isAllowedType()) {
                $this->xmlSendError(1, 'Invalid type specified');
            }
            // File Upload doesn't have to Return XML, so it must be intercepted before anything.
            if ($this->command == 'FileUpload') {
                $url = $this->uploadFile();
                $this->sendBrowserUploadResults($url, $this->filename);
                exit();
            }
            // Execute the required command
            switch ($this->command) {
                case 'GetFolders' :
                    $xml = $this->getFolders();
                    break;
                case 'GetFoldersAndFiles' :
                    $xml = $this->getFoldersAndFiles();
                    break;
                case 'CreateFolder' :
                    $xml = $this->createFolder();
                    break;
            }
            $this->printXml($xml);
        }
    }

    /**
     * To get js in XML alias
     *
     */
    function getJS()
    {
        //$this->setVar('lang',$this->getCurrentLang());
    }

    private function getCurrentFolder()
    {
        $sCurrentFolder = str_replace(':', '/', $this->get('CurrentFolder', '/'));
        // Check the current folder syntax (must begin and start with a slash).
        if (!preg_match( '|/$|', $sCurrentFolder )) $sCurrentFolder .= '/';
        if (strpos($sCurrentFolder, '/') !== 0) $sCurrentFolder = '/'.$sCurrentFolder;
        // Ensure the folder path has no double-slashes
        while (strpos ($sCurrentFolder, '//') !== false ) {
            $sCurrentFolder = str_replace ('//', '/', $sCurrentFolder);
        }
        // Check for invalid folder paths (..)
        if (strpos($sCurrentFolder, '..') || strpos($sCurrentFolder, "\\")) {
            return false;
        }
        return $sCurrentFolder;
    }

    private function convertToXmlAttribute($value)
    {
        $os = defined('PHP_OS') ? PHP_OS : php_uname();

        if (strtoupper(substr($os, 0, 3)) === 'WIN' || FindBadUtf8($value)) {
            return ( utf8_encode( htmlspecialchars( $value ) ) ) ;
        }
        else
        {
            return ( htmlspecialchars( $value ) ) ;
        }
    }

    private function getServerFolder() {
        return rtrim(rad_config::getParam('uploadImgPath'), '/').$this->current_folder;
    }

    private function getFolders()
    {
        $sServerDir = $this->getServerFolder();
        $aFolders = array() ;
        $oCurrentFolder = opendir($sServerDir);
        while ($sFile = readdir($oCurrentFolder)) {
            if (($sFile != '.') && ($sFile != '..') && is_dir($sServerDir.$sFile)) {
                $aFolders[] = '<Folder name="'.$this->convertToXmlAttribute($sFile).'" />';
            }
        }
        closedir($oCurrentFolder) ;
        natcasesort($aFolders);
        return '<Folders>'.implode('', $aFolders).'</Folders>';
    }

    private function getFoldersAndFiles()
    {
        $sServerDir = $this->getServerFolder();
        $aFolders = array();
        $aFiles = array();

        $oCurrentFolder = opendir($sServerDir);
        while ( $sFile = readdir( $oCurrentFolder ) ) {
            if ($sFile != '.' && $sFile != '..') {
                if (is_dir($sServerDir.$sFile)) {
                    $aFolders[] = '<Folder name="'.$this->convertToXmlAttribute($sFile).'" />' ;
                } else {
                    $file_size = @filesize($sServerDir.$sFile);
                    if (!$file_size) {
                        $file_size = 0 ;
                    }
                    if ($file_size > 0) {
                        $file_size = round($file_size / 1024) ;
                        if ($file_size < 1) $file_size = 1 ;
                    }
                    $aFiles[] = '<File name="'.$this->convertToXmlAttribute($sFile).'" size="'.$file_size.'" />' ;
                }
            }
        }

        natcasesort($aFolders);
        natcasesort($aFiles);
        return '<Folders>'.implode('', $aFolders).'</Folders>'
            .'<Files>'.implode('', $aFiles).'</Files>';
    }

    private function prepareFolderName($name) {
        // Remove . \ / | : ? * " < >
        return preg_replace( '/\\.|\\\\|\\/|\\||\\:|\\?|\\*|"|<|>|[[:cntrl:]]/', '_', stripslashes($name));
    }

    private function createFolder()
    {
        $sErrorMsg = '';

        if ($this->get('NewFolderName')) {
            $sNewFolderName = $this->prepareFolderName($this->get('NewFolderName'));
            if (strpos($sNewFolderName, '..') !== false) {
                $sErrorNumber = '102' ; // Invalid folder name
            } else {
                // Map the virtual path to the local server path of the current folder
                $sServerDir = $this->getServerFolder();

                if (is_writable($sServerDir)) {
                    $sServerDir.= $sNewFolderName;
                    if (file_exists($sServerDir)) { // Folder already exists
                        return $this->getErrorNode(101);
                    }
                    if (mkdir($sServerDir)) {
                        if (rad_config::getParam('wysiwyg.chmod_on_folder_create')) {
                            $permissions = (rad_config::getParam('wysiwyg.chmod_on_folder_create') === true) ? 0777 : rad_config::getParam('wysiwyg.chmod_on_folder_create');
                            $oldumask = umask(0);
                            mkdir($sServerDir, $permissions);
                            umask($oldumask);
                        }
                        return $this->getErrorNode();
                    }

                    switch ( $sErrorMsg ) {
                        case '' :
                            $sErrorNumber = '0';
                            break ;
                        case 'Invalid argument' :
                        case 'No such file or directory' :
                            $sErrorNumber = '102';
                            break ;
                        default :
                            $sErrorNumber = '110';
                            break ;
                    }
                } else {
                    $sErrorNumber = '103';
                }
            }
        }
        else {
            $sErrorNumber = '102' ;
        }
        return $this->getErrorNode($sErrorNumber, $sErrorMsg);
    }

    private function sendBrowserUploadResults($url, $filename, $message='')
    {
        echo '<script type="text/javascript">
(function(){var d=document.domain;while (true){try{var A=window.parent.document.domain;break;}catch(e) {};d=d.replace(/.*?(?:\.|$)/,"");if (d.length==0) break;try{document.domain=d;}catch (e){break;}}})();';
        $rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
        echo 'window.parent.OnUploadCompleted('.intval($this->error).',"'.strtr($url, $rpl).'","'.strtr($filename, $rpl).'", "'.strtr($message, $rpl).'");';
        echo '</script>';
    }

    private function setXmlHeaders()
    {
        ob_end_clean();

        // Prevent the browser from caching the result.
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // HTTP/1.1
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        // HTTP/1.0
        header('Pragma: no-cache') ;

        // Set the response format.
        header('Content-Type: text/xml; charset=utf-8');
    }

    private function printXml($xml)
    {
        $this->setXmlHeaders();

        echo '<'.'?xml version="1.0" encoding="utf-8" ?'.'>';
        if ($this->command) {
            echo '<Connector command="'.$this->command.'" resourceType="'.$this->resource_type.'">
<CurrentFolder path="'.$this->convertToXmlAttribute($this->current_folder).'" url="'.$this->convertToXmlAttribute($this->getHttpPath(rtrim(rad_config::getParam('uploadImgPath'), DS).$this->current_folder)) . '" />';
        }
        else {
            echo '<Connector>';
        }
        echo $xml.'</Connector>';
        exit();
    }

    private function xmlSendError($number, $text='')
    {
        $this->printXml($this->getErrorNode($number, $text));
    }

    private function getErrorNode($number=0, $text='')
    {
        return '<Error number="' . $number . '" text="' . htmlspecialchars( $text ) . '" />';
    }
    /**
     * Check if it is an allowed command
     * @return bool
     */
    private function isAllowedCommand() {
        return in_array($this->command, array('QuickUpload', 'FileUpload', 'GetFolders', 'GetFoldersAndFiles', 'CreateFolder'));
    }
    /**
     * Check if it is an allowed type
     * @return bool
     */
    private function isAllowedType() {
        return in_array($this->resource_type, array('File', 'Image', 'Flash', 'Media'));
    }

    private function prepareFileName($filename)
    {
        $filename = stripslashes($filename);
        // Remove \ / | : ? * " < >
        $filename = preg_replace( '/\\\\|\\/|\\||\\:|\\?|\\*|"|<|>|[[:cntrl:]]/', '_', $filename);
        return $filename;
    }

    /**
     * Get the extension
     * @param $filename
     * @return string
     */
    private function getExtension($filename)
    {
        return strtolower( substr($filename, (strrpos($filename, '.') + 1)) );
    }

    /**
     * Check file content. Function validates only image files.
     * Returns false if file is invalid.
     *
     * @param string $file_path absolute path to file
     * @param string $extension file extension
     * @return boolean
     */
    private function checkImage($file_path, $extension)
    {
        if (!@is_readable($file_path) || !in_array($extension, $this->image_extensions)) {
            return false;
        }
        if ( @getimagesize($file_path) === false ) {
            return false ;
        }
        return true;
    }

    private function getHttpPath($file_path)
    {
        return rad_config::getParam('url').str_replace('\\', '/', substr($file_path, strlen(rad_config::getParam('rootPath'))));
    }

    private function removeExtension($filename)
    {
        return substr($filename, 0, strrpos($filename, '.'));
    }

    /**
     * Compare files
     * @param string $file1
     * @param string $file2
     * @return bool
     */
    private function equalFiles($file1, $file2)
    {
        return (md5_file($file1) == md5_file($file2));
    }

    public function uploadFile()
    {
        if (isset($_FILES['upload']) && !empty($_FILES['upload']['tmp_name'])) {
            $file = $_FILES['upload'];
            $server_dir = rad_config::getParam('uploadImgPath').ltrim($this->current_folder, '/');

            $this->filename = stripslashes($file['name']);
            $filename = $this->prepareFileName($file['name']);
            $ext = $this->getExtension($filename);
            if (!$this->checkImage($file['tmp_name'], $ext)) {
                $this->error = 202;
            }
            /*if ( !IsHtmlExtension( $ext, $GLOBALS['config']['HtmlExtensions'] ) && ( $detectHtml = DetectHtml( $file['tmp_name'] ) ) === true ) {
                    $this->error = 202;
            }*/
            if (!$this->error) {
                $orig_filename = $filename;
                $file_path = $server_dir.$filename;
                $counter = 0;
                while (is_file($file_path)) {
                    if ($this->equalFiles($file['tmp_name'], $file_path)) {
                        return $this->getHttpPath($file_path);
                    }
                    $counter++;
                    $filename = $this->removeExtension($orig_filename).'('.$counter.').'.$ext;
                    $file_path = $server_dir.$filename;
                }
                move_uploaded_file($file['tmp_name'], $file_path);

                if (is_file($file_path)) {
                    if (rad_config::getParam('wysiwyg.chmod_on_upload')) {
                        $permissions = (rad_config::getParam('wysiwyg.chmod_on_upload') === true) ? 0777 : rad_config::getParam('wysiwyg.chmod_on_upload');
                        $oldumask = umask(0) ;
                        chmod($file_path, $permissions);
                        umask($oldumask) ;
                    }
                    return $this->getHttpPath($file_path);
                }
            }
        } else {
            $this->error = 202;
        }
        return '';
    }

    private function getCKEditorParam($key)
    {
        if ($params_pos = strpos($_SERVER['REQUEST_URI'], '?')) {
            parse_str(substr($_SERVER['REQUEST_URI'], $params_pos+1), $params);
            if (isset($params[$key])) {
                return $params[$key];
            }
        }
        return false;
    }

    private function sendUploadResults($http_path='')
    {
        $callback = $this->getCKEditorParam('CKEditorFuncNum');
        $rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
        echo '<script type="text/javascript"> window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.strtr($http_path, $rpl).'", "'.strtr($this->error, $rpl).'");</script>';
    }

    private function processUpload()
    {
        $this->sendUploadResults($this->uploadFile());
        exit();
    }

    function badRequest($code='0')
    {
        die('BAD REQUEST!!! in file: '.__FILE__.' line: '.__LINE__.' code='.$code);
    }
}