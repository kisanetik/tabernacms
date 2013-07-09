<?php
/*
 * Created on 19 february 2008
*
* config class to acces to the config
*/
class rad_config
{
    /**
     *
     * All Config here..
     * @access private
     *
     */
    private static $config = array();

    /**
     * Sets the Param into config
     * @param string paramname
     * @param string paramvalue
     * @access private
     * @var Boolean
     */
    public static function setParam($paramname='',$paramvalue='')
    {
        if(!empty($paramname)){
            self::$config[$paramname]=$paramvalue;
            return true;
        }else{
            throw new rad_config_exception('Empty paramname for config');
        }
    }

    /**
     * Get the param value by the paramname
     * if param not exist return null
     * @param string paramname
     * @var string paramvalue
     */
    public static function getParam($paramname, $defValue = NULL)
    {
        if(isset(self::$config[$paramname])){
            return self::$config[$paramname];
        }else{
            return $defValue;
        }
    }

    /**
     * Load configuration from Database
     * NOTICE: If values not empty - overrides the values from file
     */
    public static function loadConfig()
    {
        foreach (rad_dbpdo::queryAll('select * from '.RAD.'settings') as $id) {
            self::$config[$id['fldName']]=(strlen($id['fldValue']))?$id['fldValue']:$id['defValue'];
        }
    }

    /**
     * Return the appropriate configuration parameter from php.ini file
     * 
     * @param string $paramName Parameter name
     * @param string $defaultValue Default value
     * @return string fetched or default value
     */
    public static function getSys($paramName, $defaultValue='')
    {
        switch ($paramName) {
            case 'max_post':    // get the minimal allowed filesize in bytes
                                // from the various configuration options
                $value = min( 
                    rad_config::convertToBytes(ini_get('post_max_size')),
                    rad_config::convertToBytes(ini_get('upload_max_filesize'))
                );
                break;
            default:
                $value = ini_get($paramName);
                $value = $value === false ? $defaultValue : $value; 
        }
        return (string) $value;
    }

    /**
     * Convert capacity value with possible suffix (K, M, G supported) to its equivalent in bytes
     * 
     * @param int|string $value value to convert
     * @param int $precision the number of digits after the decimal point
     * @return float calculated value with specified precision.
     */
    protected static function convertToBytes($value)
    {
        $value = strtolower(trim($value));
        $value_int = (int) $value;
        if (strpos($value, 'g')) {            //Gigabytes
            $value = $value_int * 1073741824; // 1024 * 1024 * 1024;
        } elseif (strpos($value, 'm')) {      // Megabytes
            $value = $value_int * 1048576;    // 1024 * 1024;
        } elseif (strpos($value, 'k')) {      // Kilobytes
            $value = $value_int / 1024;       // just 1024 ;)
        } else {                              // Bytes
            $value = $value_int;
        }
        return $value;
    }
    
    public static function clearParams($params) 
    {
        $result = false;
        if(count($params)) {
            foreach($params as $id=>$param) {
                $res = rad_dbpdo::queryAll('select * from '.RAD.'settings WHERE fldName LIKE :param', array('param'=>$param));
                if(count($res)) {
                    foreach($res as $id) {
                        $item = new struct_core_settings($id);
                        $item->remove();
                        $result = true;
                    }
                }
            }
        }
        return $result;
    }

}//class

class rad_config_exception extends rad_exception
{
  public function __construct($message, $code = 3)
  {
         parent::__construct($message, $code);
     }
}