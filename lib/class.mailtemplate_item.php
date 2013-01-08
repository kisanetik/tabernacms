<?php
/**
 * Class for sending mails using template engine
 * @package RADCMS
 * @author Denys Yackushev
 * @datecreated 12 December 2011
 * @see http://rad-cms.ru/articles/a/41
 */
class rad_mailtemplate_item extends rad_vars
{

    private $_templateName = null;

    private $_blocks = array();

    /**
     * Mailer class for sending the messages
     * @var Swift_Message
     */
    private $_mailer = null;

    /**
     * Transport instance for Swift Mailer
     * @var Swift_Transport
     */
    private $_transportInstance = null;

    /**
     * Constructor
     * @param type $templateName  - not obligatory, template name
     */
    public function __construct($templateName=null)
    {
        if($templateName) {
            $this->_templateName = $templateName;
        }
    }

    /**
     * Sets the mail template name
     * @param string $template - template file name (only by name)
     * @return rad_mailtemplate_item
     */
    public function setTemplateName($templateName)
    {
        $this->_templateName = $templateName;
        return $this;
    }

    /**
     * Gets current mail template name
     * @return string
     */
    public function getTemplateName()
    {
        return $this->_templateName;
    }

    /**
     * Send the mail
     * @param string|array $to - mail reciver, can be also as array('john@doe.com' => 'John Doe')
     * @param enum(html|text) $format - format of letter (html or text)
     * @return boolean
     */
    public function send($to, $format='text')
    {
        //include_once LIBPATH
        rad_mailtemplate::setCurrentItem($this);
        $o = rad_rsmarty::getSmartyObject();
        if($this->getVars()) {
            foreach($this->getVars() as $key=>$value) {
                $o->assign($key, $value);
            }
        }
        if(!is_file(MAILTEMPLATESPATH.$this->getTemplateName())) {
            throw new rad_exception('File "'.MAILTEMPLATESPATH.$this->getTemplateName().'" not found!');
        }
        $o->fetch(MAILTEMPLATESPATH.$this->getTemplateName());
        $o->clearAllAssign();
        if(empty($this->_blocks[$format])) {
            throw new rad_exception('Format "'.$format.'" is not declared in file: "'.MAILTEMPLATESPATH.$this->getTemplateName().'"');
        }
        if(!empty($this->_mailer)) {
            $this->_mailer->setSubject($this->_blocks[$format]['subject']);
            if(!empty($this->_blocks[$format]['Cc'])) {
                $this->_mailer->setCc($this->_blocks[$format]['Cc']);
            }
            if(!empty($this->_blocks[$format]['Bcc'])) {
                $this->_mailer->setBcc($this->_blocks[$format]['Bcc']);
            }
            if(!empty($this->_blocks[$format]['headers'])) {
                $headers = rad_mailtemplate::parseHeader($this->_blocks[$format]['headers']);
                if(!empty($headers)) {
                    foreach($headers as $headerName=>$headerValue) {
                        switch(strtolower($headerName)) {
                            case 'x-priority':
                                $this->_mailer->setPriority((int)$headerValue);
                                break;
                            default:
                                $this->_mailer->getHeaders()->addTextHeader($headerName, $headerValue);
                                break;
                        }
                    }
                }
            }
            if(!empty($this->_blocks[$format]['body'])) {
                $this->_mailer->setBody($this->_blocks[$format]['body'], ($format=='text'?'text/plain':'text/html'));
            }
            if(!empty($this->_blocks[$format]['from'])) {
                $from = explode("\n", str_replace("\r", '', $this->_blocks[$format]['from']));
                if(count($from)) {
                    foreach($from as $fromString) {
                        $fromItem = explode('<', $fromString);
                        if(count($fromItem)>1) {
                            $fromName = trim($fromItem[0]);
                            $fromEmail = trim(str_replace('>', '', $fromItem[1]));
                        } else {
                            $fromName = trim($fromItem[0]);
                            $fromEmail = trim($fromItem[0]);
                        }
                        $this->_mailer->setFrom(array($fromEmail=>$fromName));
                        $this->_mailer->setReturnPath($fromEmail);
                    }
                }

            }
            if(!empty($this->_blocks[$format]['transport'])) {
                $transport = explode("\n", str_replace("\r",'',$this->_blocks[$format]['transport']));
                if(!empty($transport)) {
                    $transportParams = array();
                    foreach($transport as $transportKey=>$transportString) {
                        $transportString = trim($transportString);
                        if(!empty($transportString)) {
                            $transportItem = explode(':', $transportString);
                            if(count($transportItem)>1) {
                                $transportItemKey = trim($transportItem[0]);
                                unset($transportItem[0]);
                                $transportItemValue = trim(implode(':', $transportItem));
                                $transportParams[$transportItemKey] = $transportItemValue;
                            }
                        }
                    }
                }
                if(empty($transportParams['type'])) {
                    throw new rad_exception('Error in mailtemplate "'.$this->getTemplateName().'" at transport block: type of the transport required!');
                }
                switch(strtolower($transportParams['type'])) {
                    case 'smtp':
                        if( empty($transportParams['host'])
                        or empty($transportParams['port'])
                        or empty($transportParams['user'])
                        or !isset($transportParams['password'])
                        ) {
                            throw new rad_exception('Error in mailtemplate "'.$this->getTemplateName().'" at transport block: Not enouph actual params!');
                        }
                        $this->_transportInstance = Swift_SmtpTransport::newInstance($transportParams['host'], $transportParams['port'])
                        ->setUsername($transportParams['user'])
                        ->setPassword($transportParams['password']);
                        if(!empty($transportParams['security'])) {
                            $this->_transportInstance->setEncryption($transportParams['security']);
                        }
                        break;
                    case 'mail':
                        $this->_transportInstance = Swift_MailTransport::newInstance();
                        break;
                    default:
                        throw new rad_exception('Error in mailtemplate "'.$this->getTemplateName().'" Unknown transport type "'.$transportParams['type'].'"!');
                    break;
                }//switch
            }
            $this->_mailer->setTo($to);
            $this->_mailer->setCharset('utf-8');
            if(!$this->_transportInstance) {
                $this->_transportInstance = Swift_MailTransport::newInstance();
            }
            return rad_mailtemplate::getMailer($this->_transportInstance)->send($this->_mailer);
        } else {
            $headers = 'MIME-Version: 1.0' . PHP_EOL;
            $headers .= 'Content-Transfer-Encoding: base64'.PHP_EOL;
            $headers .= 'From: '.$this->_blocks[$format]['from'].PHP_EOL;
            switch($format) {
                case 'text':
                    $headers = 'Content-Type: text/plain; charset=utf-8'.PHP_EOL;
                    break;
                case 'html':
                    $headers .= 'Content-type: text/html; charset=utf-8'.PHP_EOL;
                    break;
                default:
                    throw new rad_exception('Unknown format: "'.$format.'"');
                    break;
            }
            if(!empty($this->_blocks[$format]['Cc'])) {
                $headers .= 'Cc: '.$this->_blocks[$format]['Cc'].PHP_EOL;
            }
            if(!empty($this->_blocks[$format]['Bcc'])) {
                $headers .= 'Bcc: '.$this->_blocks[$format]['Bcc'].PHP_EOL;
            }
            if(!empty($this->_blocks[$format]['headers'])) {
                $headers .= $this->_blocks[$format]['headers'];
            }
            if(is_array($to)) {
                $toString = '';
                foreach($to as $toEmail=>$toName) {
                    $toString .= $toName.' <'.$toEmail.'>,';
                }
                $to = substr($toString, 0, strlen($toString)-1);
            }
            return mail($to, $this->_blocks[$format]['subject'], chunk_split(base64_encode($this->_blocks[$format]['body'])), $headers );
        }
    }

    /**
     * Sets the block from template content
     * @param string $name
     * @param string $type
     * @param string $html
     * @param unknown $lang - for the future
     * @return rad_mailtemplate_item
     */
    public function setBlock($name, $type, $html, $lang=null)
    {
        $this->_blocks[$type][$name] = $html;
        return $this;
    }

    /**
    * Sets the mailer for sending the messages
    * @param Swift_Message $mailer
    * @return rad_vars
    */
    public function setMailer($mailer)
    {
        $this->_mailer = $mailer;
        return $this;
    }
}