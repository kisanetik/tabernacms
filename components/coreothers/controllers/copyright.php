<?php
/**
 * For the bottom of the site
 * Copyrights here, banners, counters and link to the expertplus
 * @author Denys Yackushev
 * @version 0.1
 * @pachage Taberna
 */
class controller_coreothers_copyright extends rad_controller
{
    
    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $params->copyright_main = $this->_parseDates( $params->copyright_main );
            $this->setVar('params', $params);
        }
    }//constructor
    
    /**
     * Parse and replace date tags
     *
     */
    private function _parseDates($str)
    {
        $str_b = stristr($str,'<%start_dates=');
        if($str_b) {
            $start_date = '';
            $beg = false;
            for($i=0;$i<strlen($str_b);$i++) {
                $start_date.=($beg)?$str_b[$i]:'';
                if($str_b[$i]=='=') {
                    $beg = true;
                }
                if($str_b[$i+1].$str_b[$i+2]=='%>') {
                    break;
                }
            }
            if( ((string)date("Y")) == ((string)$start_date)) {
                return str_replace('<%start_dates='.$start_date.'%>', $start_date, $str);
            } else {
                return str_replace('<%start_dates='.$start_date.'%>', $start_date.' - '.(string)date("Y") ,$str);
            }
        }
        return $str;
    }
}//class