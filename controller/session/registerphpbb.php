<?php
/**
 * Simple hand-registration of users with registration on phpBB 3.0.10
 * @author Viacheslav Tereshchenko
 * @version 0.2
 * @package Taberna
 */

define('IN_PHPBB', true);

class controller_session_registerphpbb extends rad_controller
{
    /**
     * Where putr registered users
     * @var integer tre_id
     */
    private $_treestart = 0;

    /**
     * City id
     * @var integer
     */
    private $_countrystart = 0;

    private $_maksstart = 81;
    
    /**
     *Format of email letter (text|html)
     * @var string
     */
    private $_mail_format = 'html';
    
    private $_phpbb_src = '/var/web/forum.tabernaecommerce.ru/';
    
    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_treestart = $params->_get('treestart',$this->_treestart,$this->getCurrentLangID());
            $this->_countrystart = $params->_get('countrystart',$this->_countrystart,$this->getCurrentLangID());
            $this->_maksstart = $params->_get('maksstart',$this->_maksstart,$this->getCurrentLangID());
            $this->_mail_format = $params->_get('mail_format', $this->_mail_format);
            $this->_phpbb_src = $params->_get('phpbb_src', $this->_phpbb_src, $this->getCurrentLangID());
            $this->setVar('params',$params);
        }
        if( $this->getCurrentUser() ) {
            $this->setVar('user',$this->getCurrentUser());
        }
        if($this->request('a')) {
            $this->setVar('action',strtolower($this->request('a')));
            switch(strtolower($this->request('a'))){
                case 'cap':
                    $this->showCapcha();
                    break;
                case 'r':
                    $this->tryRegister();
                    break;
                case 'getjs':
                    $this->getJS();
                    break;
                case 'chdata.html':
                    $this->changeData();
                    break;
                case 'checkandsend':
                	$this->_assignDefaultData();
                	$this->remindPassByEmail();
                	break;
                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }//switch
        }else {
            if($this->request('c')) {
                $this->activateUser();
            } elseif($this->request('actcode')) {
                $this->sendNewPassword();
            } else {
                //DEFAULT DATA FORM FOR REGISTRATION
                $this->_assignDefaultData();
            }
        }//if request('a')
    }

    private function _assignDefaultData()
    {
        $this->setVar('item', new struct_users());
        $tree = rad_instances::get('model_menus_tree');
        $tree->setState('pid',$this->_countrystart);
        $tree->setState('active',1);
        $this->setVar('cities',$tree->getItems());
        $tree->setState('pid',$this->_maksstart);
        $this->setVar('manufactures',$tree->getItems());
        $this->setVar('hash', $this->hash());
    }

    /**
     * <ru>Показывает капчу</ru>
     * <en>Shows Captcha</en>
     */
    function showCapcha()
    {
        $model = rad_instances::get('model_session_captcha');
        $model->show();
    }

    /**
     * Проверяет данные перед регистрацией.
     * Ассигнирует шаблону данные для отображения ошибок
     * @return Boolean Всё ок?
     */
    private function _verifyInputData($item = null)
    {
        $messages = array();
        $req = $this->getAllRequest();
        foreach($req as $key=>$value) {
            if(is_string($value))
                $req[$key]=stripslashes($value);
        }
        if(!$item) {
            $item = new struct_users($req);
        } else {
            $item->MergeArrayToStruct($req);
        }
        if(empty($item->u_pass) and $this->request('u_pass1')) {
            $item->u_pass = $this->request('u_pass1');
        }
        $item->u_email = strip_tags($item->u_email);
        $item->u_fio = strip_tags($item->u_fio);
        $item->u_login = strip_tags($item->u_login);
        if(!php_mail_check($item->u_email)) {
            $messages[] = $this->lang('entervalidemail.session.error');
        }
        if($this->request('u_pass1')!=$this->request('u_pass2')) {
            $messages[] = $this->lang('passwordnotpassed.session.error');
        }
        if(count($messages)) {
            $this->setVar('message',implode('<br />',$messages));
            return false;
        } else {
            return $item;
        }
    }

    /**
     * При попытке зарегистрироваться, проверяются данные и шлётся мыло
     */
    function tryRegister()
    {
        $item = $this->_verifyInputData($this->getCurrentUser());
        if($this->request('change')) {
            $this->setVar('change',true);
        }
        if($item){
            $this->setVar('item',$item);
            $modelCaptcha = new model_session_captcha(SITE_ALIAS);
            if( !$modelCaptcha->check( trim($this->request('captcha')) ) ) {
                $this->setVar('message',$this->lang('wrongcaptcha.session.error'));
            } else {
                $model = rad_instances::get('model_system_users');
                $model->setState('u_email',$item->u_email)
                      ->setState('u_active', 1);
                $tmp = $model->getItems(1);
                if(count($tmp) and $tmp[0]->u_id) {
                    if($this->request('change') and $tmp[0]->u_active) {
                        $model->updateItem($item);
                        rad_session::setUser($item);
                        $this->setVar('subitems',$subitems);
                        $this->setVar('item',$item);
                        $this->setVar('message',$this->lang('yourdatesuccupdated.session.message'));
                    //RESEND EMAIL
                    } elseif($tmp[0]->u_active and $tmp[0]->u_email_confirmed) {
                        $this->setVar('message',$this->lang($this->config('registration.mail_already_registred_text')));
                    } else {
                        $table = new model_system_table(RAD.'subscribers_activationurl');
                        $table->setState('where','sac_scrid='.$tmp[0]->u_id.' and sac_type=2');
                        $item_url = $table->getItem();
                        if($item_url->sac_id){
                            $this->_sendMail($item,'register_resend',array('url'=>$item_url->sac_url));
                        }else{
                            $item_url = new struct_subscribers_activationurl();
                            $item_url->sac_url = md5(rad_session::genereCode(31).now().$item->u_id);
                            $item_url->sac_scrid = $item->u_id;
                            $item_url->sac_type = 2;
                            $table->insertItem($item_url);
                            $this->_sendMail($item,'register_resend',array('url'=>$item_url->sac_url));
                        }
                        $this->setVar('message',$this->lang($this->config('registration.mail_regsended_text')));
                        $this->setVar('onlymessage',true);
                    }
                } else {
                    //REGISTER!
                    $item->u_active = 1;
                    $item->u_group = $this->_treestart;
                    $clearpass = $item->u_pass;
                    $item->u_pass = trim($this->request('u_pass1'));
                    $model->insertItem($item);
                    $item->u_id = $model->inserted_id();
                    $item_url = new struct_subscribers_activationurl();
                    $item_url->sac_url = md5(rad_session::genereCode(31).now().$item->u_id);
                    $item_url->sac_scrid = $item->u_id;
                    $item_url->sac_type = 2;
                    $item_url->save();
                    $this->_sendMail($item,'register',array('url'=>$item_url->sac_url, 'clearpass'=>$clearpass));
                    $this->setVar('message',$this->lang($this->config('registration.mail_regsended_text')));
                    $this->setVar('onlymessage',true);
                }
            }
        } else {
            $this->setVar('item', new struct_users($this->getAllRequest()));
        }
    }
    
    function phpBBRgister($userObj) 
    {
    	$save_sytem_config = $GLOBALS['config'];
		global $phpbb_root_path;
		global $phpEx;
		global $db;
		global $config;
		global $user;
		global $auth;
		global $cache;
		global $template;
        $messages = array();
        $phpbb_root_path = $this->_phpbb_src;
        $phpEx = 'php';
        ob_start(); 
        if( is_readable($this->_phpbb_src . 'config.php') and is_executable($this->_phpbb_src . 'config.php') and
            is_readable($this->_phpbb_src . 'common.php') and is_executable($this->_phpbb_src . 'common.php') and
            is_readable($this->_phpbb_src . 'includes/functions_user.php') and is_executable($this->_phpbb_src . 'includes/functions_user.php') ) {
                require_once($this->_phpbb_src . 'config.php');
                require_once($this->_phpbb_src . 'common.php');
                require_once($this->_phpbb_src . 'includes/functions_user.php');
        } else {
        	$messages[] = $this->lang('noaccessphpbbfiles.session.error');
        	$messages[] = $this->_phpbb_src . 'config.php<br/>' . $this->_phpbb_src . 'common.php<br/>' . $this->_phpbb_src . 'includes/functions_user.php<br/>';
        	return $messages;
        }
        if(!validate_username($userObj->u_login)){
	        $user_row = array(
	            'username' => $userObj->u_login,
	            'user_password' => phpbb_hash($userObj->u_pass),
	            'user_email' => $userObj->u_email,
	            'group_id' => 7,
	            'user_timezone' => 0.00,
	            'user_dst' => 0,
	            'user_lang' => 'ru',
	            'user_type' => 0,
	            'user_actkey' => '',
	            'user_dateformat' => '|d M Y|, H:i',
	            'user_style' => 1,
	            'user_regdate' => time(),
	            );
	        $lid = user_add($user_row);
	        if(!$lid) {
	        	$messages[] = $this->lang('cannotadduser.session.error');
	        }
        } else { 
        	$messages[] = $this->lang('loginallreadyexists.session.error'); 
        }
        ob_end_clean();
        $GLOBALS['config'] = $save_sytem_config;
        if(count($messages)) {
            return $messages;
        } else {
            return false;
        }
    }
	
    private function _sendMail(struct_users $user,$type,$params = array())
    {
        switch($type) {
            case 'register_resend':
            case 'register':
                $template_name = $this->config('registration.template');
                $link = $this->makeURL('c='.urlencode( $params['url'] ));
                $email_to = $user->u_email;
                $clearpass = !empty($params['clearpass'])?$params['clearpass']:'';
                break;
            case 'register_ok':
                $template_name = $this->config('registration.after_template');
                $link = '';
                $email_to = $user->u_email;
                $clearpass = '';
                break;
            case 'send_admin':
                $template_name = $this->config('registration.admin_notify_template');
                $link = '';
                $email_to = 'admin';
                $clearpass = !empty($params['clearpass'])?$params['clearpass']:'';
                break;
            case 'remind':
                $template_name = $this->config('remind_password.template');
	            $link = $this->makeURL('actcode='.urlencode( $params['url'] ));
                $email_to = $user->u_email;
                $clearpass = '';
            	break;
            case 'newpass':
                $template_name = $this->config('new_password.template');
                $link = '';
                $email_to = $user->u_email;
                $clearpass = !empty($params['clearpass'])?$params['clearpass']:'';
                break;

            default:
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                break;
        }
        if($email_to=='admin') {
            $email_to = $this->config('admin.mail');
        }
        rad_mailtemplate::send($email_to, $template_name, array('user'=>$user, 'link'=>$link, 'clearpass'=>$clearpass), $this->_mail_format);
    }

    function activateUser()
    {
        $c = urldecode( $this->request('c') );
        if($c){
            $this->setVar('action','c');
            $model = rad_instances::get('model_system_users');
            $model->setState('code',$c);
            $user = $model->getItem();
            if(isset($user->u_id) and $user->u_id){
            	$errorMsgs = $this->phpBBRgister($user); 
            	if(!$errorMsgs) {
	                $user->u_email_confirmed = 1;
	                $user->u_pass = md5($user->u_pass);
	                $model->updateItem($user);
	                rad_instances::get('model_mail_subscribes')->deleteActivationURL($c);
	                $this->setVar('message',$this->lang( $this->config('registration.mailactivated_text') ) );
	                //send message to user
	                $this->_sendMail($user, 'register_ok');
	                $this->_sendMail($user, 'send_admin');
            	} else {
            		$this->setVar('message',implode('<br />',$errorMsgs));
            	}
            }else{
                //code not found
                $this->setVar('message',$this->lang($this->config('registration.code_not_found')));
            }
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function getJS()
    {
        //
    }

    function changeData()
    {
        $this->_assignDefaultData();
        $this->unsetVar('user');
        $this->setVar('item',$this->getCurrentUser());
        $model = rad_instances::get('model_system_users');
        $model->setState('pid',$this->getCurrentUser()->u_id);
        $subitems = $model->getItems();
        $this->setVar('subitems',$subitems);
        if(count($subitems)) {
            $sia = array();
            foreach($subitems as $id){
                $sia[] = $id->u_id;
            }
            $this->assignMans($sia);
        }
        $this->setVar('currencies', rad_instances::get('model_catalog_currency')->getItems() );
    }
    
    function remindPassByEmail() 
    {
    	$messages = array();
    	if($this->hash() == $this->request('hash')) {
	    	if($this->request('u_email') and php_mail_check($this->request('u_email'))) {
	    		$email = $this->request('u_email');
	    		$model = rad_instances::get('model_system_users');
                $model->setState('u_email', $email);
                $user = $model->getItems(1);
                $user = current($user);
                if($user and $user->u_active and $user->u_email_confirmed) {
                    $model = rad_instances::get('model_mail_subscribes');
                	$item_url = $model->setState('sac_scrid', $user->u_id)->setState('sac_type', 3)->getActivationUrl();
                    if(empty($item_url->sac_id)) {
                        $item_url = new struct_subscribers_activationurl();
                        $item_url->sac_url = md5(rad_session::genereCode(31).now().$user->u_id);
                        $item_url->sac_scrid =  $user->u_id;
                        $item_url->sac_type = 3;
                        $item_url->save();
                    }
                    $this->_sendMail($user, 'remind', array('url'=>$item_url->sac_url));
                } else {
                    $messages[] = $this->lang('notfoundemail.session.error');
                }	                
	    	} else {
	    		$messages[] = $this->lang('entervalidemail.session.error');
	    	}
    	} else {
    		$this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
    	}
        if(count($messages)) {
            $this->setVar('message',implode('<br />',$messages));
        } else {
        	$this->setVar('code_sent', true);
        }
    }
    
    function sendNewPassword()
    {
    	$messages = array();
    	$actcode = $this->request('actcode');
        $model = rad_instances::get('model_mail_subscribes');
        $item = $model->setState('sac_url', $actcode)->setState('sac_type', 3)->getActivationUrl();
        if(!empty($item->sac_id)) {
            $user = rad_instances::get('model_system_users')->setState('u_id', (int) $item->sac_scrid)->getItem();
            if(!empty($user->u_id)) {
                $password = rad_session::genereCode(6);
		        $user->u_pass = md5($password);
		        if($this->phpBBchangePassword($user->u_login, $password)) {
                    $user->save();
                    $item->remove();
                    $this->_sendMail($user, 'newpass', array('clearpass'=>$password));
                    $this->setVar('pass_sent', true);
		        } else { 
                    $messages[] = $this->lang('phpbbchangepassword.session.error'); //user not found in phpbb DB or doesn't have permission to phpbb required files   
                }
            } else {
            	$messages[] = $this->lang('usernotfound.session.error');
            }
        } else {
        	$messages[] = $this->lang('wrongcode.session.error');
        }
        if(count($messages)) {
            $this->setVar('message',implode('<br />',$messages));
        }
    }
    
    function phpBBchangePassword($u_name, $new_password) 
    {
        $save_sytem_config = $GLOBALS['config'];
        global $phpbb_root_path;
        global $phpEx;
        global $db;
        global $config;
        global $user;
        global $auth;
        global $cache;
        global $template;
        $phpbb_root_path = $this->_phpbb_src;
        $phpEx = 'php';
        ob_start(); 
        if( is_readable($this->_phpbb_src . 'config.php') and is_executable($this->_phpbb_src . 'config.php') and
            is_readable($this->_phpbb_src . 'common.php') and is_executable($this->_phpbb_src . 'common.php') and
            is_readable($this->_phpbb_src . 'includes/functions_user.php') and is_executable($this->_phpbb_src . 'includes/functions_user.php') ) {
                require_once($this->_phpbb_src . 'config.php');
                require_once($this->_phpbb_src . 'common.php');
                require_once($this->_phpbb_src . 'includes/functions_user.php');
        } else {
			return false;
        }
        $username_ary = $u_name;
        user_get_id_name($user_id_ary, $username_ary);
        $isOK = false;
        if(!empty($user_id_ary) && isset($user_id_ary[0])) {
        	$uid = $user_id_ary[0];
        	$q = "UPDATE " . USERS_TABLE . " SET `user_password` = '" . phpbb_hash($new_password) . "' WHERE `user_id` = " . $uid . " LIMIT 1";
        	$isOK = $db->sql_query($q);
        } 
        ob_end_clean();
        $GLOBALS['config'] = $save_sytem_config;
        return $isOK;
    }
}