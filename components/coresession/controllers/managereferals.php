<?php
/**
 * Class for managing the referals
 * @package Taberna
 * @author Yackushev Denys
 * @datecreated 22 Agust 2012
 */
class controller_coresession_managereferals extends rad_controller
{
    private $_dateItems = 14;

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->setVar('params', $params);
        }
        if($this->request('action')) {
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->getJS();
                    break;
                case 'getrefs':
                    $this->getRefsItems();
                    break;
                case 'showdetails':
                    $this->showDetails();
                    break;
                case 'showdetailsstatic':
                    $this->showDetailStatic();
                    break;
                default:
                    $this->securityHoleAlert($this->getClassName(), __FILE__, __LINE__);
                    break;
            }//switch
        } else {
            $this->startPage();
        }
    }

    function getJS()
    {
        $this->header('Content-type: text/javascript');
    }

    function startPage()
    {
        $dateFrom = strtotime($this->request('date_from', date('Y-m-d', strtotime('-'.$this->_dateItems.' days'))));
        $dateTo = strtotime($this->request('date_to', date('Y-m-d')));
        $this->setVar('date_from', $dateFrom);
        $this->setVar('date_to', $dateTo);
    }

    function getRefsItems()
    {
        $dateFrom = strtotime($this->request('datefrom', date('Y-m-d', strtotime('-'.$this->_dateItems.' days'))));
        $dateTo = strtotime($this->request('dateto', date('Y-m-d')));
        $this->setVar('date_from', $dateFrom);
        $this->setVar('date_to', $dateTo);
        $searchWord = $this->request('searchword');
        $model = rad_instances::get('model_coresession_referals')
                    ->setState('date.from', $dateFrom)
                    ->setState('date.to', $dateTo)
                    ->setState('group.users', true)
                    ->setState('select.subcount', true);
        if(!empty($searchWord)) {
            $model->setState('search', $searchWord);
        }
        $this->setVar('items', $model->getRefStatistics($this->_dateItems));
    }

    function showDetails()
    {
        if(!(int)$this->request('uid')) {
            $this->redirect('404');
        }
        $this->setVar('uid',(int)$this->request('uid'));
        $dateFrom = strtotime($this->request('datefrom', date('Y-m-d', strtotime('-'.$this->_dateItems.' days'))));
        $dateTo = strtotime($this->request('dateto', date('Y-m-d')));
        $this->setVar('datefrom', $dateFrom);
        $this->setVar('dateto', $dateTo);

    }

    function showDetailStatic()
    {
        $uid = (int)$this->request('uid');
        if(!$uid) {
            $this->redirect('404');
        }
        $this->setVar('uid',$uid);
        $dateFrom = (int)$this->request('datefrom');
        $dateTo = (int)$this->request('dateto');
        if(!$dateFrom or !$dateTo) {
            throw new rad_exception('Not enougn actual params!', __LINE__);
        }
        $this->setVar('datefrom', $dateFrom);
        $this->setVar('dateto', $dateTo);
        /*like personal cab*/
        $model = rad_instances::get('model_coresession_referals')
            ->setState('rrf_user_id', $uid)
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
        /*$this->setVar('referals_closed_order', $this->_refOrderStatus);*/
        $this->setVar('referals_closed_order', 43);//getParamsFor('personalCabinet')->refOrderStatus
        $this->setVar('currency_precision', $this->config('currency.precision'));
    }
}