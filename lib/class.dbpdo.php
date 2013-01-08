<?php
/**
 * Database Layer Class
 * Extends PDO Library (PDO.dll PDO.so PDO_MYSQL.dll\so)
 * @author Yackushev Denys
 * @version 0.2.1
 * @datecreated 25.10.2008
 * @package RADCMS
 *
 */
class rad_dbpdo
{
    const FETCH_ASSOC = PDO::FETCH_ASSOC;
    const FETCH_NUM   = PDO::FETCH_NUM;
    const FETCH_BOTH  = PDO::FETCH_BOTH;
    const FETCH_COLUMN = PDO::FETCH_COLUMN;
    /**
     * Self instance
     *
     * @var PDO
     */
    protected static $dbc = null;

  /**
   * Connected to database?
   */
    protected static $connected = false;

    private static $sql_history = array();

    /**
     * Check connection to sql server and connect ti server if not connected
     *
     * @param array mixed $config - global config
     * @param $driver_options - PDO driver options
     */
    protected function check_connection($config=null,$driver_options=null)
    {
        if(!$config) global $config;
        if(!empty($config['db_config'])) {
            $db_config = &$config['db_config'];
        } else {
            throw new rad_exception('db_config not found at config!');
        }
        if(!self::$dbc){
            try{
                self::$dbc = new PDO($db_config['db_server'].':host='.$db_config['db_hostname'].';dbname='.$db_config['db_databasename'],$db_config['db_username'],$db_config['db_password'],$driver_options);
                self::$connected = true;
                self::exec(rad_config::getParam('setNames'));
            }catch(PDOException $e){
                throw new rad_exception("PDO Error!: ".$e->getMessage());
            }
        }
    }

  /**
   * Show connected to DB or not
   * @return Boolean must be true ;)
   */
    public static function connected()
    {
      return self::$connected;
    }

    /**
     * Constructor
     *
     * @param array $db_config
     * @param string $driver_options PDO driver options
     * @return class
     */
    function __construct($db_config=null,$driver_options=null)
    {
        die('You can\'t create the system class!');
        /*
        try{
            parent::__construct($db_config['db_server'].':host='.$db_config['db_hostname'].';dbname='.$db_config['db_databasename'],$db_config['db_username'],$db_config['db_password'],$driver_options);
        }catch (PDOException $e){
            print "Error! :".$e->getMessage().'<br>';
            die();
        }
        */
    }

    /**
     * Execute an a query
     * @param string $query
     * @param array $params
     * @return PDOStatement object
     */
    public static function query($query, $params=null)
    {
        self::check_connection();
        self::$sql_history[] = $query;
        if(is_object($query) and get_class($query)=='rad_query') {
            $params = $query->getValues();
            $query = $query->toString();
        }
        if(is_array($params)) {
            $result = self::$dbc->prepare($query);
            $result->execute($params);
        }elseif(!empty($params)) {
            $result = self::$dbc->prepare($query);
            $result->execute(array($params));
        } else {
            $result = self::$dbc->query($query);
        }
        if ((int)self::$dbc->errorCode()) {
            $info = self::$dbc->errorInfo();
            throw new rad_exception('Error in query syntax: ' . $query.' in sql: '.$query, self::$dbc->errorCode());
            return false;
        }
        return $result->fetch(rad_dbpdo::FETCH_ASSOC);
    }

    /**
     * Query all of rows and return array of struct's
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement object array
     */
    public static function queryAll($query, $params = null)
    {
        self::check_connection();
        self::$sql_history[] = $query;
        if(is_object($query) and get_class($query)=='rad_query') {
            $params = $query->getValues();
            $query = $query->toString();
        }
        if(is_array($params)) {
            $result = self::$dbc->prepare($query);
            $result->execute($params);
        } else {
            $result = self::$dbc->query($query);
        }
        if (!$result) {
            $info = self::$dbc->errorInfo();
            throw new rad_exception('Error in query syntax: ' . $info[2].' in sql: '.$query, self::$dbc->errorCode());
            return false;
        }
        return $result->fetchAll(rad_dbpdo::FETCH_ASSOC);
    }

    /**
     *
     * @param rad_struct $struct
     * @param string $tablename
     * @return integer (count of inserted rows)
     */
    public static function insert_struct(rad_struct $struct, $tablename)
    {
        $pr_key = $struct->getPrimaryKey();
        if($pr_key) {
            unset( $struct->$pr_key );
        }
        $res = self::$dbc->prepare( 'INSERT INTO '.$tablename.'('.implode(',',$struct->getKeys('`',true)).')values(:'.implode(',:',$struct->getKeys('',true)).');' );
        $res->execute( $struct->StructToArray('',true) );
        if((int)$res->errorCode()) {
        	throw new rad_exception('Error in query syntax: ' . print_h($res->errorInfo(),true).' in sql: '. $res->errorCode());
        }
        if($res and rad_config::getParam('cache.power',false)) {
            //rad_cacheutils::incTableVer($tablename);
        }
        return $res->rowCount();
    }

    /**
     * Updates the struct in DB by it primaryField
     *
     * @param rad_struct $struct
     * @param string $tablename table name
     * @return number of updated rows (as usually 1)
     */
    public static function update_struct( rad_struct $struct, $tablename)
    {
        if($struct->getPrimaryKey()){
            $sql = 'UPDATE '.$tablename.' SET ';
            $arr_keys = array();
            foreach($struct->getKeys('',true) as $id=>$key) {
                if($key!=$struct->getPrimaryKey()) {
                    $arr_keys[] = '`'.$key.'`=:'.$key;
                }
            }
            $sql .= implode(', ', $arr_keys).' WHERE `'.$struct->getPrimaryKey().'`=:'.$struct->getPrimaryKey();
            $res = self::$dbc->prepare($sql);
            $res->execute($struct->StructToArray('',true));
            if((int)$res->errorCode()) {
            	print_h($res->errorInfo());
            }
            if($res and rad_config::getParam('cache.power',false)) {
                //rad_cacheutils::incTableVer($tablename);
            }
            return $res->rowCount();
        }else{
            throw new rad_exception('Функция update_struct работает ТОЛЬКО с теми структурами, у которых объявлен primary key как одно поле!');
            $res = 0;
            return $res;
        }
    }

    /**
     * Delete the record in DB by it struct
     *
     * @param $struct rad_struct
     * @param $tablename string
     *
     * @return integer number of deleted items
     */
    public static function delete_struct( rad_struct $struct, $tablename )
    {
        $pr_key = $struct->getPrimaryKey();
        if($pr_key){
            $res = self::$dbc->prepare( 'DELETE FROM '.$tablename.' WHERE `'.$pr_key.'`=?' );
            $res->execute( array($struct->$pr_key) );
            if($res and rad_config::getParam('cache.power',false)) {
                //rad_cacheutils::incTableVer($tablename);
            }
            return $res->rowCount();
        }else{
            throw new rad_exception('Функция delete_struct работает ТОЛЬКО с теми структурами, у которых объявлен primary key как одно поле!');
            $res = 0;
            return $res;
        }
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     * Just analog of PDO functions
     * @param string $query
     * @param boolean $escapeCheck - Need to escape for deletes,updates and inserts?
     * @return integer numrows
     */
    public static function exec($query='',$escapeCheck=false)
    {
        self::check_connection();
        self::$sql_history[] = $query;
        if($escapeCheck) {
            return self::$dbc->exec($query);
        } elseif(rad_config::getParam('cache.power') and !1) {
//         die('cache.power file: '.__FILE__.' and line: '.__LINE__);
            $sql = trim($query);
            $tmp = explode(' ',$sql);
            //TODO Add more sql operators!
            switch( strtolower($tmp[0]) ){
                case 'insert':
                case 'select':
                case 'delete':
                    $res = self::$dbc->exec($query);
                    if($res)
                        rad_cacheutils::incTableVer(trim($tmp[2]));
                    break;
                case 'truncate':
                case 'update':
                    $res = self::$dbc->exec($query);
                    if($res)
                        rad_cacheutils::incTableVer(trim($tmp[1]));
                    break;
                case 'show':
                case 'set':
                    $res = self::$dbc->exec($query);
                    break;
                default:
                    print_h($tmp);
                    throw new rad_exception('can\'t parse SQL when power caching is on!',__LINE__);
                    break;
            }//switch
            return $res;
        } else {
            return self::$dbc->exec($query);
        }
    }

    /**
     * Begins the transaction
     * @see PDO->beginTransaction();
     * @return Boolean
     */
    public static function beginTransaction()
    {
        return self::$dbc->beginTransaction();
    }

    /**
     * Rolls back the transaction
     * @see PDO->rollBack()
     * @return Boolean
     */
    public static function rollBack()
    {
        return self::$dbc->rollBack();
    }

    /**
     * Commits the transaction
     * @see PDO->commit()
     * @return boolean
     */
    public static function commit()
    {
        return self::$dbc->commit();
    }

    /**
     * returns true, if has alternative transaction;
     * @return boolean
     */
    public static function hasActiveTransaction()
    {
        return self::$dbc->hasActiveTransaction();
    }

    /**
     * Fetch extended error information associated with the last operation on the database handle
     * @return string errorInfo
     */
    public static function errorInfo()
    {
        return self::$dbc->errorInfo();
    }

    /**
     *  Fetch the SQLSTATE associated with the last operation on the database handle
     * @return string errorCode
     */
    public static function errorCode()
    {
        return self::$dbc->errorCode();
    }

    /**
     * Self class name
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ ;//. ": [{$this->code}]: {$this->message}\n";
    }

    public static function lastInsertId()
    {
        return self::$dbc->lastInsertId();;
    }

    /**
     * Get PDO connection attributes and db status
     * @return mixed array
     */
    public static function getConnectionAttributes()
    {
        $attributes = array(
          'AUTOCOMMIT', 'ERRMODE', 'CASE', 'CLIENT_VERSION', 'CONNECTION_STATUS',
          'ORACLE_NULLS', 'PERSISTENT', 'SERVER_INFO', 'SERVER_VERSION'
        );
        $res = array();
        foreach ($attributes as $val) {
            $res['PDO::ATTR_'.$val] = self::$dbc->getAttribute(constant('PDO::ATTR_'.$val));
        }
        return $res;
    }

    /**
     * Function like mysql_real_escape_string in older DB versions
     *
     * @param string $string
     * @return string
     * @access public
     */
    public static function escapeString($string=NULL)
    {
        return $string;
    }

    /**
     * Unescape
     */
    private function unescapeString($string=NULL)
    {
        return $string;
    }

    /**
     * Returns the array of SQL hostory
     *
     * @access public static
     * @return array mixed
     */
    public static function getHistory()
    {
        return self::$sql_history;
    }

    /**
     * Gets the PDO Object
     * @return /PDO
     */
    public static function getPDO()
    {
    	self::check_connection();
        return self::$dbc;
    }

}