<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 1
 * Date: 20.08.13
 * Time: 16:39
 * To change this template use File | Settings | File Templates.
 */

class rpl_base {
    /**
     * @var array Parsed params array
     */
    public $get = NULL;

    /**
     * @var string Separates parameter and parameter value
     */
    protected $_pv_separator = '~';
    /**
     * @var string Separates parameter-value pairs
     */
    protected $_p_separator = '^';
    /**
     * @var string Emultase file extension, thus ending the combined URL.
     */
    protected $_ending = '.html';

    function __construct() {}

    protected final function _repChars($str, $back = false)
    {
        if ($back) {
            return str_replace('/', '&#8260;', $str);
        }
        return str_replace(array('&#8260;', '?'), '/', $str);
    }

    /**
     * Parse the special slash-delimited part of request URI (after the alias). For example, in the the URI
     * http://demo.tabernaecommerce.test/ru/catalog/59/filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html?umc=17
     * - it would be /59/.
     * @param array $request Plain array of all slash-delimited parts of URI. In the example above it would be:
     * array('59', 'filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html').
     * All the parsed params should be removed from the array using array_shift, unset etc.
     * @param array $result Associative array of parsed params to be updated. No need to do URLDecode - it would be made later!
     */
    protected function _parseRequestMiddle(&$request, &$result){
    }

    /**
     * Parse the remaining (common) part of request URI with compressed params. For example, in the the URI
     * http://demo.tabernaecommerce.test/ru/catalog/59/filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html?umc=17
     * - it would be /filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html
     * @param string $requestString The remaining, not parsed, part of URI. In the example above it would be:
     * 'filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67'
     * @param array $result Associative array of parsed params to be updated. No need to do URLDecode - it would be made later!
     */
    protected function _parseRequestEnd($requestString, &$result){
        $p = explode($this->_p_separator, $requestString);
        foreach($p as $param) {
            $r = explode($this->_pv_separator, $param);
            if (strlen($r[0])) {
                if (count($r) == 1) {
                    $result[$r[0]] = '';
                } else {
                    $pos = strpos($r[0], '[');
                    if ($pos !== FALSE) {
                        $getKey = substr($r[0], 0, $pos);
                        $getVal = substr($r[0], $pos+1, -1);
                        $result[$this->_repChars($getKey)][$this->_repChars($getVal)] = $this->_repChars($r[1]);
                    } else {
                        $result[$this->_repChars($r[0])] = $this->_repChars($r[1]);
                    }
                }
            }
        }
    }

    /**
     * Parse the query string part of request URI. For example, in the the URI
     * http://demo.tabernaecommerce.test/ru/catalog/59/filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html?umc=17
     * - it would be ?umc=17
     * @param array $query Associative array with parsed query string variables. In the example above it would be:
     * array('umc' => '17')
     * @param array $result Associative array of parsed params to be updated. No need to do URLDecode - it would be made later!
     */
    protected function _parseQuery($query, &$result){
    }

    /**
     * Makes the correct param array from parsed URI, reparsing it.
     * It is not recommended overriding the function. Override protected _parse*() instead.
     * @param array $request_array Plain array of slash-separated URI parts
     * @param array $query_array Associative array of query string variables
     * @param array $get Parsed $GET array from the internal parser (used mostly to retrieve alias name)
     */
    public final function parse_string($request_array, $query_array, $get)
    {
        $result = array();
        if (empty($request_array) && !empty($get)) {
            $result = $get;
        } else {
            if (isset($get['alias'])) {
                $result['alias'] = $get['alias'];
            }

            $this->_parseRequestMiddle($request_array, $result);
            $qs = implode('/', $request_array);
            $qs = cutOffEnd($qs, $this->_ending);
            $this->_parseRequestEnd($qs, $result);

            foreach($result as $key=>$value) {
                if(!is_array($value)) {
                    $result[$key] = urldecode($value);
                }
            }
        }
        $this->_parseQuery($query_array, $result);

        $this->get = $result ?: NULL;
    }

    /**
     * Construct the special slash-delimited part of request URI (after the alias). For example, in the the URI
     * http://demo.tabernaecommerce.test/ru/catalog/59/filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html?umc=17
     * - it would be 59/ (with the trailing slash).
     * All the processed params should be removed from the array using unset etc.
     * @param array $get Parsed $GET array
     * @return string Middle (slash-delimited) part of URL, after the alias name.
     */
    protected function _makeUrlMiddle(&$get){
        return '';
    }

    /**
     * Construct the remaining (common) part of request URI with compressed params. For example, in the the URI
     * http://demo.tabernaecommerce.test/ru/catalog/59/filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67.html?umc=17
     * - it would be filter~1^vv[4]~8192^vv[3]~0^vv[2]~классический^costfrom~13411^costto~19022.67 (without ending .html or whatever)
     * @param array $get Parsed $GET array
     * @return string End
     */
    protected function _makeUrlEnd(&$get){
        $s = false;
        $string = '';

        foreach($get as $paramname => $paramvalue) {
            if (!strlen($paramname)) continue;
            if ($s) {
                $string .= $this->_p_separator;
            }
            $string .= $this->_repChars($paramname, true).$this->_pv_separator.$this->_repChars($paramvalue, true);
            $s = true;
        }

        return $string;
    }

    /**
     * Makes the correct url from string to work with the access
     * It is not recommended overriding the function. Override protected _makeUrl*() instead.
     * @param array $get Parsed $GET array
     * @return string Full URI generated
     */
    public final function makeurl($get = array())
    {
        $string = SITE_URL;
        if (rad_config::getParam('lang.location_show')) {
            $string .= rad_lang::getCurrentLanguage().'/';
        }
        $string .= $get['alias'].'/';
        unset($get['alias']);

        $string .= $this->_makeUrlMiddle($get);
        $string .= $this->_makeUrlEnd($get);

        if (substr($string, -1) == '/') {
            $string .= 'index'.$this->_ending;
        } else {
            $string .= $this->_ending;
        }

        return $string;
    }

    public function clearState() {} //It has to be implemented since it's used by rad_instances
}