<?php
/**
 * Search model
 * @author Vycheslav Panevskii
 * @package Taberna
 */
class model_coreresource_search extends rad_model
{
    protected $_searchResultCount = 0;

    private $entities = array(
        0 => 'pages',
        1 => 'articles',
        2 => 'news',
        3 => 'catalog'
    );

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
                $this->_searchResultCount = count($sphinxResult);
                $sphinxResult = array_slice($sphinxResult, $offset, $limit);

                $sortedCompoundsId = array();
                $prepareDataIdGroups = array();
                foreach($sphinxResult as $item) {
                    $sortedCompoundsId[$item['type'].'_'.$item['id']] = array();
                    $prepareDataIdGroups[$item['type']][] = $item['id'];
                }

                $searchResults = $this->getMysqlDataByIds($prepareDataIdGroups);
                if ($searchResults) {
                    foreach($searchResults as $searchItem){
                        $sortedCompoundsId[$searchItem['entety_type'].'_'.$searchItem['id']] = $searchItem;
                    }
                }
                return $sortedCompoundsId;
                break;
            case 'mysql':
                return $this->getMysqlData($this->getState('search_str', ''), $offset, $limit);
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

    private function getFirstWords($s)
    {
        if (preg_match('/^([^ ,.!?]+)([, ]*)([^ ,.!?]*)/', $s, $arr)) {
            return array($arr[1], ((mb_strlen($arr[3]) < 3) ? false : $arr[3]));
        }
        return false;
    }

    private function getNormalizedString($s, $autocomplete=false)
    {
        $sphinx = rad_shpinx::getInstance()->getSpinx();
        $kwords = $sphinx->buildKeywords($s, 'taberna_index', false);
        if (!empty($kwords)) {
            foreach ($kwords as $kword) {
                if ($autocomplete) {
                    $normalized_words[] = ($kword['normalized'] == $kword['tokenized']) ? $kword['normalized'] : $kword['normalized'].'*';
                    $this->normalized_variants[] = $kword['normalized'];
                }
                else {
                    $normalized_words[] = ($kword['normalized'] == $kword['tokenized']) ? $kword['normalized'] : '('.$kword['tokenized'].'|'.$kword['normalized'].'*)';
                }
            }
            $result = implode(' ', $normalized_words);
            if ($autocomplete) {
                if (mb_substr($result, -1) != '*') {
                    $result.= '*';
                }
            }
            return $result;
        }
        return $s;
    }

    private function setSphinxFilters()
    {
        $sphinx = rad_shpinx::getInstance()->getSpinx();
        $sphinx->SetFilter('lang_id', array($this->getState('lang_id')));
        $search_entities = $this->getState('search_entities');
        if (!empty($search_entities)) {
            $intersect = array_intersect($this->entities, $search_entities);
            if (!empty($intersect) && (count($intersect) < count($this->entities))) {
                $sphinx->SetFilter('type', array_keys($intersect));
            }
        }
    }

    public function getAutocompleteJSON()
    {
        if ($this->getState('search_system') == 'sphinx') {
            $sphinx = rad_shpinx::getInstance()->getSpinx();
            $sphinx->SetConnectTimeout(1);
            $sphinx->SetArrayResult(false);
            $this->setSphinxFilters();
            mb_internal_encoding('UTF-8');

            $term = trim(str_replace('%20', ' ', $this->getState('search_str')));
            $term = $this->getNormalizedString($term, true);

            if ($results = $sphinx->Query('@(title,shortdesc) "'.$term.'"', 'taberna_index')) {
                $kwords = array();
                if (!empty($results['matches'])) {
                    foreach ($results['matches'] as $row) {
                        $title = mb_strtolower($row['attrs']['title']);
                        $shortdesc = mb_strtolower(strip_tags($row['attrs']['shortdesc']));
                        $result = array();
                        $extra_word = '';
                        foreach ($this->normalized_variants as $kword) {
                            if (($pos = mb_strpos($title, $kword)) !== false) {
                                list($word, $extra_word) = $this->getFirstWords(mb_substr($row['attrs']['title'], $pos));
                                if ($word) {
                                    $result[] = $word;
                                }
                            }
                            elseif (($pos = mb_strpos($shortdesc, $kword)) !== false) {
                                list($word, $extra_word) = $this->getFirstWords(mb_substr(strip_tags($row['attrs']['shortdesc']), $pos));
                                if ($word) {
                                    $result[] = $word;
                                }
                            }
                        }
                        if (!empty($result)) {
                            $kword = implode(' ', $result).($extra_word ? ' '.$extra_word : '');
                            $kwords[ mb_strtolower($kword) ] = $kword;
                        }
                    }
                    ksort($kwords);
                }
                return json_encode(array_values($kwords));
            }
        }
        return false;
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

    private function getSearchStringForSphinx($s)
    {
        if ($this->getState('substring_mode')) {
            $s = preg_replace('/([^\s])([|&])([^\s])/', '$1 $2 $3', preg_replace('/\s+/', '  ', $s));
            return preg_replace('#(^| |!|-)([^!*\s|&-][^*\s|&]*)( |$)#', '$1($2|*$2*)$3', $s);
        }
        return $this->getNormalizedString($s);
    }

    protected function _getIdsFromSphinx($searchString = '')
    {
        $sphinx = rad_shpinx::getInstance()->getSpinx();
        /** @var SphinxClient $sphinx */
        $this->setSphinxFilters();
        $searchString = $this->getSearchStringForSphinx($searchString);
        $result = array();

        $sphinx->SetFieldWeights(array('title' => 70, 'shortdesc' => 20, 'fulldesc' => 10));
        $resultData = $sphinx->Query($searchString, 'taberna_index');
        if ($resultData['error']) {
            throw new Exception('Sphinx error: '.$resultData['error']);
        }
        if (!empty($resultData['matches'])) {
            foreach ($resultData['matches'] as $match) {
                $row = $match['attrs'];
                $row['type'] = $this->entities[ $row['type'] ];
                $result[] = $row;
            }
        }
        return $result;
    }

    private function getMysqlDataByIds($prepareDataIdGroups)
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
                    ".RAD."catalog
                    LEFT JOIN ".RAD."cat_images as images on images.img_cat_id = cat_id and images.img_main = 1
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
                    ".RAD."news
                WHERE
                    nw_id IN (".implode(',', $prepareDataIdGroups['news']).")";
        }
        if (isset($prepareDataIdGroups['pages'])) {
            $sql[] = "SELECT
                    'pages' as entety_type,
                    pg_id as id,
                    pg_title as title,
                    pg_shortdesc as shortdesc,
                    pg_fulldesc as fulldesc,
                    pg_img as image
                FROM
                    ".RAD."pages
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
                    ".RAD."articles
                WHERE
                    art_id IN (".implode(',', $prepareDataIdGroups['articles']).")";
        }
        return $this->queryAll(implode(' UNION ', $sql));
    }

    private function getSqlWhereForKeywords($search_fields, $keywords_types)
    {
        $terms = array();
        foreach ($keywords_types as $key=>$exclude) {
            $terms[] = "(CONCAT_WS(' ',".$search_fields.')'.($exclude ? ' NOT' : '').' REGEXP :'.$key.')';
            if (count($terms) == 10) break;
        }
        return implode(' AND ', $terms);
    }

    private function getMysqlData($query, $offset, $limit)
    {
        $keywords = preg_split('/[,.;\s\\[\\]]+/', trim($query), 0, PREG_SPLIT_NO_EMPTY);
        if (!count($keywords)) {
            return array();
        }
        $params = array(
            'lang_id' => $this->getState('lang_id')
        );
        $keywords_types = array();
        foreach ($keywords as $i=>$keyword) {
            $keywords_types['keyword'.$i] = (strpos($keyword, '!') === 0); // include or exclude
            $params['keyword'.$i] = '[[:<:]]'.trim($keyword, '!');
        }
        $rows = $this->queryAll("
            (
                SELECT SQL_CALC_FOUND_ROWS 'catalog' AS entety_type, cat_id AS id, cat_name AS title, cat_shortdesc AS shortdesc, cat_fulldesc AS fulldesc, images.img_filename AS image
                FROM ".RAD."catalog
                LEFT JOIN ".RAD."cat_images as images on images.img_cat_id = cat_id and images.img_main = 1
                WHERE cat_active=1 AND cat_lngid=:lang_id AND ".$this->getSqlWhereForKeywords('cat_name, cat_shortdesc, cat_fulldesc', $keywords_types)."
            )
            UNION (
                SELECT 'news' AS entety_type, nw_id AS id, nw_title AS title, nw_shortdesc AS shortdesc, nw_fulldesc AS fulldesc, '' AS image
                FROM ".RAD."news
                WHERE nw_active=1 AND nw_langid=:lang_id AND ".$this->getSqlWhereForKeywords('nw_title, nw_shortdesc, nw_fulldesc', $keywords_types)."
            )
            UNION (
                SELECT 'articles' AS entety_type, art_id AS id, art_title AS title, art_shortdesc AS shortdesc, art_fulldesc AS fulldesc, '' AS image
                FROM ".RAD."articles
                WHERE art_active=1 AND art_langid=:lang_id AND ".$this->getSqlWhereForKeywords('art_title, art_shortdesc, art_fulldesc', $keywords_types)."
            )
            UNION (
                SELECT 'pages' AS entety_type, pg_id AS id, pg_title AS title, pg_shortdesc AS shortdesc, pg_fulldesc AS fulldesc, '' AS image
                FROM ".RAD."pages
                WHERE pg_active=1 AND pg_langid=:lang_id AND ".$this->getSqlWhereForKeywords('pg_title, pg_shortdesc, pg_fulldesc', $keywords_types)."
            )
            LIMIT ".intval($offset).','.intval($limit),
            $params
        );
        $found_rows = $this->query('SELECT FOUND_ROWS() AS c');
        $this->_searchResultCount = $found_rows['c'];
        $result = array();
        if ($rows) {
            foreach($rows as $row){
                $result[ $row['entety_type'].'_'.$row['id'] ] = $row;
            }
        }
        return $result;
    }

    public function getSearchResultCount()
    {
        return (int)$this->_searchResultCount;
    }
}