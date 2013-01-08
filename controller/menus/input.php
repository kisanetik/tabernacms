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
            $this->setVar('params',$this->getParamsObject());
            if($this->getParamsObject()->_get('phones')) {
                $this->setVar('phones', explode(',', $this->getParamsObject()->_get('phones', '', $this->getCurrentLangID())));
            }
        }
        if($this->getCurrentUser()) {
            $this->setVar('user',$this->getCurrentUser());
        }
    }
}