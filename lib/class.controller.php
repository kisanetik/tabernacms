<?php
/**
 * @author Yackushev Denys
 * @package RADCMS
 * @datecreated 21 october 2008
 * @abstract rad_controller
 *
 */
abstract class rad_controller extends rad_vars
{
    /**
     * Just for cache
     * @var string(32)
     */
    private $hash = false;

    /**
     * Constructor pre-logic
     *
     */
    function __construct()
    {
        if($this->hasMessage()){
            $this->setVar('message',$this->getMessage());
        }
    }

    /**
     * Returns the session hash, for secure XSS attacks
     */
    function hash()
    {
        if(!$this->hash) {
            $this->hash = md5(session_id());
        }
        return $this->hash;
    }

    /**
     * for cookie that needs to send at the end of script if the script all run vell
     */
    protected $cacheCookie=array();

    /**
     * alias for rad_input::get()
     * @param $key string
     * @return string
     * @access public
     */
    public function get($key=null, $defValue=NULL)
    {
        return rad_input::get($key, $defValue);
    }

    /**
     * alias for rad_input::post();
     * @param $key string
     * @return mixed
     * @access public
     */
    public function post($key=null, $defValue=NULL)
    {
        return rad_input::post($key, $defValue);
    }

    /**
     * alias for rad_input::request();
     * @param $key string
     * @return string
     * @access public
     */
    public function request($key=null, $defValue=NULL)
    {
        return rad_input::request($key, $defValue);
    }

    /**
     * Alias for rad_input::allRequest();
     * gets the all key=>value of request
     *
     * @return mixed array
     * @access public
     */
    public function getAllRequest()
    {
        return rad_input::allRequest();
    }

    /**
     * alias for rad_input::cookie();
     * @param $key string
     * @return  string
     * @access public
     */
    public function cookie($key, $defValue=NULL)
    {
        return rad_input::cookie($key, $defValue);
    }

    /**
     * Sets to cache Cookie some param
     * @param $key string
     * @param $value string
     * @access public
     */
    public function cacheCookie($key=null, $value=null)
    {
        if($key){
           $this->cacheCookie[$key] = $value;
           return true;
        }
        return false;
    }

    /**
     * Alias for rad_lang::lang($code='',$langcode=null)
     *
     * @param string $code
     * @param string $langcode
     * @param boolean $ucfirst
     * @return string
     * @example lang('submit.system.button','ru');
     * @link http://wiki.rad-cms.ru/index.php/Rad_controller:methods:lang
     */
    public function lang($code='', $langcode=null, $ucfirst = false)
    {
        return rad_lang::lang($code, $langcode, null, $ucfirst);
    }

    /**
     * Gets the current language code string like en,us,ru,uk ...
     *
     * @return string
     */
    public function getCurrentLang()
    {
        return rad_lang::getCurrentLanguage();
    }

    /**
     * Gets the current langID
     *
     * @return integer
     */
    public function getCurrentLangID()
    {
        return rad_lang::getCurrentLangID();
    }

    /**
     * Gets the content language ID
     * @return integer
     */
    public function getContentLangID()
    {
        return rad_lang::getContentLangID();
    }

    /**
     * returns the object with content language
     * @return struct_core_lang
     */
    public function getContentLang()
    {
        return rad_lang::getContentLangObj();
    }

    /**
     * Alias for rad_input::redirect($url)
     * Needs to redirect to other pages
     *
     * @param string $url
     * @param string $message
     * @param Boolean $isJS - is JavaScript redirect, or in header?
     *
     * @return Boolean
     */
    public function redirect($url=null,$message=null,$isJS=true)
    {
        return rad_input::redirect($url, $message, $isJS);
    }

    /**
     * return the Current class name in child
     * @return string
     * @access public
     */
    final public function getClassName()
    {
        return get_class($this);
    }

    /**
     * Sets the message to this classname only and this user!!!
     *
     * @param string $message
     */
    final public function setMessage($message='', $className=null)
    {
        $className = ($className)?$className:$this->getClassName();
        $_SESSION['messages'][$className] = $message;
    }

    final public function hasMessage()
    {
        return (isset($_SESSION['messages'][$this->getClassName()]));
    }
    /**
     * Gets only for this classname and this user the setted message!
     * If you get the message - the message will me clear!
     *
     * @return string or null if has no setted messages;
     */
    final public function getMessage()
    {
        if(isset($_SESSION['messages'][$this->getClassName()])){
            $result = $_SESSION['messages'][$this->getClassName()];
            unset($_SESSION['messages'][$this->getClassName()]);
        } else {
            $result = NULL;
        }
        return $result;
    }

    /**
     * Alias for rad_permissions::hasRights($classname,$action,$user_id)
     * Checks if classname has rights for some action for $user_id or current user_id
     *
     * @param string $classname
     * @param string $action
     * @param integer $user_id
     * @return Boolean
     * @access public
     */
    public function hasRights($action,$classname=NULL,$user_id=null)
    {
        $classname = ($classname)?$classname:$this->getClassName();
        return rad_permissions::hasRights($classname,$action,$user_id);
    }

    /**
     * Create the notification with security hole alert in some code
     */
    //TODO: Make this function
    //TODO: recheck all usage cases for this method. In most cases it's used like the developer was drunk.
    protected function securityHoleAlert($file = '', $line = '', $class = '')
    {
        if($this->config('debug.redirectSHA')) {
            $this->redirect($this->config('debug.redirectSHA'));
        } else {
            die('TEMPRORY SECURITY HOLE ALERT AT: '.$file.' LINE:'.$line.' CLASS:'.$class.'<br /> Need to turn off this error? go to config.php and set the debug.redirectSHA option. <br /> Documentation: <a href="http://wiki.radcms.ru/index.php?title=Config.php">wiki</a>');
        }
    }

    /**
     * Function sends the header
     *
     * @param string $param
     * @param boolean $metatag - send header in metatag in html???
     * @todo finish metatag
     */
    //TODO finish metatag functionality
    function header($param,$metatag=false)
    {
        if( !$metatag ){
            return header($param);
        }
    }

    /**
     * Gets the config from rad_config
     *
     * @param string $paramname\
     * @param mixed $defValue
     *
     * @return mixed value
     */
    function config($paramname, $defValue=NULL)
    {
        return rad_config::getParam($paramname, $defValue);
    }

    /**
     * Gets the params object for current controller
     *
     * @return rad_paramsobject
     */
    function getParamsObject()
    {
        return rad_instances::getParamsFor( $this->getClassName() );
    }

    /**
     * Get the params for needed alias and needed controller
     *
     * @param string $alias
     * @param string $controller
     */
    //TODO finish that function
    function getParamsFor($alias,$controller){
        /*
         * SELECT inc.params_hash from rad_includes_in_aliases inc inner join rad_aliases a on inc.alias_id = a.id where a.alias = "$alias" and inc.controller = "$controller"
         * return new rad_paramsobject(inc.params_hash,true);
         */
    }

    /**
     * Return the object with current user
     *
     * @return struct_core_users
     *
     */
    function getCurrentUser()
    {
        return rad_session::$user;
    }

    /**
     * GEts current PHPSESSID
     *
     * @return string
     */
    function getCurrentSessID()
    {
        return session_id();
    }

    /**
     * return Array of all cached active languages and codes from main table languages rad_lang
     * structure Array('langCode'=>id_lang - id language
     *                           =>lng_name - Full language name
     *                           =>lng_code - Sort language code (Example: en ru ua ge jp fr .etc)
     * Alias for rad_lang::getActiveLanguages();
     * @return struct_core_lang
     */
    function getAllLanguages()
    {
        return rad_lang::getActiveLanguages();
    }

    /**
     * gets the user params
     * @return rad_paramsobject
     *
     */
    function getCurrentUserParams()
    {
        return rad_session::$user_params;
    }

    /**
     * Function needed for breadcrumbs
     */
    public static function getBreadcrumbsVars()
    {
        return null;
    }

    /**
     * Adds the param name and value to the breadcrumbs
     * @param string $varname
     * @param mixed $varvalue
     * @return Boolean true
     *
     */
    function addBC($varname,$varvalue)
    {
        return rad_breadcrumbs::add($varname, $varvalue, $this->getClassName());
    }

    /**
     * Makes the url from standart params
     * @param string $context
     * @param boolean $canonicad | false
     * @return string
     * @example makeURL('alias=index.html&page=2&itemsperpage=10&category=754')
     */
    function makeURL($string, $canonical=false)
    {
        if($canonical) {
            return SITE_URL.'index.php?lang='.rad_lang::getCurrentLanguage().(empty($string)?'':'&'.$string);
        }
        return rad_input::makeURL($string);
    }

    /**
     * Gets the current template path by current controller name in current alias
     * @return string
     */
    function getTemplatePath()
    {
        return rad_loader::getTemplatePathByController($this->getClassName());
    }

    /**
     * The function wrapper for the rad_config::getSys().
     * Returns the appropriate configuration parameter from php.ini file
     *
     * @param string $paramName Parameter name
     * @param string $defaultValue Default value
     * @return string fetched or default value
     */
    function configSys($paramName, $defaultValue='')
    {
        return rad_config::getSys($paramName);
    }
}