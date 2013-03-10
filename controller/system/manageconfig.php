<?php

/**
 * System managing config
 * @author Tereshckenko Viacheslav
 * @package Taberna
 */

class controller_system_manageconfig extends rad_controller
{

    private $_allowedConfigFields = array(
                    'page.defaultTitle',
                    'admin.mail',
                    'system.mail',
                    'referals.on',
                    'referals.percent',
                    'lang.location_show',
                    'theme.default'
                    );
    
    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        return $bco;
    }

    function __construct()
    {
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->getJS();
                    break;                
                case 'save':
                    $this->save();
                    header('Location: '.$this->makeUrl('alias='.SITE_ALIAS));
                    break;
            }
        }
        $configParams = array();
        foreach($this->_allowedConfigFields as $field) {
            $configParams[$field] = rad_config::getParam($field);
        }
        $this->setVar('configParams', $configParams);
        $this->assignThemes();
    }
    
    /**
     * Gets the main javascript for the page
     */
    function getJS()
    {
        $this->setVar('ROOT_PID', addslashes(str_replace(rad_config::getParam('rootPath'),'',TEMPLATESPATH)));
        $this->setVar('lang',$this->getCurrentLang());
    }    
    /**
     * Assign theme folders
     *
     */
    function assignThemes()
    {
        $themes = array();
        if(is_dir(THEMESPATH)) {
            $d = dir(THEMESPATH);
            while (false !== ($entry = $d->read())) {
                if( ($entry!='.') and ($entry!='..') and (is_dir(THEMESPATH.$entry)) and (file_exists(THEMESPATH.$entry.'/description.txt')) and (is_file(THEMESPATH.$entry.'/description.txt')) ){
                    $themes[] = $entry;
                }
            }
        }
        $this->setVar('themes', $themes);
    }
    
    function save()
    {
        if($this->request('hash') == $this->hash()) {
            $newParams = array();
            foreach($this->_allowedConfigFields as $acf) {
                $getacf = $this->escapeString( $this->request( str_replace('.', '__', $acf) ) ); //beacuse we can't get form params with "." in name 
                if($getacf !== NULL) {
                    $newParams[$acf] = $getacf;
                }
            }
            if($this->validateParams($newParams)) {
                $modelSettings = rad_instances::get('model_system_settings');
                $modelSettings->updateItemsByfldName($newParams);
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());            
        }
    }
    
    function validateParams($params = NULL)
    {
        $message = array();
        if($params and count($params)) {
            if(empty($params['page.defaultTitle']) or strlen($params['page.defaultTitle']) < 1){
                $message[] = $this->lang('defaulttitleisempty.system.error');
            }
            if(empty($params['admin.mail']) or strlen($params['admin.mail']) < 1){
                $message[] = $this->lang('adminmailisempty.system.error');
            } elseif(!filter_var($params['admin.mail'], FILTER_VALIDATE_EMAIL)) {
                $message[] = $this->lang('adminmailiswrong.system.error');
            } elseif(strlen($params['admin.mail']) > 50) {
                $message[] = $this->lang('adminmailiswrong.system.error');
            }
            if(empty($params['system.mail']) or strlen($params['system.mail']) < 1){
                $message[] = $this->lang('systemmailisempty.system.error');
            } elseif(!filter_var($params['system.mail'], FILTER_VALIDATE_EMAIL)) {
                $message[] = $this->lang('systemmailiswrong.system.error');
            } elseif(strlen($params['system.mail']) > 50) {
                $message[] = $this->lang('systemmailiswrong.system.error');
            }
            if(isset($params['referals.on'])) {
                if(!in_array((int)$params['referals.on'], array(0,1))) {
                    $message[] = $this->lang('referalsiswrong.system.error');
                }
                if($params['referals.on'] == 1) {
                    if (empty($params['referals.percent']) or !ctype_digit(strval($params['referals.percent'])) or (int)$params['referals.percent'] < 0) {
                        $message['referals.percent'] = $this->lang('referalpercentsiswrong.system.error');
                    }
                }
            } else {
                $message[] = $this->lang('referalsiswrong.system.error');
            }
            if(isset($params['lang.location_show'])) {
                if(!in_array((int)$params['lang.location_show'], array(0,1))) {
                    $message[] = $this->lang('locationiswrong.system.error');
                }
            } else {
                $message[] = $this->lang('locationiswrong.system.error');
            }            
            if(empty($params['theme.default'])) {
                $params['theme.default'] = '';
            }
        } else {
            $message[] = $this->lang('emprtyparams.system.error');
        }
        if(count($message)) {
            $this->setVar('errormessages', $message);
            return false;
        } else {
            return true;
        }
    }    

}