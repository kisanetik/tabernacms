<?php
/**
 * Class for working with referals
 * @package Taberna
 * @author Yackushev Denys
 * @datecreated 07 Agust 2012
 */
class controller_coresession_referals extends rad_controller
{
    /**
     * Cookie name for user from partner
     * @var string
     */
    private $_cookieName = 'sRefCoockieName';

    /**
     * Cookie Live time
     * 86400(day)*365(days in year)
     * @var integer
     */
    private $_cookieTime = 31536000;

    function __construct()
    {
        if(!$this->config('referals.on')) {
            $this->redirect($this->makeUrl('alias='.$this->config('defaultAlias')));
        }
        parent::__construct();
        $this->_cookieName = $this->config('referals.cookieName', $this->_cookieName);
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_cookieTime = $params->_get('cookie_time', $this->_cookieTime);
            $this->setVar('params', $params);
        }
        if($this->cookie($this->_cookieName)) {
            //TODO обработать несуществующий куки, добавить значит по юзерайди.
            $model = rad_instances::get('model_coresession_referals');
            if( $item = $model->setState('cookie', $this->cookie($this->_cookieName))
                              ->getItem()) {
                $item->rrf_date = now();
                $item->rrf_time = now();
                setcookie($this->_cookieName, $item->rrf_cookie, time()+$this->_cookieTime , '/', $this->config('hostname'));
                $item->save();
            } else {
                if($this->request('user_id')) {
                    if( $user = rad_instances::get('model_core_users')->getItem( (int)$this->request('user_id') ) ) {
                        $this->_insertItem($user->u_id);
                    }
                }
            }
        } elseif($this->request('user_id')) {
            if( $user = rad_instances::get('model_core_users')->getItem( (int)$this->request('user_id') ) ) {
                $this->_insertItem($user->u_id);
            }
        }
        
        $this->redirect(SITE_URL);
    }

    function _insertItem($userId)
    {
        $code = md5($userId);
        $itemType = model_coresession_referals::TYPE_INDEX;
        $itemId = 0;
        $item = new struct_coresession_referals(array(
                        'rrf_user_id'=>$userId,
                        'rrf_refferer'=>(!empty($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'direct'),
                        'rrf_date'=>now(),
                        'rrf_time'=>now(),
                        'rrf_cookie'=>$code,
                        'rrf_item_type'=>$itemType,
                        'rrf_item_id'=>$itemId
        ));
        setcookie($this->_cookieName, $code, time()+$this->_cookieTime , '/', $this->config('hostname'));
        $item->insert();
    }

}