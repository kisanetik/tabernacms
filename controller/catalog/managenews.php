<?php
/**
 * Class for managing news in admin
 * @author Denys Yackushev
 * @package RADCMS
 *
 */
class controller_catalog_managenews extends rad_controller
{
    /**
     * Root parent id
     *
     * @var integer
     */
    private $_pid = 16;

    private $_dateSeparator = '-';

    private $_ishaveperiods = false;

    private $_hasismain = false;

    private $_hassource = false;

    private $_hassubscribes = false;

    private $_hassubcats = true;

    private $_have_tags = true;

    private $_itemsperpage = 30;

	/**
	 * Just for last inserted id of the page
	 * @var integer
	*/
	private $_inserted_id = 0;

	public static function getBreadcrumbsVars()
	{
		$bco = new rad_breadcrumbsobject();
		$bco->add('action');
		$bco->add('newstitle');
		$bco->add('curr_cat');
        $bco->add('parents');
		return $bco;
	}

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID() );
            $this->_hasismain = $params->_get('hasismain',$this->_hasismain);
            $this->_ishaveperiods = $params->_get('ishaveperiods',$this->_ishaveperiods);
            $this->_hassource = $params->_get('hassource',$this->_hassource);
            $this->_hassubscribes = $params->_get('hassubscribes',$this->_hassubscribes);
            $this->_hassubcats = $params->_get('hassubcats',$this->_hassubcats);
            $this->_have_tags = (boolean)$params->_get('have_tags',$this->_have_tags);
            $this->_itemsperpage = $params->_get('itemsperpage',$this->_itemsperpage);
            $this->setVar('params',$params);
        }
        $this->setVar('hash',$this->hash());
        if($this->request('action')) {
            $this->setVar('action',$this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->getjs();
                    break;
                case 'getjs_editform':
                    $this->getJSEditForm();
                    break;
                case 'getnews':
                    $this->getNews();
                    break;
                case 'editform':
                    if($this->request('action_sub')) {
                        $this->saveNews();
                        if($this->request('returntorefferer')>0) {
                            $this->editFormNews();
                        }
                    } else {
                        $this->editFormNews();
                    }
                    break;
                //edit tree node
                case 'edit':
                    $this->showEditNode();
                    break;
                case 'savenode':
                    $this->saveNode();
                    break;
                case 'addnode':
                    if( isset($params) and ($params->hassubcats) ) {
                        $this->addNode();
                    }
                    break;
                case 'deletenode':
                    $this->deleteNode();
                    break;
                case 'delnews':
                    $this->delNews();
                    break;
	            case 'delnewsnojs':
	            	$this->deleteNewsNoJS();
	            	break;
                case 'newlngpid':
                    $this->newLngPID();
                    break;
                case 'setactive':
                	$this->setActive();
                	break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    die('action not exists!');
                    break;
            }
        }
    }

    function setActive()
    {
        if($this->request('hash') == $this->hash()) {
            $v = (int)$this->request('v');
            $item_id = (int)$this->request('c');
            if($item_id){
                $r = rad_instances::get('model_catalog_news')->setActive($item_id,$v);
                $r = ($v and $r)?false:true;
                if($r){
                    echo '$("active_news_link_'.$item_id.'_1").style.display="none";';
                    echo '$("active_news_link_'.$item_id.'_0").style.display="";';
                }else{
                    echo '$("active_news_link_'.$item_id.'_1").style.display="";';
                    echo '$("active_news_link_'.$item_id.'_0").style.display="none";';
                }
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Gets the javascript,
     * @retirn JavaScript
     */
    function getjs()
    {
        $this->setVar('ROOT_PID',$this->_pid);
    }

    /**
     * JavaScript module for the edit form
     * @retirn JavaScript
     */
    function getJSEditForm()
    {
        $this->setVar('ROOT_PID',$this->_pid);
    }

    /**
     * Gets the news in tree and show it in table from AJAX
     * @return html
     */
    function getNews()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            $model = rad_instances::get('model_catalog_news');
            $model->setState('nw_tre_id', $node_id);
            $tmp_item = new struct_news();
            if(isset($news_item->nw_langid)) {
                $model->setState('lang',$this->getCurrentLangID());
            }
            $model->setState('select','count(*)');
            $items_count = $model->getItem();
            $model->unsetState('select');
            $page = (int)$this->request('p',1)-1;
            $limit = ($page*$this->_itemsperpage).','.$this->_itemsperpage;
            $this->setVar('items',$model->getItems($limit));
            $this->setVar('total_rows',$items_count);
            $pages = div((int)$items_count,$this->_itemsperpage);
            $pages+=(mod($items_count,$this->_itemsperpage))?1:0;
            $this->setVar('pages_count',$pages+1);
            $this->setVar('page',$page+1);
        }
    }

    /**
     * Show page with add news form
     * @return html page
     */
    function editFormNews()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            $modelTree = rad_instances::get('model_menus_tree');
            $modelTree->setState('pid', $this->_pid);
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.catalog.text')) ));
            $parents[0]->child = $modelTree->getItems(true);
            $this->setVar('categories', $parents);
            $newsId = (int)$this->request('nw_id');
        	if(!$newsId and $this->_inserted_id) {
            	$newsid = $this->_inserted_id;
        	}
            $this->setVar('selected_category',$node_id);
            $modelTree->clearState(); // -- breadcrumbs
	        $curr_cat = $modelTree->getItem($node_id);
	        $this->addBC('curr_cat', $curr_cat);
	        $cat_path = $modelTree->getCategoryPath($curr_cat, $this->_pid, 0);
	        unset($cat_path[0]);
            $this->addBC('parents', $cat_path); // -- end
            if($newsId) {
            	$modelNews = rad_instances::get('model_catalog_news');
                if($this->_have_tags) {
                	$modelNews->setState('with_tags',true);
                }
                $item = $modelNews->getItem($newsId);
                $item->nw_datenews = ((int)$item->nw_datenews)?$item->nw_datenews:now();
                if($this->_ishaveperiods){
                    $item->nw_datenews_from = ((int)$item->nw_datenews_from)?$item->nw_datenews_from:now();
                    $item->nw_datenews_to = ((int)$item->nw_datenews_to)?$item->nw_datenews_to:now();
                }
                $this->addBC('action', 'edit');
                $this->addBC('newstitle', $item->nw_title);
                $this->setVar('item',$item);
            } else {
            	$this->addBC('action', 'add');
                $this->setVar('item', new struct_news( array('nw_datenews'=>now(),'nw_datenews_from'=>now(),'nw_datenews_to'=>now()) ) );
            }
			$this->setVar('max_post', $this->configSys('max_post'));
        } else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    private function _deleteAllImg($img){
        if(count(glob(NEWSRESIZEDPATCH.'*'.$img)))
            foreach(glob(NEWSRESIZEDPATCH.'*'.$img) as $filename){
                if(is_file($filename))
                    unlink($filename);
            }
        if(file_exists(NEWSORIGINALPATCH.$img) and is_file(NEWSORIGINALPATCH.$img))
            unlink(NEWSORIGINALPATCH.$img);
    }

    /**
     * Save the one news or add it from edit_form
     * @return html page
     */
    function saveNews()
    {
        if($this->request('hash') == $this->hash()) {
            $model = rad_instances::get('model_catalog_news');
            if($this->request('action_sub')=='edit'){
                $nw_id = (int)$this->request('nw_id');
                if($nw_id){
                    $news_item = $model->getItem($nw_id);
                    $news_item->MergeArrayToStruct($this->getAllRequest());
                }else{
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    return;
                }
            }else{
                $news_item = new struct_news( $this->getAllRequest() );
            }
            if($this->request('del_img')){
                $this->_deleteAllImg($news_item->nw_img);
                $news_item->nw_img = '';
            }
            if(count($_FILES['news_image'])){
              if( ((int)$_FILES['news_image']['size']) and (!$_FILES['news_image']['error']) ) {
                    if($news_item->nw_img){
                        $this->_deleteAllImg($news_item->nw_img);
                    }
                    $news_item->nw_img = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['news_image']['name']).'.'.strtolower( fileext($_FILES['news_image']['name']) );
                    move_uploaded_file($_FILES['news_image']['tmp_name'], NEWSORIGINALPATCH.$news_item->nw_img);
              }
            }
            $news_item->nw_shortdesc = stripslashes( $this->request('FCKeditorShortDescription') );
            $news_item->nw_fulldesc = stripslashes( $this->request('FCKeditorFullDescription') );
            $news_item->nw_active = ($this->request('nw_active')=='on')?'1':'0';
            $news_item->nw_dateupdated = now();
            $news_item->nw_usercreated = $this->getCurrentUser()->u_id;
            $news_item->nw_tre_id = (int)$news_item->nw_tre_id;
            if(isset($news_item->nw_langid))
                $news_item->nw_langid = $this->getContentLangID();
            if(strlen($news_item->nw_datenews)){
                $news_item->nw_datenews = date($this->config('datetime.format'),strtotime($news_item->nw_datenews.' '.$this->request('news_time',date('H:i:s'))));
            }else{
                $news_item->nw_datenews = date($this->config('datetime.format'));//now();
            }
            if($this->_hasismain){
                $news_item->nw_ismain = ($this->request('nw_ismain')=='on')?'1':'0';
            }
            if($this->_hassubscribes){
                $news_item->nw_subscribe = ($this->request('nw_subscribe')=='on')?'1':'0';
            }
            if($this->_ishaveperiods){
                $news_item->nw_datenews_to = date($this->config('datetime.format'),strtotime($news_item->nw_datenews_to));
                $news_item->nw_datenews_from = date($this->config('datetime.format'),strtotime($news_item->nw_datenews_from));
            }
            if($this->_hassource){
                $news_item->nw_source_url = trim(stripslashes($news_item->nw_source_url));
                $news_item->nw_source_text = trim(stripslashes($news_item->nw_source_text));
            }
    		if($this->_have_tags) {
                if(strlen(trim($this->request('newstags')))) {
                    $model_tags = rad_instances::get('model_resource_tags');
                    $tags_array = $model_tags->addItems(trim($this->request('newstags')));
                    if(count($tags_array)) {
                        foreach($tags_array as $id_tag=>$tag_id) {
                            $news_item->tags[] = new struct_tags_in_item(array('tii_item_id'=>$news_item->nw_id, 'tii_tag_id'=>$tag_id));
                        }
                    }
                }
    		}
            /** FIX for the RUSAUTO **/
            if($this->getParamsObject() and $this->getParamsObject()->_get('hasshowstart',false)){
                if(strlen($news_item->nw_showstart)){
                    $tmp_date = explode($this->_dateSeparator,$news_item->nw_showstart);
                    $news_item->nw_showstart = $tmp_date[2].$this->_dateSeparator.$tmp_date[1].$this->_dateSeparator.$tmp_date[0];
                }else{
                    $news_item->nw_showstart = now();
                }
            }
    
            if($this->getParamsObject() and $this->getParamsObject()->_get('hasshowend',false)){
                if(strlen($news_item->nw_showend)){
                    $tmp_date = explode($this->_dateSeparator,$news_item->nw_showend);
                    $news_item->nw_showend = $tmp_date[2].$this->_dateSeparator.$tmp_date[1].$this->_dateSeparator.$tmp_date[0];
                }else{
                    $news_item->nw_showend = now();
                }
            }
    
            /** END FIX for the RUSAUTO **/
    
            if($this->request('action_sub')=='add'){
                $news_item->nw_datecreated = now();
                $this->_inserted_id = $model->insertItem($news_item);
            }elseif($this->request('action_sub')=='edit'){
                $rows = $model->updateItem($news_item);
            }
            $tree_id = $news_item->nw_tre_id;
            if($this->request('returntorefferer')=='0'){
                $this->redirect($this->makeURL('alias=SITE_ALIAS').'#nic/'.$tree_id);
            } elseif($this->request('action_sub')=='add') {
            	$this->redirect($this->makeURL('action='.$this->request('action').'&node_id='.$tree_id.'&nw_id='.$this->_inserted_id));
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * For edit node form from news-tree
     * @return html for AJAX
     */
    function showEditNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $item = rad_instances::get('model_menus_tree')->getItem($node_id);
            $this->setVar('item', $item);
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid', $this->getParamsObject()->_get( 'treestart', $this->_pid, $this->getContentLangID() ));
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.catalog.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents', $parents );
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Save the tree node and return JS instructions
     * @return JavaScript
     */
    function saveNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                rad_instances::get('controller_system_managetree')->save($node_id);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Adds new default node to groups-tree
     * @return JavaScript code
     */
    function addNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            rad_instances::get('controller_system_managetree')->addItem($node_id);
            echo 'RADNewsTree.editClick();';
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Deletes news group from tree
     * @return JavaScript
     */
    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id){
                $model = rad_instances::get('model_menus_tree');
                $current_node = $model->getItem($node_id);
                $rows = 0;
                //get current tree
                $parent_node = $model->getItem($current_node->tre_pid);
                $toDeleteTreeIds = array();
                $toDeleteTreeIds[] = $current_node->tre_id;
                //get all child trees
                if(!$current_node->tre_islast) {
                    $model->setState('pid',$node_id);
                    $child_nodes = $model->getItems(true);
                    $toDeleteTreeIds = $model->getRecurseNodeIDsList($child_nodes, $toDeleteTreeIds);
                }
                $model->setState('pid',$parent_node->tre_id);
                $child_parents = $model->getItems();
                if(count($child_parents) <= 1) {
                    $parent_node->tre_islast = 1;
                    $model->updateItem($parent_node);
                }
                //delete all items from deleted trees
                $newsModel = rad_instances::get('model_catalog_news');
                $rows += $newsModel->deleteItemsByTreeId($toDeleteTreeIds);
                //delete seleted tree and child trees
                $rows += $model->deleteItemById($toDeleteTreeIds);
                if($rows) {
                    echo 'RADNewsTree.message("'.addslashes( $this->lang('-deleted') ).': '.$rows.'");';
                    echo 'RADNewsTree.cancelEdit();';
                } else {
                    echo 'RADNewsTree.message("'.addslashes( $this->lang('deletedrows.catalog.error') ).': '.$rows.'");';
                    echo 'RADNewsTree.cancelEdit();';
                }
                echo 'RADNewsTree.refresh();';                
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Delete news by it ID
     * @return JavaScript for AJAX
     */
    function delNews()
    {
        if($this->request('hash') == $this->hash()) {
            $n_id = (int)$this->request('n_id');
            if($n_id) {
                $item = rad_instances::get('model_catalog_news')->getItem($n_id);
                $this->_deleteAllImg($item->nw_img);
                $model = rad_instances::get('model_catalog_news');
                $rows = $model->deleteItem(new struct_news( array('nw_id'=>$n_id) )) ;
                if($rows){
                    echo 'RADNews.message("'.$this->lang('deletedrows.catalog.text').': '.$rows.'");';
                }else{
                    echo 'RADNews.message("'.$this->lang('deletedrows.catalog.error').': '.$rows.'");';
                }
                if($this->_hassubcats){
                    echo 'RADNewsTree.listNews(RADNewsTree.getSID());';
                }else{
                    echo 'RADNewsTree.listNews(ROOT_PID);';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }
    
	/**
	 * Delete page by id
	 * @return void
	*/
	function deleteNewsNoJS()
    {
        if ($this->request('hash') != $this->hash()) {
            return $this->redirect('404');
        }
        $news_id = (int)$this->request('id');
        rad_instances::get('model_catalog_news')->deleteItemById($news_id);
        $parent_id = (int)$this->request('nid');
        $this->redirect($this->makeURL('alias=SITE_ALIAS') . '#nic/' . $parent_id);
    }

/**
   * Sets the new PID for the tree and return the JS commands
   * @return JavaScript
   *
   */
  function newLngPID()
  {
      $lngid = (int)$this->request('i');
      if($lngid){
          $params = $this->getParamsObject();
          echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
          echo 'RADNewsTree.refresh();';
      }else{
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
      }
  }
}