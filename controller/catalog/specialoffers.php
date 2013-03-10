<?php
/**
 * Class for showing the special offers
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_catalog_specialoffers extends rad_controller
{
    /**
     * Items per page
     * @var integer
     */
    private $_itemsperpage = 4;

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_itemsperpage = $params->_get('itemsperpage', $this->_itemsperpage);
            $this->setVar('params', $params );
            if($params->_get('type_show', false)) {//last products and other onmain
                $model = rad_instances::get('model_catalog_catalog')
                ->setState('active', 1)
                ->setState('lang', $this->getCurrentLangID())
                ->setState('join.mainimage', true)
                ->setState('only.withimages', true)
                ->setState('lang', $this->getCurrentLangID());
                switch($params->_get('type_show')) {
                    case 'last':
                        $model->setState('order by', 'cat_datecreated DESC');
                        break;
                    case 'showed':
                        $model->setState('order by', 'cat_showed DESC');
                        break;
                }
                $this->setVar('items', $model->getItems($this->_itemsperpage));
            } else {//special offers for menu
                $model = rad_instances::get('model_catalog_catalog')
                        ->setState('special_offer', $params->cs_type)
                        ->setState('limit', $params->itemsperpage)
                        ->setState('where_condition',' 1 ')
                        ->setState('lang', $this->getCurrentLangID());
                if($params->ordering != 0) {
                	$model->setState('order by', $params->ordering);
                }
                $items = $model->getProductsList();
                model_catalog_currcalc::init();
                $curCurrency = model_catalog_currcalc::$_curcours;
                foreach($items as &$item) {
                	if($item->cat_currency_id != $curCurrency->cur_id) {
                	   $item->cat_cost = model_catalog_currcalc::calcCours($item->cat_cost, $item->cat_currency_id);
                	   $item->currency_indicate = $curCurrency->cur_ind;
                	}
                }
                $this->setVar('products', $items);
            }
        }
    }
}