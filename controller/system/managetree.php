<?php
/**
 * System managing tree
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_system_managetree extends rad_controller
{

    /**
     * Default inserted new item
     * @var struct_tree
     */
    private $defNewItem = NULL;

    private $_pid = '0';

    private $tree = array();
    private $s_tree = 17;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        $bco->add('tree');
        $bco->add('ref');
        return $bco;
    }

    function __construct()
    {
        $this->defNewItem = new struct_tree;
        $this->defNewItem->tre_active = false;
        $this->defNewItem->tre_lang = $this->getCurrentLangID();
        $this->defNewItem->tre_name = $this->lang('newdefitemname.menus.text').' '.now();
        $this->defNewItem->tre_position = '100';
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID() );
            $this->setVar('params',$params);
        }
        $this->setVar('hash',$this->hash());
        if($this->hasMessage())
        $this->setVar('message',$this->getMessage());
        if($this->request('action')){
        	$this->addBC('action', $this->request('action'));
	        switch( $this->request('action') ) {
	            case 'add':
	                $this->addItem();
	                break;
	            case 'editform':
	                $this->editItem();
	                break;
	            case 'save':
	                $this->save();
	                break;
	            case 'delete':
	                $this->deleteItem();
	                break;
	            case 'showuploadform':
	                $this->showUploadForm();
	                break;
	            case 'uploadfile':
	                $this->uploadFile();
	                break;
	            case 'getnodes':
	                if($this->request('nic')) {
	                    $this->recursive($this->request('nic'));
	                } else {
	                    $this->getNodes();
	                }
	                break;
	            case 'detailedit':
	                if(isset($params) and ($params->showdetailedit))
	                if($this->request('sub_action')) {
	                    $this->saveDetail();
	                    if($this->request('returntorefferer')=='0') {
                            $suffix = '';
                            if ($this->request('tre_id')) {
                                $suffix .= '#nic/' . (int) $this->request('tre_id');
                            }
	                        if($this->request('ref')) {
	                            $this->redirect($this->makeURL('alias='.$this->request('ref').($suffix?$suffix:'')));
	                        } else {
	                            $this->redirect($this->makeURL('alias=SITE_ALIAS').$suffix);
	                        }
	                    } else {
	                        $this->detailEdit();
	                    }
	                } else {
	                    $this->detailEdit();
	                }
	                break;
	            case 'getjs':
	            case 'getjs_detail':
	                $this->getJS();
	                break;
	            case 'newlngpid':
	                $this->getNewLngPid();
	                break;
	            default:
	                if($this->request('alias')=='SYSmanageTree') {
	                    $this->assignItems();
	                }
	            break;
	        }//switch
	        $this->setVar('action',$this->request('action'));
        }
        //($this->request('action'))?$this->setVar('action',$this->request('action')):'';
    }

    function recursive($id=false)
    {
        if($id != false) {
            $this->tree[] = $id;
            $model = rad_instances::get('model_menus_tree');
            $parent = $model->getItem($id);
            $p_id = $parent->tre_pid;
            $this->tree[] = $p_id;
            $this->pathallparent($p_id);
            $this->tree = array_reverse($this->tree);
            echo json_encode( $this->tree );
        }
    }

    function pathallparent($p_id)
    {
        $model = rad_instances::get('model_menus_tree');
        $parent = $model->getItem($p_id);
        $sub = $parent->tre_pid;
        if($sub != false) {
            while(1){
                    if($sub == false) {
                        break;
                    } else {
                        if($sub != $this->s_tree) {
                            $this->tree[] = $sub;
                            $this->pathallparent($sub);
                        }
                        break;
                    }
            }//while
        }
    }

    function addItem($id=null)
    {
        $id = ($id)?$id:(int)$this->request('id');
        $this->defNewItem->tre_pid = $id;
        $model = rad_instances::get('model_menus_tree');
        if ($id == $this->_pid) {
            $this->defNewItem->tre_lang = $this->getContentLangID();
        } else {
            $parent_item = $model->getItem($id);
            $model->clearState();
            $this->defNewItem->tre_lang = $parent_item->tre_lang;
        }
        $rows = $model->insertItem($this->defNewItem);
        $insertedId = $model->inserted_id();
        if($id) {
            $updateItem = $model->getItem($id);
        }
        $model->clearState();
        if ($rows) {
            if(isset($updateItem)) {
                $id = $model->inserted_id();
                if ($updateItem->tre_islast>0) {
                    $updateItem->tre_islast=0;
                    $rows += $model->updateItem($updateItem);
                }
            }
            echo 'RADTree.message("';
            echo addslashes( $this->lang('-added') );
            echo ': ' . $rows . '");';
            echo 'RADTree.cancelClick();';
            echo 'RADTree.addItemNode(' . $insertedId . ',"';
            echo addslashes( $this->defNewItem->tre_name ) . '");';
        } else {
            echo 'RADTree.message("';
            echo  addslashes( $this->lang('addedrows.system.error') );
            echo  ': ' .$rows . '");';
            echo 'RADTree.cancelClick();';
        }
    }

    /**
     * Show edit node form
     */
    function editItem()
    {
        $node_id = (int) $this->request('node_id');
        $model = rad_instances::get('model_menus_tree');
        $this->setVar('item', $model->getItem($node_id) );
        $model->setState('pid', '0');
        $parents = array(
            new struct_tree(
                array(
                    'tre_id'   => $this->_pid,
                    'tre_name' => $this->lang('rootnode.menus.text'),
                )
            )
        );
        $model->setState('lang', $this->getContentLangID());
        $parents[0]->child = $model->getItems(true);
        $this->setVar('parents', $parents);
    }

    function save($id=NULL)
    {
        if($this->request('hash') == $this->hash()) {
            $id = ($id)?$id:(int)$this->request('id');
            if($id) {
                $model = rad_instances::get('model_menus_tree');
                $item = new struct_tree($this->getAllRequest());
                $itemOld = $model->getItem($id);
                $item->tre_id = $itemOld->tre_id;
                $item->tre_lang = $itemOld->tre_lang;
                $name_search = array('>','<');
                $name_replace = array('&gt;','&lt;');
                $item->tre_name = str_replace( $name_search, $name_replace, stripslashes($item->tre_name) );
                $item->tre_islast = $itemOld->tre_islast;
                $item->tre_type = (int)$item->tre_type;
                if(!$this->request('deleteimage')) {
                    $item->tre_image = $itemOld->tre_image;
                    $item->tre_image_menu = $itemOld->tre_image_menu;
                    $item->tre_image_menu_a = $itemOld->tre_image_menu_a;
                } else {
                    $model->updateImage('',$id);
                }
                $model->clearState();
                $item->tre_id = $id;
                $rows = $model->updateItem($item);
                if($rows) {
                    echo 'RADTree.tree.selected.text="'.addslashes( $item->tre_name ).'";';
                    if($itemOld->tre_pid==$item->tre_pid) {
                        if($item->tre_active) {
                            echo 'RADTree.tree.selected.color="#000000";';
                            echo 'RADTree.tree.selected.color="#376872";';
                        } else {
                            echo 'RADTree.tree.selected.color="#808080";';
                        }
                        echo 'RADTree.tree.selected.update();';
                    } else {
                        //check old parent
                        $model->clearState();
                        $chItem = $model->getItem($itemOld->tre_pid);
                        $model->clearState();
                        $model->setState('pid', $itemOld->tre_pid);
                        if(!$model->getItemsCount() and $chItem->tre_islast=='0') {
                            $chItem->tre_islast = 1;
                            $model->updateItem($chItem);
                        }
                        //check new parent
                        $model->clearState();
                        $new_parent = $model->getItem( $item->tre_pid );
                        if($new_parent->tre_islast) {
                            $new_parent->tre_islast = 0;
                            $model->updateItem($new_parent);
                        }
                        echo 'RADTree.refresh();';
                    }
    
                } else {
                    echo 'RADTree.message("'.addslashes( $this->lang('updatedrows.menus.error') ).': '.$rows.'");';
                    echo 'RADTree.refresh();';
                }
                echo 'RADTree.cancelClick();';
            } else {
                $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }//function

    function deleteItem($id=NULL)
    {
        if($this->request('hash') == $this->hash()) {
            $this->setVar('deleteJS',true);
            $id = ($id)?$id:(int)$this->request('id');
            if($id) {
                $model = rad_instances::get('model_menus_tree');
                $item = $model->getItem($id);
                $rows = $model->deleteItemById($id);
                if($rows) {
                    $this->setVar('successDel',true);
                    if( $item->tre_pid > 0 ) {
                        $model->clearState();
                        $model->setState('pid',$item->tre_pid);
                        if( !$model->getItemsCount() ) {
                            $model->clearState();
                            $update_item = $model->getItem($item->tre_pid);
                            $update_item->tre_islast = 1;
                            $rows += $model->updateItem($update_item);
                        }
                        echo 'RADTree.message("'.addslashes($this->lang('deletedrows.system.message')).': '.$rows.'");';
                        echo 'RADTree.tree.selected.remove();';
                    }//tre_pid>0
                } else {
                    echo 'RADTree.message("'.addslashes($this->lang('norowsupdated.system.error')).': '.$rows.'");';
                }
                echo 'RADTree.cancelClick();';
            } else {
                $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    function assignItems()
    {
        $model = rad_instances::get('model_menus_tree');
        $model->setState('lang',$this->getContentLangID());
        $model->setState('order','tre_position,tre_name');
        $items = $model->getItems(true);
        $this->setVar('items',$items);
    }

    function showUploadForm()
    {
        $this->setVar('id',$this->request('id'));
    }

    function uploadFile()
    {
        $this->setVar('id',$this->request('id'));
        if(isset($_FILES['tree_image']) and $this->request('id')) {
            $model = rad_instances::get('model_menus_tree');
            $image_fn = $model->uploadImage('tree_image');
            if( $image_fn ) {
                $fn = basename($image_fn);
                $this->setVar('new_fn',$fn);
                $this->setVar('uploaded', $model->updateImage($image_fn, $this->request('id')) );
            } else {
                die('Can\'t move file!!!');
            }
        } else {
            $this->badRequest();
        }
    }

    /**
     * Return the nodes list in XML
     *
     * @return xml
     */
    function getNodes()
    {
        $model = rad_instances::get('model_menus_tree');
        $model->setState('pid',$this->request('pid',$this->_pid));
        if(!(int)$this->request('nolang'))
        $model->setState('lang',$this->getContentLangID());
        $model->setState('order', 'tre_position,tre_name');
        $items = $model->getItems();
        $s = '<?xml version="1.0"?><nodes>';
        if(count($items)) {
            $search = array('"', '&');
            $replace = array('&quot;','&amp;');
            foreach($items as $id) {
                $s.='<node text="'.str_replace($search, $replace, $id->tre_name).'"';
                $s.=($id->tre_active)?'':' color="#808080"';
                $s.=($id->tre_islast)?'':' load="'.$this->makeURL('alias=SYSmanageTreeXML&action=getnodes&pid='.$id->tre_id).'"';
                $s.=' id="'.$id->tre_id.'"';
                $s.=' islast="'.$id->tre_islast.'"';
                $s.=' />';
            }//foreach
        }//if
        $s.='</nodes>';
        $this->header('Content-Length: '.strlen($s));
        $this->header('Content-Type: application/xml');
        echo $s;
    }

    /**
     * Detail edit category, exacly the short and full description, meta tags e.t.c.
     *
     */
    function detailEdit()
    {
        $tre_id = (int)$this->request('tre_id');
        if($tre_id) {
            $model = rad_instances::get('model_menus_tree');
            $item = $model->getItem($tre_id);
            $this->addBC('tree', $item->tre_name);
            $this->setVar('item',$item);
            $model->setState('pid', '0');
            $model->setState('lang',$this->getContentLangID());
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.menus.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents',$parents);
            $this->setVar('max_post', $this->configSys('max_post'));
            if($this->request('ref')) {
                $this->setVar('ref',$this->request('ref'));
                $this->addBC('ref', $this->request('ref'));
            }
            //            print_r($parents);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    private function _deleteImages($img)
    {
        if(count(glob(MENURESIZEDPATCH.'*'.$img))) {
            foreach(glob(MENURESIZEDPATCH.'*'.$img) as $filename){
                unlink($filename);
            }
        }
        if(file_exists(MENUORIGINALPATCH.$img) and is_file(MENUORIGINALPATCH.$img)) {
            unlink(MENUORIGINALPATCH.$img);
        }
    }

    /**
     * Saves data from detail edit
     *
     */
    function saveDetail()
    {
        if($this->request('hash') == $this->hash()) {
            $tre_id = (int)$this->request('tre_id');
            if($tre_id) {
                $item = new struct_tree( $this->getAllRequest() );
                $model = rad_instances::get('model_menus_tree');
                $item_old = $model->getItem($tre_id);
                $item->tre_lang = ($item_old->tre_lang)?$item_old->tre_lang:$this->getContentLangID();
                $item->tre_islast = $item_old->tre_islast;
                $item->tre_name = stripslashes($item->tre_name);
                $item->tre_fulldesc = stripslashes($item->tre_fulldesc);
                $item->tre_metadesc = stripslashes($item->tre_metadesc);
                $item->tre_metakeywords = stripslashes($item->tre_metakeywords);
                $item->tre_metatitle = stripslashes($item->tre_metatitle);
                if($this->request('del_img_section')) {
                    $this->_deleteImages( $item_old->tre_image );
                    $item->tre_image = '';
                } else {
                    $item->tre_image = $item_old->tre_image;
                }
                if( $this->request('del_img_menu') ) {
                    $this->_deleteImages( $item_old->tre_image_menu );
                    $item->tre_image_menu = '';
                } else {
                    $item->tre_image_menu = $item_old->tre_image_menu;
                }
                if( $this->request('del_img_menu_a') ) {
                    $this->_deleteImages( $item_old->tre_image_menu_a );
                    $item->tre_image_menu_a = '';
                } else {
                    $item->tre_image_menu_a = $item_old->tre_image_menu_a;
                }
                if(count($_FILES)) {
                    if(isset($_FILES['tre_image']) and ($_FILES['tre_image']['size']>0) and ($_FILES['tre_image']['error']!=4) ) {
                        $this->_deleteImages( $item_old->tre_image );
                        $item->tre_image = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['tre_image']['name']).'.'.strtolower( fileext($_FILES['tre_image']['name']) );
                        move_uploaded_file($_FILES['tre_image']['tmp_name'], MENUORIGINALPATCH.$item->tre_image);
                    }
                    if(isset($_FILES['tre_menuimage']) and ($_FILES['tre_menuimage']['size']>0) and ($_FILES['tre_menuimage']['error']!=4) ) {
                        $this->_deleteImages( $item_old->tre_image_menu );
                        $item->tre_image_menu = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['tre_menuimage']['name']).'.'.strtolower( fileext($_FILES['tre_menuimage']['name']) );
                        move_uploaded_file($_FILES['tre_menuimage']['tmp_name'], MENUORIGINALPATCH.$item->tre_image_menu);
                    }
                    if(isset($_FILES['tre_menuimagea']) and ($_FILES['tre_menuimagea']['size']>0) and ($_FILES['tre_menuimagea']['error']!=4) ) {
                        $this->_deleteImages( $item_old->tre_image_menu_a );
                        $item->tre_image_menu_a = $this->getCurrentUser()->u_id.md5(time().$this->getCurrentUser()->u_id.$_FILES['tre_menuimagea']['name']).'.'.strtolower( fileext($_FILES['tre_menuimagea']['name']) );
                        move_uploaded_file($_FILES['tre_menuimagea']['tmp_name'], MENUORIGINALPATCH.$item->tre_image_menu_a);
                    }
                }
                $rows = $model->updateItem($item);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function getNewLngPid()
    {
        $lngid = (int)$this->request('i');
        if($lngid) {
            $params = $this->getParamsObject();
            echo 'RADTree.refresh();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * To get js in XML alias
     *
     */
    function getJS()
    {
        if($this->request('ref')) {
            $this->setVar('ref', $this->request('ref') );
            $this->setVar('ROOT_PID', $this->_pid );
        }
    }

    function badRequest()
    {

    }
}