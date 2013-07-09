<?php
/**
 * System class for login and another operations at users
 * @package RADCMS
 * @author Denys Yackushev
 * @datecreated may 2007
 */
class rad_user
{
    /**
     * Table name for users
     *
     * @var string
     */
    /**
     * Struct user
     *
     * @var struct_core_users
     */
    private static $user;

    private static $_cache=null;

    /**
     * Get's the struct_core_users by his u_id
     *
     * @param integer $id
     * @param $cache - need to cache this user?!
     * @return struct_core_users
     */
    public static function getUserByID($id=null, $cache=true)
    {
        if ($id) {
            if(isset(self::$_cache[$id]))
                return self::$_cache[$id];
            $result = rad_dbpdo::query('select * from '.RAD.'users where `u_id`=?', array($id));
            self::$_cache[$id] = new struct_core_users($result);
            return self::$_cache[$id];
        } else {
            return $id;
        }
    }

    /**
     * Static function that's check by possible email
     *
     * @param string $email
     * @access static
     * @return Boolean
     */
    public static function checkEmail(&$email)
    {
        $result=true;
        if(strlen($email)<7)
            $resule=false;
        else{
            if((!stristr($email,'@'))or(!stristr($email,'.')))
                $result=false;
            else{
                $arr=explode('@',$email);
                $arr1=explode('.',$arr[1]);
                if((strlen($arr1[1])<2)or(strlen($arr[0])<1))
                    $result=false;
            }
        }
        return $result;
    }

    /**
     * Get's the current user in class setted by function setUser
     *
     * @return unknown
     */
    public static function getUser(){
        return self::$user;
    }

    /**
     * Sets the current user in class
     *
     * @param struct_core_users $user
     */
    public static function setUser(struct_core_users $user)
    {
        self::$user = $user;
    }

    /**
     * Delete the user by his u_id field
     *
     * @param integer $u_id
     * @return count deleted records
     */
    public static function deleteUserByID($u_id=null){
        if($u_id){
            return rad_dbpdo::exec('delete from '.RAD.'users where `u_id`='.(int)$u_id);
        }else return null;
    }

    /**
     * Delete current user seted by function setUser
     *
     * @return count deleted records
     */
    public static function deleteCurrentUser()
    {
        if((int)self::$user['u_id']){
            return self::deleteUserByID(self::$user['u_id']);
        }else return null;
    }

    /**
     * Delete User seted in struct
     *
     * @param struct_core_users $user
     * @return count deleted records
     */
    public static function deleteUser(struct_core_users $user)
    {
        return self::deleteUserByID($user->u_id);
    }

    /**
     * Insert new user
     *
     * @param struct_core_users $user
     * @return count inserted records
     */
    public static function insertUser(struct_core_users $user)
    {
        return rad_dbpdo::insert_struct($user,RAD.'users');
    }

    /**
     * Update user row
     * @var integer
     */
    public static function updateUser(struct_core_users $user)
    {
        $result = rad_dbpdo::update_struct($user,RAD.'users');
        if($result){
            rad_session::$user = $user;
            $_SESSION['user_dump'] = $user;
        }
        return $result;
    }

    /**
     * Get all users with all fields
     * @var array of struct_core_users
     */
    public static function getAllUsers()
    {
        $res = array();
        foreach (rad_dbpdo::queryAll('select * from '.RAD.'users') as $key) {
            $res[] = new struct_core_users($key);
        }
        return $res;
    }

    /**
     * Check user by its username and password
     *
     * @var string login
     * @var string password
     *
     * @return struct_core_users
     */
    public static function checkUser(&$login='',&$password='')
    {
        $res = rad_dbpdo::query('select * from '.RAD.'users where u_login=:login and u_pass=:pass and u_active=1 limit 1', array('login'=>$login, 'pass'=>md5($password) ) );
        if(count($res)){
            return new struct_core_users($res);
        }else{
            return null;
        }
    }

}