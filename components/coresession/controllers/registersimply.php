<?php
/**
 * Simple hand-registration of users
 * @author Denys Yackushev
 * @version 0.2
 * @pachage Taberna
 */
class controller_coresession_registersimply extends rad_controller
{
    /**
     * Where putr registered users
     * @var integer tre_id
     */
    protected $_treestart = 0;

    /**
     * City id
     * @var integer
     */
    protected $_countrystart = 0;

    protected $_maksstart = 81;

    /**
     *Format of email letter (text|html)
     * @var string
     */
    protected $_mail_format = 'html';

    private $_is_facebook = false;
    //private $_is_twitter = false;

    public function __construct()
    {
        if ($params = $this->getParamsObject()) {
            $this->_treestart = $params->_get('treestart', $this->_treestart, $this->getCurrentLangID());
            $this->_countrystart = $params->_get('countrystart', $this->_countrystart, $this->getCurrentLangID());
            $this->_maksstart = $params->_get('maksstart', $this->_maksstart, $this->getCurrentLangID());
            $this->_mail_format = $params->_get('mail_format', $this->_mail_format);
            $this->setExtraParams($params);
            $this->setVar('params', $params);
        }
        if ($this->getCurrentUser()) {
            $this->setVar('user', $this->getCurrentUser());
        }
        if ($this->isAlreadyRegistered()) {
            if($this->request('c')) {
                $this->activateUser();
            } else {
                $this->setAlreadyRegisteredMessage();
            }
        } elseif ($this->request('a')) {
            $a = strtolower($this->request('a'));
            $this->setVar('action', $a);
            switch($a) {
                case 'cap':
                    $this->showCapcha();
                    break;
                case 'r':
                    $this->tryRegister();
                    break;
                case 'success':
                    $this->setSuccessMessage();
                    break;
                case 'getjs':
                    $this->getJS();
                    break;
                case 'checkandsend':
                    $this->_assignDefaultData();
                    $this->remindPassByEmail();
                    break;
                case 'reactivate':
                    $this->sendNewActivationCode();
                    break;

                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }//switch
        } else {
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

    /**
     * @param rad_paramsobject $params
     */
    protected function setExtraParams($params)
    {
        $this->_is_facebook = (boolean) $params->_get('is_facebook', $this->_is_facebook);
        //$this->_is_twitter = (boolean) $params->_get('is_twitter', $this->_is_twitter);
    }

    protected function isAlreadyRegistered()
    {
        if ($this->getCurrentUser()) {
            return $this->getCurrentUser()->u_id;
        }
        return false;
    }

    protected function _assignDefaultData()
    {
        $this->setVar('item', new struct_core_users());
        $tree = rad_instances::get('model_coremenus_tree');
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
    protected function showCapcha()
    {
        $model = rad_instances::get('model_coresession_captcha');
        $model->show();
    }

    /**
     * Проверяет данные перед регистрацией.
     * Ассигнирует шаблону данные для отображения ошибок
     * @return Boolean Всё ок?
     */
    protected function _verifyInputData($item = null)
    {
        $messages = array();
        $req = $this->getAllRequest();
        foreach($req as $key=>$value) {
            if(is_string($value))
                $req[$key]=stripslashes($value);
        }
        if(!$item) {
            $item = new struct_core_users($req);
        } else {
            $item->MergeArrayToStruct($req);
        }

        $item->u_email  = strip_tags($item->u_email);
        $item->u_fio    = trim(strip_tags($item->u_fio));
        $item->u_login  = trim(strip_tags($item->u_login));

        $this->setVar('u_pass1', trim(filter_var($this->request('u_pass1'), FILTER_SANITIZE_STRING)));
        $this->setVar('u_pass2', trim(filter_var($this->request('u_pass2'), FILTER_SANITIZE_STRING)));

        if(!php_mail_check($item->u_email)) {
            $messages[] = $this->lang('entervalidemail.session.error');
        } elseif (rad_instances::get('model_core_users')->emailExists($item->u_email)) {
            $messages[] = $this->lang('mailexsists.session.message');
        }
        if (empty($item->u_fio)) {
            $messages[] = $this->lang('emptyfio.session.error');
        }
        if (empty($item->u_login)) {
            $messages[] = $this->lang('emptylogin.session.error');
        } elseif (rad_instances::get('model_core_users')->loginExists($item->u_login)) {
            $messages[] = $this->lang('loginexists.session.error');
        }
        if (empty($item->u_pass) and $this->request('u_pass1')) {
            $item->u_pass = trim($this->request('u_pass1'));
        }

        if($this->request('u_pass1')!=$this->request('u_pass2')) {
            $messages[] = $this->lang('passwordsnotmatch.session.message');
        } elseif (mb_strlen($this->request('u_pass1')) < 6) {
            $messages[] = $this->lang('passwordishort.session.message');
        }
        if (count($messages)) {
            $this->setVar('message', implode('<br />', $messages));
            $this->setVar('action');
            return false;
        } else {
            return $item;
        }
    }

    /**
     * При попытке зарегистрироваться, проверяются данные и шлётся мыло
     */
    protected function tryRegister()
    {
        $item = $this->_verifyInputData($this->getCurrentUser());
        if ($this->request('change')) {
            $this->setVar('change', true);
        }
        if ($item) {
            $this->setVar('item', $item);
            $modelCaptcha = new model_coresession_captcha(SITE_ALIAS);
            if( !$modelCaptcha->check( trim($this->request('captcha')) ) ) {
                $this->setVar('captcha_error',$this->lang('wrongcaptcha.session.error'));
                $this->setVar('action');
            } else {
                $model = rad_instances::get('model_core_users');
                $model->setState('u_email',$item->u_email)
                      ->setState('u_active', 1);
                $tmp = $model->getItems(1);
                if (!empty($tmp[0]->u_id)) {
                    if ($this->request('change') and $tmp[0]->u_active) {
                        $model->updateItem($item);
                        rad_session::setUser($item);
                        $this->setVar('item',$item);
                        $this->setVar('message',$this->lang('yourdatesuccupdated.session.message'));
                    } elseif($tmp[0]->u_active and $tmp[0]->u_email_confirmed) {
                        //RESEND EMAIL
                        $this->setVar('message',$this->lang($this->config('registration.mail_already_registred_text')));
                    } else {
                        $this->sendActivationCode($item);
                        $this->setVar('message',$this->lang($this->config('registration.mail_regsended_text')));
                        $this->setVar('onlymessage',true);
                    }
                } else {
                    //REGISTER!
                    $item->u_group = $this->_treestart;
                    $this->register($item);
                    $this->redirect($this->makeURL('a=success'));
                }
            }
        } else {
            $this->setVar('item', new struct_core_users($this->getAllRequest()));
        }
    }

    /**
     * @param struct_core_users $item
     */
    protected function register($item)
    {
        rad_instances::get('model_core_users')->register($item);
    }

    protected function setSuccessMessage()
    {
        $this->setVar('message', $this->lang($this->config('registration.mail_regsended_text')));
        $this->setVar('onlymessage', true);
    }

    protected function setAlreadyRegisteredMessage()
    {
        $this->setVar('message', $this->lang('already_registered.session.error', null, true));
        $this->setVar('onlymessage', true);
    }

    private function sendActivationCode($item)
    {
        $table = new model_core_table('subscribers_activationurl','coremail');
        $table->setState('where','sac_scrid='.$item->u_id.' and sac_type=2');
        $item_url = $table->getItem();
        if ($item_url->sac_id) {
            $this->_sendMail($item,'register_resend',array('url'=>$item_url->sac_url));
        } else {
            $item_url = new struct_coremail_subscribers_activationurl();
            $item_url->sac_url = md5(rad_session::genereCode(31).now().$item->u_id);
            $item_url->sac_scrid = $item->u_id;
            $item_url->sac_type = 2;
            $item_url->email = $item->u_email;
            $item_url->date_created = time();
            $table->insertItem($item_url);
            $this->_sendMail($item, 'register_resend', array('url'=>$item_url->sac_url));
        }
    }

    protected function _sendMail(struct_core_users $user, $type, $params = array())
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

    protected function activateUser()
    {
        $c = urldecode( $this->request('c') );
        $this->setVar('onlymessage', true);
        if ($c) {
            $this->setVar('action','c');
            $model = rad_instances::get('model_core_users');
            $model->setState('code',$c);
            $user = $model->getItem();
            if (isset($user->u_id) and $user->u_id) {
                if ($user->u_email_confirmed) {
                    $table = new model_core_table('subscribers_activationurl','coremail');
                    $table->setState('sac_url', $c);
                    $activation = $table->getItem();
                    if ($activation) {
                        if ($model->emailExists($activation->email, $user->u_id)) {
                            $this->setVar('message', $this->lang('mail_alreadyregistred.registration.text', null, true));
                        } else {
                            $user->u_email = $activation->email;
                            $model->updateItem($user);
                            rad_session::updateUserData($user->u_id);
                            rad_instances::get('model_coremail_subscribes')->confirm($c);
                            $this->setVar('message', $this->lang('subscribers.mailactivated.text', null, true));
                        }
                    } else {
                        $this->setVar('message', $this->lang( $this->config('registration.code_not_found') ));
                    }
                } elseif (!($error = $this->beforeActivateUser($user))) {
                    $user->u_email_confirmed = 1;
                    $model->updateItem($user);
                    rad_instances::get('model_coremail_subscribes')->confirm($c);
                    /* make referals component */
                    if($this->config('referals.on') and class_exists('struct_coresession_referals_users')) {
                        $this->setReferral($user);
                    }
                    $this->setVar('message', $this->lang( $this->config('registration.mailactivated_text') ));
                    //send message to user
                    $this->_sendMail($user, 'register_ok');
                    $this->_sendMail($user, 'send_admin');
                } else {
                    $this->setVar('message', (is_array($error) ? implode('<br />', $error) : $error));
                }
            } else {
                //code not found
                $this->setVar('message',$this->lang($this->config('registration.code_not_found')));
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Returns the error text if needed to prevent user activation
     * @param struct_core_users $user
     * @return string
     */
    protected function beforeActivateUser($user)
    {
        return '';
    }

    protected function setReferral($user)
    {
        if($referral = rad_instances::get('model_coresession_referals')
            ->setState('cookie', $this->cookie($this->config('referals.cookieName')))
            ->getItem()) {
            $refUser = new struct_coresession_referals_users(
                array(
                    'rru_partner_id'=>$referral->rrf_user_id,
                    'rru_user_id'=>$user->u_id,
                    'rru_referal_id'=>$referral->rrf_id
                )
            );
            rad_instances::get('model_coresession_referals')->insertUser($refUser);
        }
    }

    protected function getJS()
    {
        $this->setVar('hash', $this->hash());
    }

    protected function remindPassByEmail()
    {
        $messages = array();
        if($this->hash() == $this->request('hash')) {
            if($this->request('u_email') and php_mail_check($this->request('u_email'))) {
                $email = $this->request('u_email');
                $model = rad_instances::get('model_core_users');
                $model->setState('u_email', $email);
                $user = $model->getItem();
                if($user and $user->u_active and $user->u_email_confirmed) {
                    if (!($error = $this->beforeRemindPassword($user))) {
                        $this->remindPassword($user);
                    } else {
                        $messages[] = $error;
                    }
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

    /**
     * @param struct_core_users $user
     * @return string
     */
    protected function beforeRemindPassword($user)
    {
        if (empty($user->u_pass) || ($user->u_facebook_id != 0)) {
            return $this->lang('fbregistreduser.session.error');
        }
        return '';
    }

    /**
     * @param struct_core_users $user
     */
    protected function remindPassword($user)
    {
        $model = rad_instances::get('model_coremail_subscribes');
        $item_url = $model->removeExpired()->setState('sac_scrid', $user->u_id)->setState('sac_type', 3)->getActivationUrl();
        if(empty($item_url->sac_id)) {
            $item_url = new struct_coremail_subscribers_activationurl();
            $item_url->sac_url = md5(rad_session::genereCode(31).now().$user->u_id);
            $item_url->sac_scrid =  $user->u_id;
            $item_url->sac_type = 3;
            $item_url->email = $user->u_email;
            $item_url->date_created = time();
            $item_url->save();
        }
        $this->_sendMail($user, 'remind', array('url'=>$item_url->sac_url));
    }

    protected function sendNewPassword()
    {
        $messages = array();
        $actcode = $this->request('actcode');
        $model = rad_instances::get('model_coremail_subscribes');
        $item = $model->removeExpired()->setState('sac_url', $actcode)->setState('sac_type', 3)->getActivationUrl();
        if(!empty($item->sac_id)) {
            $user = rad_instances::get('model_core_users')->setState('u_id', (int) $item->sac_scrid)->getItem();
            if(!empty($user->u_id)) {
                $password = rad_session::genereCode(6);
                $user->u_pass = rad_session::encodePassword($password);
                if (!($error = $this->beforeSaveNewPassword($user, $password))) {
                    $user->save();
                    $item->remove();
                    $this->_sendMail($user, 'newpass', array('clearpass'=>$password));
                    $this->setVar('pass_sent', true);
                } else {
                    $messages[] = $error;
                }
            } else {
                $messages[] = $this->lang('usernotfound.session.error');
            }
        } else {
            $messages[] = $this->lang('wrongcode.session.error');
        }
        if(count($messages)) {
            $this->setVar('message', implode('<br />', $messages));
        }
    }

    protected function sendNewActivationCode()
    {
        if ($this->hash() == $this->request('hash') && !empty($_SESSION['try_login_user_id'])) {
            $user = rad_instances::get('model_core_users')->getItem($_SESSION['try_login_user_id']);
            if (!empty($user->u_id)) {
                $this->sendActivationCode($user);
                unset($_SESSION['try_login_user_id']);
                $this->setVar('message', $this->lang('activation_code_sent.registration.message', null, true));
                $this->setVar('onlymessage', true);
                return;
            }
        }
        $this->redirect($this->makeURL('alias=login.html'));
    }

    /**
     * Returns the error text if needed to prevent saving the new password
     * @param struct_core_users $user
     * @param string $password
     * @return string
     */
    protected function beforeSaveNewPassword($user, $password)
    {
        return '';
    }
}