<?php
/**
 * Для подсчета кол-ва страниц и пэйджинга
 * @deprecated 0.1 - 18 October 2010
 * @package RADCMS
 * @version 0.1
 * @author Yackushev Denys
 *
 */
class rad_paginator
{
    /**
     * Show link to first page?
     * @var boolean default is true
     */
    protected $showFirst = true;

    /**
     * Show link to last page?
     * @var boolean default is true
     */
    protected $showLast = true;

    protected $texts = array();

    /**
     * Default varname in REQUEST or GET param
     * @var string
     */
    protected $getParam = 'page';

    /**
     * Additional get params
     * @var string - in format http, like var1=value1&var2=value2&var3=value3
     */
    protected $getParams = '';

    /**
     * Calculated count of the pages
     */
    protected $pagesCount = 0;

    /**
     * The current page
     * @var integer
     */
    protected $currentPage = 1;

    protected $itemsPerPage = 20;

    /**
     * Кол-во отображаемых строниц слева и справа от текущей
     * @var integer
     */
    protected $neighbours = 6;

    protected $totalRows = 0;

    /**
     * Делать алиась только с окончанием XML
     * @var boolean
     */
    protected $addAliasXML = false;

    /**
     * Internal iterator for the calculation
     * @var integer
     */
    private $iterator = 0;

    /**
     * Count pages at the left of the current page
     * @var integer
     */
    private $leftNeighbour = 0;

    /**
     * Count pages at the right of the current page
     * @var integer
     */
    private $rightNeighbour = 0;

    /**
     * Constructor
     * @param mixed array $params
     */
    public function __construct($params)
    {
        if(!isset($params['total'])){
            throw new rad_exception('Param "total" in class '.get_class($this).' is required!', __LINE__);
        }
        //текста по умолчанию
        $this->texts = array(
            'first'=>$this->lang('-first'),
            'last'=>$this->lang('-last'),
            'next'=>$this->lang('-next'),
            'prev'=>$this->lang('-prev'),
            'ellipsis'=>'...'
        );
        $this->totalRows = $params['total'];
        //Кол-во на странице записей
        $this->itemsPerPage = (!empty($params['itemsperpage'])?$params['itemsperpage']:$this->itemsPerPage);
        //Показывать ссылку на первую страницу?
        $this->showFirst = (bool)(isset($params['showfirst'])?$params['showfirst']:$this->showFirst);
        $this->showLast = (bool)(isset($params['showlast'])?$params['showlast']:$this->showLast);
        //Имя параметра, содержащего номер страницы
        $this->getParam = (!empty($params['getparam'])?$params['getparam']:$this->getParam);
        $this->getParams = ( (!empty($params['getparams']) and strlen($params['getparams']) )?$params['getparams']:'' );
        $this->addAliasXML = (bool)(isset($params['addAliasXML'])?$params['addAliasXML']:$this->addAliasXML);

        /* Calculation */

        //Кол-во страниц
        $this->pagesCount = ceil($this->totalRows/$this->itemsPerPage);
        //Текущая страница
        $this->currentPage = rad_input::request($this->getParam, $this->currentPage);
        $this->currentPage = ($this->currentPage < 1?1:$this->currentPage);
        $this->currentPage = ($this->currentPage > $this->totalRows?$this->totalRows:$this->currentPage);
        //Кол-во страниц слева
        $this->leftNeighbour = $this->currentPage - $this->neighbours;
        $this->leftNeighbour = ($this->leftNeighbour < 1?1:$this->leftNeighbour);
        //Кол-во страниц справа
        $this->rightNeighbour = $this->currentPage + $this->neighbours;
        $this->rightNeighbour = ($this->rightNeighbour > $this->pagesCount?$this->pagesCount:$this->rightNeighbour);

//        $this->texts = ( (isset($params['texts']) and is_array($params['texts']))?array_merge($this->texts, $params['texts']):$this->texts);
    }

    private function lang($code='')
    {
        call_user_func(array(rad_config::getParam('loader_class'),'checkLangContainer'));
        return call_user_func_array( array(rad_config::getParam('loader_class'),'lang'), array($code) );
    }

    /**
     * Возвращает лимит для запроса
     * @param $page string номер страницы
     * @return string Вставка в SQL запрос с лимитом
     */
    public function getSQLLimit($page=NULL)
    {
        $page = (int) $page > 0 ? (int) $page : $this->currentPage;
        return ( ($page-1)*$this->itemsPerPage ).','.$this->itemsPerPage;
    }

    /**
     * Определяет, нужна-ли ссылка в начало (на первую страницу)
     * @return boolean
     */
    public function hasFirstLink()
    {
        return (bool)$this->showFirst and $this->currentPage > 1;
    }

    /**
     * Определяет, нужна-ли ссылка в начало (на первую страницу)
     * @return boolean
     */
    public function hasLastLink()
    {
        return (bool)$this->showLast and $this->currentPage < $this->pagesCount;
    }

    /**
     * Gets the pages
     * @return array of paginator_page
     */
    public function getPages()
    {
        $result = array();
        if($this->showFirst){
            $current = ($this->currentPage==$this->leftNeighbour)?true:false;
            $result[] = new paginator_page(array('text'=>$this->texts['first'], 'url'=>$this->makeUrl(1), 'isCurrentPage'=>$current, 'count'=>$this->pagesCount, 'current'=>$this->leftNeighbour));
        }
        for($this->iterator=$this->leftNeighbour; $this->iterator <= $this->rightNeighbour; $this->iterator++){
            if($this->iterator!=$this->currentPage)
                $result[] = new paginator_page( array('text'=>$this->iterator, 'url'=>$this->makeUrl( $this->iterator ), 'count'=>$this->pagesCount, 'current'=>$this->iterator) );
            else
                $result[] = new paginator_page( array('text'=>$this->iterator, 'url'=>'', 'isCurrentPage'=>true, 'count'=>$this->pagesCount, 'current'=>$this->iterator) );
        }
        if($this->showLast){
            $current = ($this->currentPage==$this->rightNeighbour)?true:false;
            $result[] = new paginator_page(array('text'=>$this->texts['last'], 'url'=>$this->makeUrl($this->pagesCount), 'isCurrentPage'=>$current, 'count'=>$this->pagesCount, 'current'=>$this->rightNeighbour));
        }
        //var_dump($result); die();
        return $result;
    }

    protected function makeUrl($page)
    {
        if($page==1 and SITE_ALIAS==rad_config::getParam('defaultAlias', 'index.html'))
            return SITE_URL;
        $current = ($this->currentPage==$this->rightNeighbour)?true:false;
        $gp = (strlen($this->getParams)?'&'.$this->getParams:'');
        $site_alias = SITE_ALIAS;
        if($this->addAliasXML and substr($site_alias,-3)!='XML')
            $site_alias.='XML';
        return rad_input::makeURL( 'alias='.$site_alias.$gp.( ($page>1)?'&'.$this->getParam.'='.$page:'') );
    }
}

class paginator_page
{
    private $url = '#';

    private $text = '';

    private $current = 1;

    private $cnt = 1;

    public $isCurrentPage = false;

    function __construct($params)
    {
        $this->url = $params['url'];
        $this->text = $params['text'];
        $this->current = (isset($params['current'])?$params['current']:$this->current);
        $this->cnt = $params['count'];
        $this->isCurrentPage = (isset($params['isCurrentPage'])?$params['isCurrentPage']:$this->isCurrentPage);
    }

    function getHtml()
    {
        //Make the html
    }

    function href()
    {
        return $this->url;
    }

    function text()
    {
        return $this->text;
    }


    public function pageNumber()
    {
        return $this->current;
    }

/*
    function isFirst()
    {
        return (bool)$this->current==1;
    }

    function isLast()
    {
        return (bool)$this->current==$this->cnt;
    }
    */
}