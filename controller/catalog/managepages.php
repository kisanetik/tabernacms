<?php
/**
 * Class for managing pages
 *
 * @author Yackushev Denys
 * @package RADCMS
 *
 */
class controller_catalog_managepages extends rad_controller
{
	/** 
	 * Root parent id
	 *
	 * @var integer
	*/
	private $_pid = 18;
	
	/**
	 * Items per page
	 * @var integer
	*/
	private $_itemsPerPage = 20;
	
	/**
	 * Just for last inserted id of the page
	 * @var integer
	*/
	private $_inserted_id = 0;
	
	private $_have_tags = true;

	public static function getBreadcrumbsVars()
	{
		$bco = new rad_breadcrumbsobject();
		$bco->add('action');
		$bco->add('pagetitle');
		$bco->add('curr_cat');
		$bco->add('parents');
		return $bco;
	}

	function __construct()
	{
		if($this->getParamsObject()) {
			$params = $this->getParamsObject();
			$this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID() );
			$this->_have_tags = (boolean)$params->_get('have_tags', $this->_have_tags);
			$this->_itemsPerPage = $params->itemsperpage;
			$this->setVar('params',$params);
		}
		$this->setVar('hash',$this->hash());
	    $this->setVar('searchword',$this->request('searchword',''));
	    if( $this->request('action') ){
	        $this->setVar('action', $this->request('action') );
	        switch($this->request('action')){
	            case 'getnodes':
	                $this->getNodes();
	                break;
	            case 'getjs_editform':
	            case 'getjs':
	                $this->getJS();
	                break;
	            case 'getpages':
	                $this->getPages();
	                break;
	            //edit node
	            case 'edit':
	                $this->editNode();
	                break;
	            case 'editform':
	                if($this->request('action_sub')){
	                    $this->savePage();
	                    if($this->request('returntorefferer')>0)
	                        $this->showEditForm();
	                }else{
	                    $this->showEditForm();
	                }
	                break;
	            case 'addnode':
	                $this->addNode();
	                break;
	            case 'deletenode':
	                $this->deleteNode();
	                break;
	            case 'savenode':
	                $this->saveNode();
	                break;
	            case 'newlngpid':
	                $this->getNewLngContPID();
	                break;
	            case 'delpages':
	                $this->delPage();
	                break;
	            case 'delpagenojs':
	            	$this->deletePageNoJS();
	            	break;
	            case 'setactive':
	            	$this->setActive();
	            	break;
	            default:
	                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
	                break;
	        }//switch
	    }
	}

	/**
     * Gets the JavaScript for this el
     * @return JS
     */
    function getJS()
    {
        $this->setVar('ROOT_PID',$this->_pid);
    }

    /**
     * Get pages list for AJAX in current node (node_id)
     * @return HTML for AJAX
     */
    function getPages()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $model = rad_instances::get('model_catalog_pages');
            $model->setState('tre_id',$node_id);
			$this->setVar('items',$model->getItems() );
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Edit node tree
     * @return JavaScript command for AJAX
     */
    function editNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $node = rad_instances::get('model_menus_tree')->getItem($node_id);
            $this->setVar('item',$node);
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.system.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents', $parents);
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }


        //$this->recursive($id);
    }

    /**
     * Fully page - show the page with add\edit form
     * @return html
     */
    function showEditForm()
    {
        $pg_id = (int)$this->request('id');
        if(!$pg_id and $this->_inserted_id)
            $pg_id = $this->_inserted_id;
        $node_id = (int)$this->request('nid');
        if(!$node_id)
            $node_id = $this->_pid;
        $this->setVar('selected_category', $node_id);
        if($pg_id){//EDIT
        	$modelPages = rad_instances::get('model_catalog_pages');
        	if($this->_have_tags) {
        		$modelPages->setState('with_tags', true);	
        	}
            $item = $modelPages->getItem($pg_id);
            $item->created_user = rad_user::getUserByID($item->pg_usercreated);
            $item->pg_shortdesc = stripslashes( $item->pg_shortdesc );
            $item->pg_fulldesc = stripslashes( $item->pg_fulldesc );
            $this->setVar('item',  $item );
            $this->addBC('action', 'edit');
            $this->addBC('pagetitle', $item->pg_title);
        }else{//ADD
            $this->setVar('item',new struct_pages() );
            $this->addBC('action', 'add');
        }
        $model_categories = rad_instances::get('model_menus_tree');
        $model_categories->setState('pid', $this->_pid);
        $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.catalog.text')) ));
        $parents[0]->child = $model_categories->getItems(true);
        $model_categories->clearState();
        $curr_cat = $model_categories->getItem($node_id);
        $this->addBC('curr_cat', $curr_cat);
        $cat_path = $model_categories->getCategoryPath($curr_cat, $this->_pid, 0);
        unset($cat_path[0]);
        $this->addBC('parents', $cat_path);
        $this->setVar('categories',$parents);
        $this->setVar('max_post', $this->configSys('max_post'));
    }

    private function _deleteAllImg($img){
        if(count(glob(PAGESRESIZEDPATCH.'*'.$img)))
            foreach(glob(PAGESRESIZEDPATCH.'*'.$img) as $filename){
                unlink($filename);
            }
        if(file_exists(PAGESORIGINALPATCH.$img) and is_file(PAGESORIGINALPATCH.$img))
            unlink(PAGESORIGINALPATCH.$img);
    }

    /**
     * Saves the page into DB
     */
    function savePage()
    {
        if($this->request('hash') == $this->hash()) {
            $model = rad_instances::get('model_catalog_pages');
            if($this->request('action_sub')=='edit'){
                $pg_id = (int)$this->request('pg_id');
                if( (int)$this->request('id') and (!$pg_id) )
                    $pg_id = (int)$this->request('id');
                if($pg_id){
                    $pages_item = $model->getItem($pg_id);
                    $pages_item->MergeArrayToStruct($this->getAllRequest());
                }else{
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    return;
                }
            }else{
                $pages_item = new struct_pages( $this->getAllRequest() );
            }
            if($this->request('del_img')){
                $this->_deleteAllImg($pages_item->pg_img);
                $pages_item->pg_img = '';
            }
            if(count($_FILES['pages_image'])){
                if((int)$_FILES['pages_image']['size']){
                    if($pages_item->pg_img){
                        $this->_deleteAllImg($pages_item->pg_img);
                    }
                    $pages_item->pg_img = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['pages_image']['name']).'.'.strtolower( fileext($_FILES['pages_image']['name']) );
                    move_uploaded_file($_FILES['pages_image']['tmp_name'], PAGESORIGINALPATCH.$pages_item->pg_img);
                }//size
            }
            $pages_item->pg_shortdesc = stripslashes( $this->request('FCKeditorShortDescription') );
            $pages_item->pg_fulldesc = stripslashes( $this->request('FCKeditorFullDescription') );
            $pages_item->pg_active = ($this->request('pg_active')=='on')?'1':'0';
            $pages_item->pg_showlist = ($this->request('pg_showlist')=='on')?'1':'0';
            $pages_item->pg_dateupdated = now();
            $pages_item->pg_usercreated = $this->getCurrentUser()->u_id;
            $pages_item->pg_langid = $this->getContentLangID();
            if($this->_have_tags) {
            	if(strlen(trim($this->request('pagetags')))) {
                    $model_tags = rad_instances::get('model_resource_tags');
                    $tags_array = $model_tags->addItems(trim($this->request('pagetags'))); 
                    if(count($tags_array)) {
                        foreach($tags_array as $id_tag=>$tag_id) {
                            $pages_item->tags[] = new struct_tags_in_item(array('tii_item_id'=>$pages_item->pg_id, 'tii_tag_id'=>$tag_id));
                        }
                    }
                }
            }
            if($this->request('action_sub')=='add') {
                $pages_item->pg_datecreated = now();
                $this->_inserted_id = $model->insertItem($pages_item);
            } elseif($this->request('action_sub')=='edit') {
                $rows = $model->updateItem($pages_item);
            }
    		$tree_id = $pages_item->pg_tre_id;
            if($this->request('returntorefferer')=='0') {
                $this->redirect($this->makeURL('alias=SITE_ALIAS').'#nic/'.$tree_id);
            } elseif($this->request('action_sub')=='add') {
            	$this->redirect($this->makeURL('action='.$this->request('action').'&nid='.$tree_id.'&id='.$this->_inserted_id));
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }



    function addNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            rad_instances::get('controller_system_managetree')->addItem($node_id);
            echo 'RADPagesTree.editClick();';
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id){
                rad_instances::get('controller_system_managetree')->deleteItem($node_id);
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
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
            if($node_id){
                rad_instances::get('controller_system_managetree')->save($node_id);
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Returns the new langueage content PID
     * @return JavaScript
     */
    function getNewLngContPID()
    {
        $lngid = (int)$this->request('i');
        if($lngid){
            $params = $this->getParamsObject();
            echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
            echo 'RADPagesTree.refresh();';
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Delete the page
     * @return JavaScript
     *
     */
    function delPage()
    {
        if($this->request('hash') == $this->hash()) {
            $page_id = (int)$this->request('n_id');
            if($page_id){
                $rows = rad_instances::get('model_catalog_pages')->deleteItemById($page_id);
                if($rows){
                    echo 'RADPagesTree.listPages(RADPagesTree.getSID());';
                }else{
                    echo 'alert("ERROR!!!!! Can\'t delete!!!");';
                }
            }else{
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
	function deletePageNoJS()
    {
        if ($this->request('hash') != $this->hash()) {
            return $this->redirect('404');
        }
        $page_id = (int)$this->request('id');
        rad_instances::get('model_catalog_pages')->deleteItemById($page_id);
        $parent_id = (int)$this->request('nid');
        $this->redirect($this->makeURL('alias=SITE_ALIAS') . '#nic/' . $parent_id);
    }

    function setActive()
    {
        if($this->request('hash') == $this->hash()) {
            $v = (int)$this->request('v');
            $item_id = (int)$this->request('c');
            if($item_id){
                $r = rad_instances::get('model_catalog_pages')->setActive($item_id,$v);
                $r = ($v and $r)?false:true;
                if($r){
                    echo '$("active_pages_link_'.$item_id.'_1").style.display="none";';
                    echo '$("active_pages_link_'.$item_id.'_0").style.display="";';
                }else{
                    echo '$("active_pages_link_'.$item_id.'_1").style.display="";';
                    echo '$("active_pages_link_'.$item_id.'_0").style.display="none";';
                }
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

}//class
