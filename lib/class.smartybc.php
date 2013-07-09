<?php
class rad_smartybc extends Smarty_Resource_Custom
{
    // PDO instance
    protected $db;
    // prepared fetch() statement
    protected $fetch;
    // prepared fetchTimestamp() statement
    protected $mtime;

    public function __construct() {

    }

    /**
     * Fetch a template and its modification time from database
     *
     * @param string $name template name
     * @param string $source template source
     * @param integer $mtime template modification timestamp (epoch)
     * @return void
     */
    protected function fetch($name, &$source, &$mtime)
    {
        //die('nnnn='.$name);
        $mtime = time();
        switch($name) {
            case 'title_script':
                $source = rad_breadcrumbs::$title_script;
                return true;
                break;
            case 'meta_script':
                $source = rad_breadcrumbs::$meta_script;
                return true;
                break;
            case 'breadcrumbs_script':
                $source = rad_breadcrumbs::$breadcrumbs_script;
                return true;
            case 'description_script':
                $source = rad_breadcrumbs::$description_script;
                return true;
                break;
            default:
                die('name='.$name);
                return false;
            break;
        }//switch
    }

    /**
     * Fetch a template's modification time from database
     *
     * @note implementing this method is optional. Only implement it if modification times can be accessed faster than loading the comple template source.
     * @param string $name template name
     * @return integer timestamp (epoch) the template was modified
     */
    protected function fetchTimestamp($name) {
        return time();
    }
}