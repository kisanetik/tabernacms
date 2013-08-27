<?php
/**
 * Simple hand-registration of users with registration on phpBB 3.0.10
 * @author Viacheslav Tereshchenko
 * @version 0.2
 * @package Taberna
 */

define('IN_PHPBB', true);

class controller_coresession_registerphpbb extends controller_coresession_registersimply
{
    private $_phpbb_src = '/var/web/forum.tabernaecommerce.ru/';

    /**
     * @param rad_paramsobject $params
     */
    protected function setExtraParams($params)
    {
        $this->_phpbb_src = $params->_get('phpbb_src', $this->_phpbb_src, $this->getCurrentLangID());
    }

    /**
     * @param struct_core_users $item
     */
    protected function register($item)
    {
        rad_instances::get('model_core_users')->register($item, false);
    }

    private function phpBBRegister($userObj)
    {
        $save_sytem_config = $GLOBALS['config'];
        global $phpbb_root_path;
        global $phpEx;
        $messages = array();
        $phpbb_root_path = $this->_phpbb_src;
        $phpEx = 'php';
        ob_start(); 
        if( is_readable($this->_phpbb_src . 'config.php') and is_executable($this->_phpbb_src . 'config.php') and
            is_readable($this->_phpbb_src . 'common.php') and is_executable($this->_phpbb_src . 'common.php') and
            is_readable($this->_phpbb_src . 'includes/functions_user.php') and is_executable($this->_phpbb_src . 'includes/functions_user.php') ) {
                require_once($this->_phpbb_src . 'config.php');
                require_once($this->_phpbb_src . 'common.php');
                require_once($this->_phpbb_src . 'includes/functions_user.php');
        } else {
            $messages[] = $this->lang('noaccessphpbbfiles.session.error');
            $messages[] = $this->_phpbb_src . 'config.php<br/>' . $this->_phpbb_src . 'common.php<br/>' . $this->_phpbb_src . 'includes/functions_user.php<br/>';
            return $messages;
        }
        if(!validate_username($userObj->u_login)){
            $user_row = array(
                'username' => $userObj->u_login,
                'user_password' => phpbb_hash($userObj->u_pass),
                'user_email' => $userObj->u_email,
                'group_id' => 7,
                'user_timezone' => 0.00,
                'user_dst' => 0,
                'user_lang' => 'ru',
                'user_type' => 0,
                'user_actkey' => '',
                'user_dateformat' => '|d M Y|, H:i',
                'user_style' => 1,
                'user_regdate' => time(),
                );
            $lid = user_add($user_row);
            if(!$lid) {
                $messages[] = $this->lang('cannotadduser.session.error');
            }
        } else { 
            $messages[] = $this->lang('loginallreadyexists.session.error');
        }
        ob_end_clean();
        $GLOBALS['config'] = $save_sytem_config;
        if(count($messages)) {
            return $messages;
        } else {
            return false;
        }
    }

    /**
     * Returns the error text if needed to prevent user activation
     * Пароль до активации и регистрации пользователя в phpBB хранится в открытом виде!
     * @param struct_core_users $user
     * @return string
     */
    protected function beforeActivateUser($user)
    {
        if (!($error = $this->phpBBRegister($user))) {
            $user->u_pass = rad_session::encodePassword($user->u_pass);
        }
        return $error;
    }

    /**
     * @param struct_core_users $user
     * @return string
     */
    protected function beforeRemindPassword($user)
    {
        return '';
    }

    /**
     * Returns the error text if needed to prevent saving the new password
     * @param struct_core_users $user
     * @param string $password
     * @return string
     */
    protected function beforeSaveNewPassword($user, $password)
    {
        if (!$this->phpBBchangePassword($user->u_login, $password)) {
            return $this->lang('phpbbchangepassword.session.error'); //user not found in phpbb DB or doesn't have permission to phpbb required files
        }
        return '';
    }

    private function phpBBchangePassword($u_name, $new_password)
    {
        $save_sytem_config = $GLOBALS['config'];
        global $phpbb_root_path;
        global $phpEx;
        global $db;
        $phpbb_root_path = $this->_phpbb_src;
        $phpEx = 'php';
        ob_start(); 
        if( is_readable($this->_phpbb_src . 'config.php') and is_executable($this->_phpbb_src . 'config.php') and
            is_readable($this->_phpbb_src . 'common.php') and is_executable($this->_phpbb_src . 'common.php') and
            is_readable($this->_phpbb_src . 'includes/functions_user.php') and is_executable($this->_phpbb_src . 'includes/functions_user.php') ) {
                require_once($this->_phpbb_src . 'config.php');
                require_once($this->_phpbb_src . 'common.php');
                require_once($this->_phpbb_src . 'includes/functions_user.php');
        } else {
            return false;
        }
        $username_ary = $u_name;
        user_get_id_name($user_id_ary, $username_ary);
        $isOK = false;
        if(!empty($user_id_ary) && isset($user_id_ary[0])) {
            $uid = $user_id_ary[0];
            $q = "UPDATE " . USERS_TABLE . " SET `user_password` = '" . phpbb_hash($new_password) . "' WHERE `user_id` = " . $uid . " LIMIT 1";
            $isOK = $db->sql_query($q);
        } 
        ob_end_clean();
        $GLOBALS['config'] = $save_sytem_config;
        return $isOK;
    }
}