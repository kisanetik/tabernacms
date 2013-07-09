<?php
/**
 * System manage users
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_core_manageusers extends rad_controller
{
    private $defaultSort = 'u_id';

    private $defaultLimit = '20';

    private $groups = NULL;

    private $passMinLength = 4;

    /**
     *  Users groups PID
     * @var integer
     */
    private $_pid = 133;
    
    function __construct()
    {
        if($this->getParamsObject()){
            //$this->defaultSort = $this->getParamsObject()->defaultsort;
            $params = $this->getParamsObject();
            //$this->_pid_types = $this->getParamsObject()->treetypesstart;
            $this->defaultLimit = rad_config::getParam( 'users.PerPage', $this->defaultLimit );
            $this->defaultSort = rad_config::getParam( 'users.ordering', $this->defaultSort );
            $this->passMinLength = $params->passMinLength;
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID());
            $this->setVar('params',$params);
            if(!$this->request('action') and $params->_get('ishaveregistration',false))
                $this->showSettings();
        }
        $this->setVar('hash',$this->hash());
        if($this->request('action')){
            $this->setVar( 'action', strtolower( $this->request( 'action' ) ) );
            switch(strtolower($this->request('action'))){
                case 'getjs':
                    $this->getJS();
                    break;
                case 'getusers':
                    $this->getUsers();
                    break;
                case 'editform':
                    $this->editForm();
                    break;
                case 'getnodes':
                    if($this->request('nic')) {
                        $this->recursive($this->request('nic'));
                    } else {
                        $this->getNodes();
                    }
                    break;
                case 'deletenode':
                    $this->deleteNode();
                    break;
                case 'addnode':
                    $this->addNode();
                    break;
                case 'savenode':
                    $this->saveNode();
                    break;
                case 'adduser':
                    $this->addUserForm();
                    break;
                case 'edituser':
                    $this->editUserForm();
                    break;
                case 'save':
                    if($this->request('u_id')){
                        $this->saveUser();
                    }else{
                        $this->addUser();
                    }
                    break;
                case 'chpass':
                    $this->chPass();
                    break;
                case 'deluser':
                    $this->deleteRecord();
                    break;
                case 'saveparam':
                    $this->saveUserParam();
                    break;
                case 'savesettings':
                    $this->saveSettings();
                    break;
                case 'newlngpid':
                    $this->getNewLngPid();
                    break;
                default:
                    $this->badRequest();
                    break;
            }//switch
        }//if action
        if($this->get('group'))
            $this->showRecords( $this->get('sort', $this->defaultSort), $this->get('page', 0), $this->defaultLimit );
        //$this->setVar('selected_group',$this->get('group',-1));
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
     * Get the users from AJAX
     * @return HTML
     */
    function getUsers()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $model = rad_instances::get('model_core_users');
            $model->setState('u_group',$node_id);
            $model->setState('where','u_email NOT IN("ep_promo","ep_support")');
            $items = $model->getItems();
            $this->setVar('items',$items);
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Show edit tree node form in AJAX
     * @return html
     */
    function editForm()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $node = rad_instances::get('model_coremenus_tree')->getItem($node_id);
            $this->setVar('item',$node);
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_coremenus_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.system.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents', $parents);
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Deletes the one node from users groups tree
     */
    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                $model = rad_instances::get('model_coremenus_tree');
                $current_node = $model->getItem($node_id);
                $rows = 0;
                //get current tree
                $parent_node = $model->getItem($current_node->tre_pid);
                $toDeleteTreeIds = array();
                if($current_node->tre_id != $this->_pid) {
                    $toDeleteTreeIds[] = $current_node->tre_id;
                }
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
                $newsModel = rad_instances::get('model_core_users');
                $rows += $newsModel->deleteItemsByTreeId($toDeleteTreeIds);
                //delete seleted tree and child trees
                $rows += $model->deleteItemById($toDeleteTreeIds);
                if($rows) {
                    echo 'RADUsersTree.message("'.addslashes( $this->lang('-deleted') ).': '.$rows.'");';
                    echo 'RADUsersTree.cancelEdit();';
                } else {
                    echo 'RADUsersTree.message("'.addslashes( $this->lang('deletedrows.catalog.error') ).': '.$rows.'");';
                    echo 'RADUsersTree.cancelEdit();';
                }
                echo 'RADUsersTree.refresh();';                
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Return the nodes list in XML
     *
     * @return xml
     */
    function getNodes()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->request('pid',$this->_pid));
        if(!(int)$this->request('nolang')) {
            $model->setState('lang',$this->getContentLangID());
        }
        //$model->setState('showSQL',true);
        $model->setState('order', 'tre_position,tre_name');
        $items = $model->getItems();
        //print_r($items);die;
        $s = '<?xml version="1.0"?><nodes>';
        if(count($items)){
            foreach($items as $id){
                $s.='<node text="'.str_replace('"', '&quot;', $id->tre_name).'"';
                $s.=($id->tre_active)?'':' color="#808080"';
                $s.=($id->tre_islast)?'':' load="'.SITE_URL.'SYSmanageTreeXML/action/getnodes/pid/'.$id->tre_id.'/"';
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
     * Save node in users groups tree
     */
    function saveNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                rad_instances::get('controller_core_managetree')->save($node_id);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Adds the default node to users groups thee into the parent_id
     */
    function addNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            rad_instances::get('controller_core_managetree')->addItem($node_id);
            echo 'RADUsersTree.editClick();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Show the form with add user fields
     * @return html
     */
    function addUserForm()
    {
        $this->setVar('item',new struct_core_users());
        $node_id = (int)$this->request('node_id');
        if($node_id){
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_coremenus_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.menus.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents',$parents);
            $this->setVar('selected',$node_id);
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function editUserForm()
    {
        $u_id = (int)$this->request('u_id');
        $node_id = (int)$this->request('node_id');
        if($u_id and $node_id) {
            $this->setVar('item',rad_instances::get('model_core_users')->getItem($u_id));
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_coremenus_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.menus.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents',$parents);
            $this->setVar('selected',$node_id);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Adds the user from AJAX user form
     */
    function addUser()
    {
        $item = new struct_core_users($this->getAllRequest());
        $model = rad_instances::get('model_core_users');
        $item->u_pass = md5($item->u_pass);
        $item->u_subscribe_langid = $this->getCurrentLangID();
        if($item->u_access < $this->getCurrentUser()->u_access) {
            $item->u_access = $this->getCurrentUser()->u_access;
        }
        $rows = $model->insertItem($item);
        if( $rows ) {
            echo 'RADUsers.message("'.addslashes($this->lang('addedrows.sustem.message')).': '.$rows.'");';
            echo 'RADUsersTree.listUsers(RADUsersTree.getSID());';
        } else {
            $this->badRequest();
        }
        echo 'RADUsers.cancelClick();';
    }

    /**
     * Save the user from request from AJAX form
     * @return JavaScript code
     */
    function saveUser()
    {
        if($this->request('hash') == $this->hash()) {
            $u_id = (int)$this->request('u_id');
            if($u_id) {
                $user = new struct_core_users( $this->getAllRequest() );
                $user->u_id = $u_id;
                if($user->u_access < $this->getCurrentUser()->u_access) {
                    echo 'alert("can\'t edit user with rules more then yours");';
                    die();
                }
                $user->addFieldToIgnoresList('u_pass');
                $rows = rad_instances::get('model_core_users')->updateItem($user);
                if($rows) {
                    echo 'RADUsers.message("'.addslashes($this->lang('updatedrows.sustem.message')).': '.$rows.'");';
                    echo 'RADUsersTree.listUsers(RADUsersTree.getSID());';
                } else {
                    $this->badRequest();
                }
                echo 'RADUsers.cancelClick();';
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Change password to user from AJAX
     * @return JS
     */
    function chPass()
    {
        if($this->request('hash') == $this->hash()) {
            $u_id = (int)$this->request('u_id');
            $n_pass = $this->request('new_pass');
            $n_pass = trim( $n_pass );
            if(strlen($n_pass)>=$this->passMinLength){
                $new_pass = md5( $n_pass );
                if($u_id){
                    $rows = rad_instances::get('model_core_users')->changePassword($u_id,$new_pass);
                    if($rows){
                        echo 'alert("'.$this->lang('passwordchanged.system.message').'");';
                    }else{
                        echo 'alert("'.$this->lang('passwordchanged.system.error').'");';
                    }
                }else{
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                }
            }else{
                echo 'alert("'.addslashes( $this->lang('passminlength.system.error').' '.$this->passMinLength ).'");';
            }
        } else {
            echo 'alert("'.$this->lang('passwordchanged.system.error').'");';
        }
    }

    /**
     * Deletes the user by it ID
     * @return JavaScript
     */
    function deleteRecord()
    {
        if($this->request('hash') == $this->hash()) {
            $u_id = (int)$this->request('u_id');
            if($u_id){
                $user = rad_instances::get('model_core_users')->getItem($u_id);
                if($user->u_access < $this->getCurrentUser()->u_access){
                    echo 'alert("can\'t edit user with rules more then yours");';
                    die();
                }
                $rows = rad_instances::get('model_core_users')->deleteItem(new struct_core_users(array('u_id'=>$u_id)));
                if($rows){
                    echo 'RADUsers.message("'.addslashes($this->lang('deletedrows.sustem.message')).': '.$rows.'");';
                    echo 'RADUsersTree.listUsers(RADUsersTree.getSID());';
                }else{
                    echo 'RADUsers.message("'.addslashes($this->lang('deletedrows.sustem.error')).': '.$rows.'");';
                }
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Saves the user params, like hidden or not left menu
     *
     */
    function saveUserParam()
    {
        $prm_name = $this->request('n');
        $prmvalue = $this->request('v');
        $user = $this->getCurrentUser();
        if(isset($user->u_id) and $user->u_id) {
            $paramsobject = $this->getCurrentUserParams();
            $paramsobject->_set($prm_name,$prmvalue,'string');
            $user->u_params = $paramsobject->_hash();
            rad_instances::get('model_core_users')->updateItem($user);
        }
    }

    function badRequest()
    {
        $this->setVar('message','Bad Request!!!');
    }

    function getNewLngPid()
    {
        $lngid = (int)$this->request('i');
        if($lngid) {
            $params = $this->getParamsObject();
            echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
            echo 'RADUsersTree.refresh();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }
}