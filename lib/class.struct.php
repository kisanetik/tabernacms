<?php

/**
 * Base class for Structs
 *
 * @author    Yackushev Denys
 * @version   0.2.1
 * @package   RADCMS
 *
 */
class rad_struct
{
    /**
     * Primary key of the table
     *
     * @var string
     */
    private $__primaryKey = NULL;

    private $__ignoresList = array();

    /**
     * Adds field name to the ignores list when update or insert this struct
     * @param string $fieldName
     */
    public function addFieldToIgnoresList($fieldName)
    {
        if(is_array($fieldName)){
            $this->__ignoresList = array_merge($this->__ignoresList,$fieldName);
        }else{
            $this->__ignoresList[] = $fieldName;
        }
        return $this;
    }

    /**
     * Fill Struct with data from Array (or Object - To do list)
     *
     * @param array $array
     * @access protected
     */
    public function CopyToStruct($array)
    {
        if(!empty($array)) {
            foreach($array as $key => $value) {
                if(isset($this->$key)){
                    $this->$key=$value;
                }
            }
        }
          return $this;
    }

    /**
     * Protected function, to save this struct to it table by it primary key
     * @return integer number of updated rows (as usually 1)
     */
    public function save()
    {
        $prKey = $this->getPrimaryKey();
        if(!$this->$prKey) {
            return $this->insert();
        }
        return rad_dbpdo::update_struct($this, $this->_getTableName());
    }

    /**
     * Inserts the item!
     * @return integer number of inserted rows (as usually 1)
     */
    public function insert()
    {
        $pk = $this->getPrimaryKey();
        if ($rows = rad_dbpdo::insert_struct($this, $this->_getTableName())) {
            $this->$pk = rad_dbpdo::lastInsertId();
        }
        return $rows;
    }

    /**
     * Deletes the item by it PrimaryKey!
     * @return integer number of deleted rows (as usually 1)
     */
    public function remove()
    {
        return rad_dbpdo::delete_struct($this, $this->_getTableName());
    }

    /**
     * Load item by it primary key
     */
    public function load()
    {
        $pk = $this->getPrimaryKey();
        $this->CopyToStruct( rad_dbpdo::query('SELECT '.implode(',', $this->getKeys('`',true)).' FROM '.$this->_getTableName().' WHERE `'.$pk.'`=?', array($this->$pk)) );
        return $this;
    }


    /**
    * Constructor
    *
    * @param array $array (optional)
    * @access public
    */
    public function __construct($array = NULL, $primaryKey = NULL, $ignoresList = NULL)
    {
        if (is_array($array)) {
            $this->CopyToStruct($array);
        }
        if(!is_null($primaryKey)) {
            $this->__primaryKey = $primaryKey;
        }
        if( is_array( $ignoresList ) and count( $ignoresList ) ){
            $this->__ignoresList = $ignoresList;
        }
    }

    /**
     * alias for CopyToStruct function
     * @param mixed $array
     * @return rad_struct | self
     */
    public function MergeArrayToStruct($array) {
        $this->CopyToStruct($array);
        return $this;
    }

    /**
     * Returns the string from array
     *
     * @param array $value
     * @param string $isQuoted
     * @param string $delimiter
     *
     * @return string
     */
    protected function _arrayToStringSQL($value,$isQuoted='',$delimiter=',')
    {
        if( is_array($value) )
        {
            $res = '';
            foreach($value as $key=>$vl) {
                if( strlen($res) ) {
                    $res .= $delimiter;
                }
                if( !is_array( $vl ) ) {
                    $res .= $isQuoted.$vl.$isQuoted;
                } else {
                  $res .= $isQuoted.'rad_array()'.$isQuoted;
                }//if is_array
            }//foreach
            return $res;
        } else {//is array
            return $isQuoted.''.$isQuoted;
        }
    }

    /**
     * Get fields=>values array of this object
     *
     * @param $isQuoted string - quote each field
     * @param boolean $withoutIgnores - Default false
     *
     * @return mixed array
     */
    public function StructToArray($isQuoted='', $withoutIgnores=false)
    {
        $mas = array();
        foreach($this as $key=>$value) {
            if( ($key != '__primaryKey') and ($key != '__ignoresList') and ( !in_array( $key, $this->__ignoresList ) ) ) {
                if($withoutIgnores) {
                    if( !in_array( $key, $this->__ignoresList ) ) {
                        if(!is_array($value)) {
                              $mas[$key]=$isQuoted.$value.$isQuoted;
                        } else {
                               $mas[$key] = $this->_arrayToStringSQL($value,$isQuoted,',');
                        }
                    }
                } else {
                    if(!is_array($value)) {
                         $mas[$key]=$isQuoted.$value.$isQuoted;
                    } else {
                         $mas[$key] = $this->_arrayToStringSQL($value,$isQuoted,',');
                    }
                }
            }//if key
        }
        return $mas;
    }

    /**
     * Get fields of the object
     *
     * @param $isQuoted string - quote each field
     * @param $withputIgnores boolean - get keys with ignores or withput
     *
     * @return mixed array
     */
    public function getKeys($isQuoted='', $withputIgnores = false)
    {
        $mas = array();
        foreach($this as $key=>$value) {
            if($key[0].$key[1] != '__') {
                if($withputIgnores) {
                    if( !in_array( $key, $this->__ignoresList ) ) {
                        $mas[]=$isQuoted.$key.$isQuoted;
                    }
                } else {
                    $mas[]=$isQuoted.$key.$isQuoted;
                }
            }
        }
        return $mas;
    }

    /**
     * Get the name of the primary key field of the table
     *
     * @return string
     * @access public
     */
    public function getPrimaryKey()
    {
        return $this->__primaryKey;
    }

    protected function _getComponentName(){
        static $result = null;
        if ($result === null) {
            $parts = explode('_', get_class($this));
            $result = count($parts) < 2 ? false : $result = $parts[1];
        }
        return $result;
    }

    protected function _getComponentClass(){
        static $result = null;
        if ($result === null) {
            $parts = explode('_', get_class($this));
            if (count($parts) < 3) {
                $result = false;
            } else {
                array_shift($parts); array_shift($parts);
                $result =  implode('_', $parts);
            }
        }
        return $result;
    }

    protected function _getTableName(){
        static $result = null;
        if ($result === null) $result = RAD . $this->_getComponentClass();
        return $result;
    }
}