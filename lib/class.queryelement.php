<?php
/**
 * @author Yackushev Denys
 * @package RADCMS
 * @link http://wiki.rad-cms.ru/index.php/Rad_query
 *
 */
class rad_queryelement
{
    /**
     * Name of the element
     *
     * @var string
     */
    var $_name = null;
    
    /**
     * Array of the elements
     *
     * @var mixed array
     */
    var $_elements = null;
    
    /**
     * Glue piece
     *
     * @var string
     */
    var $_glue = null;

    /**
     * Constructor
     * @param   string  The name of the element
     * @param   mixed   String or array
     * @param   string  The glue for elements
     */
    function __construct( $name, $elements, $glue=',' )
    {
        $this->_elements    = array();
        $this->_name        = $name;
        $this->append( $elements );
        $this->_glue        = $glue;
    }

    /**
     * Appends element parts to the internal list
     * @param   mixed   String or array
     */
    function append( $elements, $glue = NULL )
    {
        $glue = ($glue)?$glue:$this->_glue;
        if (is_array( $elements )) {
            $this->_elements =  array_merge( $this->_elements, array($elements=>$glue) ) ;
        } else {
            $this->_elements =  array_merge( $this->_elements, array( array($elements=>$glue) ) ) ;
        }
    }

    /**
     * Render the query element
     * @return  string
     */
    function toString()
    {
        $s = "\n{$this->_name} ";
        foreach($this->_elements as $element) {
            $first = true;
            foreach($element as $condition=>$glue) {
                $s .= ($first)?' '.$glue.' '.$condition:$condition;
                $first = false;
            }
        }
        return $s;
    }
}