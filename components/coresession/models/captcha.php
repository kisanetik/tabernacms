<?php
/**
 * Internal class for generating the captcha, show and check it!
 * @package RADCMS
 * @author Denys Yackushev
 */
class model_coresession_captcha extends rad_model
{
    /**
     * Captcha instance
     * @var KCAPTCHA
     */
    private $_instanceCaptcha = null;
    
    private $_sessionName = 'model_coresession_captcha_keystring';
    
    private $_kcaptchaFilename = 'kcaptcha/kcaptcha.php';
    
    private $_keystring = NULL;
    
    /**
     * Constructor
     * @param string $page - on What page the image is shows (location or alias or request)
     */
    public function __construct($page=NULL)
    {
        $this->_kcaptchaFilename = dirname(__FILE__).DS.'kcaptcha'.DS.'kcaptcha.php';
        $this->_sessionName = ($page)?$this->_sessionName.md5($page):$this->_sessionName;
        $this->_keystring = rad_session::getVar($this->_sessionName, $this->_keystring);
    }
    
    /**
     * Shows the image
     */
    public function show()
    {
        if(is_file($this->_kcaptchaFilename)) {
            include_once $this->_kcaptchaFilename;
            $this->_instanceCaptcha = new KCAPTCHA();
            rad_session::setVar($this->_sessionName, $this->_instanceCaptcha->getKeyString());
        } else {
            throw new rad_exception('KCaptcha library not found!');
        }
    }
    
    /**
     * Returns the generated keystring, when picture is show
     * @return string|NULL
     */
    public function getKeyString()
    {
        return $this->_keystring;
    }
        
    /**
     * Check, is input string is not wrong, when captcha is shows
     * @param string $string 
     * @return Boolean
     */
    public function check($string)
    {
        if($this->getKeyString()==$string && mb_strlen($string)) {
            return true;
        }
        return false;
    }
}