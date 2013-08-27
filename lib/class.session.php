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
     * @var int
     */
    public static $error_code;
    /**
     * Error codes
     */
    const ERROR_WRONG_PASSWORD = 1;
    const ERROR_USER_NOT_ACTIVATED = 2;
    const ERROR_USER_IS_BLOCKED = 3;

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
        if (isset($_SESSION['user'], $_SESSION['pass'], $_SESSION['user_dump'])) {
            self::$is_admin = $_SESSION['user_dump']->is_admin;
            self::$user = $_SESSION['user_dump'];
            if (strlen(self::$user->u_params)) {
                self::$user_params = new rad_paramsobject(self::$user->u_params,false);
            } else {
                self::$user_params = new rad_paramsobject();
            }
            return;
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
    public static function getVar($key, $defValue = NULL)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $defValue;
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
     * @static
     * @param string $password
     * @return string
     */
    public static function encodePassword($password)
    {
        return md5($password);
    }

    public static function updateUserData($user_id)
    {
        self::$user = rad_user::getUserByID($user_id);
        $_SESSION['user_dump'] = self::$user;
    }

    /**
     *
     * @param string $u user
     * @param string $p uncoded password
     * @return id user or false
     */
    public static function login($u, $p, $sessionTime=NULL)
    {
        //$sessionTime =($sessionTime)?$sessionTime:rad_config::getParam('CookieExpireTime');
        $id = rad_dbpdo::query('SELECT u_id, u_pass, is_admin, u_active, u_email_confirmed FROM '.RAD.'users WHERE `u_email`=:u_email', array('u_email'=>$u));
        if (!empty($id['u_id']) && (
                (($id['u_email_confirmed'] || (rad_config::getParam('registration.class') != 'registerphpbb')) && ($id['u_pass'] == self::encodePassword($p)))
                || (!$id['u_email_confirmed'] && (rad_config::getParam('registration.class') == 'registerphpbb') && ($id['u_pass'] == $p))
            )) {
            if (!$id['u_active']) {
                self::$error_code = self::ERROR_USER_IS_BLOCKED;
                return false;
            } elseif (!$id['u_email_confirmed']) {
                self::$error_code = self::ERROR_USER_NOT_ACTIVATED;
                $_SESSION['try_login_user_id'] = $id['u_id'];
                return false;
            }
            self::$error_code = 0;
            self::$is_admin = $id['is_admin'];
            self::$user = rad_user::getUserByID($id['u_id']);
            rad_user::setUser(self::$user);
            $_SESSION['user'] = $u;
            $_SESSION['pass'] = $id['u_pass'];
            $_SESSION['user_dump'] = self::$user;
            $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
            return  self::$user;
        }
        self::$error_code = self::ERROR_WRONG_PASSWORD;
        return false;
    }

    /**
     *
     * @param string $social_id identifire from social site 
     * @param string $provider social site name
     * @return id user or false
     */
    public static function social_login($social_id, $provider, $sessionTime=NULL)
    {
        //$sessionTime =($sessionTime)?$sessionTime:rad_config::getParam('CookieExpireTime');
        $provider_row = 'u_'.$provider.'_id'; 
        $id = rad_dbpdo::query('SELECT u_id, u_email, u_pass, is_admin FROM '.RAD.'users WHERE `'.$provider_row.'`=:'.$provider_row, array($provider_row => $social_id));
        if (!empty($id['u_id'])) {
            self::$error_code = 0;
            self::$is_admin = $id['is_admin'];
            self::$user = rad_user::getUserByID($id['u_id']);
            rad_user::setUser(self::$user);
            $_SESSION['user_dump'] = self::$user;
            $_SESSION['user'] = $id['u_email'];
            $_SESSION['pass'] = md5($id['u_pass']);
            return  self::$user;
        }
        self::$error_code = self::ERROR_WRONG_PASSWORD;
        return false;
    }

    /**
     * Destroy the session
     *
     */
    public static function logout()
    {
        self::$is_admin = 0;
        self::$user = null;
        unset($_SESSION['user'], $_SESSION['pass'], $_SESSION['user_dump']);
        if (!session_regenerate_id(true)) {
            session_destroy();
            session_start();
        }
    }
}