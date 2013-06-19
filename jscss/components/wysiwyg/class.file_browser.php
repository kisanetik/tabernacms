<?php
class WysiwygFileBrowser
{
	private $command;
	private $resource_type;
	private $current_folder;

	public function __construct() {
		$this->command = isset($_GET['Command']) ? $_GET['Command'] : '';
		$this->resource_type = isset($_GET['Type']) ? $_GET['Type'] : '';
		$this->current_folder = $this->getCurrentFolder();
	}

	private function getCurrentFolder()
	{
		$sCurrentFolder = isset($_GET['CurrentFolder']) ? $_GET['CurrentFolder'] : '/';

		// Check the current folder syntax (must begin and start with a slash).
		if ( !preg_match( '|/$|', $sCurrentFolder ) )
			$sCurrentFolder .= '/' ;
		if ( strpos( $sCurrentFolder, '/' ) !== 0 )
			$sCurrentFolder = '/' . $sCurrentFolder ;

		// Ensure the folder path has no double-slashes
		while ( strpos ($sCurrentFolder, '//') !== false ) {
			$sCurrentFolder = str_replace ('//', '/', $sCurrentFolder) ;
		}

		// Check for invalid folder paths (..)
		if ( strpos( $sCurrentFolder, '..' ) || strpos( $sCurrentFolder, "\\" ))
			SendError( 102, '' ) ;

		return $sCurrentFolder ;
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
		return rtrim($GLOBALS['config']['uploadImgPath'], '/').$this->current_folder;
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
		$sErrorNumber	= '0' ;
		$sErrorMsg		= '' ;

		if (isset($_GET['NewFolderName'])) {
			$sNewFolderName = $this->prepareFolderName($_GET['NewFolderName']);

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
						/*$permissions = 0777;
					if ( isset( $Config['ChmodOnFolderCreate'] ) ) {
						$permissions = $Config['ChmodOnFolderCreate'] ;
					}
					// To create the folder with 0777 permissions, we need to set umask to zero.
					$oldumask = umask(0) ;
					mkdir( $folderPath, $permissions ) ;
					umask( $oldumask ) ;*/
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

	private function sendUploadResults($error_number, $url, $filename, $message='')
	{
		echo '<script type="text/javascript">
(function(){var d=document.domain;while (true){try{var A=window.parent.document.domain;break;}catch(e) {};d=d.replace(/.*?(?:\.|$)/,"");if (d.length==0) break;try{document.domain=d;}catch (e){break;}}})();';
		$rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
		echo 'window.parent.OnUploadCompleted('.intval($error_number).',"'.strtr($url, $rpl).'","'.strtr($filename, $rpl).'", "'.strtr($message, $rpl).'");';
		echo '</script>';
	}

	private function fileUpload()
	{
		include_once('./class.file_uploader.php');
		$uploader = new WysiwygFileUploader($this->current_folder);
		$url = $uploader->upload();

		$this->sendUploadResults($uploader->error,  $url, $uploader->filename);
		exit();
	}

	private function getUrlFromPath()
	{
		return str_replace('jscss/components/wysiwyg/', '', $GLOBALS['config']['url'])
			.rtrim(str_replace('\\', '/', substr($GLOBALS['config']['uploadImgPath'], strlen($GLOBALS['config']['rootPath']))), '/')
			.$this->current_folder;
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
<CurrentFolder path="'.$this->convertToXmlAttribute($this->current_folder).'" url="'.$this->convertToXmlAttribute($this->getUrlFromPath()) . '" />';
		}
		else {
			echo '<Connector>';
		}
		echo $xml.'</Connector>';
		exit();
	}

	function sendError($number, $text)
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

	public function process()
	{
		if (!isset($_GET['Command']) || !isset($_GET['Type']) || !isset($_GET['CurrentFolder'])) {
			readfile('./browser.html');
			return;
		}
		if (!$this->isAllowedCommand()) {
			$this->sendError(1, 'The "'.$this->command.'" command isn\'t allowed');
		}
		if (!$this->isAllowedType()) {
			$this->sendError(1, 'Invalid type specified');
		}
		// File Upload doesn't have to Return XML, so it must be intercepted before anything.
		if ($this->command == 'FileUpload') {
			$this->fileUpload();
			return;
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