<?php
/**
 * Just for showing request and the message in some template
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_system_message extends rad_controller
{
    function __construct()
    {
        if( isset($_SESSION['message']) and (strlen( $_SESSION['message'] )) ) {
            $this->setVar('message',$_SESSION['message']);
            unset($_SESSION['message']);
        }
        $this->setVar('req', $this->getAllRequest());
        $this->setVar('adminMail', $this->config('admin.mail'));
    }
}