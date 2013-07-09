<?php
/**
 * controller_coreothers_feedback class for Feedback on the site
 * @author Denya Yackushev
 * @version 0.1
 * @pachage Taberna
 */
class controller_coreothers_feedback extends rad_controller
{
    /**
     * <ru>Не требовать никаких таблиц и настроек, просто отправлять администратору</ru>
     * <en>Du not require any params and tables, just send mail to admin</en>
     * @var boolean
     */
    private $_notsave = true;

    /**
     * Format of email letter (text|html)
     * @var string
     */
    private $_mail_format = 'html';
    
    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_notsave = (boolean)$params->_get('notsave', $this->_notsave);
            $this->_mail_format = $params->_get('mail_format', $this->_mail_format);
            $this->setVar('params', $params);
        }
        $this->setVar('hash', $this->hash());
        if($this->request('qo')=='true')
        $this->setVar('qo', true);
        if($this->request('action')) {
            $this->setVar('action', $this->request('action') );
            switch($this->request('action')) {
                case 'getjs':
                    $this->getJS();
                    break;
                case 'send':
                case 'callback':
                    if($this->request('hash')==$this->hash()) {
                        if($this->validator()) {
                            if($this->_notsave) {
                                $this->justSend();
                            } else {
                                $this->send();
                            }
                        } else {
                            $this->backPage();
                        }
                    } else {
                        $this->redirect('/');
                    }
                    break;
                default:
                    $this->startPage();
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    break;
            }
        } else {
            $this->startPage();
        }
    }

    /*
     * Возврат страницы.
    */
    function backPage()
    {
        if($this->request('method') == 'all') {
            $urlRef = (isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
        } else {
            $urlRef = (isset($_SERVER['REDIRECT_URL']))?$_SERVER['REDIRECT_URL']:'';
        }
        $params = ($this->request('t_turname'))?$this->request('t_turname'):$this->editUrlReferer($urlRef);
        $server = (!empty($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:'';
        $referer = ($this->request('referer'))?$this->request('referer'):$server;
        $this->setVar('referer', $referer);
    }

    /*
     * Старт станицы
    */
    function startPage()
    {
        $this->setVar('user', $this->getCurrentUser() );
        if(!empty($_SERVER['HTTP_REFERER'])) {
            $this->setVar('referer', $_SERVER['HTTP_REFERER']);
        }
    }

    function getJS()
    {

    }

    /**
     * Проверка полей
     */
    function validator()
    {
        $rs = false;
        if($this->request('sender_email') and $this->request('sender_fio') and $this->request('message_body')) {
            $modelCaptcha = new model_coresession_captcha(SITE_ALIAS);
            if(!php_mail_check($this->request('sender_email'))) {
                $this->setVar('error_message', $this->lang('entervalidemail.feedback.error', null, true));
                $rs = false;
            } elseif ( mb_strlen($this->request('message_body')) < 3 ) {
                $this->setVar('error_message', $this->lang('entercorrectfio.feedback.error', null, true));
                $rs = false;
            } elseif(!$modelCaptcha->check($this->request('captcha_text'))) {
                $this->setVar('error_message', $this->lang('wrongcaptcha.session.error', null, true));
                $rs = false;
            } else {
                $rs = true;
            }
        } elseif ($this->request('phone') and $this->request('sender_fio') and $this->request('captcha_text')) {
            $modelCaptcha = new model_coresession_captcha('index.html');
            $jsonResult = array();
            if (mb_strlen($this->request('sender_fio')) < 3) {
                $jsonResult['error_message'] = $this->lang('entercorrectfio.feedback.error', null, true);
                $this->setVar('error_message', json_encode($jsonResult) );
                $rs = false;
            } elseif (!preg_match('/^[+]7[(]\\d{3}[)]\\d{3}-\\d{2}-\\d{2}$/',$this->request('phone'))) {
                $jsonResult['error_message'] = $this->lang('entercorrectphone.callback.error');
                $this->setVar('error_message', json_encode($jsonResult) );
                $rs = false;
            } elseif (!$modelCaptcha->check($this->request('captcha_text'))) {
                $jsonResult['error_message'] = $this->lang('wrongcaptcha.session.error', null, true);
                $this->setVar('error_message', json_encode($jsonResult) );
                $rs = false;
            } else {
                $rs = true;
                $res = array();
                $res['error_message'] = 'error_none';
                $this->setVar('error_message',json_encode($res));
            }
        } else {
            $jsonResult['error_message'] = "error_occurred";
            $this->setVar('error_message', json_encode($jsonResult) );
            $rs = false;
        }
        return $rs;
    }

    /*
     * edit Url Referer
    */
    function editUrlReferer($url) 
    {
        $url = urldecode($url);
        if ($url) {
            return $this->makeURL('alias=page&title='.$url);
        }
        return SITE_URL;
    }
    
    /**
     * Sending mail and save it to backemails
     */
    function send()
    {
        
        //rad_mailtemplate::send($email_to, $template_name, array('user'=>$user, 'link'=>$link, 'clearpass'=>$clearpass), $this->_mail_format);
    }

    /**
     * Просто отправляет мыло админу с инпут-полями
     */
    function justSend()
    {
        if ($this->request('action') === 'send') {
            rad_mailtemplate::send(
                $this->config('admin.mail'), 
                $this->config('feedback.template'), 
                array(
                    'email'=>$this->request('sender_email'), 
                    'fio'=>$this->request('sender_fio'), 
                    'message_body'=>$this->request('message_body')
                ),
                $this->_mail_format
            );
        } elseif ($this->request('action') == 'callback') {
            rad_mailtemplate::send(
                $this->config('admin.mail'),
                $this->config('callback.template'),
                array(
                    'phone' => $this->request('phone'),
                    'fio' => $this->request('sender_fio'),
                ),
                $this->_mail_format
            );
        }
    }
}