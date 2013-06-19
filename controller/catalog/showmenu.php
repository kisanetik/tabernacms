<?php
/**
 * Class for menu of a catalog
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_catalog_showmenu extends rad_controller
{
	private $_pid = 38;

    private $_countitems = 3;
    
    private $_get_all_recursive = false;

    private $_menuEffect = 1;
    
	public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('items');
        $bco->add('curr_item');
        return $bco;
    }
	
	function __construct()
	{
		 if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->treestart;
            $this->_countitems = $params->countitems;
            $this->_get_all_recursive = (boolean)$params->get_all_recursive;
            $this->_menuEffect = $params->menueffect;
            $this->setVar('params',$params);
         }
        /** @var $model model_menus_tree */
         $model = rad_instances::get('model_menus_tree');
         $model->setState('pid', $this->_pid);
         $model->setState('lang',$this->getCurrentLangID());
         $model->setState('active', 1);
         $model->setState('menueffect',$this->_menuEffect);
         $cat = (int)$this->request('cat');
         if($cat) {
             $items = $model->getItems(true);
             $this->_recSetActive($items,$cat);
         } else {
             $items = $model->getItems( ($params->startlevels>1 or $this->_get_all_recursive) );
             for($i=0;$i<count($items);$i++){
                 $items[$i]->selected = false;
             }
         }
         $this->setVar('items', $items );
         $this->setVar('menueffect',$this->_menuEffect);
         $this->addBC('items', $items);
	}
	
    private function _recSetActive(&$items,$active_id)
    {
        for($i=0;$i<count($items);$i++ ) {
            $items[$i]->selected = ($items[$i]->tre_id==$active_id);
            if(is_array($items[$i]->child)) {
                if(!$items[$i]->selected) {
                    $items[$i]->selected = $this->_recSetActive($items[$i]->child,$active_id);
                } else {
                     $this->_recSetActive($items[$i]->child,$active_id);
                }
                $result = $items[$i]->selected;
            } else {
                if($items[$i]->selected) {
                    $result = true;
                }
            }
        }
        $result = (isset($result))?$result:false;
        return $result;
    }
}