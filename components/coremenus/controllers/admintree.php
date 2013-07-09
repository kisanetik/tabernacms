<?php
/**
 * Menus class for simple trees on parent_id for the admin
 * @package RADCMS
 * @author Denys Yackushev
 */
class controller_coremenus_admintree extends rad_controller
{

    private $_pid = 57;

    public static function exportedVars()
    {

    }

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->setVar('params',$params);
            $this->_pid = $params->treestart;
        }
        $this->manage();
    }

    /**
     * main init function
     *
     */
    function manage()
    {
        $tree = rad_instances::get('model_coremenus_tree');
        $tree->setState('tre_active', 1);
        $tree->setState('pid', $this->_pid);
        $tree->setState('order','tre_position');
        $tree->setState('access',$this->getCurrentUser()->u_access);
        $this->setVar('items', $tree->getItems(true) );
        $this->setVar('user_params',$this->getCurrentUserParams() );
        $model = new model_core_table('lang');
        $langs = $model->getItems();
        $this->setVar('langs', $langs );
        $this->setVar('contentLngId',$this->getContentLangID());
    }

}