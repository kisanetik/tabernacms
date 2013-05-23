<?php
/**
 * Shows the sitemap
 * @author Denys Yackushev
 * @version 0.1
 * @pachage RADCMS
 */
class controller_others_sitemap extends rad_controller
{
    /**
     * <ru>Показывать статические страницы?</ru>
     * <en>Show static pages?</en>
     * @var boolean
     */
    private $_showPages = 0;

    /**
     * treeId for static pages
     * @var integer
     */
    private $_treePages = 18;

    /**
     * <ru>Показывать статьи?</ru>
     * <en>Show static articles?</en>
     * @var boolean
     */
    private $_showArticles = 0;

    /**
     * treeId for Articles
     * @var integer
     */
    private $_treeArticles = 19;

    /**
     * <ru>Показывать новости?</ru>
     * <en>Show static news?</en>
     * @var boolean
     */
    private $_showNews = 0;

    /**
     * treeId for Articles
     * @var integer
     */
    private $_treeNews = 16;

    /**
     * <ru>Показывать каталог?</ru>
     * <en>Show static catalog?</en>
     * @var boolean
     */
    private $_showCatalog = 0;

    /**
     * treeId for Articles
     * @var integer
     */
    private $_treeCatalog = 37;

    /**
     * which system selected to export XML data
     * @var string
     */
    private $_exportSite = 'sitemap';

    /**
     * shop name parametr for YML
     * @var string
     */
    private $_shopName = 'Taberna Shop';

    /**
     * shop company parametr for YML
     * @var string
     */
    private $_shopCompany = 'Taberna Co';

    /**
     * shop agency parametr for YML
     * @var string
     */
    private $_shopAgency = 'Taberna (tabernacms.com)';

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_showPages = $params->_get('showpages', $this->_showPages, $this->getCurrentLangID());
            $this->_treePages = $params->_get('treepages', $this->_treePages, $this->getCurrentLangID());
            $this->_showArticles = $params->_get('showarticles', $this->_showArticles, $this->getCurrentLangID());
            $this->_treeArticles = $params->_get('treearticles', $this->_treeArticles, $this->getCurrentLangID());
            $this->_showNews = $params->_get('shownews', $this->_showNews, $this->getCurrentLangID());
            $this->_treeNews = $params->_get('treenews', $this->_treeNews, $this->getCurrentLangID());
            $this->_showCatalog = $params->_get('showcatalog', $this->_showCatalog);
            $this->_treeCatalog = $params->_get('treecatalog', $this->_treeCatalog, $this->getCurrentLangID());
            $this->_exportSite = $params->_get('export', $this->_exportSite);
            $this->_shopName = $params->_get('shopname', $this->_shopName, $this->getCurrentLangID());
			$this->_shopCompany = $params->_get('shopcompany', $this->_shopCompany, $this->getCurrentLangID());
			$this->_shopAgency = $params->_get('shopagency', $this->_shopAgency, $this->getCurrentLangID());
            $this->setVar('params',$params);
        }
        switch($this->_exportSite) {
        	case 'sitemap':
		        if($this->_showPages) {
		            $pagesTree = rad_instances::get('model_menus_tree')->setState('active', 1)
		                                   ->setState('pid', $this->_treePages)
		                                   ->setState('lang', $this->getCurrentLangID())
		                                   ->getItems(true);
		            $modelPages = rad_instances::get('model_catalog_pages')
		                                         ->setState('lang', $this->getCurrentLangID())
		                                         ->setState('active', 1);
		            if(!empty($pagesTree)) {
		                $trees = array();
		                foreach($pagesTree as $treePageT) {
		                    $trees[] = (int)$treePageT->tre_id;
		                }
		                $pages = $modelPages->setState('tre_id', $trees)
		                                    ->getItems();
		                if(!empty($pages)) {
		                    foreach($pagesTree as &$treePage) {
		                        foreach($pages as $page) {
		                            if($page->pg_tre_id==$treePage->tre_id) {
		                                $treePage->pages[] = $page;
		                            }
		                        }
		                    }
		                }
		                $this->setVar('pages', $pagesTree);
		            }
		        }//Show Pages

		        if($this->_showArticles) {
		            $articlesTree = rad_instances::get('model_menus_tree')->setState('active', 1)
		                                      ->setState('pid', $this->_treeArticles)
		                                      ->setState('lang', $this->getCurrentLangID())
		                                      ->getItems(true);
		            $modelArticles = rad_instances::get('model_articles_articles')
		                                          ->setState('lang', $this->getCurrentLangID())
		                                          ->setState('active', 1);
		            if(!empty($articlesTree)) {
		                $articlesT = array();
		                foreach($articlesTree as $treeA) {
		                    $articlesT[] = (int)$treeA->tre_id;
		                }
		                $articles = $modelArticles->setState('tre_id', $articlesT)
		                                          ->getItems();
		                if(!empty($articles)) {
		                    foreach($articlesTree as $treeArticle) {
		                        foreach($articles as $article) {
		                            if($article->art_treid==$treeArticle->tre_id) {
		                                $treeArticle->articles[] = $article;
		                            }
		                        }
		                    }
		                }
		            }
		            $this->setVar('articles', $articlesTree);
		        }//Show Articles

		        if($this->_showNews) {
		            $newsTree = rad_instances::get('model_menus_tree')->setState('active', 1)
		                                      ->setState('pid', $this->_treeNews)
		                                      ->setState('lang', $this->getCurrentLangID())
		                                      ->getItems(true);
		            $news = rad_instances::get('model_catalog_news')
		                                    ->setState('active', 1)
		                                    ->setState('lang', $this->getCurrentLangID())
		                                    ->getItems();
		            if(!empty($news)) {
		                foreach($news as $newsId) {
		                    $this->_newsRecursy($newsTree, $newsId);
		                }
		                $this->setVar('news', $newsTree);
		            }
		        }//Show News

		        if($this->_showCatalog) {
		            $catalogTree = rad_instances::get('model_menus_tree')->setState('active', 1)
		                                      ->setState('pid', $this->_treeCatalog)
		                                      ->setState('lang', $this->getCurrentLangID())
		                                      ->getItems(true);
		            $modelCatalog = rad_instances::get('model_catalog_catalog')
		                                        ->setState('active', 1)
		                                        ->setState('join.mainimage', true)
		                                        ->setState('join.tree', true)
		                                        ->setState('lang', $this->getCurrentLangID())
		                                        ->setSTate('currency', model_catalog_currcalc::getDefaultCurrencyId());
		            $products = $modelCatalog->getItems();
		            foreach($products as $product) {
		                $this->_catRecursy($catalogTree, $product);
		            }
		            $this->setVar('catalog', $catalogTree);
		        }//Show Catalog
		        break;
			case 'yandex.yml':
				header("Content-Type: text/xml");
        		$this->setVar('nowdate', date("Y-m-d H:i"));
        		$this->setVar('shop_name', (mb_strlen($this->_shopName, 'utf-8') >= 20) ? mb_substr( $this->_shopName, 0, 17, 'utf-8') . '...' : $this->_shopName); //Короткое название магазина — название, которое выводится в списке найденных на Яндекс. Маркете товаров. Оно не должно содержать более 20 символов.
        		$this->setVar('shop_company', $this->_shopCompany); //Полное наименование компании, владеющей магазином. Не публикуется, используется для внутренней идентификации
		        $this->setVar('shop_url', $this->config('url')); //URL главной страницы магазина.
		        $this->setVar('shop_platform', 'Taberna'); //CMS, на основе которой работает магазин.
		        $this->setVar('shop_version', rad_update::getInstance()->getCurrentVersion()); //Версия CMS.
		        $this->setVar('shop_agency', $this->_shopAgency); //Наименование агентства, которое оказывает техническую поддержку магазину и отвечает за работоспособность сайта.
		        $this->setVar('shop_email', $this->config('system.mail')); //Контактный адрес разработчиков CMS или агентства, осуществляющего техподдержку.
		        //	Show currencies
		        $currencies = rad_instances::get('model_catalog_currency')->getItems();
		        $this->setVar('currencies', $currencies);
				//	Show categries & offers
		        $this->setVar('showCatalog', $this->_showCatalog);
		        if($this->_showCatalog) {
		            $catalogTree = rad_instances::get('model_menus_tree')->setState('active', 1)
		                                      ->setState('pid', $this->_treeCatalog)
		                                      ->setState('lang', $this->getCurrentLangID())
		                                      ->getItems(true);
		            $modelCatalog = rad_instances::get('model_catalog_catalog')
		                                        ->setState('active', 1)
		                                        ->setState('join.mainimage', true)
		                                        ->setState('join.tree', true)
		                                        ->setState('lang', $this->getCurrentLangID())
		                                        ->setSTate('currency', model_catalog_currcalc::getDefaultCurrencyId());
		            $products = $modelCatalog->getItems();
		            if(!empty($products)) {
    		            $modelCatalog->getValValues($products);
    		            foreach($products as $product) {
    		            	//	Params
    		            	if(count($product->type_vl_link)) {
    	                    	foreach($product->type_vl_link as $tvlkey => $tvl) {
    	                        	if($product->type_vl_link[$tvlkey]->vl_measurement_id) {
    	                            	$mesId = $product->type_vl_link[$tvlkey]->vl_measurement_id;
    	                            	$mes = new struct_measurement( array('ms_id'=>$mesId) );
    	                            	$mes->load();
    	                            	$product->type_vl_link[$tvlkey]->ms_value = trim($mes->ms_value);
    	                        	}
    	                    	}
                    		}
                    		//	Pictures
    			            $model_images = rad_instances::get('model_system_image');
    			            $model_images->setState('cat_id',$product->cat_id);
    			            $product->images_link = $model_images->getItems();
    			            //	Name
    		                if(mb_strlen($product->cat_name, 'utf-8') >= 255) {
                    			$product->cat_shortdesc = mb_substr($product->cat_name, 0, 252, 'utf-8' ) . '...';
                    		}
    			            //	Desctiption
                    		$product->cat_shortdesc = strip_tags($product->cat_shortdesc);
                    		if(mb_strlen($product->cat_shortdesc, 'utf-8') >= 512) {
                    			$product->cat_shortdesc = mb_substr($product->cat_shortdesc, 0, 509, 'utf-8' ) . '...';
                    		}
    		                $this->_catRecursy($catalogTree, $product);
    		            }
		            }
		            $this->setVar('catalog', $catalogTree);
		        }
        }
    }

    private function _newsRecursy($cats, $news)
    {
        foreach($cats as &$cat) {
            if($cat->tre_id==$news->nw_tre_id) {
                $cat->news[] = $news;
            }
            if(!empty($cat->child)) {
                $this->_catRecursy($cat->child, $news);
            }
        }
    }

    private function _catRecursy(&$cats, $product)
    {
        foreach($cats as &$cat) {
            if(empty($cat->tre_id)) {
                continue;
            }
            if(!empty($product->tree_link->tre_id) and $cat->tre_id==$product->tree_link->tre_id) {
                $cat->products[] = $product;
            }
            if(!empty($cat->child)) {
                $this->_catRecursy($cat->child, $product);
            }
        }
    }

}