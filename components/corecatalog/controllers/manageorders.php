<?php
/**
 * Class for managing orders in admin
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_manageorders extends rad_controller
{
    /**
     * Private self type of the orders in tre
     * @var integer
     */
    private $_typesPid = 117;

    private $_itemsperpage = 20;

    private $_products_tree_id = 38;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        $bco->add('cur_order_num');
        return $bco;
    }

    function __construct()
    {
        if( $this->getParamsObject() ) {
            $params = $this->getParamsObject();
            //$this->_typesPid = $params->typestart or 117;
            $this->_typesPid = $params->_get('typestart',$this->_typesPid, $this->getContentLangID());
            $this->_itemsperpage = $params->_get('itemsperpage', $this->_itemsperpage);
            $this->_products_tree_id = $params->_get('products_tree_id',$this->_products_tree_id, $this->getContentLangID());
            $this->setVar( 'params', $params );
        }
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->setVar('action',$this->request('action'));
            switch($this->request('action')) {
                case 'getjs_list':
                case 'getjs':
                    $this->getjs();
                    break;
                case 'edit':
                case 'show_order':
                    $this->showEdit();
                    $this->addBC('action', $this->request('action'));
                    break;
                case 'changestate':
                    $this->changeState();
                    break;
                case 'refresh':
                    $this->startPage();
                    break;
                case 'delete':
                    $this->deleteOrder();
                    break;
                case 'addProducts':
                    $this->addProducts();
                    break;
                case 'delete_position':
                    $this->deletePosition();
                    break;
                case 'change_count':
                    $this->changeCount();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName() );
                    break;
            }
        } else {
            $this->startPage();
        }
    }//construct

    /**
     * Start page
     */
    function startPage()
    {
        $this->assignTypes();
        $this->assignOrders();
    }

    /**
     * Assign types from tree
     *
     */
    function assignTypes()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid', $this->_typesPid );
        $items = $model->getItems();
        $this->setVar('types', $items );
    }

    function assignOrders()
    {
        $model = rad_instances::get('model_corecatalog_order')->setState('lang_id', $this->getContentLangID());
        $pid = $this->request('pid', -1); // , $this->_startType
        $scheme = $this->request('scheme', -1);
        if($pid > 0) {
            $model->setState('pid', $pid);
        }
        if($scheme > 0) {
            $model->setState('order_type', $scheme);
        }
        $model->setState('order by', 'order_dt DESC');

        $model->setState('select','count(*)');
        $items_count = $model->getItem();
        $model->unsetState('select');
        $page = (int)$this->request('p',1)-1;
        $limit = ($page * $this->_itemsperpage).','.$this->_itemsperpage;

        $this->setVar('orders', $model->getItems($limit) );

        $this->setVar('total_rows', $items_count);
        $pages = div((int)$items_count, $this->_itemsperpage);
        $pages += ($items_count % $this->_itemsperpage) ? 1 : 0;
        $this->setVar('pages_count', $pages+1);
        $this->setVar('page', $page+1);
    }

    function getjs()
    {

    }


    /**
     * Shows the edit order form of just a view
     *
     */
    function showEdit()
    {
        $order_id = (int)$this->request('oid');
        if($order_id) {
            $this->setVar('order_id', $order_id);
            $model = rad_instances::get('model_corecatalog_order');
            $order = $model->getItem($order_id,true);
            if($order->order_delivery) {
                $order->delivery = new struct_corecatalog_delivery( array('rdl_id'=>$order->order_delivery) );
                $order->delivery->load();
            }
            $this->setVar('order',$order);
            $this->addBC('cur_order_num', $order->order_num);
            $total_count = 0;
            $total_cost = 0;
            if(count($order->order_positions)){
                foreach($order->order_positions as $id){
                    $total_count += $id->orp_count;
                    $total_cost += ($id->orp_count * model_corecatalog_currcalc::calcCours( $id->orp_cost, $id->orp_curid ) );
                }//foreach
            }//if count
            $this->setVar('total_cost',$total_cost);
            $this->setVar('total_count',$total_count);
            $this->setVar('currency', model_corecatalog_currcalc::$_curcours );
            $this->assignTypes();
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Change order state from edit form
     *
     */
    function changeState()
    {
        if($this->request('hash') == $this->hash()) {
            $nsid = (int)$this->request('nsid');
            $order_id = (int)$this->request('oid');
            if($nsid) {
                $model = rad_instances::get('model_corecatalog_order');
                $order = $model->getItem($order_id);
                $order->order_status = $nsid;
                $rows = $model->updateItem($order);
                echo 'RADOrders.message("'.addslashes( $this->lang('-updated') ).': '.$rows.'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function deleteOrder()
    {
        if($this->request('hash') == $this->hash()) {
            $orderId = (int)$this->request('oid');
            if( $orderId ) {
                $model = rad_instances::get('model_corecatalog_order');
                $rows = $model->deleteItemById($orderId);
                /* delete from the referals*/
                if($this->config('referals.on') and class_exists('struct_coresession_referals_orders')) {
                    rad_instances::get('model_coresession_referals')->deleteOrderEvent($orderId);
                }
                echo 'RADOrdersList.refresh();';
                echo 'RADOrdersList.message("'.addslashes( $this->lang('-deleted') ).': '.$rows.'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function addProducts()
    {
        if($this->request('hash') == $this->hash()) {
            $orderId = (int)$this->request('oid');
            $newProducts = $this->request('jsondata');
            if($orderId && !empty($newProducts)) {
                rad_instances::get('model_corecatalog_order')->addToPositions($orderId, $newProducts);
                rad_instances::get('model_coresession_referals')->recalcOrderSum($orderId);
                echo 'RADOrders.refresh();';
                echo 'RADOrders.message("'.addslashes($this->lang('insertedrows.catalog.text')).': '.count($newProducts).'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function deletePosition()
    {
        if($this->request('hash') == $this->hash()) {
            $orderId = (int)$this->request('oid');
            $catId = (int)$this->request('cat_id');
            if($orderId > 0  and $catId > 0) {
                $r = rad_instances::get('model_corecatalog_order')->deletePositionFromOrder($orderId, $catId);
                rad_instances::get('model_coresession_referals')->recalcOrderSum($orderId);
                echo 'RADOrders.refresh();';
                echo 'RADOrders.message("'.addslashes($this->lang('deletedrows.catalog.text')).': '.$r.'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function changeCount()
    {
        if($this->request('hash') == $this->hash()) {
            $orderId = (int)$this->request('oid');
            $cat_id = (int)$this->request('cat_id');
            $count = (float)$this->request('count');
            if($orderId > 0  and $cat_id > 0) {
                $model = rad_instances::get('model_corecatalog_order');
                if($count == 0) {
                    $r = $model->deletePositionFromOrder($orderId, $cat_id);
                } elseif($count > 0) {
                    $r = $model->changePositionCount($orderId, $cat_id, $count);
                } else {
                    $r = 0;
                }
                rad_instances::get('model_coresession_referals')->recalcOrderSum($orderId);
                echo 'RADOrders.refresh();';
                echo 'RADOrders.message("'.addslashes($this->lang('updatedrows.catalog.text')).': '.$r.'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

}//class