<?php
    /**
 * Class for managing subscribes in admin
 * @author Tereshchenko Viacheslav
 * @package Taberna
 *
 */
class controller_coremail_managesubscribes extends rad_controller
{
    /**
     * users groups node ID
     */
    private $_usergroups_id = 15;

    /**
     * mails count will be sent per one iteration
     */
    private $_mailperiteration = 50;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_usergroups_id = $params->_get('usergroups_id',$this->_usergroups_id, $this->getContentLangID());
            $this->_mailperiteration = $params->_get('mailperiteration',$this->_mailperiteration);
            $this->setVar('params',$params);
        }
        if($this->request('action')){
            $this->setVar('action',$this->request('action'));
            switch($this->request('action')){
                case 'getjs':
                    $this->getjs();
                    break;
                case 'send':
                    $this->send();
                    break;
                case 'getgroups':
                    $this->getGroups();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    die('action not exists!');
                    break;
            }
        } else {
            $this->assignUserGroups();
        }
        $this->setVar('hash', $this->hash());
    }

    /**
     * Gets the JavaScript for this el
     * @return JS
     */
    function getJS()
    {
        $this->setVar('GROUPS_ID',$this->_usergroups_id);
    }

    function assignUserGroups()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->request('pid',$this->_usergroups_id));
        if(!(int)$this->request('nolang')) {
            $model->setState('lang',$this->getContentLangID());
        }
        $model->setState('order', 'tre_position,tre_name');
        $items = $model->getItems(true);
        $this->setVar('users_groups',$items);
    }

    /**
   * Gets the new user groups depending on lang_id
   * @return JS array (JSON)
   */
    function getGroups()
    {
        $lngid = (int)$this->request('i');
        if($lngid) {
            $params = $this->getParamsObject();
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('pid',$this->request('pid', $params->_get('usergroups_id', $this->_usergroups_id, $lngid) ));
            $items = $model->getItems(true);
            echo json_encode($items);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    private function _verifyInputData($req=NULL)
    {
        $messages = array();
        if(isset($req['mailfromemail']) and strlen($req['mailfromemail']) > 0) {
            if(!filter_var($req['mailfromemail'], FILTER_VALIDATE_EMAIL)) {
                $messages[] = $this->lang('emailincorrect.mail.error');
            }
        } else {
            $messages[] = $this->lang('emptyemail.mail.error');
        }
        if(!isset($req['mailfromname']) or strlen($req['mailfromname']) < 1) {
            $messages[] = $this->lang('emptyname.mail.error');
        }
        if(!isset($req['mailsubject']) or strlen($req['mailsubject']) < 1) {
            $messages[] = $this->lang('emptysubject.mail.error');
        }
        if(!isset($req['FCKeditorMailBody']) or strlen($req['FCKeditorMailBody']) < 1) {
            $messages[] = $this->lang('emptybody.mail.error');
        }
        if(!isset($req['mailgroups']) or count($req['mailgroups']) < 1) {
            $messages[] = $this->lang('groupsnotselected.mail.error');
        }
        if(!isset($req['mailformat'])) {
            $messages[] = $this->lang('wrongformat.mail.error');
        }
        if(isset($req['mailsmtp']) and $req['mailsmtp'] === 'on') {
            if( !isset($req['smtphost']) or strlen($req['smtphost']) < 1 or
                !isset($req['smtpport']) or strlen($req['smtpport']) < 1 or
                !isset($req['smtpuser']) or strlen($req['smtpuser']) < 1 or
                !isset($req['smtppass']) or strlen($req['smtppass']) < 1 or
                !isset($req['smtpsecurity']) or
                !($req['smtpsecurity'] === 'none' or
                $req['smtpsecurity'] === 'ssl' or
                $req['smtpsecurity'] === 'tls') )
            {
                $messages[] = $this->lang('wrongsmtp.mail.error');
            }
        }
        if(count($messages)) {
            $this->setVar('message',implode('<br />',$messages));
            return false;
        } else {
            return true;
        }
    }

    function send()
    {
        if($this->hash() == $this->request('hash')) {
            $req = $this->getAllRequest();
            if($this->_verifyInputData($req)) {
                $template = $req['FCKeditorMailBody'];
                $vars = array('%%SITE_URL%%'=>'SITE_URL');
                $params = array(
                    'fromName' => $req['mailfromname'],
                    'fromEmail' => $req['mailfromemail'],
                    'Subject' => $req['mailsubject'],
                    'smtp' => '',
                    'format' => 'text/plain',
                    'header' => 'X-Priority: 1 (Higuest)'
                );
                if($req['mailformat'] === '0') {
                    $params['format'] = 'text/html';
                }
                if(isset($req['mailsmtp']) and $req['mailsmtp'] === 'on') {
                    $params['smtp'] = array(
                        'host' => $req['smtphost'],
                        'port' => (int)$req['smtpport'],
                        'user' => $req['smtpuser'],
                        'password'  => $req['smtppass'],
                        'security' => ''
                    );
                    if($req['smtpsecurity'] !== 'none') {
                        $params['smtp']['security'] = $req['smtpsecurity'];
                    }
                }
                $model = rad_instances::get('model_core_users');
                $model->setState('select','count(*)');
                $model->setState('u_group',array_values($req['mailgroups']));
                $model->setState('u_subscribe_active',1);
                $model->setState('u_subscribe_langid',(int)$this->getCurrentLangID());
                $countUsers = $model->getItem(false);
                $model->unsetState('select');
                for($cnt = 0; $cnt < $countUsers; $cnt += $this->_mailperiteration) {
                    $limit = $cnt . ',' . ($cnt+$this->_mailperiteration);
                    $usersArr = NULL;
                    $usersItems = $model->getItems($limit);
                    if(count($usersItems)) {
                        foreach($usersItems as $user) {
                            if(empty($user->u_fio)) {
                                $usersArr[] = $user->u_email;
                            } elseif(!empty($user->u_fio) and !empty($user->u_email)) {
                                $usersArr[] = array($user->u_fio => $user->u_email);
                            } else {
                                continue;
                            }
                        }
                    }
                    if(count($usersArr)) {
                        rad_mailtemplate::sendMasTemplate($usersArr, $template, $vars, $params);
                    } else {
                        $this->setVar('message', $this->lang('emailsnotfound.mail.error'));
                    }
                }
                $this->setVar('message', '<span style="color:green">'.$this->lang('deliverycomplete.mail.text').'</span>');
            }
            $this->assignUserGroups();
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

}