<?php
/**
 * Class for managing articles
 *
 * @author Ivan Deyna
 * @deprecated 25 June 2009
 * @package RADCMS
 *
 */
class controller_articles_managearticles extends rad_controller
{
    /**
     * Root parent id
     *
     * @var integer
     */
    private $_pid = 381;

    /**
     * Items per page
     * @var integer
     */
    private $_itemsPerPage = 20;
    
    /**
     * Is articles have tags
     * @var boolean
     */
    private $_have_tags = true;

    /**
     * Just for last inserted id of the page
     * @var integer
     */
     private $_inserted_id = 0;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        $bco->add('article');
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
      if( $this->request('action') ) {
          $this->setVar('action', $this->request('action') );
          switch($this->request('action')){
              case 'getnodes':
                  $this->getNodes();
                  break;
              case 'getjs_editform':
              case 'getjs':
                  $this->getJS();
                  break;
              case 'getarticles':
                  $this->getArticles();
                  break;
              //edit node
              case 'edit':
                  $this->editNode();
                  break;
              case 'editform':
                  if($this->request('action_sub')) {
                      $this->saveArticle();
                      if($this->request('returntorefferer')>0) {
                          $this->showEditForm();
                      }
                  } else {
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
              case 'delarticles':
                  $this->delArticle();
                  break;
	            case 'delarticlenojs':
	            	$this->deleteArticleNoJS();
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

    function setActive()
    {
        if($this->request('hash') == $this->hash()) {
            $v = (int)$this->request('v');
            $id = (int)$this->request('a');
            if($id) {
                $r = rad_instances::get('model_articles_articles')->setActive($id,$v);
                $r = ($v and $r)?false:true;
                if($r) {
                    echo '$("active_articles_link_'.$id.'_1").style.display="none";';
                    echo '$("active_articles_link_'.$id.'_0").style.display="";';
                } else {
                    echo '$("active_articles_link_'.$id.'_1").style.display="";';
                    echo '$("active_articles_link_'.$id.'_0").style.display="none";';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
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
     * Get articles list for AJAX in current node (node_id)
     * @return HTML for AJAX
     */
    function getArticles()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            $model = rad_instances::get('model_articles_articles');
            $model->setState('tre_id',$node_id);
            $this->setVar('items',$model->getItems() );
        } else {
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
        if($node_id) {
            $node = rad_instances::get('model_menus_tree')->getItem($node_id);
            $this->setVar('item',$node);
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.system.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents', $parents);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Fully page - show the page with add\edit form
     * @return html
     */
    function showEditForm()
    {
        $art_id = (int)$this->request('id');
        if(!$art_id and $this->_inserted_id) {
            $art_id = $this->_inserted_id;
        }
        $node_id = (int)$this->request('nid');
        if(!$node_id) {
            $node_id = $this->_pid;
        }
        $this->setVar('selected_category', $node_id);
        if($art_id) {//EDIT
        	$modelArticles = rad_instances::get('model_articles_articles');
        	if($this->_have_tags) {
        		$modelArticles->setState('with_tags', true);
        	}
        	$item = $modelArticles->getItem($art_id); 
            $item->created_user = rad_user::getUserByID($item->art_usercreated);
            $item->art_shortdesc = stripslashes( $item->art_shortdesc );
            $item->art_fulldesc = stripslashes( $item->art_fulldesc );
            $this->addBC('action', 'edit');
            $this->addBC('article', $item->art_title);
            $this->setVar('item',  $item );
        } else {//ADD
        	$this->addBC('action', 'add');
            $this->setVar('item',new struct_articles());
        }
        $model_categories = rad_instances::get('model_menus_tree');
        $model_categories->setState('pid', $this->_pid);
        $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.system.text')) ));
        $parents[0]->child = $model_categories->getItems(true);
        $model_categories->clearState(); // -- breadcrumbs
        $curr_cat = $model_categories->getItem($node_id);
        $this->addBC('curr_cat', $curr_cat);
        $cat_path = $model_categories->getCategoryPath($curr_cat, $this->_pid, 0);
        unset($cat_path[0]);
        $this->addBC('parents', $cat_path); // --end
        $this->setVar('categories',$parents);
        $this->setVar('max_post', $this->configSys('max_post'));
    }

    private function _deleteAllImg($img){
        if(count(glob(ARTICLESRESIZEDPATCH.'*'.$img))) {
            foreach(glob(ARTICLESRESIZEDPATCH.'*'.$img) as $filename){
                unlink($filename);
            }
        }
        if(file_exists(ARTICLESORIGINALPATCH.$img) and is_file(ARTICLESORIGINALPATCH.$img)) {
            unlink(ARTICLESORIGINALPATCH.$img);
        }
    }

    /**
     * Saves the page into DB
     */
    function saveArticle()
    {
        if($this->request('hash') == $this->hash()) {
            $model = rad_instances::get('model_articles_articles');
            if($this->request('action_sub')=='edit') {
                $art_id = (int)$this->request('art_id');
                if( ( (int)$this->request('id') ) and (!$art_id) ) {
                    $art_id = (int)$this->request('id');
                }
                if($art_id) {
                    $articles_item = $model->getItem($art_id);
                    $articles_item->MergeArrayToStruct($this->getAllRequest());
                } else {
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    return;
                }
            } else {
                $articles_item = new struct_articles( $this->getAllRequest() );
            }
            if($this->request('del_img')) {
                $this->_deleteAllImg($articles_item->art_img);
            }
            if(isset($_FILES['articles_image']) && count($_FILES['articles_image'])) {
                if((int)$_FILES['articles_image']['size']) {
                    if($articles_item->art_img) {
                        $this->_deleteAllImg($articles_item->art_img);
                    }
                    $articles_item->art_img = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['articles_image']['name']).'.'.strtolower( fileext($_FILES['articles_image']['name']) );
                    if(!file_exists(ARTICLESORIGINALPATCH)) {//create folder, if not exists
                    	recursive_mkdir(ARTICLESORIGINALPATCH);
                    }
                    move_uploaded_file($_FILES['articles_image']['tmp_name'], ARTICLESORIGINALPATCH.$articles_item->art_img);
                }//size
            }
            $articles_item->art_shortdesc = stripslashes( $this->request('FCKeditorShortDescription') );
            $articles_item->art_fulldesc = stripslashes( $this->request('FCKeditorFullDescription') );
    
            $articles_item->art_showonmain = ($this->request('art_showonmain')=='on')?'1':'0';
            $articles_item->art_isweek = ($this->request('art_isweek')=='on')?'1':'0';
            $articles_item->art_active = ($this->request('art_active')=='on')?'1':'0';
            $articles_item->art_langid = $this->getContentLangID();
    
            $articles_item->art_dateupdated = now();
            $articles_item->art_usercreated = $this->getCurrentUser()->u_id;
            //IS HAVE TAGS?
            if($this->_have_tags) {
                if(strlen(trim($this->request('articletags')))) {
                    $model_tags = rad_instances::get('model_resource_tags');
                    $tags_array = $model_tags->addItems(trim($this->request('articletags'))); 
                    if(count($tags_array)) {
                        foreach($tags_array as $id_tag=>$tag_id) {
                            $articles_item->tags[] = new struct_tags_in_item(array('tii_item_id'=>$articles_item->art_id, 'tii_tag_id'=>$tag_id));
                        }
                    }
                }
            }
            if($this->request('action_sub')=='add') {
                $articles_item->art_datecreated = now();
                $this->_inserted_id = $model->insertItem($articles_item);
            } elseif($this->request('action_sub')=='edit') {
                $rows = $model->updateItem($articles_item);
            }
            $tree_id = $articles_item->art_treid;
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
        if($node_id) {
            rad_instances::get('controller_system_managetree')->addItem($node_id);
            echo 'RADArticlesTree.editClick();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                rad_instances::get('model_articles_articles')->deleteByNodeID($node_id);
                rad_instances::get('controller_system_managetree')->deleteItem($node_id);
            } else {
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
     * Returns the new langueage content PID
     * @return JavaScript
     */
    function getNewLngContPID()
    {
        $lngid = (int)$this->request('i');
        if($lngid) {
            $params = $this->getParamsObject();
            echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
            echo 'RADArticlesTree.refresh();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Delete the article
     * @return JavaScript
     *
     */
    function delArticle()
    {
        if($this->request('hash') == $this->hash()) {
            $article_id = (int)$this->request('art_id');
            if($article_id) {
                $rows = rad_instances::get('model_articles_articles')->deleteItemById($article_id);
                if($rows) {
                    echo 'RADArticlesTree.listArticles(RADArticlesTree.getSID());';
                } else {
                    echo 'alert("ERROR!!!!! Can\'t delete!!!");';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }
    
	/**
	* Delete article by id
	* @return void
	*/
	function deleteArticleNoJS()
    {
        if ($this->request('hash') != $this->hash()) {
            return $this->redirect('404');
        }
        $art_id = (int)$this->request('id');
        rad_instances::get('model_articles_articles')->deleteItemById($art_id);
        $parent_id = (int)$this->request('nid');
        $this->redirect($this->makeURL('alias=SITE_ALIAS') . '#nic/' . $parent_id);
    }

}//class
