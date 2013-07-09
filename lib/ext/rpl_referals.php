<?php
/*
 * Plugin for parsing and genere get string
 * @package RADCMS
 * @author Denys Yackushev
 */

class rpl_referals
{

    public $get = NULL;
    private $_pv_separator = '|';
    private $_p_separator = '.';
    private $_ending = '.html';

    function __construct()
    {
    }

    private function _repChars($str, $back = false)
    {
        if($back) {
            return str_replace('/', '&#8260;', $str);
        }
        return str_replace('&#8260;', '/', str_replace('⁄', '/', $str));
    }

    private function addToRes($s,&$result)
    {
        if(strstr($s,$this->_pv_separator)) {
            $r = explode($this->_pv_separator,$s);
            if(strlen($r[0]) and count($r)>=2 and strlen($r[1])) {
                if(strpos($r[0], '[')) {
                    $getKey = substr($r[0], 0, strpos($r[0], '['));
                    $i= strpos($r[0], '[')+1;
                    $getVal = '';
                    while($i<count($r[0])-1 and $r[0][$i]!=']') {
                        $getVal .= $r[0][$i];
                        $i++;
                    }
                    $getVal = substr($r[0], strpos($r[0], '[')+1, -1);
                    $result[$this->_repChars($getKey)][$this->_repChars($getVal)] = $this->_repChars($r[1]);
                } else {
                    $result[$this->_repChars($r[0])] = $this->_repChars($r[1]);
                }
            }
        } else {
            if(strlen($s)) {
                $result[$s] = '';
            }
        }
    }

    public function parse_string($query_string,$get)
    {
        //$query_string=urldecode(substr($query_string,strlen(rad_config::getParam('folder'))));

        if(rad_config::getParam('lang.location_show')) {
            $lngCode = '';
            for($i=0;$i<strlen($query_string);$i++) {
                if($query_string[$i]!='/') {
                    $lngCode .= $query_string[$i];
                } else {
                    break;
                }
            }
            rad_lang::setGetLngCode($lngCode);
            $query_string = substr($query_string, strlen($lngCode.'/'));
        }
        $result = array();
        $query_string=urldecode($query_string);
        if(isset($get['alias'])) {
            $result['alias'] = $get['alias'];
        }
        if(substr($query_string, (-1*strlen($this->_ending)))==$this->_ending) {
            $query_string = substr($query_string, 0, (-1*strlen($this->_ending)));
        }
        if(strstr($query_string,'/')) {
            $qs = str_replace($result['alias'].'/','',$query_string);
            if(mb_strlen($qs) > 1 and $qs[0]=='0') {//Just User.ID
                $result['user_id'] = (int)$qs;
            }
            /*
            if(strstr($qs,'/')) {
                $r = explode('/',$qs);
                if($r[0]!='search') {
                    $result['cat'] = (int)$r[0];
                    $qs = $r[1];
                    unset($r);
                } else {
                    $result['search'] = $r[1];
                    $qs = '';
                    if( (count($r)>2 and ($r[2]!='')) ) {
                        for($i=2;$i<(count($r));$i++)
                          $qs .= $r[$i].'/';
                    }
                    unset($r);
                }
            }
            if(strstr($qs,$this->_p_separator)) {
                $r = explode($this->_p_separator,$qs);
                foreach($r as $id) {
                    $this->addToRes($id, $result);
                }
            } else {
                $this->addToRes($qs, $result);
            }
            */
        }
        if(!count($result)) {
            $result = NULL;
        }
        $this->get = $result;
    }

    /**
     * Makes the correct url from string to work with the access
     * @param array mixed get
     * @return string
     */
    public function makeurl($get='')
    {
        if(rad_config::getParam('lang.location_show')) {
            $string = SITE_URL.rad_lang::getCurrentLanguage().'/'.$get['alias'].'/';
        } else {
            $string = SITE_URL.$get['alias'].'/';
        }
        if(!isset($get['user_id']) and !isset($get['id']) and !isset($get['type'])) {
            return $string.$this->_ending;
        }
        if(!isset($get['type'])) {
            throw new rad_exception('Not enouph actual params "type"');
        }
        if(!isset($get['user_id'])) {
            throw new rad_exception('Not enouph actual params "user_id"');
        }
        if(!isset($get['id']) and $get['type']!==model_coresession_referals::TYPE_INDEX) {
            throw new rad_exception('Not enouph actual params "id"');
        }
        switch($get['type']) {
            case model_coresession_referals::TYPE_INDEX:
                $string .= '0'.(int)$get['user_id'];
                break;
            case model_coresession_referals::TYPE_ARTICLE:
                $string .= (int)$get['user_id'].$this->_p_separator.'a'.(int)$get['id'].$this->_ending;
                break;
            case model_coresession_referals::TYPE_CATALOG:
                $string .= (int)$get['user_id'].$this->_p_separator.'c'.(int)$get['id'].$this->_ending;
                break;
            case model_coresession_referals::TYPE_NEWS:
                $string .= (int)$get['user_id'].$this->_p_separator.'n'.(int)$get['id'].$this->_ending;
                break;
            case model_coresession_referals::TYPE_PAGE:
                $string .= (int)$get['user_id'].$this->_p_separator.'s'.(int)$get['id'].$this->_ending;
                break;
            case model_coresession_referals::TYPE_PRODUCT:
                $string .= (int)$get['user_id'].$this->_p_separator.'p'.(int)$get['id'].$this->_ending;
                break;
            default:
                throw new rad_exception('Unknown type "'.$get['type'].'" for genering reflink!');
                break;
        }
        unset($get['id'],$get['user_id'],$get['type'],$get['alias']);
        $i=0;
        $c_get = count($get);
        if($c_get) {
            foreach($get as $paramname=>$paramvalue) {
                if( ($paramname!='ralias') and !empty($paramname)) {
                    if($i) {
                        $string .= $this->_p_separator;
                    }
                    $string .= $this->_repChars($paramname, true).$this->_pv_separator.$this->_repChars($paramvalue, true);
                    $i++;
                }
            }
        }
        $string .= $this->_ending;
        return $string;
    }

    /**
     * Just for avalibility
     */
    public function clearState()
    {

    }
}//class
