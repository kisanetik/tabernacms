<?php
/**
 * Search form
 */
class controller_resource_searchform extends rad_controller
{
	function __construct()
	{
		if ($this->getParamsObject()) {
			$params = $this->getParamsObject();
			$params->substring_checkbox = rad_config::getParam('sphinx.on') && (rad_config::getParam('sphinx.substring_search')=='allow');
			$params->substring_checked = $params->substring_checkbox && $this->get('ss');
			$this->setVar('search', $this->request('s', ''));
			$this->setVar('params', $params);
		}
	}
}