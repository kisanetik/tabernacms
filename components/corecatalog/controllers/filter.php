<?php
/**
 * Class for filter products in cart
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_filter extends rad_controller
{

    /**
     * Need to filter by brands?
     * @var boolean
     */
    private $_filterbrands = true;

    /**
     * Need to filter by price?
     * @var boolean
     */
    private $_filterprice = true;

    /**
     * Need to filter by val_values?
     * @var boolean
     */
    private $_filtervalvalues = true;

    /**
     * GET param for tre_id
     * @var string
     */
    private $_getcat = 'cat';

    /**
     * Instance of category (struct_coremenus_tree)
     * @var struct_coremenus_tree
     */
    private $_cat = NULL;

    /**
     * Query strng for current filter
     * @var string
     */
    private $_currentFilter;

    /**
     * current setted filters
     * @var mixed array
     */
    private $_current = array();

    /**
     * Just for cache
     * @param mixed array of ids from rad_catalog.cat_id's
     */
    private $_catIds = array();

    function __construct()
    {
        if( $this->getParamsObject() ){
            $params = $this->getParamsObject();
            $this->_filterbrands = $params->_get('filterbrands', $this->_filterbrands);
            $this->_filterprice = $params->_get('filterprice', $this->_filterprice);
            $this->_filtervalvalues = $params->_get('filtervalvalues', $this->_filtervalvalues);
            $this->_getcat = $params->_get('get_cat', $this->_getcat);
            $this->setVar( 'params', $params );
        }
        $this->_currentFilter = 'alias='.SITE_ALIAS.'&filter=1';
        if($this->request('filter')) {
            if($this->request('brand_id')) {
                if(is_array($this->request('brand_id'))) {
                    $this->_currentFilter.='&brand_id=';
                    //Don't use implode!
                    $tmp = array();
                    foreach($this->request('brand_id') as $brKey=>$brValue) {
                        $tmp[] = (int)$brValue;
                    }
                    $this->_currentFilter .= implode(',', $tmp);
                } else {
                    $this->_currentFilter.='&brand_id='.(int)$this->request('brand_id');
                }
            }
            if($this->request('vv')) {
                foreach($this->request('vv') as $vvKey=>$vvValue) {
                    $this->_current['vv'][$vvKey] = $vvValue;
                    $this->_currentFilter.='&vv['.$vvKey.']='.$vvValue;
                }
            }
        }
        $this->assignFilters();
        $this->setVar('currentFilter', $this->_currentFilter);
        $this->setVar('current', $this->_current);
    }

    function assignFilters()
    {
        $this->setVar('show', false);
        if($this->request($this->_getcat)) {
            $cat = rad_instances::get('model_coremenus_tree')->getItem($this->request($this->_getcat));
            if($cat->tre_active and $cat->tre_islast) {
                $this->setVar('show', true);
                $this->_cat = $cat;
                $this->_currentFilter .= '&'.$this->_getcat.'='.$cat->tre_id;
                if($this->_filterbrands) {
                    $this->assignBrands();
                }
                if($this->_filtervalvalues) {
                    $this->assignValValues();
                }
                if($this->_filterprice) {
                    $this->assignFilterPrice();
                }
            }
        }
    }

    private function _getCatsProducts()
    {
        $result = null;
        if($this->config('cache.power')) {
            $fn = rad_config::getParam('cache.power.dir').$this->_cat->tre_id.'.cachecatfilter';
            if(is_file($fn)) {
                $data = unserialize(file_get_contents($fn));
                if($data['date'] >= (time() - rad_config::getParam('cache.power.time')) ) {
                    $result = $data['rows'];
                }
            }
        }
        if(!$result) {
            $result = rad_instances::get('model_corecatalog_catalog')
                        ->setState('active', 1)
                        ->setState('tre_id', $this->_cat->tre_id)
                        ->setState('select', 'a.cat_brand_id, a.cat_id')
                        ->setState('return.array', true)
                        ->getItems();
            if($this->config('cache.power')) {
                $data = array('date'=>time(), 'rows'=>$result);
                safe_put_contents($fn, serialize($data));
            }
        }
        return $result;
    }

    protected function assignBrands()
    {
        $cats = $this->_getCatsProducts();
        if(!empty($cats)) {
            $catBrands = array();
            foreach($cats as $id) {
                $catBrands[$id['cat_brand_id']] = $id['cat_brand_id'];
                $this->_catIds[] = $id['cat_id'];
            }
            $this->setVar('brands',
                            rad_instances::get('model_corecatalog_brands')
                            ->setState('id', $catBrands)
                            ->setState('active', 1)
                            ->getItems() );
        }
        if(strstr($this->request('brand_id'),',')) {
            $brands = explode(',', $this->request('brand_id'));
            foreach($brands as $keyBrand=>$valBrand) {
                if(!(int)$valBrand) {
                    unset($brands[$keyBrand]);
                }//if
            }//foreach
            $this->_current['brand_id'] = $brands;
        } else {
            $this->_current['brand_id'][] = $this->request('brand_id', 0);
        }
    }

    protected function assignValValues()
    {
        $this->_current['vv'] = empty($this->_current['vv'])?0:$this->_current['vv'];
        $this->_current['vl'] = empty($this->_current['vl'])?'':$this->_current['vl'];
        if(empty($this->_catIds)) {
            $cats = $this->_getCatsProducts();
            if(!empty($cats)) {
                foreach($cats as $id) {
                    $this->_catIds[] = $id['cat_id'];
                }
            }
        }
        if(!empty($this->_catIds)) {
            if($this->config('cache.power')) {
                $valValues = $this->getValValuesCache();
            } else {
                $valValues = $this->getValValues();
            }
            if(!empty($valValues)) {
                $this->setVar('valvalues', $valValues);
                $valNames = array();
                foreach($valValues as $valId=>$valVal) {
                    $valNames[$valId] = new struct_corecatalog_cat_val_names(array('vl_id'=>(int)$valId));
                    $valNames[$valId]->load()->vl_name;
                }
                $this->setVar('valnames', $valNames);
            }
        }
    }

    /**
     * Gets the cache file name by product_ids and category id (tre_id)
     * @param mixed array of integer $product_ids
     * @paraminteger $cat_id
     * @return string
     */
    public static function getCacheFileName($productIds, $catId)
    {

        $file = rad_config::getParam('cache.power.dir').md5(implode('.', $productIds)).$catId.'.cachefilter';
        return $file;
    }

    protected function getValValuesCache()
    {
        $file = self::getCacheFileName($this->_catIds, $this->_cat->tre_id);
        $result = NULL;
        if(is_file($file)) {
            $data = unserialize(file_get_contents($file));
            if($data['date'] >= (time() - rad_config::getParam('cache.power.time')) ) {
                $result = $data['rows'];
            }
        }
        if(!$result) {
            $result = $this->getValValues();
            $data = array('date'=>time(), 'rows'=>$result);
            safe_put_contents($file, serialize($data));
        }
        return $result;
    }

    protected function getValValues()
    {
        if(!empty($this->_catIds)) {
            $items = rad_instances::get('model_corecatalog_types')
                        ->setState('cat_id', $this->_catIds)
                        ->setState('filter', 1)
                        ->setState('return.array', true)
                        ->setState('select', 'vv_value,vl_id')
                        ->setState('group by', 'vv_value')
                        ->setState('order by', 'vv_value')
                        ->getItems();
            $result = NULL;
            if(!empty($items)) {
                $result = array();
                foreach($items as $id) {
                    $result[$id['vl_id']][] = $id['vv_value'];
                }
            }
            return $result;
        }
        return NULL;
    }

    protected function assignFilterPrice()
    {
        if(empty($this->_catIds)) {
            $cats = $this->_getCatsProducts();
            if(!empty($cats)) {
                foreach($cats as $id) {
                    $this->_catIds[] = $id['cat_id'];
                }
            }
        }
        if(!empty($this->_catIds)) {
            $minmax = rad_instances::get('model_corecatalog_catalog')
                    ->setState('currency', model_corecatalog_currcalc::getDefaultCurrencyId())
                    ->setState('active', 1)
                    ->setState('tre_id', (int)$this->request($this->_getcat))
                    ->getMinMaxPrices();
            $minmax['minprice'] = ($minmax['minprice'])?$minmax['minprice']:0;
            $minmax['maxprice'] = ($minmax['maxprice'])?$minmax['maxprice']:0;
            $this->setVar('prices', array('min'=>$minmax['minprice'], 'max'=>$minmax['maxprice']));
            $this->_current['costfrom'] = $this->request('costfrom', $minmax['minprice']);
            if($this->request('costfrom')) {
                $this->_currentFilter.='&costfrom='.$this->request('costfrom', $minmax['minprice']);
            }
            $this->_current['costto'] = $this->request('costto', $minmax['maxprice']);
            if($this->request('costto')) {
                $this->_currentFilter.='&costto='.$this->request('costto', $minmax['maxprice']);
            }
        }
    }
}