<?php
/**
 * Input class for simple menus just dublicates the input params
 * @package RADCMS
 * @author Denys Yackushev
 *
 */
class controller_menus_input extends rad_controller
{
    function __construct()
    {
        $request = $this->getAllRequest();
        if(count($request)) {
            foreach($request as $key=>$value){
                if(is_array($value)) {
                    $this->setVar(html_entity_decode(urldecode($key)), $value);
                } else {
                    $this->setVar(html_entity_decode(urldecode($key)), html_entity_decode( urldecode($value) ) );
                }
            }
		}
        if($this->getParamsObject()) {
			$params = $this->getParamsObject();

            $this->setVar('params',$params);
            if($params->_get('phones')) {
                $this->setVar('phones', explode(',', $params->_get('phones', '', $this->getCurrentLangID())));
            }

			if ($width = $params->_get('width'))
				$this->setVar('vkwidth', $width);
			if ($height = $params->_get('height'))
				$this->setVar('vkheight', $height);
			if ($id = $params->_get('id'))
				$this->setVar('vkid', $id);
            if ($params->_get('showcallback'))
                $this->setVar('showcallback', $params->_get('showcallback'));
            if($params->_get('workhours')) {
                $this->setVar('workhours', explode(',', $params->_get('workhours', '', $this->getCurrentLangID())));
            }
        }
        $this->setVar('hash', $this->hash());
        if($this->getCurrentUser()) {
            $this->setVar('user',$this->getCurrentUser());
        }
        $this->setVar('search', $this->request('s', ''));
    }
}