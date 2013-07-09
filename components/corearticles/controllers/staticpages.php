<?php
/**
 * Menus class for simple static pages From DB
 * @package RADCMS
 * @author Denys Yackushev
 *
 */
class controller_corearticles_staticpages extends rad_controller
{
    private $_pid = 18;
    private $showfirstifempty = false;
    /**
     * Расположение страницы в дереве категорий
     * @var mixed
     */
    private $_pages_tree = array();
    
    /**
     * Показывать только одну страницу?
     * @var boolean
     */
    private $_isshowpage = false;
    
    private $_assignRubric = 0;

    /**
     * Add the breadcrumbs vars!
     */
    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('items');
        $bco->add('pages');
        $bco->add('rubrics');
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getCurrentLangID());
            $this->showfirstifempty = $params->_get('showfirstifempty',$this->showfirstifempty);
            $this->_isshowpage = $params->_get('isshowpage', $this->_isshowpage);
            $this->_assignRubric = $params->_get('assignrubric', $this->_assignRubric, $this->getCurrentLangID());
            $this->setVar('params', $params);
            
        }
        if($this->request('cp') or $this->request('pgid') or $this->_assignRubric) {
            $this->assignPage();
            if($this->getVar('item')) {
                $this->assignRubrics($this->getVar('item'));
                $this->assignSuRubrics($this->getVar('item'));
            }
        } elseif($this->request('title')) {
            $this->assignPageByName();
            if($this->getVar('item')) {
                $this->assignRubrics($this->getVar('item'));
                $this->assignSuRubrics($this->getVar('item'));
            }
        } else {
            $this->assignLanguages();
        }
        if($this->_isshowpage) {
            $table = new model_core_table('pages','corearticles');
            $page = $table->getItem($params->pgid);
            $this->setVar('item', $page);
            $this->addBC('pages', array($page));
        } elseif(!$this->_assignRubric) {
            $this->assignMenu();
            if($this->showfirstifempty and !( $this->request('cp') or $this->request('pgid') ) and count($this->getVar('items'))) {
                $model = rad_instances::get('model_corearticles_pages');
                $items = $this->getVar('items');
                if(!empty($items)) {
                    $model->setState('tre_id',$items[0]->tre_id);
                    $pages = $model->getItems(1);
                    $this->setVar('pages',$pages);
                    $this->addBC('pages',$pages);
                }//if !empty items
            }
        } else {
            $this->setVar('title', rad_instances::get('model_coremenus_tree')->getItem((int)$this->_assignRubric));
        }


       $this->setVar('page',$this->request('page', 0)) ;
        
    }

    /**
     * Assign languages for changing languages
     */
    function assignLanguages()
    {
        //$this->setVar('languages', rad_instances::get('model_core_lang')->getItems() );
        $this->setVar('languages', $this->getAllLanguages() );
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
        $c = (int)($this->_assignRubric)?$this->_assignRubric:$this->request('cp');
        $pg_id = (int)$this->request('pgid',0);
        if($c){
            $model = rad_instances::get('model_corearticles_pages');
            $model->setState('tre_id',$c);
            $items = $model->getItems();
            $this->setVar('pages',$items);
            $this->addBC('pages',$items);
            if(count($items)<1){
                $this->redirect('404');
            }
        }elseif($pg_id){
            $model = rad_instances::get('model_corearticles_pages');
            $pages[] = $model->getItem($pg_id);
            $this->setVar('pages', $pages);
            $this->addBC('pages', $pages);
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName() );
        }
    }
    
    function assignPageByName()
    {
        //$title = urldecode(trim($this->request('title')));
        $title = trim($this->request('title'));
        if($title) {
            $model = rad_instances::get('model_corearticles_pages');
            $model->setState('name', $title);
            $item = $model->getItem();
            if($item) {
                $this->setVar('item', $item);
                $pages[] = $item;
                $this->addBC('pages', $pages);
            } else {
                $this->redirect('404');
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
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

    function assignRubrics(struct_corearticles_pages $page)
    {
        if(!isset($this->_pages_tree[$page->pg_id])) {
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('active',1);
            $model->setState('lang',$this->getCurrentLangID());
            $array_rubrics[] = $model->getItem($page->pg_tre_id);
            if(!empty($array_rubrics[0]) and $array_rubrics[0]->tre_pid!=0 and $array_rubrics[0]->tre_id!=$this->_pid) {
                while($array_rubrics[count($array_rubrics)-1]->tre_id!=$this->_pid and $array_rubrics[count($array_rubrics)-1]->tre_pid!=0) {
                    $array_rubrics[] = $model->getItem( $array_rubrics[count($array_rubrics)-1]->tre_pid );
                }
            }
            unset($array_rubrics[count($array_rubrics)-1]);
            $array_rubrics = array_reverse($array_rubrics);
            $this->_pages_tree[$page->pg_id] = $array_rubrics;
        }
    //print_h($this->_pages_tree[$page->pg_id]);die('sys_pid='.$this->_pid);
        $this->setVar('rubrics', $this->_pages_tree[$page->pg_id]);
        $this->addBC('rubrics', $this->_pages_tree[$page->pg_id]);

        
    }
    
    function assignSuPages(struct_corearticles_pages $page)
    {
        $model = rad_instances::get('model_corearticles_pages');
        $model->clearState();
        $model->setState('tre_id', $page->pg_tre_id);
        $items = $model->getItems();
        $this->setVar('subPages', $items);
        /*Get the parent tree*/
        $model_tree = rad_instances::get('model_coremenus_tree');
        $parentTree = $model_tree->getItem($page->pg_tre_id);
        $this->setVar('parentTree', $parentTree);
    }
    
    function assignSuRubrics(struct_corearticles_pages $page)
    {
      $model = rad_instances::get('model_coremenus_tree');
      $currTree = $model->getItem($page->pg_tre_id);
      if(!empty($currTree->tre_id)) {
        $model->clearState();
        $model->setState('active', 1);
        $model->setState('lang', $this->getCurrentLangID());
        $model->setState('pid', $currTree->tre_pid);
        $subTrees = $model->getItems();
        $this->setVar('subTrees', $subTrees);
      }
    }

}