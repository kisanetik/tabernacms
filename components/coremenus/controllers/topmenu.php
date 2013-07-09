<?php
/**
 * Menus class for simple trees on parent_id for the admin
 * @package Taberna
 * @author Denys Yackushev
 */
class controller_coremenus_topmenu extends rad_controller
{
    private $_pid = 45;
    
    private $_title = 0;
    
    /**
     * Add the breadcrumbs vars!
     */
    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('items');
        $bco->add('curr_item');
        $bco->add('topmenu_level0',2);
        $bco->add('topmenu_level1',2);
        $bco->add('topmenu_level2',2);
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getCurrentLangID());
            $this->_title = $params->_get('title',$this->_title,$this->getContentLangID());
            $this->setVar('params', $params);
            $this->setVar('title', $this->_title);
        }
        $this->assignLanguages();
        $this->assignMenu();
        $this->setVar('langs',$this->getAllLanguages());
        $this->setVar('curLangID',$this->getCurrentLangID());
        $this->setVar('user', $this->getCurrentUser());
    }

    /**
     * Assign languages for changing languages
     */
    function assignLanguages()
    {
        $this->setVar('languages', $this->getAllLanguages() );
        $this->setVar('currLangID', $this->getCurrentLangID());
        $this->setVar('currLang', $this->getCurrentLang());
    }

    function getActiveMenu($items, $level=0)
    {
        if(count($items) and (int)$this->request('m_id', $this->request('menu_id'))) {
            foreach($items as &$id) {
                if($id->tre_id==(int)$this->request('m_id', $this->request('menu_id'))) {
                    return $id;
                }
                if(!empty($id->child)) {
                    $res = $this->getActiveMenu($id->child, ++$level);
                    if(!empty($res)) {
                        return $res;
                    }
                }
            }
        } else {
            return null;
        }
    }

    function assignMenu()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->_pid);
        $model->setState('active',1);
        $model->setState('access',(!empty($this->getCurrentUser()->u_access)?$this->getCurrentUser()->u_access:1000));
        $items = $model->getItems(true);
        $this->addBC('items', $items);
        $curr_item = $this->getActiveMenu($items);
        $this->addBC('curr_item', $curr_item );
        $this->setVar('curr_item', $curr_item );
        $this->setVar('items',$items);
    }

}