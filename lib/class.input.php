<?php
/**
 * Input class for the system
 * @author Denys Yackushev
 * @package RADCMS
 *
 */
class rad_input
{
    private static $GET=array();
    private static $POST=array();
    private static $REQUEST=array();
    private static $COOKIE=array();
    private static $_request_string = '';

    /**
    * FOR SHURE THAT NOBODY NOT CREATE THIS CLASS
    **/
    public function __construct()
    {
        throw new rad_input_exception('Can\'t create rad_input class! This is only core static class!');
    }

    /**
     * Parse all variables if global GET array
     * @access private
     *
     */
    private static function getParse()
    {
        if(empty($_GET['rad_pr'])) {
            foreach ($_GET as $key => $val) {
                $key = html_entity_decode(urldecode($key));
                if(!is_array($val)) {
                    $val = html_entity_decode(urldecode($val));
                    self::$GET[$key] = $val;
                } else {
                    foreach($val as $k => $v) {
                        $k = html_entity_decode(urldecode($k));
                        $v = html_entity_decode(urldecode($v));
                        self::$GET[$key][$k] =$v;
                    }
                }
            }
            if(rad_config::getParam('lang.location_show')) {
                if(!empty(self::$GET['lang'])) {
                    rad_lang::setGetLngCode(self::$GET['lang']);
                }
            }            
        } else {
            self::$GET=self::parseGetRequest_htaccess(str_replace(SITE_URL.'/','',SITE_URL.$_SERVER['REQUEST_URI']));
        }
    }

    /**
     * Parse all variables from request string when use ModRewrite
     * @access private
     * @param string request_string
     * @return null
     */
    //TODO Get the paramname from server!
    private static function parseGetRequest_htaccess($string='')
    {
        if(!empty($string)) {
            self::$_request_string = $string;
            $request=substr($string,strlen(rad_config::getParam('folder')));
            $request = urldecode($request);
            $result['alias']='';
            $pos=0;
            $tmp='';
            if(rad_config::getParam('lang.location_show')) {
                $lngCode = '';
                for($i=0;$i<strlen($request);$i++) {
                     if($request[$i]!='/') {
                         $lngCode .= $request[$i];
                     } else {
                         break;
                     }
                }
                rad_lang::setGetLngCode($lngCode);
                $request = substr($request, strlen($lngCode.'/'));
            }
            for($i=0;$i<strlen($request);$i++) {
                if(($pos==0)and($request[$i]!='/')) {
                    $result['alias'].=$request[$i];
                } elseif( ($request[$i]=='/') and ( ($pos==0) or ($pos==1) ) ) {
                    $pos++;
                } elseif(($request[$i]=='/')and($pos==2)) {
                    $pos=1;
                    $tmp='';
                } elseif($request[$i]!='/') {
                    if($pos==1) {
                        $tmp.=$request[$i];
                    } else {
                        $t = $tmp;
                        if(!isset($result[$t])) {
                            $result[$t] = '';
                        }
                        $result[$t] .= $request[$i];
                    }
                } else {
                    echo '<hr>request[i]='.$request[$i].'<hr>';
                }
            }
            
            if(!strlen($result['alias'])){
                if(rad_config::getParam('lang.location_show')){
                    $lang = preg_replace("/[\/]/", "", self::$_request_string);
                    if($lang == rad_lang::getGetLngCode()){
                        $result['alias'] = rad_config::getParam('defaultAlias');     
                    }else{
                        $result['alias'] = rad_config::getParam('alias.404');     
                    }
                }else{
                    $result['alias'] = self::$_request_string;    
                }
            }
            
            return $result;
        } else {
            return null;
        }
    }

    public static function overrideUrl($url)
    {
        self::$GET = self::parseGetRequest_htaccess(str_replace(SITE_URL, '', $url));
        self::setRequest();
    }

    /**
     * Parse all variables in global POST array
     * @access private
     */
    private static function postParse()
    {
        foreach ($_POST as $key=>$val) {
            if(!is_array($val)) {
                self::$POST[$key]=$val;
            } else {
                foreach($val as $k=>$v) {
                    self::$POST[$key][$k]=$v;
                }
            }
        }
    }

    /**
     * Parse all variables in global COOKIE array
     * @access private
     */
    private static function cookieParse()
    {
        foreach($_COOKIE as $key=>$value) {
            self::$COOKIE[$key]=$value;
        }
    }

    /**
     * Sets all internal variables and merge arrays
     * @access private
     */
    private static function setRequest()
    {
        self::$REQUEST = array();
        if(self::$GET) {
            self::$REQUEST = self::$GET;
        }
        if(self::$COOKIE) {
            if(self::$REQUEST) {
                self::$REQUEST=array_merge(self::$REQUEST,self::$COOKIE);
            } else {
                self::$REQUEST = self::$COOKIE;
            }
        }
        if(self::$POST and is_array(self::$POST)) {
            self::$REQUEST=array_merge(self::$REQUEST,self::$POST);
        }
    }


    /**
     * init the input
     * need to call this function when system is start
     * @access public
     */
    public static function init_all()
    {
        self::getParse();
        self::postParse();
        self::cookieParse();
        self::setRequest();
        if(!isset(self::$REQUEST['alias'])) {
            self::$REQUEST['alias'] = rad_config::getParam('defaultAlias');
            self::$POST['alias'] = rad_config::getParam('defaultAlias');
        }
        self::clearGlobalVars();
        if (rad_config::getParam('cleanurl.on')) {
            rad_loader::overrideAliasUrl();
        }
    }

    /**
     * Get the paramvalue from GET array by paramname
     * @access public
     * @var string paramname
     * @return string paramvalue
     */
    public static function get($paramname='',$defValue=NULL)
    {
        if(!empty($paramname)) {
            return (isset(self::$GET[$paramname]))?self::$GET[$paramname]:$defValue ;
        } else {
            return $defValue;
        }
    }

    /**
     * Get the paramvalue from POST array by paramname
     * @access public
     * @var string paramname
     * @return string paramvalue
     */
    public static function post($paramname='',$defValue=NULL)
    {
        if(!empty($paramname)) {
            return (isset(self::$POST[$paramname]))?self::$POST[$paramname]:$defValue ;
        } else {
            return $defValue;
        }
    }

    /**
     * Get the paramvalue from REQUEST array by paramname
     * @access public
     * @var string paramname
     * @return string paramvalue
     */
    public static function request($paramname=null,$defValue=NULL)
    {
        if($paramname) {
            return (isset(self::$REQUEST[$paramname]))?self::$REQUEST[$paramname]:$defValue ;
        } else {
            return $defValue;
        }
    }

    /**
     * Get the paramvalue from COOKIE array by paramname
     * @access public
     * @var string paramname
     * @return string paramvalue
     */
    public static function cookie($paramname='',$defValue=NULL)
    {
        if(!empty($paramname)) {
            return (isset(self::$COOKIE[$paramname]))?self::$COOKIE[$paramname]:$defValue ;
        } else {
            return $defValue;
        }
    }

    /**
     * Sets the cookie
     * @param string $key
     * @param mixed $value
     */
    public static function setCookie($key=null, $value=null)
    {
        $_COOKIE[$key] = $value;
    }

    /**
     * Get all request
     *
     * @return mixed array
     */
    public static function allRequest()
    {
        return self::$REQUEST;
    }

    /**
     * Get all GET array
     * @return array mixed
     */
    public static function allGet()
    {
        return self::$GET;
    }

    protected static function clearGlobalVars()
    {
        $PHPSESSID = (isset($_COOKIE[ini_get('session.name')]))?$_COOKIE[ini_get('session.name')]:NULL;
        foreach($_REQUEST as $key=>$val) {
            unset($_REQUEST[$key]);
        }
        foreach($_GET as $key=>$val) {
            unset($_GET[$key]);
        }
        foreach($_POST as $key=>$val) {
            unset($_POST[$key]);
        }
        foreach($_COOKIE as $key=>$val) {
            unset($_COOKIE[$key]);
        }
        if($PHPSESSID) {
           $_COOKIE[ini_get('session.name')] = $PHPSESSID;
        }
    }

    public static function getFlushInput()
    {
        $res = array(
            'GET'         => self::$GET,
            'POST'         => self::$POST,
            'COOKIE'    => self::$COOKIE,
            'FILES'        => $_FILES,
            'SERVER'    => $_SERVER
        );
        return $res;
    }

    /**
     * Gets accepted languages from request that sended from browser
     * @return mixed array
     */
    public static function getAcceptedLanguages()
    {
        $languages = array();
        $_accept   = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

        foreach ($_accept as $_line) {

            $_locale = $_quotient = $_lang = $_country = false;

            list($_locale, $_quotient) = explode(';', $_line);

            if (strpos($_locale, '-')) {
                list($_lang, $_country) = explode('-', $_locale);
                $lang = $_country . $_lang;
            } else {
                $lang = $_locale;
            }

            if ($_quotient) {
                $languages[$lang] = (float) substr($_quotient, strpos($_quotient, '=') + 1);
            } else {
                $languages[$lang] = (float) 1.0;
            }
       }//foreach
       arsort($languages);
       return $languages;

    }

    /**
     * Returns the defined value
     *
     * @param string $defName
     *
     * @return string
     */
    public static function getDefine($defName)
    {
        static $defines = array();

        if( !count($defines) ) {
            $defines = get_defined_constants();
        }
        return ( isset( $defines[$defName] ) )?$defines[$defName]:$defName;

    }


    //needed to redirect to other pages!
    //TODO Finish that function redirect
    /**
     * Redirect function
     * Allow also params like 404, 301 e.t.c.
     * @param string $url
     * @param mixed $message
     * @param boolean $isJS - default is true
     */
    public static function redirect($url='',$message=null,$isJS=true)
    {
        if($message) {
            $_SESSION['message'] = $message;
        }
        if($url=='404') {
            header(rad_config::getParam('header.404'));
            header( 'Location:'.SITE_URL.rad_config::getParam('alias.404') );
        } elseif($isJS) {
            $s = '<script type="text/javascript"> location="'.$url.'"; </script>';
            die($s);
        } else {
            header('Location: '.$url);
        }
        die;
    }

    /**
     * Reparse all GET with some plugin
     * @param string $classname
     */
    public static function reparseGetWithPlug($classname='')
    {
        if( file_exists(LIBPATH.'ext/'.$classname.'.php') ) {
            $cl = rad_instances::get($classname);
            $cl->parse_string( self::$_request_string, self::$GET );
            self::$GET = $cl->get;
            self::setRequest();
        }
    }

    /**
     * Gets all the plugins for get parsing
     */
    public static function getPluginsFGet()
    {
        $result = array();
        foreach(glob(LIBPATH.'ext'.DS.'rpl_*.php') as $filename) {
            $result[] = str_replace(LIBPATH.'ext'.DS,'',str_replace('.php','',$filename) );
        }//foreach
        return $result;
    }

    /**
     * Makes the url from standart params
     * @param string $context
     * @param bool $url_aliases_enabled
     * @return string
     * @example makeURL('alias=index.html&page=2&itemsperpage=10&category=754')
     */
    public static function makeURL($context, $url_aliases_enabled = false)
    {
        static $alias_plugins = null;
        static $search = null;
        static $replace = null;
        if(!$alias_plugins) {
            $alias_plugins = rad_loader::getAliasInputClasses();
        }
        if(!$search) {
            $search = array('SITE_URL');
        }
        if(!$replace) {
            $replace = array(SITE_URL);
        }
        $c = str_replace($search, $replace, $context);
        if (defined('SITE_ALIAS')) {
            $c = str_replace('SITE_ALIAS', SITE_ALIAS, $c);
        }
        if (is_link_external($c)) {
            return $c;
        }
        $r = strstr($c,'?');
        if($r) {
            $c = substr($r,1);
        }
        $r = explode('&',$c);
        $get = array();
        foreach($r as $id) {
            $r1 = explode('=',$id);
            if(count($r1)>=2) {
                $get[$r1[0]] = $r1[1];
            } else {
                $get[$r1[0]] = '';
            }
        }
        if(!isset($get['alias'])) {
            $get['alias'] = SITE_ALIAS;
        }
        if ($url_aliases_enabled && rad_config::getParam('cleanurl.on')) {
            if ($alias = rad_loader::getUrlAliasByParams($get)) {
                return SITE_URL.$alias;
            }
        }

        if( isset($alias_plugins[ $get['alias'] ]) ) {
            $model = rad_instances::get($alias_plugins[ $get['alias'] ]);
            $string = $model->makeurl($get);
        } else {
            if((!count($get) or ( count($get)==1 and isset($get['alias']) )) and trim($get['alias'])==rad_config::getParam('defaultAlias')) {
                $string = SITE_URL;
            } else {
                if(rad_config::getParam('lang.location_show')) {
                    $string = SITE_URL.rad_lang::getCurrentLanguage().'/'.$get['alias'].'/';
                } else {
                    $string = SITE_URL.$get['alias'].'/';
                }
                if(strlen($context)) {
                    foreach($get as $prmname=>$prmvalue) {
                        if($prmname!='alias') {
                            $string .= $prmname.'/'.$prmvalue.'/';
                        }
                    }//foreach
                       if(strpos($prmvalue, '.')) {
                           if($string[strlen($string)-1]=='/') {
                               $string = substr($string,0,-1);
                           }
                       }
                }//if
            }
        }
        return $string;
    }

    /**
     * Get all GET array
     * @return array mixed
     */
    public static function allGetToURLString()
    {
        $result = '';
        if(!empty(self::$GET)) {
            $index = 0;
            foreach(self::$GET as $key => $value) {
                if($value !== '') {
                    if($index) {
                        $result .= '&';
                    } else {
                        $index++;
                    }
                    if(is_array($value)) {
                        foreach($value as $k => $val) {
                            if($index) {
                                $result .= '&';
                            } else {
                                $index++;
                            }                            
                            $result .= $key . '[' . $k . ']' . '=' . urlencode($val);
                        }
                    } else {
                        $result .= $key . '=' . $value;
                    }
                }
            }
        }
        return $result;
    }
}

class rad_input_exception extends rad_exception
{
    public function __construct($message, $code = 0)
    {
        // make sure everything is assigned properly
        parent::__construct($message.' <b>`input_class`</b> ', $code);
    }
}