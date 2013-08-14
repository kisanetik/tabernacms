<?php
/**
 * Params object
 * @package RADCMS
 * @author Denys Yackushev
 */
class rad_paramsobject
{

    /**
     * Values of the params
     * @var array()
     */
    private $_values = array();

    /**
     * Types of the param
     * @var array()
     */
    private $_types = array();

    private $_multilang = array();

    /**
     * Title of the template
     * @access private
     * @var string
     */
    private $_title = '';

    /**
     * Description of the template
     * @access private
     * @var string
     */
    private $_description = '';

    /**
     * Author of the template
     * @access private
     * @var string
     */
    private $_author = '';

    /**
     * Creation timestamp
     *
     * @var integer
     */
    private $_date = 0;

    /**
     * URL to website of the creator
     *
     * @var string
     */
    private $_url = '';

    /**
     * Constructor
     *
     * @param string $xml
     * @param Boolean $onlyparams
     */
    function __construct($xmlstring=NULL,$onlyparams = false)
    {
        if(strlen($xmlstring) and $onlyparams) {
            $xmlObj = simplexml_load_string( $xmlstring );
            $info_names = $xmlObj->xpath('/metadata/names');
            if(count($info_names)){
                $info_names = $info_names[0];
                $this->_title = $info_names->title;
                $this->_description = $info_names->description;
                $this->_author = $info_names->author;
                $this->_date = $info_names->date;
                $this->_url = $info_names->url;
            }
            $params = $xmlObj->xpath('/metadata/params');
            if(count($params)) {
                $file = NULL;
                foreach($params[0]->param as $id) {
                    $multilang = false;
                    foreach($id->attributes() as $attrKey=>$attrValue) {
                        switch($attrKey){
                            case 'name':
                                $attrname = (string)$attrValue;
                                break;
                            case 'type':
                                $attrtype = (string)$attrValue;
                                break;
                            case 'allow':
                                $attrallow = (int)$attrValue;
                                break;
                            case 'file':
                                $file = (string)$attrValue;
                                break;
                            case 'module':
                                $module = (string)$attrValue;
                                break;
                            case 'multilang':
                                $multilang = (boolean)$attrValue;
                                break;
                        }//switch
                    }//foreach attributes
                    if($attrallow) {
                        if($file) {
                            if(file_exists(rad_config::getParam('rootPath').$file)) {
                                $file_contents = file(rad_config::getParam('rootPath').$file);
                            } else {
                                $file_contents = array();
                                $file_contents[] = '<?php'."\r\n";
                            }
                        }
                        $this->_types[$attrname] = (string)$attrtype;
                        $this->_multilang[$attrname] = $multilang;
                        foreach($id as $valname=>$valvalue) {
                            if($valname=='values') {
                                foreach($valvalue as $idv) {
                                    $this->_values[$attrname]['value'][(string)$idv->key] = (string)$idv->value;
                                }
                            } else {
                                $this->_values[$attrname][$valname] = (string)$valvalue;
                            }
                        }
                    }//if attrallow
                }//foreach params
            }//if count params
        }//xmlstring and onlyparams
        elseif(strlen($xmlstring) and !$onlyparams) {
            $tmp = unserialize( $xmlstring );
            $this->_values = $tmp['values'];
            $this->_types = $tmp['types'];
            if(isset($tmp['multilang']))
                $this->_multilang = $tmp['multilang'];
        }
    }//__construct

    /**
     * Return the author of the template
     * @return string
     */
    function _getAuthor()
    {
        return $this->_author;
    }

    /**
     * Return the title of the template
     * @return string
     *
     */
    function _getTitle()
    {
        return $this->_title;
    }

    /**
     * Returns the description of the template
     *
     * @return string
     */
    function _getDescription()
    {
        return $this->_description;
    }

    /**
     * Returns the creation timestamp
     * @return integer
     */
    function _getDate()
    {
        $this->_date;
    }

    /**
     * Returns the url of the developer
     *
     * @return unknown
     */
    function _getUrl()
    {
        return $this->_url;
    }

    /**
     * Gets the count of values
     *
     * @return integer
     */
    function _getParamsCount()
    {
        return count($this->_values);
    }

    /**
     * Get the value of $paramname or $defValue or NULL
     *
     * @param string $paramname
     * @param mixed $defValue
     * @param integer $lng_id
     * @return mixed
     */
    function _get($paramname, $defValue=NULL, $lng_id=false)
    {
        if(isset($this->_values[$paramname])) {
            if($lng_id) {
                if( isset( $this->_values[$paramname]['value'][$lng_id] ) and is_array( $this->_values[$paramname]['value'][$lng_id] )) {
                    return $this->_values[$paramname]['value'][$lng_id];
                } else {
                    return ( isset( $this->_values[$paramname]['value'][$lng_id] ) )?
                            $this->_values[$paramname]['value'][$lng_id]:
                            $defValue;
                }
            }else{
                if(is_array($this->_values[$paramname]['value'])) {
                    return $this->_values[$paramname]['value'];
                } else {
                    return stripslashes( $this->_values[$paramname]['value'] );
                }
            }
        } else {
            return $defValue;
        }
    }

    /**
     * Sets the $paramvalue to the $paramname
     *
     * @param string $paramname
     * @param mixed $paramvalue
     * @param string $paramtype - default NULL and not set
     */
    function _set($paramname,$paramvalue,$paramtype=NULL,$multilang=false,$stripslashes=false)
    {
        if($multilang and is_array($paramvalue)) {
            foreach($paramvalue as $lng_id=>$value) {
                $lng = str_replace('lang_','',$lng_id);
                if($stripslashes) {
                    $value = stripslashes($value);
                }
                $this->_values[$paramname]['value'][$lng] = $value;
            }
        } elseif(is_array($paramvalue)) {
            foreach($paramvalue as $key=>$value) {
                $this->_values[$paramname]['value'][] = array('key'=>stripslashes($key),'value'=>stripslashes($value));
            }
        } else {
            $this->_values[$paramname]['value'] = stripslashes($paramvalue);
        }
        $this->_multilang[$paramname] = $multilang;
        if($paramtype) {
            $this->_settype($paramname,$paramtype);
        }
    }

    /**
     * Gets the type of paramname
     * If paramname exists - return it type, otherwise return the $defType or NULL
     *
     * @param string $paramname
     * @param string $defType
     * @return string
     */
    function _typeof($paramname, $defType = NULL)
    {
        return isset($this->_types[$paramname])?$this->_types[$paramname]:$defType;
    }

    /**
     * Sets the type of paramname
     * return true if paramname exists, otherwise: false
     *
     * @param string $paramname
     * @param string $type
     * @return Boolean
     */
    function _settype($paramname,$type)
    {
        if(isset($this->_values[$paramname])) {
            $this->_types[$paramname] = $type;
            return true;
        }
        return false;
    }

    /**
     * Gets the default value for param,
     * If param is not exists of default value - returns NULL
     *
     * @param string $paramname
     * @return mixed
     */
    function _default($paramname)
    {
        return (isset($this->_values[$paramname]['default']))?$this->_values[$paramname]['default']:NULL;
    }

    /**
     * Checks if the $paramvalue exists in $paramname values
     *
     * @param string $paramname
     * @param mixed $paramvalue
     * @param integer $lng_id
     * @return boolean
     */
    function _eq($paramname,$paramvalue,$lng_id = false)
    {
        if(!isset($this->_values[$paramname])) {
            return false;
        }
        if(is_array($this->_values[$paramname]['value'])) {
            if($lng_id) {
                foreach($this->_values[$paramname]['value'][$lng_id] as $id) {
                    if($id['value']==$paramvalue) {
                        return true;
                    }
                }
            } else {
                foreach($this->_values[$paramname]['value'] as $id) {
                    if($id['value']==$paramvalue) {
                        return true;
                    }
                }
            }
            return false;
        } else {
            return $lng_id?$paramvalue==$this->_values[$paramname]['value'][$lng_id]:($paramvalue==$this->_values[$paramname]['value']);
        }
    }

    /**
     * Sets the default value for the param
     * If paramname not exists, return false, otherwise return true
     *
     * @param string $paramname
     * @param mixed $value
     * @return Boolean
     */
    function _setDefault($paramname,$value)
    {
        if(isset($this->_values[$paramname])) {
            $this->_values[$paramname]['default'] = $value;
            return true;
        }
        return false;
    }

    /**
     * Return the param names
     *
     * @return array()
     */
    function _getParamsNames()
    {
        return array_keys($this->_values);
    }

    /**
     * Gets the string name of the param, or NULL
     *
     * @param string $paramname
     * @return string
     */
    function _getName($paramname)
    {
        return (isset($this->_values[$paramname]['name']))?trim($this->_values[$paramname]['name']):NULL;
    }

    /**
     * Check if the paramname is multilang
     *
     * @param string $paramname
     * @return Boolean
     */
    function _isMultilang($paramname)
    {
        return ( isset( $this->_multilang[$paramname] ) )?$this->_multilang[$paramname]:false;
    }

    /**
     * Sets the string name of the param
     * Returns true if $paramname exists, otherwise returns false
     *
     * @param string $paramname
     * @param string $name
     */
    function _setName($paramname,$name)
    {
        if(isset($this->_values[$paramname])) {
            $this->_values[$paramname]['name'] = $name;
            return true;
        }
        return false;
    }

    /**
     * get the hash of values
     *
     * @return string
     */
    function _hash()
    {
        $tmp = array('values'=>$this->_values,'types'=>$this->_types,'multilang'=>$this->_multilang);
        return serialize($tmp);
    }

    function __get($name)
    {
        if(isset($this->_values[$name]) and isset($this->_values[$name]['value'])) {
            if($this->_isMultilang($name) and is_array($this->_values[$name]['value'])) {
                if(isset($this->_values[$name]['value'][rad_lang::getCurrentLangID()])) {
                    if( is_array( $this->_values[$name]['value'][rad_lang::getCurrentLangID()] ) ) {
                        return $this->_values[$name]['value'][rad_lang::getCurrentLangID()];
                    } else {
                        return stripslashes( $this->_values[$name]['value'][rad_lang::getCurrentLangID()] );
                    }
                } else {
                    if(is_array($this->_values[$name]['value'])) {
                        foreach($this->_values[$name]['value'] as $key=>$value) {
                            $this->_values[$name]['value'][stripslashes($key)] = stripslashes($value);
                        }
                        return $this->_values[$name]['value'];
                    } else {
                        return stripslashes( $this->_values[$name]['value'] );
                    }
                }
            } else {
                if(is_array($this->_values[$name]['value'])) {
                    return $this->_values[$name]['value'];
                } else {
                    return stripslashes( $this->_values[$name]['value'] );
                }
            }
        }
    }

    function __set($name, $value)
    {
        $this->_values[$name]['value'] = $value;
    }

    function __isset($name)
    {
        return isset($this->_values[$name]);
    }

    function __unset($name)
    {
        if(isset($this->_values[$name])) {
            unset($this->_values[$name]);
            unset($this->_types[$name]);
            unset($this->_multilang[$name]);
        }
    }

}