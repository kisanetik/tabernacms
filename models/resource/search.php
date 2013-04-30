<?php
/**
 * Search model
 * @author Vycheslav Panevskii
 * @package Taberna
 */
class model_resource_search extends rad_model
{
	protected $_searchResultCount = 0;

	public function getSearchResult()
	{
		$searchSystem = $this->getState('search_system');

		list($offset, $limit) = $this->getState('limit', array(0, 10));
		$offset = ($offset == 0) ? $offset : $offset - 1;

		switch($searchSystem) {
			case 'sphinx':
				$sphinxResult = $this->_getIdsFromSphinx($this->getState('search_str', ''));
				if (!count($sphinxResult)) {
					return array();
				}
				usort($sphinxResult, array("model_resource_search", "arraySortCallback"));
				$this->_searchResultCount = count($sphinxResult);
				$sphinxResult = array_slice($sphinxResult, $offset, $limit);

				$sortedCompoundsId = array();
				$prepareDataIdGroups = array();
				foreach($sphinxResult as $item) {
					$sortedCompoundsId[$item['type'].'_'.$item['id']] = array();
					$prepareDataIdGroups[$item['type']][] = $item['id'];
				}

				$searchResults = $this->_getMysqlData($prepareDataIdGroups);
				if ($searchResults) {
					foreach($searchResults as $searchItem){
						$sortedCompoundsId[$searchItem['entety_type'].'_'.$searchItem['id']] = $searchItem;
					}
				}
				return $sortedCompoundsId;
				break;
			case 'yandex':
				$host = htmlspecialchars(trim($this->getState('search_host')));
				/**
				if (strpos($host, 'www.') !== 0)
					$host = 'www.'.$host;
				*/
				$host = htmlspecialchars(" host:$host");

				$user = $this->getState('user');
				$key = $this->getState('key');

				$yandexResult = $this->_getYandexData($this->getState('search_str', ''), $host, $user, $key, (int)$this->getState('page'));

				return $yandexResult;
				break;
			case 'google':
				$host = htmlspecialchars(trim($this->getState('search_host')));
				/**
				if (strpos($host, 'www.') !== 0)
					$host = 'www.'.$host;
                */
				$googleResult = $this->_getGoogleData($this->getState('search_str', ''), $host, (int)$this->getState('page'));

				return $googleResult;
				break;
		}
		return array();
	}

	protected function _getGoogleData($searchString, $host, $page = 0)
	{
		$result = array();
		$url = 'https://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start='.$page.'&q='.urlencode($searchString.' site:'.$host);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_REFERER, $host);
		$body = curl_exec($ch);
		curl_close($ch);

		$response = json_decode($body);

		if (!isset($response->responseData->cursor->estimatedResultCount) or empty($response->responseData->cursor->estimatedResultCount)) {
			return $result;
		}
		$this->_searchResultCount = $response->responseData->cursor->estimatedResultCount;
		$items = $response->responseData->results;

		if (!empty($items)) {
			foreach($items as $item) {
				$result[] = array(
					'url' => $item->unescapedUrl,
					'title' => $item->title,
					'shortdesc' => $item->content
				);
			}
		}
		return $result;
	}

	protected function _getYandexData($searchString, $host, $user, $key, $page = 0)
	{
		$result = array();

		$url = 'http://xmlsearch.yandex.ru/xmlsearch?user='.$user.'&key='.$key;

		$doc = <<<DOC
<?xml version='1.0' encoding='utf-8'?>
<request>
    <query>$searchString $host</query>

    <groupings>
        <groupby attr="" mode="flat" groups-on-page="10"  docs-in-group="1" />
    </groupings>

    <page>$page</page>
</request>
DOC;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, $host);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/xml", "Content-length: ".strlen($doc)));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $doc);
		$response = curl_exec($ch);
		curl_close($ch);

		if (!$response) {
			return $result;
		}

		$xmldoc = new SimpleXMLElement($response);

		if ($xmldoc->response->error) {
			return $result;
		}

		if (!isset($xmldoc->response->found) or empty($xmldoc->response->found)) {
			return $result;
		}

		$this->_searchResultCount = $xmldoc->response->found;

		$items = $xmldoc->xpath("response/results/grouping/group/doc");


		if (!empty($items)) {
			foreach($items as $item){
				$result[] = array(
					'url' => $item->url,
					'title' => $item->title,
					'shortdesc' => $item->passages->passage
				);
			}
		}
		return $result;
	}

	protected function _getIdsFromSphinx($searchString = '')
	{
		$sphinx = rad_shpinx::getInstance()->getSpinx();
		/** @var SphinxClient $sphinx */
		$result = array();

		if (in_array('catalog', $this->getState('search_entities'))) {
			$sphinx->SetFieldWeights(array('cat_name' => 70, 'cat_shortdesc' => 20, 'cat_fulldesc' => 10));
			$result = array();
			$resultData = $sphinx->Query($searchString, 'catalog');
			if ($resultData['error']) {
				throw new Exception('Sphinx error: '.$resultData['error']);
			}
			$result = $this->_fetchResults($resultData, $result, 'catalog');
		}

		if (in_array('news', $this->getState('search_entities'))) {
			$sphinx->SetFieldWeights(array('nw_title' => 70, 'nw_shortdesc' => 20, 'nw_fulldesc' => 10));
			$resultData = $sphinx->Query($searchString, 'news');
			if ($resultData['error']) {
				throw new Exception('Sphinx error: '.$resultData['error']);
			}
			$result = $this->_fetchResults($resultData, $result, 'news');
		}

		if (in_array('pages', $this->getState('search_entities'))) {
			$sphinx->SetFieldWeights(array('pg_title' => 70, 'pg_shortdesc' => 20, 'pg_fulldesc' => 10));
			$resultData = $sphinx->Query($searchString, 'pages');
			if ($resultData['error']) {
				throw new Exception('Sphinx error: '.$resultData['error']);
			}
			$result = $this->_fetchResults($resultData, $result, 'pages');
		}


		if (in_array('articles', $this->getState('search_entities'))) {
			$sphinx->SetFieldWeights(array('art_title' => 70, 'art_shortdesc' => 20, 'art_fulldesc' => 10));
			$resultData = $sphinx->Query($searchString, 'articles');
			if ($resultData['error']) {
				throw new Exception('Sphinx error: '.$resultData['error']);
			}
			$result = $this->_fetchResults($resultData, $result, 'articles');
		}
		return $result;
	}

	protected function _fetchResults($resultData, $result, $type)
	{
		if (isset($resultData['matches'])) {
			foreach($resultData['matches'] as $id => $item) {
				$result[] = array(
					'id' => $id,
					'weight' => $item['weight'],
					'type' => $type
				);
			}
		}
		return $result;
	}

	protected function _getMysqlData($prepareDataIdGroups)
	{
		$sql = array();
		if (isset($prepareDataIdGroups['catalog'])) {
			$sql[] = "SELECT
                    'catalog' as entety_type,
                    cat_id as id,
                    cat_name as title,
                    cat_shortdesc as shortdesc,
                    cat_fulldesc as fulldesc,
                    images.img_filename as image
                FROM
                    rad_catalog
                    LEFT JOIN rad_cat_images as images on images.img_cat_id = cat_id and images.img_main = 1
                WHERE
                    cat_id IN (".implode(', ', $prepareDataIdGroups['catalog']).")";
		}
		if (isset($prepareDataIdGroups['news'])) {
			$sql[] = "SELECT
                    'news' as entety_type,
                    nw_id as id,
                    nw_title as title,
                    nw_shortdesc  as shortdesc,
                    nw_fulldesc as fulldesc,
                    nw_img as image
                FROM
                    rad_news
                WHERE
                    nw_id IN (".implode(',', $prepareDataIdGroups['news']).")";
		}
		if (isset($prepareDataIdGroups['pages'])) {
			$sql[] = "SELECT
                    'pages' as entety_type,
                    pg_id as id,
                    pg_title as tirle,
                    pg_shortdesc as shortdesc,
                    pg_fulldesc as fulldesc,
                    pg_img as image
                FROM
                    rad_pages
                WHERE
                    pg_id IN (".implode(',', $prepareDataIdGroups['pages']).")";
		}
		if (isset($prepareDataIdGroups['articles'])) {
			$sql[] = "SELECT
                    'articles' as entety_type,
                    art_id as id,
                    art_title as title,
                    art_shortdesc as shortdesc,
                    art_fulldesc as fulldesc,
                    art_img as image
                FROM
                    rad_articles
                WHERE
                    art_id IN (".implode(',', $prepareDataIdGroups['articles']).")";
		}
		return $this->queryAll(implode(' UNION ', $sql));
	}

	public static function arraySortCallback($a, $b)
	{
		return $a['weight'] < $b['weight'];
	}

	public function getSearchResultCount()
	{
		return (int)$this->_searchResultCount;
	}
}