<?php
/**
 * Managing delivery for catalog and shipping
 * @author Denys Yackushev
 * @package Taberna
 */
class controller_catalog_managedelivery extends rad_controller
{

    private $_treestart = 0;

    function __construct()
    {
        parent::__construct();
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_treestart = $params->_get('treestart', $this->_treestart, $this->getContentLangID());
            $this->setVar('params', $params);
        }
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->setVar('action', strtolower($this->request('action')));
            switch(strtolower($this->request('action'))) {
                case 'getjs':
                    $this->getJS();
                    break;
                case 'addedit':
                        if($this->request('i')) {
                            $item = new struct_delivery( array('rdl_id'=>(int)$this->request('i')) );
                            $item->load();
                        } else {
                            $item = new struct_delivery();
                        }
                        if($this->request('action_sub')) {
                            if($this->request('hash') == $this->hash()) {
                                $item = $this->_assignFromRequest($item);
                                if($item->save()) {
                                    echo 'RADDelivery.message("'.$this->lang('-saved').'");';
                                } else {
                                    echo 'RADDelivery.message("'.$this->lang('-error').'");';
                                }
                                die('RADDelivery.cancelWClick();RADDelivery.refresh();');
                            } else {
                                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                            }
                        } else {
                            $this->setVar('item', $item);
                            $this->assignCurrency();
                        }
                    break;
                case 'deleteitem':
                    if($this->request('hash') == $this->hash()) {
                        if($this->request('i')) {
                            $item = new struct_delivery( array('rdl_id'=>(int)$this->request('i')) );
                            if($item->load()->rdl_id and $item->remove()) {
                                die('RADDelivery.message("'.$this->lang('-deleted').'");RADDelivery.refresh();');
                            }
                        } else {
                            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                        }
                    } else {
                        $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    }
                    break;
                case 'getitems':
                    $this->assignItems();
                    break;
                case 'setactive':
                    $this->setActiveJS();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    break;
            }//switch
        } else {
            $this->assignItems();
        }
    }

    function setActiveJS()
    {
        $v = (int)$this->request('v');
        $itemId = (int)$this->request('c');
        if($itemId){
            $item = new struct_delivery(array('rdl_id'=>$itemId));
            $item->load();
            $item->rdl_active = (int)$v;
            $r = $item->save();
            $r = ($v and $r)?false:true;
            if($r){
                echo '$("active_del_link_'.$itemId.'_1").style.display="none";';
                echo '$("active_del_link_'.$itemId.'_0").style.display="";';
            }else{
                echo '$("active_del_link_'.$itemId.'_1").style.display="";';
                echo '$("active_del_link_'.$itemId.'_0").style.display="none";';
            }
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function getJS()
    {
        $this->setVar('tree_start', $this->_treestart);
    }

    function assignItems()
    {
        $model = new model_system_table(RAD.'delivery');
        $model->setState('where', 'rdl_lang='.(int)$this->getContentLangID());
        $items = $model->getItems();
        $this->setVar('items', $items);
    }

    function assignCurrency()
    {
        $model = rad_instances::get('model_catalog_currency');
        $model->setState('active', 1);
        $items = $model->getItems();
        $this->setVar('currency', $items);
    }

    /**
     * @return struct_delivery
     */
    private function _assignFromRequest($item=null)
    {
        $item = $item?$item:new struct_delivery();
        if(!$item->rdl_lang) {
            $item->rdl_lang = $this->getContentLangID();
        }
        $item->MergeArrayToStruct( $this->getAllRequest() );
        $item->rdl_name = stripslashes( $item->rdl_name );
        $item->rdl_active = (boolean)$this->request('rdl_active');
        return $item;
    }
}