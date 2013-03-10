<?php
/**
 * Bread Crumbs object for the scripts of breadcrumbs
 * @author Yackushev Denys
 * @package RADCMS
 *
 */
class rad_breadcrumbsobject
{

    private $_vars = null;

    /**
     * Adds the var name to the vars cache
     *
     * @param string $varname
     * @param integer type, simple param=1, if autogenere <a href - then 2
     */
    function add($varname, $type=1)
    {
        $this->_vars[$type][] = $varname;
    }

    /**
     * Get the vars
     * @param integer type of returned vars
     * @return array mixed
     *
     */
    function getVars($type=1)
    {
        if(isset($this->_vars[$type])) {
            return $this->_vars[$type];
        } else {
            return null;
        }
    }

}