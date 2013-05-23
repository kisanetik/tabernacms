<?php
/**
 * Login controller into system
 * @package RADCMS
 * @author Denys Yackushev
 */
class controller_session_login extends rad_controller 
{

    /**
     * Where put social registered users
     * @var integer tre_id
     */
    private $_treestart = 28;

    private $_is_facebook = false;
    private $_is_twitter = false;
    private $_fb_appkey = '';
    private $_fb_secretkey = '';
    private $_tw_appkey = '';
    private $_tw_secretkey = '';
    
    private $_config = NULL;
    
    function __construct() 
    {
        parent::__construct();
        if ($this->request('referer', (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : NULL) and !rad_loader::getCurrentAlias()->ali_admin)) {
            $this->setVar('referer', $this->request('referer', $_SERVER['HTTP_REFERER']));
        }
        if ($this->getCurrentUser() and $this->getCurrentUser()->u_id) {
            $this->setVar('user', $this->getCurrentUser());
		}
		
		if ($this->getParamsObject()) {
		    $params = $this->getParamsObject();
		    $this->_treestart = (int)$params->_get('treestart', $this->_treestart);
		    $this->_is_facebook = (boolean) $params->_get('is_facebook', $this->_is_facebook);
		    //$this->_is_twitter = (boolean) $params->_get('is_twitter', $this->_is_twitter);
		    $this->_fb_appkey = $params->_get('fb_appkey', $this->_fb_appkey);
		    $this->_fb_secretkey = $params->_get('fb_secretkey', $this->_fb_secretkey);
		    //$this->_tw_appkey = $params->_get('tw_appkey', $this->_tw_appkey);
		    //$this->_tw_secretkey = $params->_get('tw_secretkey', $this->_tw_secretkey);
		    $this->setVar('params', $params);
		}
		
		$this->setVar('hash', $this->hash());
        rad_autoload_register(array('controller_session_login', 'autoloadLibrary'));
        $this->makeConfig();
    	switch($this->request('action')) {
    	    case 'soc_login':
                $this->socialsLogin();
                break;
            case 'soc_endpoint':
                $this->socialsEndpoint();
                break;
            case 'soc_refresh':
                $this->socialsRefresh();
                break;
            default:
                if ($this->request('fromsite')) {
                    $this->loginFromSite();
                } else {
                    $this->manage();
                }
                break;
    	}
    }

    function manage() 
    {
        $this->setVar('alias_loginform', $this->config('alias.loginform'));
        if (!$this->request('logout') and $this->request('alias') == 'login' and ($this->getCurrentUser()) and $this->getCurrentUser()->u_id) {
            if ($this->getCurrentUser()->is_admin) {
                $this->redirect($this->makeURL('alias=admin'));
            } else {
                $this->redirect($this->makeURL('alias=' . $this->config('mainAlias')));
            }
            return;
        }
        if (($this->request('login')) and ($this->request('pass'))) {
            if ($user = rad_session::login(rad_input::request('login'), rad_input::request('pass'))) {
                if(!$user->u_active) {
                    $this->setVar('message_error', $this->lang('usernotacitve.session.error'));
                    rad_session::logout();
                } else {
                    $this->setVar('message', 'Login sucersfull!');
                    if($this->request('referer')) {
                        $this->redirect($this->request('referer'));
                    } elseif ($_SERVER['HTTP_REFERER']) {
                        $this->redirect($_SERVER['HTTP_REFERER']);
                    } else {
                        $this->redirect($this->makeURL('alias=admin'));
                    }
                }
                //there is needs to set up some variables lica $this->setVar($key,$value)
            } else {
                $this->setVar('message_error', $this->lang('loginpassincorrect.session.message'));
            }
        } elseif ($this->request('logout')) {
            $logout_url = $this->makeURL('alias='.$this->config('alias.siteloginform'));
            rad_session::logout();
            $this->redirect($logout_url);
        } else {
            //$this->setVar('message','Not enouph actual parametets!');
        }
    }

    function loginFromSite() 
    {
        $login = $this->request('login');
        $pass = $this->request('pass');
        if ( strlen($login) and strlen($pass) and $this->hash()==$this->request('hash') ) {
            if (rad_session::login($login, $pass)) {
                $this->setVar('user', $this->getCurrentUser());
                if($this->request('referer')) {
                    $this->redirect( $this->request('referer') );
                } else {
                    $this->redirect($this->makeURL('alias=' . $this->config('mainAlias')));
                }
            } else {
                //login incorrect
                $this->setVar('message_error', $this->lang('loginpassincorrect.session.message'));
				$this->setVar('req', $this->getAllRequest());
            }
        } elseif ($this->request('logout')) {
            $lang = $this->getCurrentLang();
            rad_session::logout();
            $this->redirect(SITE_URL.$lang.'/');
        }
    }
    
    function makeConfig()
    {
        $this->_config = array();
        $this->_config["base_url"] = $this->makeURL('alias=SITE_ALIAS&action=soc_endpoint').'data/';
        $this->_config["providers"] = array();
        $this->_config["providers"]["OpenID"] = array("enabled" => true);
        if($this->_is_facebook and !empty($this->_fb_appkey) and !empty($this->_fb_secretkey)) {
            $this->_config["providers"]["Facebook"] = array(
                    "enabled" => true,
                    "keys"    => array(
                            "id" => $this->_fb_appkey,
                            "secret" => $this->_fb_secretkey 
                            ),
                    // A comma-separated list of permissions you want to request from the user. See the Facebook docs for a full list of available permissions: http://developers.facebook.com/docs/reference/api/permissions.
                    "scope"   => "",
                    // The display context to show the authentication page. Options are: page, popup, iframe, touch and wap. Read the Facebook docs for more details: http://developers.facebook.com/docs/reference/dialogs#display. Default: page
                    "display" => "popup"
            );
        }
        if($this->_is_twitter and !empty($this->_tw_appkey) and !empty($this->_tw_secretkey)) {
            $this->_config["providers"]["Twitter"] = array(
                    "enabled" => true,
                    "keys"    => array(
                            "key" => $this->_tw_appkey,
                            "secret" => $this->_tw_secretkey
                            )
            );
        }
	    $this->_config["debug_mode"] = false;
	    $this->_config["debug_file"] = '';
    }
    
    static function autoloadLibrary()
    {

        if(!class_exists('Hybrid_Auth',false)) {
            include_once LIBPATH.'hybridauth'.DS.'Hybrid'.DS.'Auth.php';
            if(!class_exists('Hybrid_Auth')) {
                throw new Exception("The class file ".LIBPATH.'hybridauth'.DS.'Hybrid'.DS.'Auth.php does not exists!');
            }
            include_once LIBPATH.'hybridauth'.DS.'Hybrid'.DS.'Endpoint.php';
            if(!class_exists('Hybrid_Endpoint')) {
                throw new Exception("The class file ".LIBPATH.'hybridauth'.DS.'Hybrid'.DS.'Endpoint.php does not exists!');
            }
        }
        return;
    }
    
    function socialsLogin()
    {
        $allowed_providers = array('facebook'/*,twitter*/);
        $provider = strtolower($this->request('provider'));
        if($provider and in_array($provider, $allowed_providers)) {
            $hybridauth = new Hybrid_Auth($this->_config);
            $service = $hybridauth->authenticate($provider);
            if ($service->isUserConnected()) {
                $user_profile = $service->getUserProfile();
                if($user_profile->identifier) {
                    $modelUsers = rad_instances::get('model_system_users');
                    $modelUsers->setState('u_'.$provider.'_id', $user_profile->identifier);
                    $user = $modelUsers->getItem();	
                    if(!$user) {
                        if($user_profile->email) {
                            $modelUsers->clearState();
                            $modelUsers->setState('u_email', $user_profile->email);
                            $user = $modelUsers->getItem();
                            if($user) {
                                //add social identifier to user
                                switch($provider) {
                				    case 'facebook':
                				        $user->u_facebook_id = $user_profile->identifier;
                                        break;
                				    case 'twitter':
                                        $user->u_twitter_id = $user_profile->identifier;
                                        break;
            		              }
                                $modelUsers->updateItem($user);
                            }
                        }
                        if(!$user) {
                            // create new user
                            $user = new struct_users();
                            $user->u_login = ($user_profile->displayName) ? $user_profile->displayName : '';
                            $user->u_email = ($user_profile->email) ? $user_profile->email : '';
                            $user->u_group = $this->_treestart;
                            $user->u_email_confirmed = 1;
                            $user->u_fio = ($user_profile->firstName) ? $user_profile->firstName : '';
                            $user->u_fio = ($user_profile->lastName) ? $user->u_fio.' '.$user_profile->lastName : $user->u_fio;
                            $user->u_address = ($user_profile->country) ? $user_profile->country : '';
                            $user->u_address = ($user_profile->region) ? $user->u_address.', '.$user_profile->region : $user->u_address;
                            $user->u_address = ($user_profile->city) ? $user->u_address.', '.$user_profile->city : $user->u_address;
                            $user->u_address = ($user_profile->address) ? $user->u_address.', '.$user_profile->address : $user->u_address;
                            $user->u_phone = ($user_profile->phone) ? $user_profile->phone : '';
                            $user->u_subscribe_active = 0;
                            switch($provider) {
                                case 'facebook':
                                  $user->u_facebook_id = $user_profile->identifier;
                                  break;
                                case 'twitter':
                                  $user->u_twitter_id = $user_profile->identifier;
                                  break;
                            }
                            $modelUsers->insertItem($user);
                            $user->u_id = $modelUsers->inserted_id();
                        }
                    }
                    if (rad_session::social_login($user_profile->identifier, $provider)) {
                        $this->setVar('user', $this->getCurrentUser());
                        $this->redirect($this->makeURL('action=soc_refresh'));
                    } else {
                        //login incorrect
                        $this->setVar('message_error', $this->lang('error.session.message'));
                        $this->setVar('req', $this->getAllRequest());
                    }
                }
            } else {
                throw new Exception("Can not connect to the service!");
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function socialsEndpoint()
    {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $get = str_replace('?','',$this->request('data'));
        	$get = explode('&',$get);
        	$newget = array();
	        foreach($get as $g) {
	            $g = explode('=',$g);
                $_REQUEST[str_replace('.','_',$g[0])] = $g[1];
	        }
	        Hybrid_Endpoint::process();
        }
    }

    function socialsRefresh()
    {
        echo "<script language=\"JavaScript\" type=\"text/javascript\">window.close();</script>";
    }

}