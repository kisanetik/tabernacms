<?php

/**
 * Controller for the login panel in menu
 * @author Yackushev Denys
 * @package Taberna
 */
class controller_coresession_loginpanel extends rad_controller
{

    private $_is_facebook = false;
    private $_is_twitter = false;

    function __construct() 
    {
        parent::__construct();
        if ($this->getCurrentUser()) {
            $this->setVar('user', $this->getCurrentUser());
        }
        if ($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_is_facebook = (boolean) $params->_get('is_facebook', $this->_is_facebook);
            //$this->_is_twitter = (boolean) $params->_get('is_twitter', $this->_is_twitter);
            $this->setVar('params', $params);
        }
        $this->setVar('hash', $this->hash());
        $this->assignCurrency();
        $this->setVar('langs', $this->getAllLanguages());
        $this->setVar('currentLangId', $this->getCurrentLangID());
    }

    function assignCurrency()
    {
        $items = rad_instances::get('model_corecatalog_currency')->getItems();
        $this->setVar('currency', $items);
        $this->setVar('currentCurrency', model_corecatalog_currcalc::getDefaultCurrencyId());

    }

}