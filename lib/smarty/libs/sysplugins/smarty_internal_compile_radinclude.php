<?php
/**
* Smarty Internal Plugin Compile Include
*
* Compiles the {radinclude} tag
*
* @package Smarty
* @subpackage Compiler
* @author pzhukov, Taberna CMS
*/

/**
* Smarty Internal Plugin Compile Include Class
*
* @package Smarty
* @subpackage Compiler
*/
class Smarty_Internal_Compile_Radinclude extends Smarty_Internal_Compile_Include {

    /**
    * caching mode to create nocache code but no cache file
    */
    const CACHING_NOCACHE_CODE = 9999;
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $required_attributes = array('file');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $shorttag_order = array('file');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $option_flags = array('nocache', 'inline', 'caching');
    /**
    * Attribute definition: Overwrites base class.
    *
    * @var array
    * @see Smarty_Internal_CompileBase
    */
    public $optional_attributes = array('_any');

    /**
     * Compiles code for the {radinclude} tag
     *
     * @param array $args array with attributes from parser
     * @param object $compiler compiler object
     * @param array $parameter array with compilation parameter
     * @throws rad_exception
     * @return string compiled code
     */
    public function compile($args, $compiler, $parameter)
    {
        // check and get attributes
        $_attr = $this->getAttributes($compiler, $args);
        if (!isset($_attr['module']))
            throw new rad_exception("radinclude: missing 'module' parameter");
        if (!isset($_attr['file']))
            throw new rad_exception("radinclude: missing 'file' parameter");
        $modulename = trim($_attr['module'], '"\''); //remove beginning and end quotes
        $filename = trim($_attr['file'], '"\'');
        if (!preg_match('/^[a-z][a-z0-9]{2,31}$/i', $modulename))
            throw new rad_exception("radinclude: 'module' should only use a-zA-Z0-9 characters and be from 2 to 31 long");
        if (!preg_match('/^[a-z0-9][-_.a-z0-9]*(?:\/[a-z0-9][-_.a-z0-9]*)*\.tpl$/i', $filename))
            throw new rad_exception("radinclude: 'file' should only consists of a-zA-Z0-9-_. and \\ symbols");
        if (!($filename = rad_themer::getFilePath(null, 'templates', $modulename, $filename)))
            throw new rad_exception("Template {$filename} not found in module {$modulename}");
        $this->replaceFilename($filename, $args); //relative to module filename -> to absolute path
        return parent::compile($args, $compiler, $parameter);
    }
    private function replaceFilename($filename, &$args){
        foreach ($args as &$arg){
            if (array_key_exists('file', $arg)){
                $arg['file']="'$filename'";
            }
        }
        unset($arg);
    }
}
