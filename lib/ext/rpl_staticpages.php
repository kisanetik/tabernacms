<?php
/*
 * Plugin for parsing and genere get string
 * @package RADCMS
 * @author Denys Yackushev
 */

class rpl_staticpages
{

    public $get = NULL;
    private $_pv_separator = '.';
    private $_p_separator = '+';
    private $_ending = '.html';

    function __construct()
    {
    }

    private function addToRes($s,&$result)
    {
        if(strstr($s,$this->_pv_separator)) {
            $r = explode($this->_pv_separator,$s);
            if(strlen($r[0]) and count($r)>=2 and strlen($r[1])) {
                $result[$r[0]] = $r[1];
            }
        } else {
            if(strlen($s)) {
                $result[$s] = '';
            }
        }
    }

    public function parse_string($query_string,$get)
    {
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
        if(isset($get['alias'])) {
            $result['alias'] = $get['alias'];
        }
        if(strstr($query_string,'/')) {
            $qs = str_replace($result['alias'].'/','',$query_string);
            if(strstr($qs,'/')) {
                $r = explode('/',$qs);
                if($r[0]!='search') {
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
        }
        if(!count($result)) {
            $result = NULL;
        }
        if(!empty($result)) {
        	foreach($result as $key=>$value) {
        		if(!is_array($value)) {
        			$result[$key] = urldecode($value);
        		}
        	}
        }
        $this->get = $result;
    }

    /**
     * Makes the correct url from string to work with the access
     * @param array mixed get
     * @return string
     */
    public function makeurl($get=array())
    {
        if(rad_config::getParam('lang.location_show')) {
            $string = SITE_URL.rad_lang::getCurrentLanguage().'/'.$get['alias'].'/';
        } else {
            $string = SITE_URL.$get['alias'].'/';
        }
        $i=0;
        $c_get = count($get);
        if($c_get) {
            foreach($get as $paramname=>$paramvalue) {
                if( ($paramname!='alias') and ($paramname!='search')) {
                    if($i) {
                        $string .= $this->_p_separator;
                    }
                    $string .= $paramname.$this->_pv_separator.$paramvalue;
                    $i++;
                }
            }
            if($i) {
                $string.=$this->_ending;
            } else {
                $string.='index'.$this->_ending;
            }
        }
        return $string;
    }

    /**
     * Just for avalibility
     */
    public function clearState()
    {

    }
}//class
