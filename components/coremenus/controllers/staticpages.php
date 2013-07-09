<?php
/**
 * Menus class for simple trees on parent_id for site
 * @package RADCMS
 * @author Denys Yackushev
 */
class controller_coremenus_staticpages extends rad_controller
{
    private $_pid = 152;
    private $showfirstifempty = false;

    /**
     * Add the breadcrumbs vars!
     */
    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('items');
        $bco->add('pages');
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart',$this->_pid,$this->getCurrentLangID());
            $this->showfirstifempty = $params->_get('showfirstifempty',$this->showfirstifempty);
            $this->setVar('params', $params);
        }
        if($this->request('cp') or $this->request('pgid')){
            $this->assignPage();
            //$this->assignRubrics();
        }else{
            $this->assignLanguages();
        }
        //$this->assignRubrics();
        $this->assignMenu();
        if($this->showfirstifempty and !( $this->request('cp') or $this->request('pgid') ) and count($this->getVar('items'))){
            $model = rad_instances::get('model_corearticles_pages');
            $items = $this->getVar('items');
            $model->setState('tre_id',$items[0]->tre_id);
            $pages = $model->getItems(1);
            $this->setVar('pages',$pages);
            $this->addBC('pages',$pages);
        }
    }

    /**
     * Assign languages for changing languages
     */
    function assignLanguages()
    {
        $this->setVar('languages', rad_instances::get('model_core_lang')->getItems() );
        $this->setVar('currLangID', $this->getCurrentLangID() );
        $this->setVar('currLang', $this->getCurrentLang() );
    }

    function assignMenu()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->_pid);
        $model->setState('tre_active','1');
        $items = $model->getItems(true);
        if($this->request('cp'))
            $this->getActiveMenu($items);
        $this->setVar('items', $items);
        $this->addBC('items', $items);
    }

    /**
     * Assign page or pages
     *
     */
    function assignPage()
    {
        $c = (int)$this->request('cp',0);
        $pg_id = (int)$this->request('pgid',0);
        //print_r($this->getAllRequest());
        if($c){
            $model = rad_instances::get('model_corearticles_pages');
            $model->setState('tre_id',$c);
            $items = $model->getItems();
            $this->setVar('pages',$items);
            $this->addBC('pages',$items);
            //print_r($items);
        }elseif($pg_id){
            $model = rad_instances::get('model_corearticles_pages');
            $pages[] = $model->getItem($pg_id);
            $this->setVar('pages', $pages);
            $this->addBC('pages', $pages);
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName() );
        }
    }

    function getActiveMenu(&$items,$level=0)
    {
        if(count($items)){
            for($i=0;$i<count($items);$i++){
                $items[$i]->currActive = false;
                if($items[$i]->tre_id == (int)$this->request('cp')){
                    $items[$i]->currActive = true;
                }
                if( isset( $items[$i]->child ) and ( is_array( $items[$i]->child ) ) and ( count( $items[$i]->child ) ) ){
                    $this->getActiveMenu($items[$i]->child,++$level);
                }
            }
        }else{
            return null;
        }
    }

    function assignRubrics()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('active',1);
        $model->setState('lang',$this->getCurrentLangID());
        $model->setState('pid',$this->_pid);
        $items = $model->getItems();
        $this->setVar('rubrics',$items);
    }

}