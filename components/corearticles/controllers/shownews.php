<?php
/**
 * Class for managing products
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corearticles_shownews extends rad_controller
{
    private $_pid = 16;

    private $_countitems = 3;

    /**
     * Items per page or the same in bt news
     */
    private $_itemsperpage = 10;

    private $_itemsperpagelast = 6;

    /**
     * To show the news between dates - current news
     * @var boolean
     */
    private $_bt_dates = false;

    /**
     * To show the only last news box
     * @var boolean
     */
    private $_last_news = false;

    /**
     * Show dates box if show only one news?
     * @var boolean
     */
    private $_showononenews = true;

    /**
     * Is need to show the Folk news?
     * @var boolean
     */
    private $_isfolknews = false;

    /**
     * is show on main page?
     * @var boolean
     */
    private $_showismain = false;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('categories');
        $bco->add('cur_category_id');
        $bco->add('item');
        $bco->add('default_pid');
        $bco->add('curr_category');
        $bco->add('monthshow');
        /*
$bco->add('topmenu_level2',2);
*/
        return $bco;
    }

    function __construct()
    {
        if ($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getCurrentLangID());
            $this->_countitems = $params->_get('countitems', false);
            $this->_isLeftMenu = (bool)$this->_countitems;
            $this->_itemsperpage = $params->_get('itemsperpage', $this->_itemsperpage);
            $this->_bt_dates = $params->_get('bt_dates', $this->_bt_dates);
            $this->_last_news = $params->_get('last_news', $this->_last_news);
            $this->_itemsperpagelast = $params->_get('itemsperpagelast', $this->_itemsperpagelast);
            $this->_showononenews = $params->_get('showononenews', $this->_showononenews);
            $this->_isfolknews = $params->_get('isfolknews', $this->_isfolknews);
            $this->_showismain = $params->_get('showismain', false);
            $this->setVar('params', $params);
        }
        if ($this->_bt_dates) {
            $this->getBTNews();
        } elseif ($this->_last_news) {

        } elseif ($this->_showismain) {
            $this->showIsMain();
        } elseif ($this->request('nid') and (!isset($this->getParamsObject()->countitems) or !$this->getParamsObject()->countitems)) {
            $this->getOneNews();
            if ($this->getParamsObject() and $this->getParamsObject()->isdates) {
                $this->getDatesBox();
            }
        } elseif ($this->request('org')) {
            $this->getOrganizationNews();
        } else {
            if ($this->getParamsObject() and $this->getParamsObject()->isdates) {
                $this->getDatesBox();
            } else {
                $this->getLastItems();
                if (empty($this->getParamsObject()->countitems)) {
                    $this->getCategoriesNews();
                }
            }
        }
    }

    /**
     * gets the last news
     */
    function getLastItems()
    {
        $model = rad_instances::get('model_corearticles_news');
        $model->setState('nw_folk', $this->_isfolknews);
        $model->setState('nw_active', 1);
        $getparams = null;
        $cat = (int)$this->request('cat_n');
        if ($cat) {
            $getparams = 'cat_n=' . $this->request('cat_n');
        }
        $cat = ($cat) ? $cat : $this->_pid;
        if (!$this->_isLeftMenu)
            $this->addBC('cur_category_id', $cat);
        $category = rad_instances::get('model_coremenus_tree')->getItem($cat);
        if (!$this->_isLeftMenu)
            $this->addBC('curr_category', $category);
        $p = (int)$this->request('p');
        $page = ($p) ? $p : 0;
        $limit = ($page * $this->_itemsperpage) . ',' . $this->_itemsperpage;
        if ($this->request('d')) {
            $getparams = ($getparams) ? '&' . $getparams : '';
            $getparams .= 'd=' . $this->request('d');
            $tmp_mas = explode('-', $this->request('d'));
            if (count($tmp_mas) == 2) {
                $montstart = mktime(0, 0, 0, (int)$tmp_mas[0], 1, (int)$tmp_mas[1]);
                $daysinmonth = date("t", $montstart);
                $monthend = mktime(0, 0, 0, (int)$tmp_mas[0], $daysinmonth, (int)$tmp_mas[1]);
                $model->setState('where', 'nw_datenews>="' . date($this->config('datetime.format'), $montstart) . '" and nw_datenews<="' . date($this->config('datetime.format'), $monthend) . '"');
            } elseif (count($tmp_mas) == 3) {
                $monthshow = mktime(0, 0, 0, (int)$tmp_mas[1], $tmp_mas[0], (int)$tmp_mas[2]);
                $model->setState('where', 'nw_datenews="' . date($this->config('datetime.format'), $monthshow) . '"');
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $model->setState('nw_tre_id', $cat);
        }
        $this->setVar('gp', $getparams);
        $tmpItem = new struct_corearticles_news();
        if (isset($tmpItem->nw_langid)) {
            $model->setState('lang', $this->getCurrentLangID());
        }
        if ($this->request('cat') and !$this->_isLeftMenu) {
            $this->setVar('items', $model->getItems($limit));
        } else {
            if ($this->_countitems) {
                $this->setVar('items', $model->getItems($this->_countitems));
            } else {
                $p = (int)$this->request('p');
                if ($p) {
                    $limit = ($p * $this->_itemsperpage) . ',' . $this->_itemsperpage;
                    $model->setState('limit', $limit);
                    $this->setVar('items', $model->getItems());
                } else {
                    $this->setVar('items', $model->getItems($this->_itemsperpage));
                }
            }
        }
        $model->setState('select', 'count(*)');
        $items_count = $model->getItems();
        $this->setVar('total_rows', $items_count);
        $pages = div((int)$items_count, $this->_itemsperpage);
        $pages += (mod($items_count, $this->_itemsperpage)) ? 1 : 0;
        $this->setVar('pages_count', $pages + 1);
        $this->setVar('page', $page + 1);
        $this->setVar('title_category', filter_var($this->request('t'), FILTER_SANITIZE_STRING));
    }

    /**
     * Get only one news by it nid
     */
    function getOneNews()
    {
        $nid = (int)$this->request('nid');
        if ($nid) {
            $model = rad_instances::get('model_corearticles_news');
            $model->setState('nw_folk', $this->_isfolknews);
            $model->setState('nw_active', 1);
            $item = $model->getItem($nid);
            if (!(int)$item->nw_id or ($this->request('title') and $this->request('title') != $item->nw_title)) {
                $this->header($this->config('header.404'));
                $this->header('Location: ' . SITE_URL . $this->config('alias.404'));
                $this->redirect(SITE_URL . $this->config('alias.404'));
            } else {
                if (!$this->_isLeftMenu)
                    $this->addBC('item', $item);
                $this->setVar('item', $item);
                $cur_category = rad_instances::get('model_coremenus_tree')->getItem($item->nw_tre_id);
                if (!$this->_isLeftMenu) {
                    $this->addBC('curr_category', $cur_category);
                    $this->addBC('cur_category_id', $item->nw_tre_id);
                    $this->addBC('default_pid', $this->_pid);
                }
                $this->setVar('default_pid', $this->_pid);
                if (isset($_SERVER['HTTP_REFERER']) and strlen($_SERVER['HTTP_REFERER'])) {
                    if (filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE) {
                        $this->setVar('back_url', SITE_URL);
                    } else {
                        $parts = parse_url($_SERVER['HTTP_REFERER']);
                        $domain = $parts['scheme'] . '://' . str_replace('www', '', $parts['host']);
                        $myparts = parse_url(SITE_URL);
                        $mydomain = $domain = $myparts['scheme'] . '://' . str_replace('www', '', $myparts['host']);
                        if ($domain == $mydomain) {
                            $this->setVar('back_url', $_SERVER['HTTP_REFERER']);
                        } else {
                            $this->setVar('back_url', SITE_URL);
                        }
                    }
                } else {
                    $this->setVar('back_url', SITE_URL);
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     *  gets the news categories from rad_tree
     */
    function getCategoriesNews()
    {
        $cat = (int)$this->request('cat_n');
        $cat = ($cat) ? $cat : $this->_pid;
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid', $cat);
        $model->setState('active', '1');
        $news_categories = $model->getItems();
        $this->setVar('categories', $news_categories);
        if (!$this->_isLeftMenu)
            $this->addBC('categories', $news_categories);
        $this->setVar('cur_category_id', $cat);
        if (!$this->_isLeftMenu)
            $this->addBC('default_pid', $this->_pid);
    }

    /**
     * Get the dates filter for DatesBox
     */
    function getDatesBox()
    {
        if ($this->request('d')) {
            $tmp_mas = explode('-', $this->request('d'));
            if (count($tmp_mas) == 2) {
                $monthshow = mktime(0, 0, 0, (int)$tmp_mas[0], 1, (int)$tmp_mas[1]);
                if (!$this->_isLeftMenu)
                    $this->addBC('monthshow', $monthshow);
            } elseif (count($tmp_mas) == 3) {
                $monthshow = mktime(0, 0, 0, (int)$tmp_mas[1], $tmp_mas[0], (int)$tmp_mas[2]);
                if (!$this->_isLeftMenu)
                    $this->addBC('monthshow', $monthshow);
                $currselected = &$monthshow;
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            if ($this->request('nid') and $this->getVar('item')) {
                $this->setVar('showonenews', true);
                $monthshow = strtotime($this->getVar('item')->nw_datenews);
            } else {
                $monthshow = time();
            }
        }
        if (!$this->request('nid') or $this->_showononenews) {
            $daysinmonth = date("t", $monthshow);
            $this->setVar('selectedYear', (int)date('Y', $monthshow));
            $this->setVar('selectedMonth', (int)date('m', $monthshow));
            $this->setVar('currentYear', (int)date('Y'));
            if (date('m', $monthshow) > 1) {
                $daysinPreviousMonth = date("t", mktime(0, 0, 0, date('m', $monthshow) - 1, 5, date('Y', $monthshow)));
                $priviousmonth = mktime(0, 0, 0, date('m', $monthshow) - 1, 5, date('Y', $monthshow));
            } else {
                $daysinPreviousMonth = date("t", mktime(0, 0, 0, 12, 5, date('Y', $monthshow) - 1));
                $priviousmonth = mktime(0, 0, 0, 12, 5, date('Y', $monthshow) - 1);
            }
            $month = array();
            $dayofweek = date('w', mktime(0, 0, 0, date('m', $monthshow), 1, date('Y', $monthshow)));
            //make days in last month
            if ($dayofweek != 1) {
                for ($i = $daysinPreviousMonth - $dayofweek + 2; $i <= $daysinPreviousMonth; $i++) {
                    $month[] = array('date' => $i, 'currmonth' => false, 'previousmonth' => true, 'dayofweek' => date('w', mktime(0, 0, 0, date('m', $priviousmonth), $i, date('Y', $priviousmonth))), 'fulldate' => mktime(0, 0, 0, date('m', $priviousmonth), $i, date('Y', $priviousmonth)));
                }
            }
            for ($i = 0; $i < $daysinmonth; $i++) {
                $dayofweek = date('w', mktime(0, 0, 0, date('m', $monthshow), $i + 1, date('Y', $monthshow)));
                $dayofweek = ($dayofweek == 0) ? 7 : $dayofweek;
                $month[] = array('date' => $i + 1, 'currmonth' => true, 'previousmonth' => false, 'dayofweek' => $dayofweek, 'fulldate' => mktime(0, 0, 0, date('m', $monthshow), $i + 1, date('Y', $monthshow)));
            }
            //for
            if (date('m', $monthshow) < 12) {
                $nextmonth = mktime(0, 0, 0, date('m', $monthshow) + 1, 1, date('Y', $monthshow));
            } else {
                $nextmonth = mktime(0, 0, 0, 1, 1, date('Y', $monthshow) + 1);
            }
            if ($month[count($month) - 1]['dayofweek'] != 7) {
                $tmp_date = 1;
                for ($i = $month[count($month) - 1]['dayofweek'] + 1; $i <= 7; $i++) {
                    $month[] = array('date' => $tmp_date, 'currmonth' => false, 'previousmonth' => false, 'dayofweek' => $i, 'fulldate' => mktime(0, 0, 0, date('m', $nextmonth), $tmp_date, date('Y', $nextmonth)));
                    $tmp_date++;
                }
            }
            $this->setVar('daysinmonth', $daysinmonth);
            $this->setVar('monthshow', $monthshow);
            $this->setVar('previousmonth', $priviousmonth);
            $this->setVar('nextmonth', $nextmonth);
            $previousuri = date('m-Y', $priviousmonth);
            $this->setVar('previousUri', $previousuri);
            $nexturi = date('m-Y', $nextmonth);
            $this->setVar('nextUri', $nexturi);
            $this->setVar('currdate', date('j'));
            if (isset($currselected))
                $this->setVar('currselected', $currselected);
            //Определяем в какие даты у нас есть новости, а в каких нету.
            $model = rad_instances::get('model_corearticles_news');
            //Get first news date
            $model->setState('nw_folk', $this->_isfolknews);
            $model->setState('select', 'MIN(nw_datenews)');
            $firstDate = $model->getItem();
            $model->unsetState('select');
            if (count($firstDate)) {
                //echo 'fd=';print_r($firstDate);
                $firstDate = date("Y", strtotime($firstDate['MIN(nw_datenews)']));
                $this->setVar('firstYear', $firstDate);
            } else {
                //for future
            }
            //get news
            $model->setState('where', 'nw_datenews>="' . date($this->config('datetime.format'), $month[0]['fulldate']) . '" and nw_datenews<="' . date($this->config('datetime.format'), $month[count($month) - 1]['fulldate']) . '"');
            $tmp_item = new struct_corearticles_news();
            if (isset($tmp_item->nw_langid))
                $model->setState('lang', $this->getCurrentLangID());
            $model->setState('nw_active', 1);
            $model->setState('select', 'nw_datenews');
            $news_items = $model->getItems();
            if (count($news_items))
                foreach ($news_items as $news_item) {
                    $tmp_datenews = strtotime($news_item->nw_datenews);
                    for ($i = 0; $i < count($month); $i++)
                        if ($month[$i]['fulldate'] == $tmp_datenews) {
                            $month[$i]['hrefisset'] = date('d-m-Y', $tmp_datenews);
                            break;
                        }
                }
            //foreach
            $this->setVar('monthdates', $month);
            return $month;
        }
    }

    //function getDatesBox

    /**
     * Get the current news where nw_datenews_from<=now()<=nw_datenews_from
     * And gets the last news
     */
    function getBTNews()
    {
        $model = rad_instances::get('model_corearticles_news');
        $model->setState('lang', $this->getCurrentLangID());
        $model->setState('nw_active', 1);
        $model->setState('nw_folk', $this->_isfolknews);
        $model->setState('where', 'nw_datenews_from <= "' . date("Y-m-d") . ' 23:59:59" AND nw_datenews_to >= "' . date("Y-m-d") . ' 00:00:00"');
        $bt_news = $model->getItems($this->_itemsperpage);
        $model->unsetState('where');
        //$model->setState('order by','nw_datenews DESC');
        $last_news = $model->getItems($this->_itemsperpagelast);
        if (count($last_news))
            foreach ($last_news as $ln)
                $all_ids[] = $ln->nw_id;
        if ($this->_showononenews) {
            $bt_mas = array();
            if (count($bt_news)) {
                foreach ($bt_news as $id) {
                    $bt_mas[] = $id->nw_id;
                    //$all_ids[] = $id->nw_id;
                }
            }
            if (count($last_news) and count($bt_mas)) {
                $replace_i = array();
                for ($i = 0; $i < count($last_news); $i++) {
                    if (in_array($last_news[$i]->nw_id, $bt_mas)) {
                        $replace_i[] = $i;
                        unset($last_news[$i]);
                    }
                }
                if (count($replace_i) and count($all_ids)) {
                    $model->setState('where', 'nw_id NOT IN(' . implode(',', $all_ids) . ')');
                    //$model->setState('showSQL',true);
                    $ri = $model->getItems(count($replace_i));
                    if (count($ri))
                        for ($i = 0; $i < count($ri); $i++) {
                            array_push($last_news, $ri[$i]);
                            //$last_news[$replace_i[$i]] = $ri[$i];
                        }
                    //for
                }
            }
        }
        $this->setVar('bt_news', $bt_news);
        $this->setVar('last_news', $last_news);
    }

    //getBTNews

    /**
     * Shows only main (Home) news
     */
    function showIsMain()
    {
        $model = rad_instances::get('model_corearticles_news');
        $model->setState('lang', $this->getCurrentLangID());
        $model->setState('where', 'nw_ismain=1');
        $item = $model->getItems('1');
        if (count($item))
            $this->setVar('item', $item[0]);
    }

    function getOrganizationNews()
    {
        $user_id = (int)$this->request('org');
        if ($user_id) {
            $model = rad_instances::get('model_corearticles_news');
            $model->setState('lang', $this->getCurrentLangID());
            $model->setState('userid', $user_id);
            $model->setState('nw_active', '1');
            $model->setState('nw_folk', $this->_isfolknews);
            /* PAGING */
            $p = (int)$this->request('p');
            $page = ($p) ? $p : 0;
            $limit = ($page * $this->_itemsperpage) . ',' . $this->_itemsperpage;
            $this->setVar('gp', 'org=' . (int)$this->request('org'));
            $model->setState('select', 'count(*)');
            $items_count = $model->getItems();
            $this->setVar('total_rows', $items_count);
            $pages = div((int)$items_count, $this->_itemsperpage);
            $pages += (mod($items_count, $this->_itemsperpage)) ? 1 : 0;
            $this->setVar('pages_count', $pages + 1);
            $this->setVar('page', $page + 1);
            /* END PAGING */
            $model->unsetState('select');
            $items = $model->getItems();
            $this->setVar('items', $items);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

}//class
