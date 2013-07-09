<?php

class rpl_exchange
{

    public $get = NULL;

    function __construct()
    {
    }

    public function parse_string($query_string, $get)
    {
        $result = array();

        list($sections, $params) = explode('?', $query_string);

        $sections = explode('/', $sections);
        parse_str($params, $result);

        if (rad_config::getParam('lang.location_show'))
            rad_lang::setGetLngCode($sections[0]);

        if (isset($get['alias']))
            $result['alias'] = $get['alias'];

        $result['_exchange_provider'] = $sections[2];

        if (empty($result))
            $result = NULL;
        else
            foreach($result as $key => $value)
                if (!is_array($value))
                    $result[$key] = urldecode($value);

        $this->get = $result;
    }

    /**
     * Makes the correct url from string to work with the access
     * @param array mixed get
     * @return string
     */
    public function makeurl($get = array())
    {
        $alias = $get['alias'];
        unset($get['alias']);

        $provider = isset($get['_exchange_provider']) ? $get['_exchange_provider'] : '';
        unset($get['_exchange_provider']);

        return SITE_URL.
            (rad_config::getParam('lang.location_show') ? rad_lang::getCurrentLanguage().'/' : '').
            $alias.'/'.
            $provider.'?'.
            implode('&', $get);
    }
}//class
