<?php
/**
 * Mail template class for send templates
 *
 * @author Denys Yackushev
 * @package RADCMS
 * @datecreated 12 December 2011
 * @see http://rad-cms.ru/articles/a/40
 */

class rad_mailtemplate
{

    /**
     * mail template item
     * @var rad_mailtemplate_item
     */
    protected static $_item = null;

    /**
     * Sending the mail by template with params
     *
     * @param string $to - reciver of the mail
     * @param string $templateName - template file name
     * @param mixed $params
     * @param enum(html|text) $format - format of letter (html or text)
     * @return boolean
     */
    public static function send($to, $templateName, $params = null, $format='text')
    {
        $item = new rad_mailtemplate_item($templateName);
        $item->setVars($params);
        $item->setMailer(self::getMailerMessage());
        return $item->send($to, $format);
    }

    /**
     * Send letter via selfTemplate
     * @param mixed $to
     * @param string $template
     * @param mixed $vars
     * @param mixed $params
     * @example
     * rad_mailtemplate::sendMasTemplate(
     *     array('John Smith'=>'j.smith@example.com', 'Anna'=>'anna@example.com', 'user@example.com'),
     *     'Template body with %%varname%% to %%__USER_NAME__%% to %%__USER_EMAIL__',
     *     array('%%varname%%'=>'autoreplaced keys'),
     *     array(
     *         'fromName'=>'ROBOT',
     *         'fromEmail'=>'robot@example.com',
     *         'Subject'=>'mail subject',
     *         'smtp'=>array(
     *             'host':'smtp.example.com',
     *             'port':25,
     *             'user':'login_for_access_to_smtp',
     *             'password':'password_for_access_to_smtp',
     *             'security':'encode method none/ssh/tls'
     *         ),
     *         'format'=>'text/plain',//default is text/html
     *         'header'=>'X-Priority: 1 (Higuest)'//not required
     *     )
     * )
     * @return mixed result array('e-mail'=>boolean)
     */
    public static function sendMasTemplate($to, $template, $vars, $params)
    {
        if(empty($to) or !is_array($to)) {
            throw new rad_exception('ERROR[mailtemplate]: $to param can be only array and can\'t be empty!');
        }
        if(empty($params['fromName']) or empty($params['fromEmail'])) {
            throw new rad_exception('ERROR[mailtemplate]: params "fromName" and "fromEmail" can\'t be empty!');
        }
        if(empty($params['Subject'])) {
            throw new rad_exception('ERROR[mailtemplate]: param "Subject" can\'t be empty!');
        }
        $result = array();
        foreach($to as $userName=>$userEmail) {
            $mailer = self::getMailerMessage($params['Subject']);
            if(!empty($params['header'])) {
                $headers = rad_mailtemplate::parseHeader($params['header']);
                if(!empty($headers)) {
                    foreach($headers as $headerName=>$headerValue) {
                        switch(strtolower($headerName)) {
                            case 'x-priority':
                                $mailer->setPriority((int)$headerValue);
                                break;
                            default:
                                $mailer->getHeaders()->addTextHeader($headerName, $headerValue);
                                break;
                        }
                    }
                }
            }
            $mailer->setBody(str_replace(array_keys($vars), $vars, $template), (!empty($params['format'])?$params['format']:'text/html'));
            $mailer->setFrom(array($params['fromEmail']=>$params['fromName']));
            $mailer->setReturnPath($params['fromEmail']);
            if(!empty($params['smtp'])) {
                if( empty($params['smtp']['host'])
                    or empty($params['smtp']['port'])
                    or empty($params['smtp']['user'])
                    or !isset($params['smtp']['password'])
                ) {
                    throw new rad_exception('Error in mailtemplate! Transport block: Not enouph actual params!');
                }
                $transport = Swift_SmtpTransport::newInstance($params['smtp']['host'], $params['smtp']['port'])
                                ->setUsername($params['smtp']['user'])
                                ->setPassword($params['smtp']['password']);
                if(!empty($params['smtp']['security'])) {
                    $transport->setEncryption($params['smtp']['security']);
                }
            } else {
                $transport = Swift_MailTransport::newInstance();
            }
            $mailer->setCharset('utf-8');
            if (is_int($userName)) {
                $mailer->setTo($userEmail);
            } else {
                $mailer->setTo('"'.$userName.'" <'.$userEmail.'>');
            }
            $result[$userEmail] = rad_mailtemplate::getMailer($transport)->send($mailer);
        }
        return $result;
    }

    /**
     * Parse string header and make the array
     * @param string $header
     * @return mixed array of key=>value
     */
    public static function parseHeader($header)
    {
        $result = array();
        $headers = explode("\n", str_replace("\r", '', $header));
        if(!empty($headers)) {
            foreach($headers as $idHeader=>$headerString) {
                $headerString = trim($headerString);
                if(!empty($headerString)) {
                    $headerTmp = explode(':', $headerString);
                    if(count($headerTmp>1)) {
                        $headerName = trim($headerTmp[0]);
                        unset($headerTmp[0]);
                        $headerValue = implode(':', $headerTmp);
                        $headerValue = trim($headerValue);
                        $result[$headerName] = $headerValue;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * Gets the internal mailer (Swift)
     * @return Swift_Message
     */
    public static function getMailerMessage($subject='')
    {
        if(!class_exists('Swift_Message')) {
            include_once LIBPATH.'swift'.DS.'lib'.DS.'swift_required.php';
        }
        if(!empty($subject)){
            return Swift_Message::newInstance($subject);
        } else {
            return Swift_Message::newInstance();
        }
    }

    /**
     * Gets the mailer class
     * @param Swift_Transport|null $transport - optional
     * @return Swift_Mailer
     */
    public static function getMailer($transport=null)
    {
        if(!class_exists('Swift_Mailer')) {
            include_once LIBPATH.'swift'.DS.'lib'.DS.'swift_required.php';
        }
        return Swift_Mailer::newInstance($transport);
    }

    /**
     * Create mail template item to work with it
     * @param string $template - not obligatory param
     * @return rad_mailtemplate_item
     */
    public static function createMail($templateName=null)
    {
        return new rad_mailtemplate_item($templateName);
    }

    /**
     * For item class to set itself
     * @param rad_mailtemplate_item $item
     */
    public static function setCurrentItem(rad_mailtemplate_item $item)
    {
        self::$_item = $item;
    }

    public static function setBlockContent($name, $type, $html, $lang=null)
    {
        self::$_item->setBlock($name, $type, $html, $lang);
    }
}