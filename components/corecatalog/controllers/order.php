<?php
/**
 * Class for managing the bin - for shopping cart
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_order extends rad_controller
{

    private $_defStatus = 123;

    private $_mail_format = 'html';

    private $_defOrderScheme = 'fastandregistration';

    private $_showDelivery = true;

    const ORDER_FAST = 'onlyfast';
    const ORDER_REG =  'onlyregistration';
    const ORDER_FAST_REG =  'fastandregistration';

    private $_OrderScheme = 0;

    private $_showCaptcha = true;

    /**
     * Need to add customer to clients base?
     * @var boolean
     */
    private $_addtoclients = false;

    /**
     * Node id of clients base in users component
     * @var integer
     */
    private $_clientsPID = 187;

    function __construct()
    {
        $this->_OrderScheme = array( self::ORDER_FAST => false,
                                     self::ORDER_REG => false,
                                     self::ORDER_FAST_REG => false );
        if( $this->getParamsObject() ){
            $params = $this->getParamsObject();
            $this->_defStatus = $params->_get('typestart', $this->_defStatus, $this->getCurrentLangID());
            $this->_defOrderScheme = $params->_get('orderscheme', $this->_defOrderScheme);
            $this->_showCaptcha = $params->_get('showcaptcha', $this->_showCaptcha);
            if(isset($this->_OrderScheme[$this->_defOrderScheme])) {
                $this->_OrderScheme[$this->_defOrderScheme] = true;
            }
            $this->_showDelivery = $params->_get('showdelivery', $this->_showDelivery, $this->getCurrentLangID());
            $this->setVar('params', $params );
            if($this->_showCaptcha or $this->_OrderScheme[self::ORDER_REG]) {
                $this->setVar('showcaptha', true);
            } else {
                $this->setVar('showcaptha', false);
            }
            $this->_addtoclients = (boolean)$params->_get('addtoclients', $this->_addtoclients);
            $this->_clientsPID = $params->_get('clientsnode', $this->_clientsPID, $this->getCurrentLangID());
            //var_dump($this->_addtoclients);print_h($params);die('lng_id='.$this->getCurrentLangID().'-----clientsPID='.$this->_clientsPID);
        }
        if($this->request('action')) {
            $this->setVar('action',$this->request('action'));
            if($this->_OrderScheme[self::ORDER_REG] == true && empty($this->getCurrentUser()->u_id) ) {
                $this->redirect( $this->makeUrl('alias='.$this->config('alias.siteloginform')) );
            } else {
                switch($this->request('action')) {
                    case 'update1':
                        $this->startPage();
                        break;
                    case 'order':
                        if($this->request('hash')==$this->hash()) {
                            $this->order();
                        } else {
                            $this->redirect('404');
                        }
                        break;
                    case 'cap':
                        $this->showCapcha();
                        break;
                    default:
                        $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName() );
                        break;
                }
            }
        } else {
            $this->startPage();
        }
    }//construct

    /**
     * Start order page - show the basket
     *
     */
    function startPage()
    {
        model_corecatalog_currcalc::init();
        $this->setVar( 'curr' , model_corecatalog_currcalc::$_curcours );
        $model = rad_instances::get('model_corecatalog_bin');
        $ct_showing = ($this->getParamsObject())?$this->getParamsObject()->ct_showing:NULL;
        $items = $model->getCartProducts(NULL,NULL,$ct_showing);
        $bin_pos = $model->getItemsCart();
        $counts = array();
        $bin_ids = array();
        $total_count = 0;
        $total_costs = 0;
        if(count($bin_pos)) {
            foreach($bin_pos as $id){
                $counts[$id->bp_catid] = $id->bp_count;
                $bin_ids[$id->bp_catid] = $id->bp_id;
            }
        }
        for($i=0;$i<count($items);$i++){
            $items[$i]->cost = $items[$i]->cat_cost;
            $items[$i]->cat_cost = model_corecatalog_currcalc::calcCours( $items[$i]->cat_cost, $items[$i]->cat_currency_id );
            $items[$i]->cat_count = $counts[$items[$i]->cat_id];
            $total_count += $items[$i]->cat_count;
            $total_costs += $items[$i]->cat_cost*$items[$i]->cat_count;
            $items[$i]->bp_id = $bin_ids[$items[$i]->cat_id];
        }
        $this->setVar('items',$items);
        $this->setVar('total_count',$total_count);
        $this->setVar('total_costs',$total_costs);
        $this->setVar('hash', $this->hash());
        $userInfo = rad_session::getVar('user_dump');
        if(!empty($userInfo)) {
            $this->setVar('userInfo', $userInfo);
        }
        if($this->_showDelivery) {
            $this->assignDelivery();
        }
    }

    function assignDelivery()
    {
        $model = new model_core_table('delivery','corecatalog');
        $model->setState('where', 'rdl_lang='.(int)$this->getCurrentLangID());
        $items = $model->getItems();
        $this->setVar('delivery', $items);
    }

    /**
     * Final order!
     * return HTML to AJAX
     */
    function order()
    {
        $item = new struct_corecatalog_orders();
        $item->order_userid = ($this->getCurrentUser())?$this->getCurrentUser()->u_id:0;
        if($this->_showCaptcha or $this->_OrderScheme[self::ORDER_REG]) {
            $captcha = new model_coresession_captcha(SITE_ALIAS);
             if( !$captcha->check($this->request('captcha_text')) ){
                $this->setVar('message',$this->lang('wrongcaptcha.session.error'));
                $this->startPage();
                $this->setVar('wrong_capcha', true);
                return;
            }
        }
        $item->order_address = $this->request( 'address', '');
        $item->order_comments = $this->request( 'order_comment' );
        $item->order_email = $this->request( 'email' );
        $item->order_fio = $this->request( 'fio' );
        $item->order_phone = $this->request( 'contact_phone' );
        $item->order_langid = $this->getCurrentLangID();
        if($this->request('delivery')) {
            $item->order_delivery = (int)$this->request('delivery');
        }
        if($item->order_userid === 0){
            //type of the order - 3 is the quick order
            $item->order_type = 3;
        } else {
            if( $this->_OrderScheme[self::ORDER_FAST_REG] ) {
                //type of the order - 2 is the quick & registration
                $item->order_type = 2;
            } else {
            //type of the order - 1 is the registration
                $item->order_type = 1;
            }
        }

        $item->order_dt = now();
        $item->order_num = date("ymdHis");
        $item->order_num .= ($this->getCurrentUser())?'u'.$this->getCurrentUser()->u_id:'s';
        $item->order_sessid = $this->getCurrentSessID();
        //Link to the tree_id
        $item->order_status = $this->_defStatus;

        //calc the order summ
        $model_bin = rad_instances::get('model_corecatalog_bin');
        $ct_showing = ($this->getParamsObject())?$this->getParamsObject()->ct_showing:NULL;
        $items = $model_bin->getCartProducts(NULL,NULL,$ct_showing);
        $bin_pos = $model_bin->getItemsCart();
        $counts = array();
        $bin_ids = array();
        $total_count = 0;
        $total_costs = 0;
        if(count($bin_pos)) {
            foreach($bin_pos as $id){
                $counts[$id->bp_catid] = $id->bp_count;
                $bin_ids[$id->bp_catid] = $id->bp_id;
            }
        }
        for($i=0;$i<count($items);$i++) {
            $items[$i]->cat_cost = model_corecatalog_currcalc::calcCours( $items[$i]->cat_cost, $items[$i]->cat_currency_id );
            $items[$i]->cat_count = $counts[$items[$i]->cat_id];
            $total_count += $items[$i]->cat_count;
            $total_costs += $items[$i]->cat_cost*$items[$i]->cat_count;
            $items[$i]->bp_id = $bin_ids[$items[$i]->cat_id];
        }
        if($this->_showDelivery and $this->request('delivery')) {
            $delivery = new struct_corecatalog_delivery(array('rdl_id'=>(int)$this->request('delivery')));
            $delivery->load();
            $totalCostsWithoutDelivery = $total_costs;
            $total_costs += model_corecatalog_currcalc::calcCours( $delivery->rdl_cost, $delivery->rdl_currency );
            $item->delivery = $delivery;
        }
        $item->order_summ = $total_costs;
        $item->order_currency = model_corecatalog_currcalc::$_curcours->cur_ind;
        $item->order_curid = model_corecatalog_currcalc::$_curcours->cur_id;
        if($this->_addtoclients) {
            if(!empty($this->getCurrentUser()->u_id)) {
                $item->order_userid = (int)$this->getCurrentUser()->u_id;
            } else {
                //try, maybe user already exists
                $modelUsers = rad_instances::get('model_core_users');
                $exUser = $modelUsers->setState('u_email', $item->order_email)->getItem();
                if(!empty($exUser->u_id)) {
                    $item->order_userid = (int)$exUser->u_id;
                } else {
                    $user = new struct_core_users(array(
                                    'u_group'=>$this->_clientsPID,
                                    'u_login'=>$item->order_email,
                                    'u_email'=>$item->order_email,
                                    'u_fio'=>$item->order_fio,
                                    'u_phone'=>$item->order_phone,
                                    'u_address'=>$item->order_address,
                                    'u_isadmin'=>0
                    ));
                    $modelUsers->insertItem($user);
                    $user->u_id = $modelUsers->inserted_id();
                    $item->order_userid = $user->u_id;
                }
            }
        }

        $model = rad_instances::get('model_corecatalog_order');
        if($rows = $model->insertItem($item)) {
            $item->order_id = $rows;
            $item->order_num .= $item->order_id;
            $item->save();
            rad_instances::get('model_corecatalog_bin')->clearItemsCart();
            /*assign to the referals*/
            if($this->config('referals.on') and class_exists('struct_coresession_referals_orders')) {
                //TODO Учесть что пользователь до этого уже приведен был другим партнером и взять с user_id
                if($this->cookie($this->config('referals.cookieName')) or !empty($item->order_userid)) {
                    if(!empty($item->order_userid)) {
                        $refUser = rad_instances::get('model_coresession_referals')->getUserPartner($item->order_userid);
                    }
                    if(!empty($refUser->u_id)) {
                        $referalId = $refUser->rru_referal_id;
                    } elseif($referal = rad_instances::get('model_coresession_referals')
                                                  ->setState('cookie', $this->cookie($this->config('referals.cookieName')))
                                                  ->getItem()) {
                        $referalId = $referal->rrf_id;
                    }
                    if(!empty($referalId)) {
                        $percent = rad_instances::get('model_coresession_referals')->getParntnerPercent($referalId);
                        $orderSum = (isset($totalCostsWithoutDelivery)?$totalCostsWithoutDelivery:$item->order_summ);
                          $refOfder = new struct_coresession_referals_orders(
                                          array(
                                              'rro_referals_id'=>$referalId,
                                              'rro_order_id'=>$item->order_id,
                                              'rro_percent'=>$percent,
                                              'rro_currency_id'=>$item->order_curid,
                                              'rro_order_sum'=>$orderSum
                                          )
                                      );
                          rad_instances::get('model_coresession_referals')->insertOrder($refOfder);
                    }
                }
            }
        }
        /*make message*/
        $this->setVar('message', $this->lang('yourorderaccepted.basket.text') );
        $item->order_positions = $bin_pos;

        if($item->order_userid === 0) {
            $this->_sendMail($item, 'order_new');
        } else {
            $this->_sendMail($item, 'order_new_auth');
        }
    }

    /**
     * Показывает капчу
     */
    function showCapcha()
    {
        $image = controller_coresession_registersimply::getSIObj();
        $image->show();
    }

    /**
     * Посылаем сообщение админу о новом заказе
     */

    private function _sendMail(struct_corecatalog_orders $order, $type)
    {
        switch($type) {
            case 'order_new':
                $template_name = $this->config('catalog.new_order');
                break;
            case 'order_new_auth':
                $template_name = $this->config('catalog.new_auth_order');
                break;
            default:
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                break;
        }
        $email_to_user = $order->order_email;
        $email_to_admin = $this->config('admin.mail');
        rad_mailtemplate::send($email_to_user, $template_name, array('order' => $order), $this->_mail_format); //mail to user
        rad_mailtemplate::send($email_to_admin, $template_name, array('order' => $order), $this->_mail_format); //copy to admin
    }

}//class