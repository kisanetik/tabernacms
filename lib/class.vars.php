<?php
/**
 * Abstract class for using the vars associated with keys
 * @package RADCMS
 * @author Denys Yackushev
 * @datecreated 17 October 2011
 */
abstract class rad_vars
{
    /**
     * Set variable
     * @param $key string
     * @param @value mixed
     * @return rad_vars
     * @access public
     */
    public function setVar($key=null,$value=null)
    {
        if($key){
            $this->outputs[$key]=$value;
        }
        return $this;
    }

    /**
 * Set variable by Ref link
 * @param $key string
 * @param @value mixed
 * @return rad_vars
 * @access public
 */
    public function setVarByRef($key=null, &$value)
    {
        if($key){
            $this->outputs[$key]=$value;
        }
        return $this;
    }

    /**
     * Gets the variable
     * @param $key string
     * @param mixed $defaultValue
     * @return mixed
     * @access public
     */
    public function getVar($key=null, $defaultValue=NULL)
    {
        if(isset($this->outputs[$key])) {
           return $this->outputs[$key];
        }
        return $defaultValue;

    }

    /**
     * Unset local variable
     * @param $key string
     * @return Boolean
     * @access public
     */
    public function unsetVar($key=null){
       if(isset($this->outputs[$key])){
           unset($this->outputs[$key]);
           return true;
       }
       return false;
    }

    /**
     * Get all setted variavles
     * @return mixed array
     * @access public
     */
    public function getVars()
    {
        if(count($this->outputs))
           return $this->outputs;
        else return null;
    }

    /**
     * Set the vars
     * @param mixed $vars
     * @return rad_vars
     */
    public function setVars($vars)
    {
        if(is_array($vars)) {
            $this->outputs = $vars;
        }
        return $this;
    }
}