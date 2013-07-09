<?php
/**
 * Session class
 * Core rad class
 * @author Denys Yackushev
 * @package RADCMS
 */

class rad_session
{
    /**
     * @var integer
     */
    public static $is_admin=0;
    /**
     * @var struct_core_users
     */
    public static $user=null;
    /**
     * @var rad_paramsobject
     */
    public static $user_params = null;

    /**
    * Start the session and try to authentificate user by session files
    *
    */
    public function __construct()
    {
        die('You can\'t create the system class!');
    }

    public static function setUser(struct_core_users $user)
    {
        return self::$user = $user;
    }

    /**
     * Starts the session
     *
     */
    public static function start()
    {
        session_set_cookie_params(rad_config::getParam('CookieExpireTime'));
        ini_set('session.gc_maxlifetime', rad_config::getParam('CookieExpireTime'));
        ini_set('session.cache_expire', ceil(rad_config::getParam('CookieExpireTime')/60));
        session_start();
        setcookie(session_name(), session_id(), time()+rad_config::getParam('CookieExpireTime'), '/');
        if (isset($_SESSION['user']) && isset($_SESSION['pass'])) {
            if (isset($_SESSION['user_dump'])) {
                self::$is_admin = $_SESSION['user_dump']->is_admin;
                self::$user = $_SESSION['user_dump'];
                if (strlen(self::$user->u_params)) {
                    self::$user_params = new rad_paramsobject(self::$user->u_params,false);
                } else {
                    self::$user_params = new rad_paramsobject();
                }
                return;
            }
        }
        self::$user = new struct_core_users();
    }

    /**
     * Return true, if current user has admin access
     * @static
     * @return bool
     */
    public static function adminAccess()
    {
        return (!empty(self::$user->u_id) && self::$is_admin && ($_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']));
    }

    /**
     * Gets the params object assigned with the user params
     * @return rad_paramsobject
     */
    public static function getUserParams()
    {
        return self::$user_params;
    }

    public static function print_h()
    {
        print_h($_SESSION);
    }

    /**
     * Sets the session var
     * @param string $key
     * @param mixed $value
     */
    public static function setVar($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    /**
     * Returns the value from the session or NULL
     * @param string $key
     * @param mixed $defValue default NULL
     * @return mixed or NULL
     */
    public static function getVar($key, $defValue=NULL)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return $defValue;
    }

    /**
     * Genere the unique code
     *
     * @param integer $count - symbols count
     * @return string
     */
    public static function genereCode($count=30)
    {
        $stringSymbols='qwertyuioplkjhgfdsazxcvbnm1234567890QWERTYUIOPLKJHGFDSAZXCVBNM';
        $result='';
        for($i=0;$i<$count;$i++)
        {
            $random=rand(0,(strlen($stringSymbols)-1));
            $result .= $stringSymbols[$random];
        }
        return $result;
    }

    /**
     *
     * @param string $u user
     * @param string $p uncoded password
     * @return id user or false
     */
    public static function login($u, $p, $sessionTime=NULL)
    {
        $_SESSION['user'] = $u;
           $_SESSION['pass'] = md5($p);
        $sessionTime =($sessionTime)?$sessionTime:rad_config::getParam('CookieExpireTime');
        $id = rad_dbpdo::query('select u_id,is_admin from '.RAD.'users where `u_email`=:u_email and u_pass=:u_pass', array('u_email'=>$_SESSION['user'], 'u_pass'=>$_SESSION['pass']));
        if (!empty($id['u_id'])) {
            rad_session::$is_admin = $id['is_admin'];
            rad_session::$user = rad_user::getUserByID($id['u_id']);
            rad_user::setUser(rad_session::$user);
            $_SESSION['user_dump'] = rad_session::$user;
            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
            return  rad_session::$user;
        } else {
            return false;
        }
    }

    /**
     *
     * @param string $social_id identifire from social site 
     * @param string $provider social site name
     * @return id user or false
     */
    public static function social_login($social_id, $provider, $sessionTime=NULL)
    {
        $sessionTime =($sessionTime)?$sessionTime:rad_config::getParam('CookieExpireTime');
        $provider_row = 'u_'.$provider.'_id'; 
        $q = 'SELECT u_id, u_email, u_pass, is_admin FROM '.RAD.'users WHERE `'.$provider_row.'`=:'.$provider_row;
        $id = rad_dbpdo::query('SELECT u_id, u_email, u_pass, is_admin FROM '.RAD.'users WHERE `'.$provider_row.'`=:'.$provider_row, array($provider_row => $social_id));
        if (!empty($id['u_id'])) {
            rad_session::$is_admin = $id['is_admin'];
            rad_session::$user = rad_user::getUserByID($id['u_id']);
            rad_user::setUser(rad_session::$user);
            $_SESSION['user_dump'] = rad_session::$user;
            $_SESSION['user'] = $id['u_email'];
            $_SESSION['pass'] = md5($id['u_pass']);
            return  rad_session::$user;
        } else {
            return false;
        }        
    }
    
    /**
     * Destroy the session
     *
     */
    public static function logout()
    {
        self::$is_admin=0;
        self::$user=null;
        $_SESSION['user'] = null;
        $_SESSION['pass'] = null;
        if(!session_regenerate_id(true)) {
            session_destroy();
            session_start();
        }
    }

}