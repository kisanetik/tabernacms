<?php
/**
 * Class for change the current language
 * @author Denys Yackushev
 * @package RADC
 */
class controller_core_changelanguage extends rad_controller
{
    function __construct()
    {
        if($this->request('lang')) {
           if( rad_lang::changeLanguage($this->request('lang')) ){
              //all is ok - redirecting
               if($this->request('fromsite')) {
                   $this->redirect( $this->makeURL('alias='.$this->config('mainAlias')) );
               } elseif($_SERVER['HTTP_REFERER']) {
                   $ref = $_SERVER['HTTP_REFERER'];
                   if(mb_substr($ref, 0, mb_strlen(SITE_URL))==SITE_URL and $this->getParamsObject() and $this->getParamsObject()->_get('returntorefferer',false)) {
                       $this->redirect( str_replace('/'.rad_lang::getCurrentLanguage().'/', '/'.$this->request('lang').'/',$ref ) );
                   } else {
                       $this->redirect( $this->makeURL('alias='.$this->config('mainAlias')) );
                   }
               } else {
                   $this->redirect( $this->makeURL('alias='.$this->config('mainAlias')) );
               }
           } else {
               $this->redirect( $this->makeURL('alias='.$this->config('defaultAlias')), 'Error changing language!');
               die('can\'t change language');
           }
        } elseif($this->request('action')) {
            $this->setVar('action', strtolower( $this->request('action') ) );
            switch( strtolower( $this->request('action') ) ) {
                case 'adminlng':
                    $this->changeAdminLanguage();
                    break;
                case 'contentlng':
                    $this->changeContentLanguage();
                    break;
                case 'getjs':
                    $this->getJS();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
                    break;
            }//switch
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Changes the admin language
     */
    function changeAdminLanguage()
    {

    }

    /**
     * Changes the content language
     *
     */
    function changeContentLanguage()
    {
        if($this->request('i')){
            $lngid = (int)$this->request('i');
            if(rad_lang::changeContentLanguage($lngid)) {
                $lng = rad_lang::getLangByID($lngid);
                echo 'RADCHLangs.changeContentResult(1,'.$lng->lng_id.',"'.$lng->lng_code.'");';
            } else {
                echo 'RADCHLangs.changeContentResult(0);';
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }

    }

    /**
     * Return the JavaScript for changing the content langs
     *
     */
    function getJS()
    {
        $this->header('Content-type: text/javascript');
        $this->setVar('contLngId',$this->getContentLangID());
        $this->setVar('contentLngObj',$this->getContentLang());
    }
}
