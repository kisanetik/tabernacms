<?php
/**
 * System class for some system modifications for all components
 * @authof Denys Yackushev
 * @package RADCMS
 */
class controller_system_system extends rad_controller
{
    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->SetVar('params', $params);
        }
        if($this->request('a')) {//action
            $this->setVar('action', $this->request('a'));
            switch($this->request('a')) {
                case 'showCaptcha':
                    $this->showCaptcha();
                    break;
                case 'user_exists':
                    $this->checkUserExists($this->request('email'));
                    break;
                case 'changeCurrency':
                    $this->changeCurrency();
                    break;
                case 'logintaberna':
                    $this->_loginTaberna();
                    break;
                case 'logintaberna_lpsave':
                    $this->_testSaveTabernaLP();
                    break;
                case 'getPartnerLicense':
                    $this->_getPartnersLicense();
                    break;
                case 'acceptLicense':
                    $this->_acceptLicense();
                    break;
                case 'tabernalogout':
                    $this->_logoutTaberna();
                    break;
                default:
                    $this->redirect('404');
                    break;
            }
        }
    }

    protected function showCaptcha()
    {
        $model = new model_session_captcha($this->request('page'));
        $model->show();
    }

    public function checkUserExists($email)
    {
        $model = rad_instances::get('model_system_users');
        $model->setState('u_email', $email);
        $user = $model->getItem();
        if(!empty($user->u_id)) {
            die( json_encode($user->u_id) );
        }
    }

    protected function changeCurrency()
    {
        if(model_catalog_currcalc::setDefaultCurrencyId((int)$this->request('cur_id'))) {
            echo 'location.reload();';
        }
    }
    
    private function _geti18()
    {
        $result = array();
        $result['TXT_SUBMIT'] = $this->lang('-submit', null, true);
        $result['TXT_W_LOGO'] = $this->lang('tabernalogin.session.title', null, true);
        $result['TXT_LOGIN'] = $this->lang('loginform.system.title', null, true);
        $result['TXT_PASS'] = $this->lang('password.session.text');
        $result['TXT_CANCEL'] = $this->lang('-cancel', null, true);
        $result['TXT_USER_NOT_FOUND'] = $this->lang('loginpassincorrect.session.message', null, true);
        $result['TXT_LP_EMPTY'] = $this->lang('enteremailpass.session.title', null, true);
        $result['TXT_UNKNOWN_ERROR'] = $this->lang('-error', null, true);
        $result['TXT_USER_BLOCKED'] = $this->lang('userblocked.session.title', null, true);
        $result['TXT_W_LICENSE'] = $this->lang('readandacceptlicense.system.title', null, true);
        $result['TXT_AUTHORIZATION'] = $this->lang('autorization.session.title', null, true);
        return $result;
    }
    
    private function _parseMenu($res)
    {
        $result = array();
        if(!empty($res->menu)) {
            for($i=0; $i < count($res->menu); $i++) {
                if(!empty($res->menu[$i]->url)) {
                    $result[$i]['href'] = $this->makeURL($res->menu[$i]->url);
                }
                $result[$i]['title'] = $this->lang($res->menu[$i]->langcode);
                if(!empty($res->menu[$i]->img)) {
                    $result[$i]['img'] = $res->menu[$i]->img;
                }
                if(!empty($res->menu[$i]->target)) {
                    $result[$i]['target'] = $res->menu[$i]->target;
                }
            }
        }
        return $result;
    }
    
    protected function _loginTaberna()
    {
        $result['i18'] = $this->_geti18();
        $email = $this->config('taberna.user');
        $pass = $this->config('taberna.pass');
        if(!empty($email) and !empty($pass)) {
            $res = rad_instances::get('model_session_taberna')->login($this->config('taberna.user'), $this->config('taberna.pass'));
            if(!$res) {
                $result['code'] = '1';//CODE_USER_NOT_FOUND
            } else {
                //CODE_USER_FOUND = 8
                $result['code'] = 8;
                $result['user'] = (!empty($res->user)) ? $res->user : null;
                $result['menu'] = $this->_parseMenu($res);
            }
        } else {
            $result['code'] = '-1';//Need to set in params user and password!
        }
        $this->header('Content-Type: text/javascript');
        die(json_encode($result));
    }
    
    protected function _testSaveTabernaLP()
    {
        $result = array();
        if($this->post('l') and $this->post('p')) {
            $user = rad_instances::get('model_session_taberna')->login($this->post('l'), $this->post('p'));
            if(!$user) {
                $result['code'] = '1';//CODE_USER_NOT_FOUND
            } elseif(is_int($user)) {
                switch($user) {
                    case 9://USER ID BLOCKD
                        $result['code'] = 9;
                        break;
                    default://UNKNOWN CODE
                        $result['code'] = 1000;
                        break;
                }
            } else {
                $result['code'] = '8';
                $result['user'] = $user->user;
                $result['menu'] = $this->_parseMenu($user);
                $result['i18'] = $this->_geti18();
                $itemUser = new struct_settings(array('fldName'=>'taberna.user', 'fldValue'=>$this->post('l'), 'rtype'=>'system'));
                $itemUser->save();
                $itemPass = new struct_settings(array('fldName'=>'taberna.pass', 'fldValue'=>$this->post('p'), 'rtype'=>'system'));
                $itemPass->save();
            }
        } else {
            $this->redirect('404');
        }
        $this->header('Content-Type: text/javascript');
        die(json_encode($result));
    }

    protected function _getPartnersLicense()
    {
        if(!$this->request('name')) {
            throw new rad_exception('"name" not defined', E_USER_WARNING);
        }
        $licenseText = rad_instances::get('model_session_taberna')->getPartnersLicense($this->request('name'));
        die($licenseText);
    }
    
    protected function _acceptLicense()
    {
        if((bool)$this->request('accepted') and (int)$this->request('partner_id') and !empty($this->getCurrentUser()->u_id)) {
            switch((int)$this->request('partner_id')) {
                case 1:
                    $pName = '3dbin';
                    break;
                default:
                    return false;
                    break;
            }
            if(rad_instances::get('model_session_taberna')->acceptLicense($pName)=='1') {
                $this->header('Content-Type: text/plain');
                die('1');
            }
        }
        die('0');
    }
    
    protected function _logoutTaberna()
    {
        if($this->config('taberna.user') and $this->config('taberna.pass')) {
            rad_config::clearParams(array('taberna.%', 'partners.3dbin.license'));
        }
        if(!empty($_SERVER['HTTP_REFERER'])) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect($this->makeURL('alias=admin'));
        }
    }
}