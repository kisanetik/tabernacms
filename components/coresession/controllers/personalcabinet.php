<?php
/**
 *
 * For personal cabinet
 * @author Denys Yackushev
 * @package Taberna
 */
class controller_coresession_personalcabinet extends rad_controller
{
    private $_typesPid = 117;

    private $_startType = 123;

    /**
     * Items per page (dates) showed in personal cabinet
     * @var unknown_type
     */
    private $_refItemsPerPage = 14;

    /**
     * Status when order if closed, link to tree.tre_id
     * @var integer
     */
    private $_refOrderStatus = 0;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        return $bco;
    }

    function __construct()
    {
        if( $this->getParamsObject() ){
            $params = $this->getParamsObject();
            $this->_typesPid = $params->_get('typestart',$this->_typesPid,$this->getContentLangID());
            $this->_startType = $params->_get('typestartshow',$this->_startType,$this->getContentLangID());
            $this->_refOrderStatus = $params->_get('reforderstatus', $this->_refOrderStatus, $this->getContentLangID());
            $this->setVar( 'params', $params );
        }
        if(empty($this->getCurrentUser()->u_id)) {
            $this->redirect( $this->makeUrl('alias='.$this->config('alias.siteloginform')) );
        } else {
            if($this->request('action')) {
                $this->setVar('action', $this->request('action'));
                $this->addBC('action', $this->request('action'));
                if($this->request('typ')) {//FOR AJAX TYPE
                    $this->setVar('typ', $this->request('typ'));
                }
                switch(strtolower($this->request('action'))){
                    case 'profile':
                        if($this->request('sub_action')) {
                            if($this->request('sub_action') === 'edit') {
                                $this->editProfile();
                            }
                        }
                        $this->showProfile();
                        break;
                    case 'orders':
                        if($this->request('order_id')) {
                            $this->showOrderInfo( (int) $this->request('order_id') );
                        } else {
                            $this->showUserOrders();
                        }
                        break;
                    case 'refref':
                    case 'referals':
                        $this->showRefStatistic();
                        break;
                    case 'partners':
                        break;
                }
            } else {
                $this->showRefStatistic();
            }
        }
        $this->setVar('referals_on', $this->config('referals.on'));
        $this->setVar('current_lang', $this->getCurrentLang());
    }

    /**
     * Check and validate input data about user before saving
     * @return Object if OK, FALSE if wrong
     * @author Slavik Tereshchenko
     * @package RADCMS
     * @datecreated 21.12.2011
     */
    private function _verifyInputData($item = null)
    {
        $currUserPass = $item->u_pass;
        $messages = array();
        $req = $this->getAllRequest();
        foreach($req as $key=>$value) {
            if(is_string($value))
                $req[$key]=strip_tags(stripslashes($value));
        }
        if(!$item) {
            $item = new struct_core_users($req);
            $item->u_login = strip_tags($item->u_login);
        } else {
            $item->MergeArrayToStruct($req);
        }
        if(empty($item->u_login)) {
            $messages[] = $this->lang('emptylogin.session.error');
        }
        if(!filter_var($item->u_email, FILTER_VALIDATE_EMAIL)) {
            $messages[] = $this->lang('entervalidemail.session.error');
        }
        if($this->request('changepass') !== NULL && $this->request('changepass') === 'on') {
            if($this->request('u_pass') && $this->request('u_pass1') && $this->request('u_pass2')) {
                if( !strcmp($currUserPass, md5($this->request('u_pass'))) ) {
                    if( strlen($this->request('u_pass1')) >= 6 ){
                        if( !strcmp($this->request('u_pass1'), $this->request('u_pass2')) ) {
                           $item->u_pass = md5($this->request('u_pass1'));
                        } else {
                          $messages[] = $this->lang('passwordnotpassed.session.error');
                        }
                    } else {
                        $messages[] = $this->lang('passwordishort.session.error');
                    }
                } else {
                    $messages[] = $this->lang('passwordnotmatch.session.error');
                }
            } else {
                $messages[] = $this->lang('passwordishort.session.error');
            }
        } else {
            $item->u_pass = $currUserPass;
        }
        if(count($messages)) {
            $this->setVar('message', implode('<br />',$messages));
            return false;
        } else {
            return $item;
        }
    }

    /**
     * Get user information from session and set it in template
     * @author Slavik Tereshchenko
     * @package RADCMS
     * @datecreated 21.12.2011
     */
    function showProfile()
    {
        $userInfo = rad_session::getVar('user_dump');
        if(!empty($userInfo)) {
            $this->setVar('userInfo', $userInfo);
            $this->setVar('hash', $this->hash());
        }
    }

    /**
     * Save input data about user
     * @return Object if OK, FALSE if wrong
     * @author Slavik Tereshchenko
     * @package RADCMS
     * @datecreated 21.12.2011
     */
    function editProfile()
    {
        if($this->hash()==$this->request('hash')) {
            $item = $this->_verifyInputData($this->getCurrentUser());
            if($item) {
                 $item->save();
            }
        }
    }

    function showUserOrders()
    {
        $this->assignTypes();
        $this->assignOrders();
        $curUser = $this->getCurrentUser();
        if(!empty($curUser->u_id)) {
            $this->setVar('userInfo', $curUser);
            $model = rad_instances::get('model_corecatalog_order');
            $model->getState('order by', 'order_dt');
            $model->setState('user_id', $curUser->u_id);
            $orders = $model->getItems();
            $this->setVar('userOrders', $orders);
        }
    }

    function showOrderInfo($order_id)
    {
        $curUser = $this->getCurrentUser();
        if(!empty($curUser->u_id)) {
            $this->setVar('userInfo', $curUser);
            $model = rad_instances::get('model_corecatalog_order');
            $order = $model->getItem($order_id, true);
            if(!empty($order)) {
                if($curUser->u_id == $order->order_userid) {
                    $this->setVar('orderInfo', $order);
                }
            }
        }
    }

    function assignTypes()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid', $this->_typesPid );
        $items = $model->getItems();
        $this->setVar('types', $items );
    }

    function assignOrders()
    {
        $model = rad_instances::get('model_corecatalog_order');
        $pid = (int)$this->request('pid', $this->_startType );
        if($pid>=0){
           $model->setState('pid',$pid);
        }elseif( $pid==(-1) ){
            $item_tre = rad_instances::get('model_coremenus_tree')->getItem($this->_startType);
            $model->setState('pid',$item_tre->tre_pid);
        }
        $this->setVar('orders', $model->getItems() );
    }

    function showRefStatistic()
    {
        if(empty($this->getCurrentUser()->u_id) or !(int)$this->getCurrentUser()->u_id) {
            $this->redirect('alias='.$this->config('alias.siteloginform'));
        }
        $this->setVar('ref_link', model_coresession_referals::makeUrl($this->getCurrentUser()->u_id,
                        array('type'=>model_coresession_referals::TYPE_INDEX)));
        $dateFrom = strtotime($this->request('datefrom', date('Y-m-d', strtotime('-'.$this->_refItemsPerPage.' days'))));
        $dateTo = strtotime($this->request('dateto', date('Y-m-d')));
        $this->setVar('date_from', $dateFrom);
        $this->setVar('date_to', $dateTo);
        $model = rad_instances::get('model_coresession_referals')
                    ->setState('rrf_user_id', $this->getCurrentUser()->u_id)
                    ->setState('date.from', $dateFrom)
                    ->setState('date.to', $dateTo)
                    ->setState('group', 'rrf_date')
                    ->setState('select.subcount', true)
                    ->setState('order by', 'rrf_date DESC');
        $referals = $model->getItems();
        $this->setVar('partner_percent', $model->getParntnerPercent());
        /*Gets the statistif for orders and percents*/
        $orders = $model->getPartnerOrders();
        $referalsOrders = array();
        if($orders) {
            foreach($orders as &$order) {
                $referalsOrders[strtotime(date($this->config('date.format'), strtotime($order->order_dt)))]['orders'][] = $order;
            }
        }
        if($referals) {
            foreach($referals as &$referal) {
                 $referalsOrders[strtotime($referal->rrf_date)]['referals'][] = $referal;
            }
        }
        $this->setVar('referals_orders', $referalsOrders);
        $this->setVar('referals_closed_order', $this->_refOrderStatus);
        $this->setVar('currency_precision', $this->config('currency.precision'));
//         $this->setVar('referals', $referals);
    }
}