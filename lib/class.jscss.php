<?php
/**
 * Collector of JS and CSS-files
 * @author Roman Chertov
 *
 * @example
 * rad_jscss::includeJS('wysiwyg.js', 'sync');
 *  * ...
 * rad_jscss::getHeaderCode();
 */
class rad_jscss
{
	private static $maintpl_files;
	private static $files;
	private static $inline_js;

	private static function addFile($filename, $html) {
		if (rad_instances::isMainTemplate()) {
			if (isset(self::$maintpl_files[$filename])) {
				self::$maintpl_files[$filename]['template'][] = rad_instances::getCurrentTemplate();
			}
			else {
				self::$maintpl_files[ $filename ] = array(
					'html' => $html,
					'template' => array( rad_instances::getCurrentTemplate() )
				);
			}
		}
		else {
			if (isset(self::$files[$filename])) {
				self::$files[$filename]['template'][] = rad_instances::getCurrentTemplate();
			}
			else {
				self::$files[ $filename ] = array(
					'html' => $html,
					'template' => array( rad_instances::getCurrentTemplate() )
				);
			}
		}
	}

	/**
	 *
	 * @static
	 * @param $filename
	 * @param string $mode - defer|async|sync, default value is "defer"
	 */
	public static function includeJS($filename, $mode='defer')
	{
		$load = ' defer="true"';
		if ($mode == 'async') {
			$load.= ' async="true"';
		} elseif ($mode == 'sync') {
			$load = '';
		}
		self::addFile($filename,
			'<script type="text/javascript" src="'.((substr($filename, 0, 6)=='jscss/' || substr($filename, 0, 4)=='img/') ? SITE_URL.$filename : $filename).'"'.$load.'></script>'
		);
	}

	public static function inlineJS($code, $dom_ready=false)
	{
		if (!self::$inline_js) {
			self::$inline_js = '';
		}
		if ($dom_ready) {
			$code = ' $(function() {'.$code.'});';
		}
		self::$inline_js.= $code;
	}

	public static function includeCSS($filename)
	{
		self::addFile($filename, '<link rel="stylesheet" type="text/css" href="'.SITE_URL.$filename.'" />');
	}

	/**
	 * Return HTML code to insert in <head> section
	 * @static
	 * @return string
	 */
	public static function getHeaderCode()
	{
		$return = '';
		if (!empty(self::$maintpl_files)) {
			foreach (self::$maintpl_files as $file) {
				$return.= $file['html'];
			}
		}
		if (!empty(self::$files)) {
			foreach (self::$files as $filename=>$file) {
				if (!isset(self::$maintpl_files[$filename])) {
					$return.= $file['html'];
				}
			}
		}
		if (!empty(self::$inline_js)) {
			$return.= '<script language="JavaScript" type="text/javascript">'."\n".self::$inline_js."\n</script>";
		}
		return $return;
	}
}