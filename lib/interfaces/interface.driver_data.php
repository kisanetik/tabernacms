<?php 
/**
 * Interface for drivers to read and write the data
 * @author denis
 *
 */
interface interface_driver_data
{

    /**
	 * Store data at the server
	 * @param string $key
	 * @param mixed $var
	 * @param mixed $params - some params, in memcach this is the flag
	 * @param integer $expire - expire time in seconds
	 * @return boolean
	 */
    public function set($key, $var=NULL, $params=NULL, $expire=NULL);
    
    /**
     * Retrieve item from the server
     * @param string $key
     * @return mixed|string
     */
    public function get($key);
    
    /**
     * Delete item from the server
     * @param string $key
     */
    public function delete($key);
    
    /**
     *  Flush all existing items at the server
     *  @return boolean
     */
    public function flush();
}