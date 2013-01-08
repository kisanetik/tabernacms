<?php
/**
 * Products tree
 * @authof Tereshchenko Viacheslav
 * @package Taberna
 */
class controller_system_productstree extends rad_controller
{
    /**
     * Root parent id
     *
     * @var integer
     */
    private $_pid = 81;
    
    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->SetVar('params', $params);
        }
        if($this->request('action')) {//action
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'openProductsTree':
                    $this->openProductsTree();
                    break;
                case 'getProductsJSON':
                    $this->getProductsJSON();
                    break;
                case 'getProductsRootJSON':
                    $this->getProductsRootJSON();
                    break;
                default:
                    $this->redirect('404');
                    break;
            }
        }
    }
    
    public function openProductsTree()
    {
        // ...
    }
    
    public function getProductsRootJSON() {
        $model = rad_instances::get('model_menus_tree');
        $root_node = $model->getItem($this->request('pid',$this->_pid));
        if(count($root_node)) {
            $nodes = array();
            $search = array('"', '&');
            $replace = array('&quot;','&amp;');
            $nodes = array(
                        array(
                            'property' => array(
                                    'name' => str_replace($search, $replace, $root_node->tre_name),
                                    'hasCheckbox' => false
                            ),
                            'type' => 'folder',
                            'data' => array(
                                    'node_id' => $root_node->tre_id
                            )
                        )
            );
            echo json_encode($nodes);
        }
    }
    
    public function getProductsJSON()
    {
        $model = rad_instances::get('model_menus_tree');
        $model->setState('pid',$this->request('npid',$this->request('pid')));
        $model->setState('lang',$this->getContentLangID());
        $items = $model->getItems();
        $nodes = array();
        $search = array('"', '&');
        $replace = array('&quot;','&amp;');
        $modelCat = rad_instances::get('model_catalog_catalog');
        if(count($items)) {
            foreach($items as $id) {
                $modelCat->clearState();
                $modelCat->setState('tre_id', $id->tre_id)->setState('lang', $this->getContentLangID());
                $productsCntInTree = (int) $modelCat->getProductsListCount();
                if(!$id->tre_islast or $productsCntInTree) {
                    $nodes[] = array(
                            'property' => array(
                                'name' => str_replace($search, $replace, $id->tre_name),
                                'hasCheckbox' => false
                            ),
                            'type' => 'folder',
                            'data' => array(
                                'npid' => $id->tre_id
                            )
                    );
                } elseif($id->tre_islast and $productsCntInTree === 0) {
                    $nodes[] = array(
                            'property' => array(
                                    'name' => str_replace($search, $replace, $id->tre_name),
                                    'hasCheckbox' => false
                            ),
                            'type' => 'empty'
                    );
                }
            }
        }
        $modelCat->setState('tre_id', $this->request('npid',$this->request('pid')));
        $modelCat->setState('lang', $this->getContentLangID());
        $productsInTree = $modelCat->getProductsList();
        if(count($productsInTree)) {
            foreach($productsInTree as $product) {
                $nodes[] = array(
                        'property' => array(
                                'name' => str_replace($search, $replace, $product->cat_name),
                                'openIconUrl'=> (!empty($product->img_filename)) ? "/image.php?f={$product->img_filename}&w=16&h=16&m=catalog" : '',
                                'closeIconUrl'=> (!empty($product->img_filename)) ? "/image.php?f={$product->img_filename}&w=16&h=16&m=catalog" : '',
                        ),
                        'type' => 'file',
                        'data' => array(
                            'product_id' => $product->cat_id
                        )
                );
            }
        }
        $this->header('Content-Type: application/json');
        echo json_encode($nodes);
    }

}