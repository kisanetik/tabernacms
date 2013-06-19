<?php

class WysiwygFileUploader
{
	private $image_extensions = array('gif', 'jpeg', 'jpg', 'png', 'swf', 'psd', 'bmp', 'iff');
	private $folder;
	public $filename = '';
	public $error = '';

	public function __construct($folder='')
	{
		$this->folder = $folder;
	}

	private function sendResults($http_path='')
	{
		$callback = $_GET['CKEditorFuncNum'];
		$rpl = array( '\\' => '\\\\', '"' => '\\"' ) ;
		echo '<script type="text/javascript"> window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.strtr($http_path, $rpl).'", "'.strtr($this->error, $rpl).'");</script>';
		exit();
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

	private function removeExtension($filename)
	{
		return substr($filename, 0, strrpos($filename, '.'));
	}

	private function getHttpPath($file_path)
	{
		return str_replace('jscss/components/wysiwyg/', '', $GLOBALS['config']['url']).str_replace('\\', '/', substr($file_path, strlen($GLOBALS['config']['rootPath'])));
	}

	private function getUploadDir()
	{
		return $GLOBALS['config']['uploadImgPath'].ltrim($this->folder, '/');
	}

	public function upload()
	{
		if (isset($_FILES['upload']) && !empty($_FILES['upload']['tmp_name'])) {
			$file = $_FILES['upload'];
			$server_dir = $this->getUploadDir();

			$this->filename = stripslashes($file['name']);
			$filename = $this->prepareFileName($file['name']);
			$ext = $this->getExtension($filename);

			if (!$this->checkImage($file['tmp_name'], $ext)) {
				$this->error = 202;
			}

			/*if ( !IsHtmlExtension( $ext, $GLOBALS['config']['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $file['tmp_name'] ) ) === true )
				{
					$this->error = 202;
				}*/

			if (!$this->error) {
				$orig_filename = $filename;
				$file_path = $server_dir.$filename;

				$counter = 0;
				while (is_file($file_path)) {
					$counter++;
					$filename = $this->removeExtension($orig_filename).'('.$counter.').'.$ext;
					$file_path = $server_dir.$filename;
				}

				move_uploaded_file($file['tmp_name'], $file_path);

				if (is_file($file_path)) {
					if (isset($GLOBALS['config']['ChmodOnUpload'])) {
						$permissions = $GLOBALS['config']['ChmodOnUpload'] ? $GLOBALS['config']['ChmodOnUpload'] : 0777;
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

	public function process()
	{
		$this->sendResults($this->upload());
		exit();
	}
}