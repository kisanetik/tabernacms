<?php
/**
 * Base class for models
 * @author Denys Yackushev
 * @package RADCMS
 */
abstract class rad_model extends rad_states
{
    /**
     * for internal SQL query
     *
     * @var string
     */
    protected $_sql = null;

    /** return the Current class name in child
     * @return string
     * @access public
     */
    final public function getClassName()
    {
        return get_class($this);
    }

    /**
     * Alias for rad_dbpdo::query($sql,$fetchMode)
     *
     * @param string $sql
     * @param array $params
     *
     * @return mixed assoc array
     *
     * @access public
     */
    function query($sql=null, $params = null)
    {
        return rad_dbpdo::query($sql, $params);
    }

    /**
     * Alias for rad_dbpdo::queryAll
     *
     * @param $sql string
     * @param array $params
     *
     * @return mixed assoc array
     *
     * @access public
     */
    public function queryAll($sql=null, $params = null)
    {
        return rad_dbpdo::queryAll($sql, $params);
    }

    /**
     * Alias for rad_dbpdo::exec($sql)
     *
     * @param $sql string
     *
     * @return integer numrows
     *
     * @access public
     */
    public function exec($sql=null)
    {
        return rad_dbpdo::exec($sql);
    }

    /**
     * Alias for rad_dbpdo::update_struct()
     * Need for update some record as struct
     *
     * @param $struct rad_struct
     * @param $tablename - string
     *
     * @return number of updated rows
     */
    protected function update_struct(rad_struct $struct, $tablename)
    {
        return rad_dbpdo::update_struct($struct, $tablename);
    }

    /**
     * Alias for rad_dbpdo::insert_struct()
     * Need for insert some record as struct
     *
     * @param $struct rad_struct
     * @param $tablename - string
     *
     * @return number of inserted rows
     */
    protected function insert_struct(rad_struct $struct, $tablename,$binded=false)
    {
        return rad_dbpdo::insert_struct($struct, $tablename,$binded);
    }

    /**
     * Delete the row by it primary key in struct
     *
     * @param rad_struct $struct
     * @param string $tablename
     *
     * @return number of deleted items
     *
     * @access public
     */
    protected function delete_struct(rad_struct $struct, $tablename)
    {
        return rad_dbpdo::delete_struct($struct, $tablename);
    }

    /**
     * Gets the last inserted autoincremnement field
     * @return integer
     */
    public function inserted_id()
    {
        return rad_dbpdo::lastInsertId();
    }

    /**
     * Sets the message to this classname only and this user!!!
     *
     * @param string $message
     */
    final public function setMessage($message='')
    {
        $_SESSION['messages'][$this->getClassName()] = $message;
    }

    final public function hasMessage()
    {
        return (isset($_SESSION['messages'][$this->getClassName()]));
    }

    /**
     * Gets only for this classname and this user the setted message!
     * If you get the message - the message will me clear!
     *
     * @return string or null if has no setted messages;
     */
    final public function getMessage()
    {
        if(isset($_SESSION['messages'][$this->getClassName()])){
            $result = $_SESSION['messages'][$this->getClassName()];
            unset($_SESSION['messages'][$this->getClassName()]);
        } else {
            $result = NULL;
        }
        return $result;
    }

    //TODO Finish! SecurityHoleAlert must to mail something to admin
    protected function securityHoleAlert($file,$line,$class)
    {
        die('TEMPRORY SECURITY HOLE ALERT AT: '.$file.' LINE:'.$line.' CLASS:'.$class);
    }

   /* Return the object with current user
     *
     * @return struct_core_users
     *
     */
    function getCurrentUser()
    {
        return rad_session::$user;
    }

    /**
     * GEts current PHPSESSID
     *
     * @return string
     */
    function getCurrentSessID()
    {
        return session_id();
    }

/**
     * Gets the current language code string like en,us,ru,uk ...
     *
     * @return string
     */
    public function getCurrentLang()
    {
        return rad_lang::getCurrentLanguage();
    }

    /**
     * Gets the current langID
     *
     * @return integer
     */
    public function getCurrentLangID()
    {
        return rad_lang::getCurrentLangID();
    }

    /**
     * Gets the content language ID
     * @return integer
     */
    public function getContentLangID()
    {
        return rad_lang::getContentLangID();
    }

    /**
     * Checks the rad_config for config and local classname config and returns the true value of the config
     */
    //TODO Finish that function with local params
    final function config($paramname,$defaultValue=NULL)
    {
        return rad_config::getParam($paramname,$defaultValue);
    }

    /**
     * Gets the PDO Object
     * @return /PDO
     */
    function getPDO()
    {
        return rad_dbpdo::getPDO();
    }

    /**
     * Starts the transaction
     * @return boolean
     */
    function beginTransaction()
    {
        return rad_dbpdo::beginTransaction();
    }

    /**
     * Call commit with opened transaction
     * @return boolean
     */
    function commitTransaction()
    {
        return rad_dbpdo::commit();
    }

    /**
     * Rolls back the transaction
     * @return boolean
     */
    function rollBackTransaction()
    {
        return rad_dbpdo::rollBack();
    }

    /**
     * Returns true if has alternative transaction
     * @return boolean
     */
    function hasActiveTransaction()
    {
        return rad_dbpdo::hasActiveTransaction();
    }

}
