<?php
class rad_states
{
    /**
     * For model fields state
     * @var mixed array
     */
    protected $_state = null;


    /**
     * To set state of object
     *
     * @param string $key
     * @param mixed $value
     */
    function setState($key,$value=null)
    {
        $this->_state[$key] = $value;
        return $this;
    }

    /**
     * Gets the state of object by key
     *
     * @param string $key
     *
     * @return mixed
     */
    function getState($key,$defValue = NULL)
    {
        if(isset($this->_state[$key]))
            return $this->_state[$key];
        else
            return $defValue;
    }
    
    /**
     * Check if state exists
     * @param string $key
     * @return boolean
     */
    function issetState($key) 
    {
        return isset($this->_state[$key]);
    }

    /**
     * Unset the state of object by key
     *
     * @param string $key
     */
    function unsetState($key)
    {
        if(isset($this->_state[$key]))
            unset($this->_state[$key]);
        return $this;
    }

    /**
     * Get all states of a object
     *
     * @return mixed array
     *
     */
    function getStates()
    {
        return $this->_state;
    }
    
    /**
     * Rewrite all interlan states
     * @param mixed $states
     * @return rad_states
     */
    function setStates($states)
    {
        $this->_state = $states;
        return $this;
    }

    //TODO Optimize this function
    /**
     * Clear object state
     *
     */
    function clearState()
    {
        if(count($this->_state)) {
            foreach($this->_state as $key=>$value) {
                unset($this->_state[$key]);
            }
        }
        return $this;
    }
}