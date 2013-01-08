<?php
/**
 * System manage users
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_system_manageusers extends rad_controller
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
        $node_id = (int)$this->escapeString($this->request('node_id'));
        if($node_id){
            $model = rad_instances::get('model_system_users');
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
    }

    /**
     * Deletes the one node from users groups tree
     */
    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                rad_instances::get('controller_system_managetree')->deleteItem($node_id);
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
        $model = rad_instances::get('model_menus_tree');
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
                rad_instances::get('controller_system_managetree')->save($node_id);
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
            rad_instances::get('controller_system_managetree')->addItem($node_id);
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
        $this->setVar('item',new struct_users());
        $node_id = (int)$this->escapeString( $this->request('node_id') );
        if($node_id){
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.menus.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents',$parents);
            $this->setVar('selected',$node_id);
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function editUserForm()
    {
        $u_id = (int)$this->escapeString( $this->request('u_id') );
        $node_id = (int)$this->escapeString( $this->request('node_id') );
        if($u_id and $node_id) {
            $this->setVar('item',rad_instances::get('model_system_users')->getItem($u_id));
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid',$this->_pid);
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.menus.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents',$parents);
            $this->setVar('selected',$node_id);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /*
    function assignGroups()
    {
        $table = new model_system_table(RAD.'users_groups');
        $this->groups = $table->getItems( '0,100' );
        if(count($this->groups)){
            $newStruct = new struct_users_groups();
            $newStruct->grp_name = $this->lang('-choose');
            $newStruct->grp_access = 1000;
            array_unshift($this->groups, $newStruct );
        }
        $this->setVarByRef('gitems',$this->groups);
    }
    */

    /*
    function showRecords($sort, $from, $limit)
    {
        $table = new model_system_table(RAD.'users');
        if($this->get('group',NULL)){
            $table->setState('where','u_group="'.$this->request('group').'"');
            //$table->setState('u_group', $this->request('group'));
            $this->setVar('group_id', $this->get('group'));
        }
        $table->setState('order by',$sort);
        $items = $table->getItems( ($from*$limit).','.($from*$limit)+$limit );
        $struct = new struct_users();
        $keys = $struct->getKeys();
        unset($struct);
        //Add vars to template
        $this->setVarByRef('items',$items);
        $this->setVarByRef('keys', $keys);

        $this->setVar('string_action', $this->lang('action'));
        $this->setVar('askDeleting', rad_config::getParam('settings.askDeleting', false) );
        if($this->hasRights('update')){
            $this->setVar('canManageUgroups', true);
        }else{
            $this->setVar('canManageUgroups', false);
        }
    }
    */


    /**
     * Adds the user from AJAX user form
     */
    function addUser()
    {
        $item = new struct_users($this->getAllRequest());
        $model = rad_instances::get('model_system_users');
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
                $user = new struct_users( $this->getAllRequest() );
                $user->u_id = $u_id;
                if($user->u_access < $this->getCurrentUser()->u_access) {
                    echo 'alert("can\'t edit user with rules more then yours");';
                    die();
                }
                $user->addFieldToIgnoresList('u_pass');
                $rows = rad_instances::get('model_system_users')->updateItem($user);
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
            $u_id = (int)$this->escapeString( $this->request('u_id') );
            $n_pass = $this->request('new_pass');
            $n_pass = trim( $n_pass );
            if(strlen($n_pass)>=$this->passMinLength){
                $new_pass = md5( $n_pass );
                if($u_id){
                    $rows = rad_instances::get('model_system_users')->changePassword($u_id,$new_pass);
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
                $user = rad_instances::get('model_system_users')->getItem($u_id);
                if($user->u_access < $this->getCurrentUser()->u_access){
                    echo 'alert("can\'t edit user with rules more then yours");';
                    die();
                }
                $rows = rad_instances::get('model_system_users')->deleteItem(new struct_users(array('u_id'=>$u_id)));
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
            rad_instances::get('model_system_users')->updateItem($user);
        }
    }

    function badRequest()
    {
        $this->setVar('message','Bad Request!!!');
    }

    function showSettings()
    {
        $this->setVar('langs',$this->getAllLanguages());
        $model = rad_instances::get('model_mail_mailtemplate');
        $model->setState('name',array($this->config('subscribers.registration_template'),$this->config('subscribers.registrationok_template')));
        $items = $model->getItems();
        $settings = array();
        if(count($items)) {
            for($i=0;$i<count($items);$i++){
                $settings[$items[$i]->sct_langid][$items[$i]->sct_name] = $items[$i];
            }
        }
        //проверяем массив на настрйоки
        foreach($this->getAllLanguages() as $lang) {
            if(!isset($settings[$lang->lng_id])) {
                $settings[$lang->lng_id] = array();
            }
            if(!isset($settings[$lang->lng_id][$this->config('subscribers.registration_template')])) {
                $settings[$lang->lng_id][$this->config('subscribers.registration_template')] = new struct_subscibe_templates();
            }//if
            if(!isset($settings[$lang->lng_id][$this->config('subscribers.registrationok_template')])) {
                $settings[$lang->lng_id][$this->config('subscribers.registrationok_template')] = new struct_subscibe_templates();
            }//if
        }//foreach
        $this->setVar('mset',$settings);
        $this->setVar('registration_template',$this->config('subscribers.registration_template'));
        $this->setVar('registrationok_template',$this->config('subscribers.registrationok_template'));
    }

    private function _getSettingsFromRequest()
    {
        $result = array();
        $req = $this->getAllRequest();
        foreach($this->getAllLanguages() as $lang){
            //Registration
            $result[] = new struct_subscibe_templates();
            $cnt = count($result)-1;
            $result[$cnt]->sct_id = (int)$req['4sct_id'][$lang->lng_id];
            $result[$cnt]->sct_name = stripslashes($this->config('subscribers.registration_template'));
            $result[$cnt]->sct_backemail = stripslashes($req['4mail_subscribe_from'][$lang->lng_id]);
            $result[$cnt]->sct_backemailname = stripslashes($req['4mail_subscribe_from_name'][$lang->lng_id]);
            $result[$cnt]->sct_mailtitle = stripslashes($req['4mail_subscribe_title'][$lang->lng_id]);
            $result[$cnt]->sct_mailtemplate = stripslashes($req['4mail_template'][$lang->lng_id]);
            //$result[$cnt]->sct_mailtemplate_item = stripslashes($req['3mail_template_item'][$lang->lng_id]);
            $result[$cnt]->sct_langid = $lang->lng_id;
            $result[$cnt]->sct_active = 1;

            //Registration ok
            $result[] = new struct_subscibe_templates();
            $cnt = count($result)-1;
            $result[$cnt]->sct_id = (int)$req['5sct_id'][$lang->lng_id];
            $result[$cnt]->sct_name = stripslashes($this->config('subscribers.registrationok_template'));
            $result[$cnt]->sct_backemail = stripslashes($req['5mail_subscribe_from'][$lang->lng_id]);
            $result[$cnt]->sct_backemailname = stripslashes($req['5mail_subscribe_from_name'][$lang->lng_id]);
            $result[$cnt]->sct_mailtitle = stripslashes($req['5mail_subscribe_title'][$lang->lng_id]);
            $result[$cnt]->sct_mailtemplate = stripslashes($req['5mail_template'][$lang->lng_id]);
            //$result[$cnt]->sct_mailtemplate_item = stripslashes($req['3mail_template_item'][$lang->lng_id]);
            $result[$cnt]->sct_langid = $lang->lng_id;
            $result[$cnt]->sct_active = 1;
        }
        return $result;
    }

    function saveSettings()
    {
        $items = $this->_getSettingsFromRequest();
        $model = rad_instances::get('model_mail_mailtemplate');
        $rows = 0;
        foreach($items as $item) {
            $model->setState('lang',$item->sct_langid);
            $model->setState('name',$item->sct_name);
            $exitsts = $model->getItems(1);
            if(count($exitsts) and $exitsts[0]->sct_id) {
                $item->sct_id = $exitsts[0]->sct_id;
                $rows += $model->updateItem($item);
            } else {
                $rows += $model->insertItem($item);
            }
        }//foreach
        echo 'RADRegSettings.message("'.addslashes($this->lang('rowsupdated.system.text')).': '.$rows.'");';
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