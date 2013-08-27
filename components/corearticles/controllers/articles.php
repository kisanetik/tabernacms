<?php
/**
 * <en>Class for showing articles on site</en>
 * <ru>Клас отображения статей на сайте</ru>
 * @author Denys Yackushev
 * @package RADCMS
 * @version 0.2
 */
class controller_corearticles_articles extends rad_controller
{
    private $_pid = 19;
    /**
     * Is need to show articles at menu
     * @var boolean
     */
    private $_ismenu = false;
    private $_ordering = 'random';
    private $_blocktitle = '';
    private $_itemsPerPage = 2;
    private $_isweek = 0;
    private $_onmain = 0;
    private $_menumode = 1;

    private $_currArticleTreeItem  = 0;

    /**
     * Add the breadcrumbs vars!
     */
    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('curr_category');
        $bco->add('category_path');
        $bco->add('default_pid');
        $bco->add('item');
        return $bco;
    }

    function __construct()
    {
        if($params = $this->getParamsObject()) {
            $this->_ismenu = $params->_get('is_menu', $this->_ismenu);
            $this->_menumode = $params->_get('menumode', $this->_menumode);
            $this->_itemsPerPage = $params->itemsperpage;
            $this->_ordering = $params->ordering;
            $this->_blocktitle = $params->blocktitle;
            $this->_pid = $params->treestart;
            $this->_isweek = $params->isweek;
            $this->_onmain = $params->onmain;
            $this->setVar('params',$params);
        }
        $this->addBC('default_pid',$this->_pid);

        if($this->_ismenu) {
            $this->assignMenu();
        } elseif ($this->_onmain) {
            $this->assignOnMain ();
        } else {
            if($this->request('a') or $this->request('p')) {
                $this->getItem();
            } else {
                $this->getItems();
            }
            $this->_assignCategories();
        }
    }

    private function _assignCategories(){
        $model = rad_instances::get('model_coremenus_tree');
        $pid = (int)$this->request('c', $this->_currArticleTreeItem);
        $pid = ($pid)?$pid : $this->_pid;
        $model->setState('pid',$pid);
        $model->setState('active',1);
        $items = $model->getItems();
        $this->setVar('categories',$items);
        $root_nodes = array();
        if($pid){
            $model->clearState();
            $currCategory = $model->getItem($pid);
            $this->setVar('currCategory', $currCategory);
            $this->addBC( 'curr_category', $currCategory);
            $root_nodes = $model->getCategoryPath ($currCategory, $this->_pid);
        }
        $this->addBC('category_path',$root_nodes);
    }

    function getItem() {
        $art_id = (int)$this->request('a', $this->request('p'));
        if($art_id){
            $item = rad_instances::get('model_corearticles_articles')->getItem($art_id);
            $this->addBC('curr_item', $item);

            $this->setVar('currCategory', rad_instances::get('model_coremenus_tree')->getItem($item->art_treid));
            $this->_currArticleTreeItem = $item->art_treid;
            $fileName = COREARTICLES_IMG_PATH.'articles'.DS.$item->art_img;
            if (is_file($fileName))
                $item->xy = getimagesize($fileName);
            $this->setVar('item', $item);
            if ($this->request('w') == '1')
                $this->setVar('centerWindow', true);
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function getItems()
    {
        $model = rad_instances::get('model_corearticles_articles');
        $pid = (int)$this->request('c');
        $pid = ($pid)?$pid:$this->_pid;

        $this->setVar('pid', $pid);
        $model->setState('tre_id',$pid);
        $model->setState('active',1);

        $this->setVar('itemsPerPageDefault',$this->_itemsPerPage);
        $this->_itemsPerPage = (int)$this->request('i', $this->_itemsPerPage);

        $pg = (int)$this->request('pg');
        $page = ($pg) ? $pg : 0;
        $limit = ($page*$this->_itemsPerPage).','.$this->_itemsPerPage;

        $items_count = $model->getCount();
        $this->setVar('items_count', $items_count);

        if($items_count){
            $pages = div((int)$items_count,$this->_itemsPerPage);
            $pages += ($items_count % $this->_itemsPerPage) ? 1 : 0;
            $this->setVar('pages_count',$pages+1);
            $this->setVar('page',$page+1);
            $this->setVar('currPage',(int)$this->request('pg',$page));
        }

        $this->setVar('itemsPerPage',$this->_itemsPerPage);

        $items = $model->getItems($limit);
        $this->setVar('items',$items);
    }

    function assignMenu()
    {
        $model = rad_instances::get('model_corearticles_articles');
        switch (strtolower($this->_ordering)) {
            case 'random':
                $model->setState('order by', 'RAND()');
                break;
            case 'last_asc':
                $model->setState('order by', 'art_datecreated ASC, art_dateupdated ASC');
                break;
            case 'last_desc':
                $model->setState('order by', 'art_datecreated DESC, art_dateupdated DESC');
                break;
            case 'position_asc':
                $model->setState('order by', 'art_position ASC');
                break;
            case 'position_desc':
                $model->setState('order by', 'art_position DESC');
                break;
            default:
                throw new rad_exception('Some error in params!!!');
                break;
        }
        $model->setState('active','1');
        if ($this->_isweek > 0) {
            $model->setState('isweek', $this->_isweek);
        }

        $model->setState('pid', $this->getAllChildId($this->_pid));
        $items = $model->getItems($this->_itemsPerPage);

        $this->setVar('blocktitle', $this->_blocktitle);
        $this->setVar('items', $items);

        $categories = rad_instances::get('model_coremenus_tree')
                    ->setState('pid', $this->_pid)
                    ->setState('active', 1)
                    ->getItems(true);
        $this->setVar('categories', $categories);
    }

    function assignOnMain ()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->_pid);
        $model->setState('active',1);
        $items = $model->getItems();

        switch (strtolower($this->_ordering))
        {
            case 'random':
                $model->setState('order by', 'RAND()');
            break;
            case 'last_asc':
                $model->setState('order by', 'art_datecreated ASC, art_dateupdated ASC');
            break;
            case 'last_desc':
                $model->setState('order by', 'art_datecreated DESC, art_dateupdated DESC');
            break;
            case 'position_asc':
                $model->setState('order by', 'art_position ASC');
            break;
            case 'position_desc':
                $model->setState('order by', 'art_position DESC');
            break;
            default:
                throw new rad_exception('Some error in params!!!');
            break;
        }

        $count = count($items);
        for ($i=0; $i < $count; $i++) {
            $pids = $this->getAllChildId ($items[$i]->tre_id);
            $models = rad_instances::get('model_corearticles_articles');
            $models->setState('tre_id', $pids);
            $models->setState('active', 1);
            $art  = $models->getItems($this->_itemsPerPage);
            if (count ($art) > 0 )
               $items[$i]->articles = $art;
            else
               unset ($items[$i]);
        }
        $this->setVar('items', $items);
    }

    /**
     * Gets all child ID's
     * @param $id mixed current category(s) ID
     * @return array id all child
     */
    function getAllChildId ($id) {
        $model = rad_instances::get('model_coremenus_tree');

        $all = (array) $id;
        $cur = $all;
        while (count($cur)> 0){
            $a = rad_dbpdo::queryAll('select tre_id from '.RAD.'tree where tre_pid in ('.join(',', $cur).') order by tre_position');
            $cur = array();
            foreach ($a as $i) {
                $cur[] = (int) $i['tre_id'];
            }
            $all = array_merge ($all, $cur);
        }
        return $all;
    }


}//class