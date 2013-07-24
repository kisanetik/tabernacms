<?php
/**
 * Class for managing currency
 * 
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_managecurrency extends rad_controller
{
    function __construct()
    {
        $this->setVar('hash', $this->hash());
        if($this->request('action')){
            $this->setVar('action',$this->request('action'));
            switch($this->request('action')){
                case 'getjs':
                    $this->getJS();
                    break;
                case 'getList':
                    $this->getList();
                    break;
                case 'addwindow':
                    $this->addWindow();
                    break;
                case 'add':
                    if($this->request('edit')){
                        $this->editOne();
                    }else{
                       $this->add();
                    }
                    break;
                case 'deleteone':
                    $this->deleteOne();
                    break;
                case 'getproductsbycur':
                    $this->getProductsWithCurrency();
                    break;
                case 'editone':
                    $this->editOneWindow();
                    break;
                case 'applysave':
                    $this->applySave();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }//switch
        }else{

        }
    }

    /**
     * Gets the list of currency
     *
     * @return string HTML
     *
     */
    function getList()
    {
        $model = rad_instances::get('model_corecatalog_currency');
        $this->setVar('items',$model->getItems());
    }

    /**
     * Content win add currency window
     *
     * @return string html
     *
     */
    function addWindow()
    {
        $this->setVar('item', new struct_corecatalog_currency());
    }

    function add()
    {
        if($this->request('hash') == $this->hash()) {
            $item = new struct_corecatalog_currency( $this->getAllRequest() );
            $item->cur_default_admin = ( $this->request('cur_default_admin') )?'1':0;
            $item->cur_default_site = ( $this->request('cur_default_site') )?'1':0;
            $item->cur_show_site = ( $this->request('cur_show_site') )?'1':0;
            $item->cur_showcurs = ( $this->request('cur_showcurs') )?'1':0;
            $item->cur_image = '';
            if(strlen($item->cur_name) and strlen($item->cur_ind) ) {
                $model = rad_instances::get('model_corecatalog_currency');
                $rows = $model->insertItem($item);
                if ($rows) {
                    $item->cur_id = $rows;
                    if ($item->cur_image = $this->uploadImage($item->cur_id)) {
                        $model->updateItem($item);
                    }
                }
                if($rows) {
                    echo 'RADCurrency.message("'.addslashes($this->lang('insertedrows.catalog.text')).': '.$rows.'");';
                } else {
                    echo 'RADCurrency.message("'.$this->lang('-error').': '.addslashes($this->lang('insertedrows.catalog.text')).'");';
                }
                echo 'RADCurrency.refresh();';
                echo 'RADCurrency.cancelnewclick();';
            } else {
                echo 'RADCurrency.message("'.$this->lang('notallfields.catalog.text').'");';
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function deleteOne()
    {
        if($this->request('hash') == $this->hash()) {
            $cur_id = (int)$this->request('cur_id');
            if($cur_id) {
                $modelCurrency = rad_instances::get('model_corecatalog_currency');
                $cursList = $modelCurrency->getItems();
                if(count($cursList) > 1) {
                    $this_key = 0;
                    $next_key = 0;
                    foreach($cursList as $key=>$cur) {
                        if($cur->cur_id == $cur_id) {
                            $this_key = $key;
                            break;
                        }
                    }
                    if(isset($cursList[$this_key+1])) {
                        $next_key = $this_key+1;
                    }
                    if($cursList[$this_key]->cur_default_admin == 1) {
                        $cursList[$next_key]->cur_default_admin = 1;
                    }
                    if($cursList[$this_key]->cur_default_site == 1) {
                        $cursList[$next_key]->cur_default_site = 1;
                    }
                    $modelCurrency->updateItem($cursList[$next_key]);
                    $product_model = rad_instances::get('model_corecatalog_catalog');
                    $model = model_core_table::getInstance('catalog', 'corecatalog');
                    $model->setState('where','cat_currency_id='.$cur_id);
                    $products = $model->getItems();
                    if(count($products)) {
                        foreach($products as $product) {
                            $product_model->deleteProductById($product->cat_id);
                        }
                    }
                    $item = $modelCurrency->getItem($cur_id);
                    if ($item->cur_image) {
                        $this->deleteImage($item->cur_image);
                    }
                    $rows = rad_instances::get('model_corecatalog_currency')->deleteItem($item);
                    if($rows){
                        echo 'RADCurrency.message("'.addslashes($this->lang('deletedrows.catalog.text')).': '.$rows.'");';
                    }else{
                        echo 'RADCurrency.message("'.$this->lang('-error').': '.addslashes($this->lang('deletedrows.catalog.text')).'");';
                    }
                    echo 'RADCurrency.refresh();';
                }
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                echo 'RADCurrency.message("'.$this->lang('-error').'");';
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Shows in window input html
     * @return html
     *
     */
    function editOneWindow()
    {
        $cur_id = (int)$this->request('cur_id');
        if($cur_id){
            $this->setVar('item' , rad_instances::get('model_corecatalog_currency')->getItem($cur_id) );
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    private function getImagePath($filename)
    {
        return (COMPONENTSPATH.'core'.DS.'img'.DS.'currency'.DS.$filename);
    }

    private function deleteImage($filename)
    {
        @unlink($this->getImagePath($filename));
    }

    private function uploadImage($currency_id, $previous_image='', $delete=false)
    {
        if (!empty($_FILES['cur_image']['size']) && !$_FILES['cur_image']['error']) {
            $ext = rad_gd_image::getFileExtension($_FILES['cur_image']['tmp_name']);
            if ($ext) {
                if ($previous_image) {
                    $this->deleteImage($previous_image);
                }
                $filename = $currency_id.'.'.$ext;
                if (move_uploaded_file($_FILES['cur_image']['tmp_name'], $this->getImagePath($filename))) {
                    return $filename;
                }
                return '';
            }
        } elseif ($previous_image && $delete) {
            $this->deleteImage($previous_image);
            return '';
        }
        return $previous_image;
    }

    /**
     * Save one currency and return JS instructions
     * @return JavaScript
     *
     */
    function editOne()
    {
        if($this->request('hash') == $this->hash()) {
            $cur_id = (int)$this->request('cur_id');
            if($cur_id) {
                $item = new struct_corecatalog_currency($this->getAllRequest());
                $item->cur_default_admin = ( $this->request('cur_default_admin') )?'1':0;
                $item->cur_default_site = ( $this->request('cur_default_site') )?'1':0;
                $item->cur_show_site = ( $this->request('cur_show_site') )?'1':0;
                $item->cur_showcurs = ( $this->request('cur_showcurs') )?'1':0;
                $old_item = rad_instances::get('model_corecatalog_currency')->getItem($cur_id);
                $item->cur_image = $this->uploadImage($item->cur_id, $old_item->cur_image, $this->request('delete_cur_image'));
                $rows = rad_instances::get('model_corecatalog_currency')->updateItem($item);
                if($rows){
                    echo 'RADCurrency.message("'.addslashes($this->lang('updatedrows.catalog.text')).': '.$rows.'");';
                }else{
                    echo 'RADCurrency.message("'.$this->lang('-error').': '.addslashes($this->lang('updatedrows.catalog.text')).':'.$rows.'");';
                }
                echo 'RADCurrency.refresh();';
                echo 'RADCurrency.cancelnewclick();';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                echo 'RADCurrency.message("'.$this->lang('-error').'");';
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function applySave()
    {
        if($this->request('hash') == $this->hash()) {
            $cur_positions = $this->request('cur_position');
            $cur_cost = $this->request('cur_cost');
            $cur_showcurs = $this->request('cur_showcurs');
            $cur_showsite = $this->request('cur_show_site');
            $mas_items = array();
            $model = rad_instances::get('model_corecatalog_currency');
            foreach($cur_positions as $key=>$value){
                $mas_items[$key] = $model->getItem( (int)$key );
                $mas_items[$key]->cur_position = $value;
                $mas_items[$key]->cur_showcurs = '0';
                $mas_items[$key]->cur_show_site = '0';
                $mas_items[$key]->cur_default_site = '0';
                $mas_items[$key]->cur_default_admin = '0';
            }//foreach
            foreach($cur_cost as $key=>$value)
              $mas_items[$key]->cur_cost = $value;
            if($cur_showcurs)
                foreach($cur_showcurs as $key=>$value)
                    $mas_items[$key]->cur_showcurs = '1';
            if($cur_showsite)
                foreach($cur_showsite as $key=>$value)
                    $mas_items[$key]->cur_show_site = '1';
            $mas_items[$this->request('default_site')]->cur_default_site = '1';
            $mas_items[$this->request('default_admin')]->cur_default_admin = '1';
            $rows = 0;
            foreach($mas_items as $id)
              $rows += $model->updateItem($id);
            if($rows){
                echo 'RADCurrency.message("'.addslashes($this->lang('updatedrows.catalog.text')).': '.$rows.'");';
            }else{
                echo 'RADCurrency.message("'.$this->lang('-error').': '.addslashes($this->lang('updatedrows.catalog.text')).':'.$rows.'");';
            }
            echo 'RADCurrency.refresh();';
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Gets the JS for the Currency
     * @return string JavaScript
     *
     */
    function getJS()
    {

    }

    function getProductsWithCurrency()
    {
        $cur_id = (int)$this->request('cur_id');
        if($cur_id) {
            $model = model_core_table::getInstance('catalog', 'corecatalog');
            $model->setState('select', 'count(*)');
            $model->setState('where','cat_currency_id='.$cur_id);
            $cnt = (int) $model->getItem();
            echo $cnt;
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            echo 'RADCurrency.message("'.$this->lang('-error').'");';
        }
    }

}