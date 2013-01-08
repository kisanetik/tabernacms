<?php
/**
 * Interface for plugins for file extension
 */
interface interface_loader{
	/**
	 * Set the variables for the template(s)
	 * template need to seen only in local var
	 * @param mixed $vars array($key=>$value)
	 */
	public static function setVars($vars);

	/**
	 * Get the setted variables
	 * @return mixed array($key=>$value)
	 */
	public static function getVars();

	/**
	 * Add variable
	 * @param string $key
	 * @param mixed $value
	 */
	public static function addVar($key, $value);

	/**
	 * Delete the variable by $key
	 * @param string $key
	 */
	public static function unsetVar($key);

	/**
	 * Clear all setted valiables
	 */
	public static function clearVars();

	/**
	 * Get content from added template(s) with setted params
	 * @param string $filename path to template, optional
	 */
	public static function getContent($filename=null);

	/**
	 * Add file to the templates list
	 * @param string $filename
	 */
	public static function addFile($filename);

	/**
	 * Remove the file from templates list
	 * @param string filename
	 */
	public static function removeFile($filename);

	/**
	 * Clear files list with templates
	 */
	public static function clearFiles();
}
