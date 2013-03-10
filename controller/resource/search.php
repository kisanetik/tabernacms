<?php
/**
 * Search result
 */
class controller_resource_search extends rad_controller
{
	/**
	 * Which search system will be used
	 * @var string
	 */
	private $_searchsystem = 'sphinx';

	protected $_itemsPerPage = 10;

	function __construct()
	{
		if ($this->request('send'))
			$this->redirect($this->makeURL('alias=search&s=' . urlencode($this->request('search'))));

		if ($this->getParamsObject()) {
			$params = $this->getParamsObject();
			$this->_searchsystem = $params->_get('searchsystem', $this->_searchsystem);
			$this->setVar('params', $params);
		}

		$this->setVar('search_results', array());

		$searchPhrase = $this->request('s', '');
		$this->setVar('search_str', $searchPhrase);
		$this->setVar('gp', 's=' . urlencode($searchPhrase));

		$page = ($page = (int)$this->request('p')) ? $page : 0;

		if (!empty($this->_searchsystem)) {

			$this->setVar('searchsystem', $this->_searchsystem);

			$searchModel = rad_instances::get('model_resource_search');
			$searchModel->setState('search_str', $searchPhrase);
			$searchModel->setState('search_system', $this->_searchsystem);
			$searchModel->setState('limit', array($page * $this->_itemsPerPage, $this->_itemsPerPage));

			switch ($this->_searchsystem) {
				case 'sphinx':
					$searchEntities = rad_config::getParam('sphinx.entities', 'catalog|news|pages|articles');
					$searchModel->setState('search_entities', explode('|', $searchEntities));
					break;
				case 'google':
					$searchModel->setState('search_host', 'www.tabernacms.com');
					$searchModel->setState('page', $page);
					break;
				case 'yandex':
					$searchModel->setState('search_host', 'www.tabernacms.com');
					$searchModel->setState('user', 'for-xml-games');
					$searchModel->setState('key', '03.97744150:aef43f4caddbb7874f3f626af7351497');
					$searchModel->setState('page', $page);
					break;
			}

			$this->setVar('search_results', $searchModel->getSearchResult());

			if ($searchResultCount = $searchModel->getSearchResultCount()) {
				$pages = div((int)$searchResultCount, $this->_itemsPerPage);
				$pages += (mod($searchResultCount, $this->_itemsPerPage)) ? 1 : 0;
				$this->setVar('pages_count', $pages + 1);
				$this->setVar('page', $page + 1);
				$this->setVar('currPage', (int)$this->request('p', $page));
			} else {
				$this->setVar('pages_count', 0);
				$this->setVar('page', 1);
				$this->setVar('currPage', (int)$this->request('p', 0));
			}
		}
	}

}