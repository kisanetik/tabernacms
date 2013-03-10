<?php
/**
 * Function for paging
 *
 * @param from (int) - counter from, usually 1 (For starting count 1,2,3,4,5 - page)
 * @param to (int) - counter ending , usually $items_count
 * @param $curpage (int) - current page to show the current class for text
 * @param step (int) - step in cycle, usually 1 and default=1
 * @param maxshow (int) - maximum show counts of pages, usually from 3 to 5, default=5
 * @param showsteps (boolean) - Show links next and prev or not, default=false
 * @param showfirst (boolean) - Show link to first element, or not, default=false
 * @param showlast (boolean) - Show link to last element, or not, default=false
 * @param show_long_listing (boolean) - Show long listing with goto page ($currpage+$maxshow+1);
 * @param $first_title_text (string) - Text in link to first element, default rad_lang::lang('-first');
 * @param $last_title_text (string) - Text in link to first element, default rad_lang::lang('-last');
 * @param $next_title_text (string) - Text in link to first element, default rad_lang::lang('-next');
 * @param $prev_title_text (string) - Text in link to first element, default rad_lang::lang('-prev');
 * @param $long_listing_text (string) - Text in link to long listing
 * @param $num_delimiter (string) - delimiter in numbers, usually &nbsp; or |, default &nbsp;
 * @param $alias (string) - alias in link href, default SITE_ALIAS
 * @param $GET (string) - other get params (cat=54&param1=value2&param2=value2)
 * @param $page_varname (string) - var name of page param, usually p
 * @param $bothldelimiter (string) - left delimiter (is need to self delimiters of the pages (EXAMPLE: &lgt;li>&lgt;/li>))
 * @param $bothrdelimiter (string) - right delimiter (is need to self delimiters of the pages (EXAMPLE: &lgt;li>&lgt;/li>))
 *
 * @param mixed array $params
 * @param Smarty $smarty
 * @todo Сделать maxshow - количество показываемых цыфр и чтобы можно было листать по ним есстесно... пока негде проверить - потому не сделал
 */

function smarty_function_paginator_make_get($array){
    $return = '';
    if( count($array) ) {
        $i = 0;
        foreach($array as $key=>$value) {
            $return .= ($i)?'&':'';
            $return .= $key.'='.$value;
            ++$i;
        }
    }
    return $return;
}

function smarty_function_paginator($params, $smarty)
{
    /**
     * Default params
     */
    $step = 1;
    $maxshow = 30;
    $showsteps = false;
    $showfirst = false;
    $showlast = false;
    $show_long_listing = false;
    $first_title_text = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array('-first'));
    $last_title_text = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array('-last'));
    $next_title_text = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array('-next'));
    $prev_title_text = call_user_func_array(array(rad_config::getParam('loader_class'),'lang'),array('-prev'));
    $long_listing_text = '..';
    $num_delimiter = '&nbsp;';
    $alias = SITE_ALIAS;
    $page_varname = 'p';

    if(!isset($params['from'])) {
        throw new rad_exception("paginator: missing 'from' parameter", E_USER_ERROR);
    }
    $from = (int)$params['from'];
    if(!isset($params['to'])) {
        throw new rad_exception("paginator: missing 'to' parameter", E_USER_ERROR);
    }
    $to = (int)$params['to'];
    if(!isset($params['curpage'])) {
        throw new rad_exception("paginator: missing 'curpage' parameter", E_USER_ERROR);
    }
    $curpage = (int)$params['curpage'];
    if(isset($params['step'])) {
        $step = (int)$params['step'];
    }
    if(!$step or $step<=0) {
        throw new rad_exception("paginator: default parameter 'step' can't be < or = 0 ", E_USER_ERROR);
    }
    if(isset($params['maxshow'])) {
        $maxshow = (int)$params['maxshow']-1;
    }
    if(!$maxshow or $maxshow<=1) {
        throw new rad_exception("paginator: default parameter 'maxshow' can't be < or = 1 ", E_USER_ERROR);
    }
    if(isset($params['long_listing_text'])) {
        $long_listing_text = $params['long_listing_text'];
    }
    $showsteps = (isset($params['showsteps']))?(boolean)$params['showsteps']:$showsteps;
    $showfirst = (isset($params['showfirst']))?(boolean)$params['showfirst']:$showfirst;
    $showlast = (isset($params['showlast']))?(boolean)$params['showlast']:$showlast;
    $show_long_listing = (isset($params['show_long_listing']))?(boolean)$params['show_long_listing']:$show_long_listing;
    $first_title_text = (isset($params['first_title_text']))?(string)rad_sloader::lang( $params['first_title_text'] ):$first_title_text;
    $last_title_text = (isset($params['last_title_text']))?(string)rad_sloader::lang( $params['last_title_text'] ):$last_title_text;
    $next_title_text = (isset($params['next_title_text']))?(string)rad_sloader::lang( $params['next_title_text'] ):$next_title_text;
    $prev_title_text = (isset($params['prev_title_text']))?(string)rad_sloader::lang( $params['prev_title_text'] ):$prev_title_text;
    $num_delimiter = (isset($params['num_delimiter']))?(string)$params['num_delimiter']:$num_delimiter;
    $alias = (isset($params['alias']))?(string)$params['alias']:$alias;
    $page_varname = (isset($params['page_varname']))?(string)$params['page_varname']:$page_varname;
    $bothldelimiter = (isset($params['bothldelimiter']))?(string)$params['bothldelimiter']:'';
    $bothrdelimiter = (isset($params['bothrdelimiter']))?(string)$params['bothrdelimiter']:'';

    /****  Calculate and return values ******/
    $return = '';

    /*** Parse GET params ******/
    $get_params = array();
    if( isset($params['GET']) and strlen($params['GET']) ){
        if($params['GET'][0]=='&') {
            substr($params['GET'],1);
        }
        $pt = explode('&',$params['GET']);
        if( count($pt) ) {
            foreach($pt as $ptID=>$ptVL) {
                $pv = explode('=',$ptVL);
                if( count($pv)>1 ) {
                    $get_params[trim($pv[0])] = trim($pv[1]);
                }
            }
        }
    }
    $get_params['alias'] = $alias;

    //TODO Сделать чтобы при переходе на первую страницу или назад(если таже самая страница будет при клике назад) - небыло ссылки
    if($showfirst){
        $get_params[$page_varname] = $from;
        if($get_params[$page_varname] == $from)
          unset( $get_params[$page_varname] );
        $return .= $bothldelimiter.'<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$first_title_text.'</a>&nbsp;'.$bothrdelimiter;
        if( isset( $get_params[$page_varname] ) )
           unset( $get_params[$page_varname] );
    }
    if($showsteps){
        $get_params[$page_varname] = ($curpage==$from)?$curpage:($curpage);
        if($get_params[$page_varname] == $from)
          unset( $get_params[$page_varname] );
        else{
            $get_params[$page_varname]--;
            $return .= $bothldelimiter.'<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$prev_title_text.'</a>&nbsp;'.$bothrdelimiter;
        }
        if( isset( $get_params[$page_varname] ) )
          unset( $get_params[$page_varname] );
    }
    if($show_long_listing){
        $get_params[$page_varname] = ( ($curpage-$maxshow-1)<=$from)?$from:($curpage-$maxshow-1);
        if( ($from+$maxshow)>=$curpage ){
          unset( $get_params[$page_varname] );
        }else{
            $return .= $bothldelimiter.'<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$long_listing_text.'</a>&nbsp;'.$bothrdelimiter;
        }
        if( isset( $get_params[$page_varname] ) )
          unset( $get_params[$page_varname] );
    }

    $return_pag = array();
    //$maxshow
    if($from==($to-1)) {
        $return_pag[] = $bothldelimiter.'<font class="pages_active last">1</font>'.$bothrdelimiter;
    } else {
        for($i=$from;$i<($to-1);$i=$i+$step) {
            if ($i >= $curpage-$maxshow and $i <= $curpage+$maxshow) {
                if($curpage == $i) {
                    $return_pag[] = $bothldelimiter.'<font class="pages_active'.(($i==($to-2))?' last':'').'">'.(string)($i+1).'</font>'.$bothrdelimiter;
                } else {
                    $get_params[$page_varname] = $i;
                    $return_pag[] = $bothldelimiter.'<font class="pages_active'.(($i==($to-2))?' last':'').'"><a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">['.($i+1).']</a></font>'.$bothrdelimiter;
                }
            }
        }
    }

    $return .= implode($num_delimiter,$return_pag);

    if($show_long_listing) {
        $get_params[$page_varname] = ( ($curpage+$maxshow+1)>=($to-2))?$curpage:($curpage+$maxshow+1);
        $get_params[$page_varname] = ($get_params[$page_varname]==0)?$curpage+$maxshow+1:$get_params[$page_varname];
        if(($curpage+$maxshow)<($to-2)) {
            $return .= $bothldelimiter.'&nbsp;<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$long_listing_text.'</a>&nbsp;'.$bothrdelimiter;
        }
        unset( $get_params[$page_varname] );
    }

    if($showsteps) {
        if($curpage!=($to-2)) {
            $get_params[$page_varname] = ($curpage==($to-2))?$curpage:($curpage+1);
            $return .= $bothldelimiter.'&nbsp;<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$next_title_text.'</a>&nbsp;'.$bothrdelimiter;
            unset( $get_params[$page_varname] );
        }
    }

    if($showlast) {
        $get_params[$page_varname] = ($to-2);
        if($get_params[$page_varname] != $to) {
            $return .= $bothldelimiter.'<a href="'.smarty_function_url(array('href'=>smarty_function_paginator_make_get($get_params) ), $smarty).'">'.$last_title_text.'</a>'.$bothrdelimiter;
        }
        unset( $get_params[$page_varname] );
    }
    if($to > 2) {
        return $return;
    }
    return '';
}