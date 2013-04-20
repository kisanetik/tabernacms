<?php
/**
 * Общая структура RSS 2.0 канала
 * @author slavik
 */
class rss_struct {
    /** Обязательные элементы канала */
    // Название канала
    public $title = '';
    // Ссылка на канал
    public $link = '';
    // Описание канала
    public $description = '';
    
    /** Дополнительные элементы канала */
    // Язык канала
    public $language = '';
    // Авторские права на канал.
    public $copyright = '';
    // Адрес электронной почты редактора данного канала.
    public $managingEditor = '';
    //  Адрес электронной почты администратора сайта, на котором расположен канал
    public $webmaster = '';
    // Дата публикации содержания в канале
    public $pubDate = '';
    // Дата последнего изменения содержания в канале
    public $lastBuildDate = '';
    // Позволяет добавлять одну или несколько категорий, к которым принадлежит канал
    public $category = '';
    // Программа-генератор, которая создала канал
    public $generator = '';
    // Ссылки на документацию в формате RSS ленты
    public $docs = '';
    // Обеспечивает процесс регистрации в «облако», которое будет использоваться для уведомления об обновлениях
    // public $cloud = '';
    // Время жизни канала в кэше в минутах
    public $ttl = '';
    // Файл изображения, которое будет отображаться в канале
    // public $image = '';
    // PICS рейтинга канала
    public $rating = '';
    // Текстовое поле ввода, которое позволяет пользователям реагировать на канал
    // public $textInput = '';
    // Сообщает агрегаторам (программам читающим RSS-ленты), в какое время мы их не хотим видеть
    public $skipHours = '';
    // Сообщает агрегаторам, в какие дни они не должны нас беспокоит
    public $skipDays = '';
    
    /** Технические элементы структуры */
    // Содержит коллекцию элементов <item> - rss_struct_item
    public $items = array();
    
    function __construct($_title, $_link, $_description) {
        $this->title = $_title;
        $this->link = $_link;
        $this->description = $_description;
        $this->generator = 'Taberna eCommerce CMS';
        if(empty($this->title) or empty($this->link) or empty($this->description)) {
            die('Set required RSS chanel parametrs!');
        }
    }
}

/**
 * Cтруктура элемента <item> RSS канала
 * @author slavik
 */
class rss_struct_item {
    // Уникальный идентификатор элемента item
    public $guid = '';
    // Дата публикации элемента
    public $pubDate = '';
    // Заголовок элемента. В нашем случае он совпадает с заголовком публикуемой записи в интернет-дневнике
    public $title = '';
    // Содержит основные данные элемента. В нашем случае это тело записи в блоге
    public $description = '';
    // Содержит полный URL адрес до страницы, на которой данный элемент представлен максимально подробно
    public $link = '';
    // Автор этой записи
    public $author = '';
    // Позволяет поместить элемент в одну или более категорий
    public $category = '';
    // Ссылка на страницу, где можно оставлять комментарии к этой записи
    public $comments = '';
    // Может быть использован для описания медиа объекта, прикрепленного к элементу
    // public $enclosure = '';
    // Ссылка на RSS-канал, откуда был взят этот элемент
    // public $source = '';
    
    /** Технические элементы структуры */
    // Дата в формате unixstamp для сортировки
    public $sortdate = ''; 
}

/**
 * Class for Show the RSS from catalog
 *
 * @author Yackushev Denys
 * @deprecated 03 March 2011
 * @package RADCMS
 *
 */
class controller_others_rss extends rad_controller
{
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
     * last items for days count
     * @var integer
     */    
    private $lastdays = 14;
    
    /* Main RSS elements */
    
    /**
     * chanel title
     * @var string
     */
    private $rss_title = '';

    /**
     * chanel description
     * @var string
     */
    private $rss_description = '';
    
    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_showArticles = $params->_get('showarticles', $this->_showArticles, $this->getCurrentLangID());
            $this->_treeArticles = $params->_get('treearticles', $this->_treeArticles, $this->getCurrentLangID());
            $this->_showNews = $params->_get('shownews', $this->_showNews, $this->getCurrentLangID());
            $this->_treeNews = $params->_get('treenews', $this->_treeNews, $this->getCurrentLangID());
            $this->_showCatalog = $params->_get('showcatalog', $this->_showCatalog);
            $this->_treeCatalog = $params->_get('treecatalog', $this->_treeCatalog, $this->getCurrentLangID());
            $this->lastdays = $params->_get('lastdays', $this->lastdays);
            if($this->lastdays < 0) {
                $this->lastdays = 0;
            }
            $this->rss_title = $params->_get('rss_title', $this->_showArticles, $this->getCurrentLangID());
            $this->rss_description = $params->_get('rss_description', $this->_showArticles, $this->getCurrentLangID());
        }
        $this->showAllItems();
    }
    
    function showAllItems()
    {
        $d1 = new DateTime();
        $d2 = new DateTime();
        $d2->setTimestamp($d1->getTimestamp() - ($this->lastdays * 24 * 60 * 60));
        $nowTimeStamp = $d1->format("Y-m-d H:i:s");
        $fromTimeStamp = $d2->format("Y-m-d H:i:s");
        
        $generalRSSElements = new rss_struct($this->rss_title, $this->makeURL('') ,$this->rss_description);
        $generalRSSElements->pubDate = date("D, d M Y H:i:s O");
        $generalRSSElements->language = $this->getCurrentLang();
        
        $items = array();
        
        if($this->_showCatalog) {
            $model = rad_instances::get('model_catalog_catalog')
            ->setState('where', "cat_dateupdated >= '".$fromTimeStamp."'")
            ->setState('active', 1)
            ->setState('lang', $this->getCurrentLangID());
            //->setSTate('currency', model_catalog_currcalc::getDefaultCurrencyId());
            $products = $model->getItems();
            if(!empty($products)) {
                foreach($products as $product) {
                    $item = new rss_struct_item();
                    $item->title = strip_tags($product->cat_name);
                    $item->description = htmlspecialchars(strip_tags($product->cat_fulldesc));
                    $item->link = $this->makeURL('alias=product&p='.$product->cat_id);
                    $item->guid = $item->link;
                    list($item->pubDate, $item->sortdate) = $this->_getTimeFormats($product->cat_dateupdated);
                    $items[] = $item;
                    unset($item);
                }
            }
        }
        if($this->_showArticles) {
            $model = rad_instances::get('model_menus_tree');
            $articlesTree = $model->setState('active', 1)
            ->setState('pid', $this->_treeArticles)
            ->setState('lang', $this->getCurrentLangID())
            ->getItems(true);
            $treeIds = $model->getRecurseNodeIDsList($articlesTree, $treeIds);
            if(!empty($treeIds)) {
                $model = rad_instances::get('model_articles_articles')
                ->setState('where', "art_dateupdated >= '".$fromTimeStamp."'")
                ->setState('lang', $this->getCurrentLangID())
                ->setState('active', 1);
                $articles = $model->setState('tre_id', $treeIds)->getItems();
                if(!empty($articles)) {
                    foreach($articles as $article) {
                        $item = new rss_struct_item();
                        $item->title = strip_tags($article->art_title);
                        $item->description = htmlspecialchars(strip_tags($article->art_fulldesc));
                        $item->link = $this->makeURL('alias=articles&a='.$article->art_id);
                        $item->guid = $item->link;
                        list($item->pubDate, $item->sortdate) = $this->_getTimeFormats($article->art_dateupdated);
                        $items[] = $item;
                        unset($item);
                    }
                }
            }
        }
        if($this->_showNews) {
            $model = rad_instances::get('model_menus_tree');
            $newsTree = $model->setState('active', 1)
            ->setState('pid', $this->_treeNews)
            ->setState('lang', $this->getCurrentLangID())
            ->getItems(true);
            $treeIds = $model->getRecurseNodeIDsList($newsTree, $treeIds);
            if(!empty($treeIds)) {
                $model = rad_instances::get('model_catalog_news')
                ->setState('where', "nw_datenews >= '".$fromTimeStamp."' AND nw_datenews <= '".$nowTimeStamp."'")
                ->setState('active', 1)
                ->setState('lang', $this->getCurrentLangID());
                $news = $model->getItems();
                if(!empty($news)) {
                    foreach($news as $nw) {
                        $item = new rss_struct_item();
                        $item->title = strip_tags($nw->nw_title);
                        $item->description = htmlspecialchars(strip_tags($nw->nw_fulldesc));
                        $item->link = $this->makeURL('alias=news&nid='.$nw->nw_id);
                        $item->guid = $item->link;
                        list($item->pubDate, $item->sortdate) = $this->_getTimeFormats($nw->nw_datenews);
                        $items[] = $item;
                        unset($item);
                    }
                }                
            }
        }
        if(!empty($items)) {
            usort($items, array($this, "_sortCmp"));
            $generalRSSElements->items = $items;
            $generalRSSElements->lastBuildDate = $items[0]->pubDate;
        } else {
            $generalRSSElements->lastBuildDate = $generalRSSElements->pubDate;
        }
        $this->setVar('RSSPage', $generalRSSElements);
        $this->header('Content-Type:text/xml');
    }
    
    private function _sortCmp($item1, $item2)
    {
        if ($item1->sortdate == $item2->sortdate) {
            return 0;
        }
        return ($item1->sortdate > $item2->sortdate) ? -1 : 1;
    }
    
    private function _getTimeFormats($date)
    {
        $d1 = new DateTime($date);
        $d2 = new DateTime();
        $d2->setTimestamp($d1->getTimestamp());
        return array($d2->format('D, d M Y H:i:s O'), $d1->getTimestamp());
    }
}