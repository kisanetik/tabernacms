<?php
/**
 * Class Language
 * @author Yackushev Denys
 * @version 0.3.7
 * @uses rad_dbpdo
 * @datecreated 22.10.2008
 * @package RADCMS
 *
 */
class rad_lang
{
    private static $currlang;

    /**
     * Current lang code
     * @example: en ru ge ua jp fr .etc
     * @var string
     */

    /**
     * ID of current language in DB
     *
     * @access private
     * @var integer
     */
    private static $langID = 0;

    /**
     * Id of the default language on the site
     * @var integer
     */
    private static $mainsiteID = 0;

    /**
     * ID of the default language for content
     */
    private static $maincontentID = 0;

    /**
     * Object struct_core_lang for the content language
     * @var struct_core_lang
     */
    private static $maincontentObj = NULL;

    /**
     * ID of the default language for admin-panel
     * @var integer
     */
    private static $mainadminID = 0;

    private static $currentLanguage = '';

    /**
     * Array of all languages and codes from main table languages rad_lang
     * structure Array('langCode'=>id_lang - id language
     *                              =>lng_name - Full language name
     *                              =>lng_code - Sort language code (Example: en ru ua ge jp fr .etc)
     * )
     *
     * @var
     */
    private static $allLanguages;

    private static $cacheLngValues = null;

    /**
     * Not found language codes in DB
     * @var mixed
     * @example
     *  array('somecode.module.text'=>array( array(
     *      'template'=>'template.tpl',
     *      'language'=>'en'
     * )))
     */
    private static $cacheNotFound = null;

    /**
     * the lng code from get or request
     * @var string (Example: en,ru,us,de,it)
     */
    private static $_getLngCode = '';

    /**
     * Constructor.
     * not need in this class
     */
    function __construct()
    {
          die('can\'t create the system class!');
    }

    /**
     * Sets the lng code from get or request
     * @param string $lngCode (Example: en,ru,us,de,it)
     */
    public static function setGetLngCode($lngCode)
    {
        self::$_getLngCode = $lngCode;
    }

    /**
     * Gets the lng code from get or request
     * @return string $lngCode (Example: en,ru,us,de,it)
     */
    public static function getGetLngCode()
    {
         return self::$_getLngCode;
    }

    /**
     * return Array of all cached active languages and codes from main table languages rad_lang
     * structure Array('langCode'=>id_lang - id language
     *                           =>lng_name - Full language name
     *                           =>lng_code - Sort language code (Example: en ru ua ge jp fr .etc)
     * @return struct_core_lang
     */
    public static function getActiveLanguages()
    {
        return self::$allLanguages;
    }

    /**
     * Init the language class
     *
     * @return Boolean
     */
    public static function init()
    {
        self::$currlang = self::getAcceptedLanguage();
        self::initAllLanguages();
        self::_getCurrentLanguage();
    }

    /**
     * Gets the language ID by it code
     *
     * @param $code string
     * @return integer
     */
    public static function getLangByCode($code=null)
    {
        $result = null;
        if (is_object(self::$allLanguages[$code])) {
            $result = self::$allLanguages[$code]->lng_id;
        }
        return $result;
    }

    /**
     * Returns the struct_core_lang object
     * @param integer $lng_id
     * @return struct_core_lang
     */
    public static function getLangByID($lng_id)
    {
        self::initAllLanguages();
        foreach(self::$allLanguages as $id) {
            if($id->lng_id==(int)$lng_id) {
                return $id;
            }
        }
        return NULL;
    }

    /**
     * Get the accepted language from request from browser
     */
    //TODO finish that function
    private static function getAcceptedLanguage()
    {
        $result = 'en';
        return $result;
    }

    /**
     * Initialize all languages from main table to allLanguages and struct this array
     *
     * @param tinyint $whereActive
     */
    private static function initAllLanguages($whereActive=1)
    {
        if (!empty(self::$allLanguages)) return;
        foreach (rad_dbpdo::queryAll('SELECT lng_id,lng_name,lng_code,lng_img,lng_mainsite,lng_mainadmin,lng_maincontent,lng_active FROM '.RAD.'lang where lng_active=? ORDER BY lng_position, lng_name', array($whereActive)) as $row) {
            if($row['lng_mainsite']) {
                self::$mainsiteID = (int)$row['lng_id'];
            }
            if($row['lng_mainadmin']) {
                self::$mainadminID = (int)$row['lng_id'];
            }
            if($row['lng_maincontent']) {
                self::$maincontentID = (int)$row['lng_id'];
                self::$maincontentObj = new struct_core_lang($row);
            }
            self::$allLanguages[$row['lng_code']] = new struct_core_lang($row);
        }
    }

    /**
     * Get current langcode from session or set the default langcode
     * Also set current private LangID and currentLanguage
     *
     */
    private static function _getCurrentLanguage()
    {
        $lngCode = self::getGetLngCode();
        if(rad_config::getParam('lang.location_show') and !empty($lngCode) and in_array(self::getGetLngCode(), array_keys(self::$allLanguages))) {
            self::$currentLanguage = self::getGetLngCode();
        } elseif(rad_config::getParam('lang.location_show') and !empty($lngCode) and !in_array(self::getGetLngCode(), array_keys(self::$allLanguages))) {
            /*Page not exists!*/
            header(rad_config::getParam('header.404'));
            self::$currentLanguage = (strlen(rad_session::getVar('currlang'))) ? rad_session::getVar('currlang') : rad_config::getParam('lang.default'); 
            //rad_input::redirect(rad_input::makeURL('alias='.rad_config::getParam('alias.404')));
        } elseif(rad_session::getVar('currlang')) {
            self::$currentLanguage = rad_session::getVar('currlang');
        } else {
            self::$currentLanguage = rad_config::getParam('lang.default');
        }
        rad_session::setVar('currlang', self::$currentLanguage);
        if(rad_session::getVar('contentLng')) {
            self::$maincontentID = (int)rad_session::getVar('contentLng');
        }
        $user = rad_session::$user;
        if(isset($user->u_id) and $user->u_id) {
            $paramsobject = rad_session::$user_params;
            self::$maincontentID = $paramsobject->_get('contentLng',self::$maincontentID);
        }
        if(!count(self::$allLanguages)) {
            throw new rad_exception('Languages in database not found! Please, insert any languages and try again!', 17134);
        }
        self::$langID=self::$allLanguages[self::$currentLanguage]->lng_id;

        self::$cacheLngValues[self::$langID] = array();
    }

    /**
     * Gets the current language code string like en,us,ru,uk ...
     *
     * @return string
     *
     * @access public
     */
    public static function getCurrentLanguage()
    {
        return self::$currentLanguage;
    }

    /**
     * Gets the ID of current language
     *
     * @access public
     * @return integer
     */
    public static function getCurrentLangID()
    {
        return self::$langID;
    }

    /**
     * Return the ID of language for the content
     * @access public
     * @return integer
     */
    public static function getContentLangID()
    {
        return self::$maincontentID;
    }

    /**
     * Returns the content lang object
     * @access public
     * @return struct_core_lang
     */
    public static function getContentLangObj()
    {
        return self::$maincontentObj;
    }

    /**
     * Returns language value by it langcode
     *
     * @param string $code
     * @param string $langcode (en.ru e.t.c.)
     * @param boolean $ucfirst
     * @return string
     * @example lang('submit.system.button');
     *
     * @access public
     */
    public static function lang($code='',$langcode=null, $container = NULL, $ucfirst=false)
    {
        $langcode = ($langcode)?$langcode:self::$currentLanguage;
        $langID   = ($langcode and isset(self::$allLanguages[$langcode]))?self::$allLanguages[$langcode]->lng_id:self::$langID;
        if(isset(self::$cacheLngValues[$langID][$code])) {
            return self::$cacheLngValues[$langID][$code];
        }
        $row = rad_dbpdo::query('SELECT `lnv_value` FROM '.RAD.'langvalues where `lnv_code`=? and `lnv_lang`=?', array($code,$langID));
        if(is_null($row['lnv_value'])) {
            self::$cacheLngValues[$langID][$code] = $code;
            if(!empty($container)) {
                self::addNotFoundCache($container->getTemplate(), $code, $langcode);
            }
        } else {
            self::$cacheLngValues[$langID][$code] = $row['lnv_value'];
        }
        return ($ucfirst)? mb_ucfirst(self::$cacheLngValues[$langID][$code]):self::$cacheLngValues[$langID][$code];
    }

    /**
     * Add to not found codes cache new record
     * @param string $template
     * @param string $code
     * @param string $langcode
     * @example self::addNotFoundCache('categories.menu.tpl', 'cattitle.catalog.title', 'en');
     */
    protected static function addNotFoundCache($template, $code, $langcode)
    {
        if(!isset(self::$cacheNotFound[$code])) {
            self::$cacheNotFound[$code][] = array(
                'template'=>$template,
                'language'=>$langcode
            );
        } else {
            $found = false;
            foreach(self::$cacheNotFound[$code] as $id) {
                if($id['language']==$langcode) {
                    $found = true;
                }
            }//foreach
            if(!$found) {
                self::$cacheNotFound[$code][] = array(
                    'template'=>$template,
                    'language'=>$langcode
                );
            }
        }
    }

    /**
     * Returns all not found cache
     * @return mixed
     * @example array('somecode.module.text'=>array( array(
     *      'template'=>'template.tpl',
     *      'language'=>'en'
     * )))
     */
    public static function getCacheNotFound()
    {
        return self::$cacheNotFound;
    }

    /**
     * Set new current language in session
     * Example: ru en ua fr jp etc.
     *
     * @param string $newLangCode
     * @example rad_lang::changeLanguage('en');
     *
     * @access public
     */
    public static function changeLanguage($newLangCode = null)
    {
        if ($newLangCode && !empty(self::$allLanguages[$newLangCode])) {
            rad_session::setVar('currlang',$newLangCode);
            self::$currentLanguage = $newLangCode;
            return true;
        }
        return false;
    }

    /**
     * Change the content language
     * @param integer $newlangId
     * @return boolean
     */
    public static function changeContentLanguage($newlangId)
    {
        foreach(self::$allLanguages as $id) {
            if($id->lng_id==$newlangId) {
                $user = rad_session::$user;
                if(isset($user->u_id) and $user->u_id) {
                    $paramsobject = rad_session::$user_params;
                    $paramsobject->_set('contentLng',$newlangId,'string');
                    $user->u_params = $paramsobject->_hash();
                    if(!rad_instances::get('model_core_users')->updateItem($user)) {
                        echo 'alert("can\'t change language! some error!");';
                    }
                    rad_session::setVar('contentLng',$newlangId);
                }
                return rad_session::setVar('contentLng',$newlangId);
            }
        }
        $false = false;
        return $false;
    }

    /**
     * Get values for codes
     * @param array $codes
     * @return array code=>value
     */
    public static function getCodeValues($codes)
    {
        if (count($codes)) {
            $codes = array_unique($codes);
            $i = 0;
            $in = '';
            foreach ($codes as $idc=>$code) {
                $in .= ($i)?',':'';
                $in.="'".str_replace("'", "", $code)."'";
                $i++;
            }
            $result = array();
            foreach(rad_dbpdo::queryAll( 'SELECT lnv_code,lnv_value from '.RAD.'langvalues where lnv_lang =? and lnv_code in('.$in.')', array(self::$langID) ) as $idv) {
                $result[$idv['lnv_code']] = $idv['lnv_value'];
            }
            return $result;
        } else {
            //codes length of array is null
        }
    }

}//class