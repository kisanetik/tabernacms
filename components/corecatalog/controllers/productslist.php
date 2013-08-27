<?php
/**
 * Class for showing the list of products
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_productslist extends rad_controller
{
    private $_pid = 38;

    private $_itemsPerPage = 10;

    private $_ct_showing = 0;

    private $_onlycategories = 0;

    /**
     * Прятать пустые значения?
     * @var Boolean
     */
    private $_hide_empty_vv = 1;

    private $_currentFilter = array();

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('categories');
        $bco->add('cur_category_id');
        $bco->add('default_pid');
        $bco->add('curr_category');
        $bco->add('parents');
        $bco->add('so_id');
        $bco->add('so_name');
        $bco->add('action');
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_pid = $params->treestart;
            $this->_itemsPerPage = $params->itemsperpage;
            $this->_ct_showing = $params->ct_showing;
            $this->_onlycategories = $params->_get('onlycategories', $this->_onlycategories);
            $this->_hide_empty_vv = $params->hide_empty_vv;
            $this->setVar('params', $params);
         }
         if($this->request('pid')) {
            $this->assignProduct();
         } elseif($this->request('search')) {
             $this->searchProducts();
         } elseif($this->request('action')=='cfind') {
             $this->searchProducts();
         } else {
             if(!$this->_onlycategories) {
                  $this->assignProducts();
             }
             $this->assignCategories();
         }
         $this->setVar('curr' , model_corecatalog_currcalc::$_curcours);
         $this->assignFilters();
    }

    /**
     * Assign the products
     */
    function assignProducts()
    {
        $cat = (int)$this->request( 'cat', $this->_pid );
        $special_offer = (int)$this->request('so');
        $order_by = $this->request('o');
        $order_by_asc = (int)$this->request('asc',2);
        if(!$cat and !$special_offer) {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            return ;
        }
        $this->setVar('itemsPerPageDefault', $this->_itemsPerPage);
        $this->_itemsPerPage = (int)$this->request('i', $this->_itemsPerPage);
        $this->setVar('itemsPerPage', $this->_itemsPerPage);
        $model = rad_instances::get('model_corecatalog_catalog');
        if(!$special_offer) {
            $this->setVar('cat_id',$cat);
            $model->setState('tre_id', $cat);
            $tree_item = rad_instances::get('model_coremenus_tree')->getItem($cat);
            $this->setVar('tree_item',$tree_item);
        } else {
            $this->setVar('special_offer',$special_offer);
            $model->setState('special_offer',$special_offer);
            $model->setState('where_condition',' 1 ');
            $this->addBC('so_id',$special_offer);
            $this->addBC('so_name',$this->lang('specialoffer'.$special_offer.'.catalog.title'));
        }
        $model->setState('active', 1);
        $model->setState('lang', $this->getCurrentLangID());
        if($this->request('filter')) {
            if((int)$this->request('brand_id')) {
                if(strstr($this->request('brand_id'),',')) {
                    $brands = explode(',', $this->request('brand_id'));
                    foreach($brands as $keyBrand=>$valBrand) {
                        if(!(int)$valBrand) {
                            unset($brands[$keyBrand]);
                        }//if
                    }//foreach
                } else {
                    $brands = $this->request('brand_id', 0);
                }
                $model->setState('brand_id', $brands);
                $this->_currentFilter['brand_id'] = $brands;
            }
            if($this->request('vv')) {
                $vv = array();
                foreach($this->request('vv') as $vlNameId=>$vvValue) {
                    if(!empty($vvValue)) {
                        $vv[$vlNameId] = $vvValue;
                    }
                }
                if(!empty($vv)) {
                    $model->setState('val_values', $vv);
                    $this->_currentFilter['vv'] = $vv;
                }
            }
            if((float)$this->request('costfrom')) {
                $model->setState('cost.from', (float)$this->request('costfrom'));
                $this->_currentFilter['costfrom'] = (float)$this->request('costfrom');
                $model->setState('currency', model_corecatalog_currcalc::getDefaultCurrencyId());
            }
            if((float)$this->request('costto')) {
                $model->setState('cost.to', (float)$this->request('costto'));
                $this->_currentFilter['costto'] = (float)$this->request('costto');
                $model->setState('currency', model_corecatalog_currcalc::getDefaultCurrencyId());
            }
        }
        $products_count = $model->getProductsListCount();
        $this->setVar('products_count', $products_count);
        $p = (int)$this->request('p');
        $page = ($p)?$p:0;
        $limit = ($page*$this->_itemsPerPage).','.$this->_itemsPerPage;
        $model->setState('limit', $limit);
        $order = ' c.cat_position, ';
        switch($this->request('o')) {
            case 'name':
                $order.='c.cat_name';
                break;
            case 'cost':
                $order.='c.cat_cost*(cr.cur_cost/'.model_corecatalog_currcalc::currCours().')';
                break;
            default:
                $order.='c.cat_name';
                break;
        }
        $order.=($this->request('asc',true))?' ASC':' DESC';
        $model->setState('order by', $order);
        $products = $model->getProductsList(true, $this->_ct_showing);
        if($products_count) {
            $pages = div((int)$products_count, $this->_itemsPerPage);
            $pages += ($products_count % $this->_itemsPerPage) ? 1 : 0;
            $this->setVar('pages_count', $pages+1);
            $this->setVar('page', $page+1);
            $this->setVar('currPage', (int)$this->request('p',$page));
        } else {
            $this->setVar('pages_count', 0);
            $this->setVar('page', 1);
            $this->setVar('currPage', (int)$this->request('p',0));
        }
        foreach($products as $pkey=>$product) {
            if(count($product->type_vl_link)) {
                foreach($product->type_vl_link as $tvlkey => $tvl) {
                    if($product->type_vl_link[$tvlkey]->vl_measurement_id) {
                        $mes_id = $product->type_vl_link[$tvlkey]->vl_measurement_id;
                        $mes = new struct_corecatalog_measurement( array('ms_id'=>$mes_id) );
                        $mes->load();
                        $products[$pkey]->type_vl_link[$tvlkey]->ms_value = $mes->ms_value;
                    }
                }
            }
            if($this->config('partners.3dbin.license')) {
                rad_instances::get('model_corecatalog_3dimages')->assign3Dimages($products);
            }
        }
        $this->setVar('products', $products );
    }

    /**
     * Assign one product!
     */
    function assignProduct()
    {
        $pid = (int)$this->request('pid');
        if($pid){
            die('SHOW ONE PID!');
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Assign the categories
     */
    function assignCategories()
    {
        $last_cat = 0;
        $last_items = 0;
        $last_category = 0;
        $cat_level = 0;
        //startfromlevel
        //showlastnode
        $cat = (int)$this->request( 'cat', $this->_pid );
        if($this->request('so')) {
            $this->setVar('so', (int)$this->request('so'));
        }
        if($cat == $last_cat) {
            $this->setVar('categories', $last_items);
            $this->setVar('category',$last_category);
            $this->setVar('cat_lavel',$cat_level);
        } elseif($cat) {
            $last_cat = $cat;
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('lang',$this->getCurrentLangID());
            $model->setState('pid', $cat);
            $last_items = $model->getItems();
            $this->setVar( 'categories', $last_items );
            $model->clearState();
            $last_category = $model->getItem($cat);
            $this->setVar('category', $last_category );
            if($this->getParamsObject()->showlastnode and $last_category->tre_islast) {
                $model->clearState();
                $model->setState('pid',$last_category->tre_pid)
                      ->setState('active', 1);
                $last_items = $model->getItems();
                $this->setVar( 'categories', $last_items );
            }
            if($last_category->tre_pid!=$this->_pid and $last_category->tre_id!=$this->_pid) {
                $cat_level = 0;
                $parent_cat = $model->getItem($last_category->tre_pid);
                if($parent_cat->tre_pid==$this->_pid or $parent_cat->tre_pid==0){
                    $cat_level = 1;
                }else{
                    $cat_level++;
                    while($parent_cat->tre_pid!=0 and $parent_cat->tre_pid!=$this->_pid){
                        $cat_level++;
                        $parent_cat = $model->getItem($parent_cat->tre_pid);
                    }
                }
            }else{
                $cat_level = 0;
            }
            $this->setVar('cat_lavel',$cat_level);
        }
        $this->addBC('cur_category_id', $cat);
        $this->addBC('default_pid',$this->_pid);
        $this->addBC('categories',$last_items);
        $this->addBC('curr_category',$last_category);
        if($last_category->tre_pid!=$this->_pid and $last_category->tre_pid > 0 and $last_category->tre_id!=$this->_pid){
            $parents = array();
            $model = rad_instances::get('model_coremenus_tree');
            $model->clearState();
            $parents[] =  $model->getItem($last_category->tre_pid);
            while($parents[count($parents)-1]->tre_pid!=$this->_pid and $parents[count($parents)-1]->tre_pid!=0) {
                $model->clearState();
                $parents[] = $model->getItem( $parents[count($parents)-1]->tre_pid );
            }
            $parents = array_reverse($parents);
            $this->addBC('parents',$parents);
        }
    }

    private function _getTreeIds($tree)
    {
        $mas = array();
        foreach($tree as $id){
            $mas[] = $id->tre_id;
            if(is_array($id->child)){
                $mas = array_merge($mas, $this->_getTreeIds($id->child) );
            }
        }
        return $mas;
    }

    /**
     * Search products by searchword
     *
     */
    function searchProducts()
    {
        $searchword = html_entity_decode( urldecode( $this->request('search') ) );
        if($searchword){
            if($this->request('action')=='cfind'){
                $tre_id = (int)$this->request('cat_tre_id');
                $cost_from = (float)$this->request('cost_from');
                $cost_to = (float)$this->request('cost_to');
                $this->setVar('action',$this->request('action'));
            }
            $this->setVar('searchword',$searchword);
            $this->setVar('itemsPerPageDefault', $this->_itemsPerPage);
            $this->_itemsPerPage = (int)$this->request('i', $this->_itemsPerPage);
            $this->setVar('itemsPerPage', $this->_itemsPerPage);
            $model = rad_instances::get('model_corecatalog_catalog');
            if( isset($tre_id) and ($tre_id) ){
                $model_tree = rad_instances::get('model_coremenus_tree');
                $model_tree->setState('pid',$tre_id);
                $trees = $model_tree->getItems(true);
                $ids = $this->_getTreeIds($trees);
                array_push($ids,$tre_id);
                $model->setState('cat_in_tre',$ids);
            }
            if( ( isset($cost_from) or isset($cost_to) ) ){
                $model->setState('cost_from',$cost_from);
                $model->setState('cost_to',$cost_to);
            }
            $model->setState('count',true);
            $model->setState('with_cat_keywords',false);
            $model->setState('with_cat_metatitle',false);
            $model->setState('with_cat_metatescription',false);
            $model->setState('with_tre_name',false);
            $model->setState('active',1);
            $model->setState('lang',$this->getCurrentLangID());
            $products_count = $model->searchItems($searchword,1);
            $model->setState('withvals',true);
            $model->unsetState('count');
            $p = (int)$this->request('p');
            $page = ($p)?$p:0;
            $limit = ($page*$this->_itemsPerPage).','.$this->_itemsPerPage;
            $model->setState('limit', $limit);
            $products = $model->searchItems($searchword, 1);
            if($products_count){
                $pages = div((int)$products_count, $this->_itemsPerPage);
                $pages += ($products_count % $this->_itemsPerPage) ? 1 : 0;
                $this->setVar('pages_count', $pages+1);
                $this->setVar('page', $page+1);
            }
            $this->setVar('products', $products );
            $this->setVar('products_count', $products_count);
        }else{
            $this->redirect(SITE_URL.'catalog.html');
        }
    }

    function assignFilters()
    {
        if(!empty($this->_currentFilter)) {
            $filter = 'filter=1';
            foreach($this->_currentFilter as $key=>$value) {
                if(is_array($value)) {
                    foreach($value as $key1=>$value1) {
                        $filter .= '&'.$key.'['.$key1.']='.$value1;
                    }
                } else {
                    $filter .= '&'.$key.'='.$value;
                }
            }
            $this->setVar('currentFilter', $filter);
        }
    }
}