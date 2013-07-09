<?php
final class rad_xmlparams
{
    /**
     * Private key
     *
     * @var string
     */
    private static $_key = 'AND DON\'T EVEN TRY TO DECODE THIS!!! )))) Вы будете приятно удивленны...';

    /**
     * Constructor
     *
     * @param string $modulename - name of folder and record in DB
     * @param string $filename - name of template filename
     */
    function __construct($modulename, $filename)
    {
        die('You can\'t ccreate the system class!!!');
    }

    /**
     * Returns the params object for template file
     * @access public
     * @param string $modulename
     * @param string $filename
     * @return rad_paramsobject
     *
     */
    public static function getParamsObject($modulename,$filename, $theme=null)
    {
        return new rad_paramsobject( self::getXmlFile($modulename, $filename, $theme), true );
    }

    /**
     * Gets the avalible controller's list
     *
     * @param string $modulename
     * @param string $filename
     * @return array mixed
     */
    public static function getControllerList($modulename,$filename)
    {
        if(!self::checkXMLFor($modulename,$filename))
            return null;
        $xmlObj = simplexml_load_string( self::getXmlFile($modulename, $filename) );
        $controllers = $params = $xmlObj->xpath('/metadata/system/prelogic');
        $res = array();
        foreach($controllers[0] as $key=>$value){
            if(is_array($value)){
                foreach($value as $k=>$v){
                    $res[] = (string)$v;
                }
            }else{
                $res[] = (string)$value;
            }
        }
        return $res;
    }

    /**
     * Check exists the xml filename for module
     *
     * @access public
     * @param string $module
     * @param string $fn
     * @return Boolean
     */
    final public static function checkXMLFor($module, $fn)
    {
        $result = is_file( COMPONENTSPATH.$module.DS.'set'.DS.$fn.'.xml' );
        return $result;
    }

    /**
     * Gets decoded XML file
     *
     * @access private
     * @param string $module
     * @param string $fn
     * @return string XML
     */
    final private static function getXmlFile($module,$fn, $theme=null)
    {
        $tail = $module.DS.'set'.DS.$fn.'.xml';
        if(!self::checkXMLFor($module,$fn)) {
            return null;
        }
        if ((defined('THEMESPATH') && $theme && is_file($file = THEMESPATH.$theme.DS.$tail))
            || is_file($file = COMPONENTSPATH.$tail) )
        {
            return file_get_contents($file);
        }
        throw new rad_exception("File params '{$fn}' for module '{$module}' not found!");
    }

    /**
     * Decode the string
     * @access private
     * @param string encoded xml
     * @return string decoded xml
     */
    final private static function decode($xml)
    {
        return $xml;
    }
}