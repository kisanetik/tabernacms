<?php
/**
 * @author Yackushev Denys
 * @package RADCMS
 * @link http://wiki.rad-cms.ru/index.php/Rad_query
 *
 */
class rad_query
{
    /**
     * The query type
     *
     * @var string
     */
    var $_type = '';
    
    /**
     * The select element
     *
     * @var object
     */
    var $_select = null;
    
    /**
     * The form element
     *
     * @var object
     */
    var $_from = null;
    
    /**
     * The join element
     *
     * @var object
     */
    var $_join = null;
    
    /**
     * The where element
     *
     * @var object
     */
    var $_where = null;
    
    /**
     * The group element
     *
     * @var object
     */
    var $_group = null;
    
    /**
     * The where element
     *
     * @var object
     */
    var $_having = null;
    
    /**
     * The where element
     *
     * @var object
     */
    var $_order = null;
    
    var $_values = null;

    /**
     * Constructor
     */
    function __construct()
    {
    }

    /**
     * Adds the value to the 
     */
    function value($value)
    {
        if(is_array($value)){
            while(list($key, $val) = each($value))
                $this->_values[$key] = $val;
        }else{
            $this->_values[] = $value;
        }
        return $this;
    }
    
    /**
     * Returns the added values
     */
    function getValues()
    {
        return $this->_values;
    }
    
    /**
     * @param   mixed   A string or an array of field names
     */
    function select( $columns )
    {
        $this->_type = 'select';
        if (is_null( $this->_select )) {
            $this->_select = new rad_queryelement( 'SELECT', $columns );
        } else {
            $this->_select->append( $columns );
        }
        return $this;
    }

    /**
     * @param   mixed   A string or array of table names
     */
    function from( $tables )
    {
        if (is_null( $this->_from )) {
            $this->_from = new rad_queryelement( 'FROM', $tables );
        } else {
            $this->_from->append( $tables );
        }
        return $this;
    }

    /**
     * @param   string
     * @param   string
     */
    function join( $type, $conditions )
    {
        if (is_null( $this->_join )) {
            $this->_join = array();
        }
        $this->_join[] = new rad_queryelement( strtoupper( $type ) . ' JOIN', $conditions );
        return $this;
    }

    /**
     * @param mixed $columns - A string or array of where conditions
     * @param string $glue
     */
    function where( $conditions, $glue='AND' )
    {
        if (is_null( $this->_where )) {
            $glue = strtoupper( $glue );
            $this->_where = new rad_queryelement(  'WHERE', $conditions, "\n\t$glue " );
        } else {
            $this->_where->append( $conditions );
        }
        return $this;
    }

    /**
     * @param mixed $columns -  A string or array of ordering columns
     * 
     */
    function group( $columns )
    {
        if (is_null( $this->_group )) {
            $this->_group = new rad_queryelement( 'GROUP BY', $columns );
        } else {
            $this->_group->append( $columns );
        }
        return $this;
    }

    /**
     * @param   mixed   A string or array of ordering columns
     * @param string $glue
     */
    function having( $columns, $glue='AND' )
    {
        if (is_null( $this->_having )) {
            $this->_having = new rad_queryelement( 'HAVING', $columns, "\n\t$glue " );
        } else {
            $this->_having->append( $columns );
        }
        return $this;
    }

    /**
     * @param   mixed   A string or array of ordering columns
     */
    function order( $columns )
    {
        if (is_null( $this->_order )) {
            $this->_order = new rad_queryelement( 'ORDER BY', $columns );
        } else {
            $this->_order->append( $columns );
        }
        return $this;
    }

    /**
     * @return  string  The completed query
     */
    function toString()
    {
        $query = '';

        switch ($this->_type)
        {
            case 'select':
                $query .= $this->_select->toString();
                $query .= $this->_from->toString();
                if ($this->_join) {
                    // special case for joins
                    foreach ($this->_join as $join) {
                        $query .= $join->toString();
                    }
                }
                if ($this->_where) {
                    $query .= $this->_where->toString();
                }
                if ($this->_group) {
                    $query .= $this->_group->toString();
                }
                if ($this->_having) {
                    $query .= $this->_having->toString();
                }
                if ($this->_order) {
                    $query .= $this->_order->toString();
                }
                break;
        }

        return $query;
    }
    
    /**
     * Query an a element
     * @return mixed array
     */
    function query()
    {
        return rad_dbpdo::query($this->toString(), $this->getValues());
    }
    
    /**
     * Query an a element
     * @param string $limit
     * @return mixed array
     */
    function queryAll($limit=NULL)
    {
        $limit = ($limit)?' LIMIT '.$limit:'';
        return rad_dbpdo::queryAll($this->toString().$limit, $this->getValues());
    }
    
    /**
     * Query an a element and return the rad_struct
     * @param string $result_struct
     * @return rad_struct
     */
    function getItem($result_struct)
    {
        $result = null;
        $res = rad_dbpdo::query($this->toString(), $this->getValues());
        if($res)
            $result = new $result_struct($res);
        return $result;
    }
    
    /**
     * Query an a element and return the mixed array of rad_struct
     * @param string $result_struct
     * @param string $limit
     * @return mixed array of rad_struct
     */
    function getItems($result_struct, $limit=null)
    {
        $limit = ($limit)?' LIMIT '.$limit:'';
        $result = null;
        $res = rad_dbpdo::queryAll($this->toString().$limit, $this->getValues());
        if($res)
            foreach($res as $id){
                $result[] = new $result_struct($id);
            }
        return $result;
    }
}