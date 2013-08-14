<?php
/**
 * Manage Languages in admin
 * @author Yackushev Denys, Novitsky Sergey, Ivan Kelembetov
 * @package RADCMS
 * @version 0.3
 */
class controller_core_managelang extends rad_controller
{
    /**
     * Default language
     * @var string
     */
    var $_default_lang = 'ru';

    /**
     * vars pagination
     * count of items per page
     * @var integer
     */
    var $_itemsPerPage = 50;
    var $_defaultPage = 1;

    /**
     * Remote url for download languages
     * @var string url without last /
     */
    private $json_url = 'http://lang.taberna.com/json.php';

    function __construct()
    {
        $model = rad_instances::get('model_core_lang');
        $items = $model->getItems();
        $this->setVar('languages', $items);

        if ($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->json_url = $params->_get('url', $this->json_url);

        }
        $this->setVar('searchword', $this->request('searchword', ''));
        $this->setVar('_itemsPerPage', $this->_itemsPerPage);
        if ($this->request('action')){
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')){
                case 'getTreeNodes':
                    $this->getNodes();
                    break;
                case 'applyEditNode':
                    $this->applyEditNode();
                    break;
                case 'deleteNode':
                    $this->deleteNode();
                    break;
                case 'json':
                    $this->addLang();
                    break;
                case 'location':
                    $this->location();
                    break;
                case 'translations_download':
                    $this->translations_download();
                    break;
                case 'showEditNode':
                    $this->showEditNode();
                    break;
                case 'addNode':
                    $this->addNode();
                    break;
                case 'showLang':
                    $this->showLand();
                    break;
                case 'editLangValue':
                    $this->editLangValue();
                    break;
                case 'deletelang':
                    $this->deletelang();
                    break;
                case 'delete':
                    $this->delete();
                    break;
                case 'newlang':
                    $this->changeLangs();
                    break;
                case 'addLangForm':
                    $this->addLangForm();
                    break;
                case 'editLangForm':
                    $this->editLangForm();
                    break;
                case 'add':
                    $this->add();
                    break;
                case 'save_code':
                    $this->save_code();
                case 'delete_code':
                    $this->delete_code();
                    break;
                case 'edit':
                    $this->edit();
                    break;
                case 'searchlang':
                    $this->searchLang();
                    break;
                case 'filter':
                    $this->getTranslations();
                    break;
                case 'save':
                    $this->save();
                    break;
                case 'uploadform':
                    $this->uploadFile();
                    $this->showUploadForm();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    break;
            }
            //switch
        }
    } //__construct

    function getTranslations()
    {
        $lang_id= (int)$this->request('lang', $this->getCurrentLangID());
        $code   = filter_var($this->request('code'), FILTER_SANITIZE_STRING);
        $model  = rad_instances::get('model_core_langvalues')->setState('lang_id', $lang_id)->setState('type', $this->request('type'))->setState('order by', 'lnv_code');
        if (!empty($code)){
            $model->setState('search.code', $code);
        }
        $model->setState('order', 'lnv_code');
        $items = $model->getItems();
        echo json_encode($items);
        exit;
    }


    /**
     * load tree node
     * return xml node
     */

    function getNodes()
    {
        $items = rad_instances::get('model_core_lang')->getItems();

        $s = '<?xml version="1.0"?>';
        $s .= '<nodes>';
        if (count($items)){
            foreach($items as $id){
                $s .= '<node text="'.$id->lng_name.'"';
                $s .= ($id->lng_active) ? '' : ' color="#808080"';
                $s .= ' id="'.$id->lng_id.'"';
                $s .= ' islast="0"';
                $s .= ' />';
            }
            //foreach
        }
        //if

        $s .= '</nodes>';

        $this->header('Content-Length: '.strlen($s));
        $this->header('Content-Type: application/xml');
        //echo json_encode($s);
        echo $s;
    }

    /**
     * connect url
     * return true or false
     */

    function url_connect($url)
    {
        $url = @parse_url($url);
        if (!$url)
            return false;

        $url = array_map('trim', $url);
        $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];

        $path = (isset($url['path'])) ? $url['path'] : '/';
        $path .= (isset($url['query'])) ? "?$url[query]" : '';

        if (isset($url['host']) && $url['host'] != gethostbyname($url['host'])){
            $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);
            if (!$fp)
                return false; //socket not opened
            fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n"); //socket opened
            $headers = fread($fp, 4096);
            fclose($fp);

            if (preg_match('#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers)){
                //matching header
                return true;
            }
            else {
                return false;
            }

        }
        else {
            return false;
        }
    }


    /**
     * Show location tree
     */
    function location()
    {
        //$code, $lang
        $code = $this->request('code');
        $lang = $this->request('lang');

        $url = $this->json_url = is_array($this->json_url) ? $this->json_url[$this->getContentLangID()] : $this->json_url;

        $this->json_url = (is_array($this->json_url)) ? $this->json_url[$this->getContentLangID()] : $this->json_url;
        $url = $this->json_url.'?code='.trim($code).'&lang='.$lang;

        if ($this->url_connect($url)){

            $post = array('lang' => $lang);
            $xml = $this->getUrlContent($url);

            $rs = str_replace("?", "", $xml);
            $rs = str_replace("\"", "", $rs);
            $js = json_decode('["'.$rs.'"]');
            echo $js[0];
        }
        else {
            return false;
        }
    }

    /**
     * Show location tree
     */
    function translations_download()
    {
        //$code, $lang
        $download_mode = strtolower($this->request('mode')); // skip, overwrite
        $lang_id = (int)$this->request('lang_id', $this->getContentLangID());

        $url = is_array($this->json_url) ? $this->json_url[$lang_id] : $this->json_url;

        $url .= '?action=translations_all&lang_id='.$lang_id;

        $result = null;

        if ($this->url_connect($url)){
            $result = $this->getUrlContent($url);
        }

        $elements = json_decode($result);

        $values = array();
        foreach($elements as $element){
            $values[] = "('{$element->lnv_code}', '{$element->lnv_value}', {$lang_id})";
        }
        $query = '';
        switch($download_mode){
            case 'overwrite':
                if (count($values)>0){
                    $query = "INSERT INTO `rad_langvalues`\n";
                    $query .= "    (`lnv_code`, `lnv_value`, `lnv_lang`)\n";
                    $query .= "VALUES\n";
                    $query .= "    {values}\n";
                    $query .= "ON DUPLICATE KEY UPDATE\n";
                    $query .= "    lnv_value = VALUES(lnv_value)";
                    $query = str_replace('{values}', implode(",\n    ", $values), $query);
                }
                break;
            case 'skip':
                if (count($values)>0){
                    $query = "INSERT IGNORE INTO `rad_langvalues`\n";
                    $query .= "    (`lnv_code`, `lnv_value`, `lnv_lang`)\n";
                    $query .= "VALUES\n";
                    $query .= "    {values}";
                    $query = str_replace('{values}', implode(",\n    ", $values), $query);
                }
                break;
        }
        $rows = 0;
        if (strlen($query)>0){
            $rows = rad_dbpdo::exec($query);
        }
        echo (int)$rows;
    }

    /**
     * show form edit lang
     */
    function showEditNode()
    {
        $node_id = $this->request('node_id');
        $model = rad_instances::get('model_core_lang');
        $items = $model->getItem($node_id);
        $this->setVar('tree', $items);
    }

    /**
     * show lang tructure
     */
    function _assignLang()
    {
        $s = new struct_core_lang();
        $s->lng_id = $this->request('node_id');
        $s->lng_name = $this->request('lng_name');
        $s->lng_code = $this->request('lng_code');
        $s->lng_active = $this->request('lng_active');
        $s->lng_position = $this->request('lng_position');
        $s->lng_maincontent = $this->request('lng_maincontent');
        $s->lng_mainadmin = $this->request('lng_mainadmin');
        $s->lng_mainsite = $this->request('lng_mainsite');
        return $s;
    }

    /**
     * delete tree node
     */
    function deleteNode()
    {
        if ($this->request('node_id')){
            $model = rad_instances::get('model_core_lang');
            $row = $model->deleteRow($this->request('node_id'));
            if ($row){
                echo 'RADLangTree.message("'.$this->lang('rowsupdated.catalog.title').': '.$row.'");';
                echo 'RADLangTree.cancelEdit();';
                echo 'RADLangTree.refresh();';
            }
            else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        }
        else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function addNode()
    {

    }

    /**
     * edit node tree
     */
    function applyEditNode()
    {
        if ($this->request('node_id') and !$this->request('method')){
            $model = rad_instances::get('model_core_lang');
            $struct = $this->_assignLang();
            $row = $model->updateItem($struct);
            if ($row){
                echo 'RADLangTree.message("'.$this->lang('rowsupdated.catalog.title').': '.$row.'");';
                echo 'RADLangTree.cancelEdit();';
                echo 'RADLangTree.refresh();';
            }
            else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        }
        elseif ($this->request('method') == 'add') {

            if ($this->request('lng_name') and $this->request('lng_code')){
                $model = rad_instances::get('model_core_lang');
                $struct = $this->_assignLang();
                $row = $model->insertItem($struct);
                if ($row){
                    echo 'RADLangTree.message("'.$this->lang('rowsupdated.catalog.title').': '.$row.'");';
                    echo 'RADLangTree.cancelEdit();';
                    echo 'RADLangTree.refresh();';
                }
                else {
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                }
            }

        }
        else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }


    /**
     * connect url
     * url (string) post(array)
     */

    function getUrlContent($url, $post = array())
    {
        $http['method'] = 'POST';
        $http['timeout'] = 10;
        if ($post)
            $http['lang'] = http_build_query($post);
        $context = stream_context_create(array('http' => $http));
        return file_get_contents($url, false, $context);
    }

    /**
     * read Cache for landuages
     * url (url_file) = string
     */

    function _readCachedLangueges($fr)
    {
        if (is_dir(rad_config::getParam('lang.cacheDir'))){
            //$fn = rad_config::getParam('lang.cacheDir').'lang.cache';
            if (file_exists($fr)){
                $tmp = file($fr);
                $rs = array();

                $need_del = array("\r", "\n", "\t");
                $to_replace = array('', '', '');
                foreach($tmp as $file_line => $code){
                    $code = trim($code);
                    if (($code) and (strlen($code)))
                        $rs[] = str_replace($need_del, $to_replace, $code);
                }
                //foreach

                return array_unique($rs);
            }
            //if fileexists
        }
        //if isdir
    }

    /**
     * scaning file it folder cached
     * $controller_temp (string)
     */

    function allTemplate($controller_temp)
    {
        $rs = array();
        $dirs = scandir($controller_temp);
        foreach($dirs as $file){
            if (($file == '.') || ($file == '..')){

            }
            elseif (is_dir($controller_temp.'/'.$file)) {
                // $this->allTemplate($controller_temp.'/'.$file); // function recursia
            }
            else {
                $rs[] = $controller_temp.$file;
            }
        }
        return $rs;
    }

    /**
     * load code no cached
     * code (string), lang_id(int)
     */

    function noCodeValue($code, $lang_id)
    {
        $model = rad_instances::get('model_core_langvalues');
        $model->setState('code_up', trim($code));
        $model->setState('lang_up', $lang_id);
        $model->setState('update', true);
        $up = $model->getItems();
        if (is_array($up) and !isset($up[0])){
            //return $code;
            $errors = array();
            $lang = new struct_core_langvalues();

            $lang->lnv_lang = $lang_id;
            $lang->lnv_id = NULL;
            $lang->lnv_code = trim(stripslashes($code));
            $lang->lnv_value = trim(stripslashes($code));

            return $lang;
        }
    }

    /**
     * Download the code from the cache
     * node_id(int)
     */

    function installCachedLang($node_id)
    {
        $controller_temp = rad_config::getParam('lang.cacheDir');
        $pr = $this->allTemplate($controller_temp);
        $rs = array();
        $no_code = array();

        if (is_array($pr)){
            foreach($pr as $v){
                $rs[] = $this->_readCachedLangueges($v);
            }
            if (is_array($rs)){
                foreach($rs as $k => $v){
                    if (is_array($v))
                        foreach($v as $vk){
                            if ($this->noCodeValue($vk, $node_id))
                                $no_code[] = $this->noCodeValue($vk, $node_id);
                        }

                }
            }

        }
        if (is_array($no_code)){
            foreach($no_code as $value){
                if ($value){
                    $model = rad_instances::get('model_core_langvalues');
                    $rows = $model->insertItem($value);
                    if ($rows){
                        //echo 'RADLangList.message("'.addslashes( $this->lang('deletedrows.lang.message') ).': '.$rows.'");';
                    }
                    else {
                        //echo 'RADLangList.message("'.addslashes( $this->lang('deleted.lang.error') ).': '.$rows.'");';
                    }
                }
                else {
                    echo 'RADLangList.message("'.addslashes($this->lang('update.lang.error')).'");';
                }
            }
        }

    }

    /**
     * load lang List
     */

    function showLand()
    {
        $page = (int)$this->request('page');
        if ((int)$this->request('node_id')){
            if (!$page)
                $this->installCachedLang($this->request('node_id')); //no_lang is cached.

            $model = rad_instances::get('model_core_langvalues');
            $lang_model = rad_instances::get('model_core_lang')->setState('where', 'lng_id ='.(int)$this->request('node_id'))->getItems();

            /*
                         $default = rad_config::getParam('lang.default');
                        $new_code = ($lang_model[0]->lng_code) ? $lang_model[0]->lng_code : $default;

                        if (rad_lang::getLangByCode($new_code))
                        {
                        rad_lang::changeLanguage($new_code);
                        }
                        */

            $count = $this->countLangs();
            $page_count = ceil($count / $this->_itemsPerPage);

            # Make sure $page dont go above $page_count
            if ($page>$page_count){
                $page = $page_count;
            }

            /* And that it doesnt go below 1*/
            $page = ($page<1) ? 1 : $page;

            $start = ($page - 1) * $this->_itemsPerPage;
            $limit = $start.', '.$this->_itemsPerPage;

            $model->setState('select', '*');
            $model->setState('lang', (int)$this->request('node_id'));
            $model->setState('order by', 'lnv_id DESC');
            $model->setState('limit', $limit);
            $items = $model->getItems();

            /*
                         foreach($items as $item) {
                        $params = $this->location($item->lnv_code, $item->lnv_lang);
                        $item->json_lang = ($params)?$params:' ';
                        }
                        */

            foreach($items as $item){
                $item->lnv_code = trim($item->lnv_code);
            }


            $this->setVar('items', $items);
            $this->setVar('pages_count', $page_count + 1);
            $this->setVar('items_count', $count);
            $this->setVar('page', $page);
            //dvy//$this->setVar('lang', rad_instances::get('model_core_lang')->getItems() );

        }
        else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }

    }

    /**
     * count all languages
     */

    function countLangs()
    {
        $model = rad_instances::get('model_core_langvalues');
        $model->setState('select', 'count(*)');

        if ((int)$this->request('node_id'))
            $model->setState('lang', $this->request('node_id'));
        if ($this->request('searchword'))
            $model->setState('search', $this->request('searchword'));

        return $model->getItems();
    }


    /**
     * Deletes the one lang
     * @return javascript commands in for AJAX
     */
    function deletelang()
    {
        if ((int)$this->request('lang_id')){
            $rows = rad_instances::get('model_core_langvalues')->deleteRow((int)$this->request('lang_id'));
            if ($rows){
                echo 'RADLangList.message("'.addslashes($this->lang('deletedrows.lang.message')).': '.$rows.'");';
                echo 'RADLangList.refresh();';
            }
            else {
                echo 'RADLangList.message("'.addslashes($this->lang('deleted.lang.error')).': '.$rows.'");';
            }
        }
    }

    /**
     * Deletes the one lang
     * @return String 'true' or 'false' for javascript handling
     */
    function delete()
    {
        if ((int)$this->request('lang_id')>0){
            $rows = rad_instances::get('model_core_lang')->deleteRow((int)$this->request('lang_id'));
            if ($rows>0){
                echo 'true';
                exit;
            }
        }
        echo 'false';
        exit;
    }

    /**
     * Add the one lang
     * @return javascript commands in for AJAX
     */
    function add()
    {
        if ($this->request('lnv_code') and $this->request('lnv_lang')){
            $lang = $this->_assignLangFromRequestUp(NULL, $this->request('lnv_lang'));
            if ($lang){
                $model = rad_instances::get('model_core_langvalues');
                $rows = $model->insertItem($lang);
                if ($rows){
                    echo 'RADLangList.message("'.addslashes($this->lang('adddrows.lang.message')).': '.$rows.'");';
                    echo 'RADLangList.refresh();';
                }
                else {
                    echo 'RADLangList.message("'.addslashes($this->lang('add.lang.error')).': '.$rows.'");';
                }


            }
            else {
                echo 'RADLangList.message("'.addslashes($this->lang('add.lang.error')).'");';
            }

        }
        else { //if $searchword
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }

    }

    /**
     * Save single row to the lang_values table.
     * @return int id of inserted row
     */
    function save_code()
    {
        $lang_id = (int)$this->request('lang_id');
        $lang_id = $lang_id>0 ? $lang_id : $this->getCurrentLang();
        $code = trim(stripslashes($this->request('code')));
        $value = trim(stripslashes($this->request('value')));
        $affected_rows = 0;
        if (!empty($code) AND !empty($value)){
            $model = rad_instances::get('model_core_langvalues');
            // trying to get record(s) with the same code and lang_id from the table
            $items = $model->setState('code', $code)->setState('lang', $lang_id)->getItems();
            if (count($items)>0){ // if record with the same code and lang_id is already exist in the table
                foreach($items as $lv){ // update all found instances to new values
                    $lv->lnv_code = $code;
                    $lv->lnv_value = $value;
                    $rows_count = $model->updateItem($lv);
                    $affected_rows += $rows_count;
                }
            }
            else {
                $lv = new struct_core_langvalues();
                $lv->lnv_lang = $lang_id;
                $lv->lnv_code = $code;
                $lv->lnv_value = $value;
                $affected_rows = $model->insertItem($lv);
            }
        }
        echo $affected_rows;
        exit;
    }

    /**
     * Delete row from the lang_values table searching by lang_id and code.
     * @return int number of deleted rows
     */
    function delete_code()
    {
        $lang_id = (int)$this->request('lang_id');
        $lang_id = $lang_id>0 ? $lang_id : $this->getCurrentLang();
        $code = trim(stripslashes($this->request('code')));
        $affected_rows = 0;
        if (!empty($code)){
            $model = rad_instances::get('model_core_langvalues');
            // trying to get record(s) with the same code and lang_id from the table
            $items = $model->setState('code', $code)->setState('lang', $lang_id)->getItems();
            if (count($items)>0){ // if record with the same code and lang_id is already exist in the table
                foreach($items as $lv){ // update all found instances to new values
                    $rows_count = $model->deleteItem($lv);
                    $affected_rows += $rows_count;
                }
            }
        }
        echo $affected_rows;
        exit;
    }

    /**
     * Form add vars
     */

    function addLangForm()
    {
        if ($this->request('lnv_lang')){
            $this->setVar('langs', rad_instances::get('model_core_lang')->getItems());
            $this->setVar('lnv_lang', $this->request('lnv_lang'));
        }

    }

    /**
     * Edit the one lang
     * @return javascript commands in for AJAX
     */

    function edit()
    {
        if ($this->request('lnv_code') and $this->request('lnv_lang') and $this->request('lnv_id')){
            $lang = $this->_assignLangFromRequest($this->request('lnv_id'), $this->request('lnv_lang'));
            if ($lang){
                $model = rad_instances::get('model_core_langvalues');
                $rows = $model->updateItem($lang);
                if ($rows){
                    echo 'RADLangList.message("'.addslashes($this->lang('editdrows.lang.message')).': '.$rows.'");';
                    echo 'RADLangList.refresh();';
                }
                else {
                    echo 'RADLangList.message("'.addslashes($this->lang('edit.lang.error')).': '.$rows.'");';
                }


            }
            else {
                echo 'RADLangList.message("'.addslashes($this->lang('edit.lang.error')).'");';
            }

        }
        else { //if $searchword
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }

    }

    /**
     * Form edit vars
     */
    function editLangForm()
    {
        if ($this->request('lnv_lang') and (int)$this->request('lnv_id')){
            $this->setVar('langs', rad_instances::get('model_core_lang')->getItems());
            $this->setVar('lnv_lang', $this->request('lnv_lang'));

            $model = rad_instances::get('model_core_langvalues');
            $model->setState('id', (int)$this->request('lnv_id'));
            $model->setState('lnv_lang', $this->request('lnv_lang'));
            $items = $model->getItems();

            if (is_array($items) and isset($items[0])){
                $this->setVar('items', $items[0]);
            }

        }

    }

    /**
     * Search lang from AJAX form in lang-list
     *
     */
    function searchLang()
    {
        $searchword = $this->request('searchword');
        $page = (int)$this->request('page');
        $lang = (int)$this->request('node_id');

        if ($searchword){
            $this->setVar('searchword', $searchword);
            $model = rad_instances::get('model_core_langvalues');
            $count = $this->countLangs();
            $page_count = ceil($count / $this->_itemsPerPage);

            # Make sure $page dont go above $page_count
            if ($page>$page_count)
                $page = $page_count;

            # And that it doesnt go below 1
            if ($page<1)
                $page = $this->_defaultPage;

            $start = ($page - 1) * $this->_itemsPerPage;
            $limit = $start.', '.$this->_itemsPerPage.'';

            $model->setState('select', '*');
            $model->setState('lang', $lang);
            $model->setState('search', $searchword);
            $model->setState('order by', 'lnv_id DESC');
            $model->setState('limit', $limit);
            $items = $model->getItems();


            $this->setVar('pages_count', $page_count + 1);
            $this->setVar('items_count', $count);
            $this->setVar('page', $page);
            $this->setVar('items', $items);
            $this->setVar('langs', rad_instances::get('model_core_lang')->getItems());

        }
        else { //if $searchword
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * assign the langs
     * full post request
     *
     */

    function _assignLangFromRequest($lval_id = NULL, $lang_id = NULL, $lnv_value = NULL)
    {
        $errors = array();
        $lang = new struct_core_langvalues();

        $lang->lnv_lang = $lang_id;
        $lang->lnv_id = $lval_id;
        $lang->lnv_code = trim(stripslashes($this->request('lnv_code')));
        $lang->lnv_value = trim(stripslashes($this->request('lnv_value')));

        return $lang;
    }

    function _assignLangFromRequestUp($lval_id = NULL, $lang_id = NULL, $lnv_value = NULL)
    {

        $model = rad_instances::get('model_core_langvalues');
        $model->setState('code_up', $this->request('lnv_code'));
        $model->setState('lang_up', $this->request('lnv_lang'));
        $model->setState('update', true);
        $up = $model->getItems();
        if (is_array($up) and !isset($up[0])){
            $errors = array();
            $lang = new struct_core_langvalues();

            $lang->lnv_lang = $lang_id;
            $lang->lnv_id = $lval_id;
            $lang->lnv_code = trim(stripslashes($this->request('lnv_code')));
            $lang->lnv_value = trim(stripslashes($this->request('lnv_value')));

            return $lang;
        }
        else {
            return false;
        }
    }

    /**
     * Edit the langs from edit lang form
     * full post request
     *
     */
    function editLangValue()
    {
        if ($this->request('id') and $this->request('lang_id')){
            $lang = $this->_assignLangFromRequest($this->request('id'), $this->request('lang_id'));

            if ($lang){
                $model = rad_instances::get('model_core_langvalues');
                $rows = $model->updateItem($lang);
            }
        }
    }

    /**
     * change the langs from change lang form
     * full post request
     *
     */
    function changeLangs()
    {
        if ($this->request('lang_id')){
            $langs = model_core_table::getInstance('langvalues')->getItem($this->request('lang_id'));
            $langs->lnv_lang = $this->request('nl');
            $rows = model_core_table::getInstance('langvalues')->updateItem($langs);
            if ($rows){
                echo 'RADLangList.message("'.$this->lang('-saved').'");';
                echo 'RADLangList.refresh()';
            }
            else {
                echo 'RADLangList.message("'.$this->lang('-notsaved').'");';
            }
        }
        else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Shows form for uploading flags. Used by adding to uftame in language properties form
     *
     */
    function showUploadForm()
    {
        $lang_id = (int)$this->request('lng_id');
        $this->setVar('lng_id', $lang_id);
    }

    /**
     * Save uploaded image file
     *
     */
    function uploadFile()
    {
        if (array_key_exists('lng_image', $_FILES)){
            $lang_id = (int)$this->request('lng_id');
            if (!empty($_FILES['lng_image']['size']) && !$_FILES['lng_image']['error']) {
                foreach(glob(str_replace('$', $lang_id, CORE_LANG_GLOB)) as $filename){
                    unlink($filename);
                }
                $new_fn = strtolower($lang_id.'_lng'.md5(now().$this->getCurrentUser()->u_id.$_FILES['lng_image']['name']).'.'.fileext($_FILES['lng_image']['name']));
                $model = rad_instances::get('model_core_lang');
                $item = $model->getItem($lang_id);
                if (move_uploaded_file($_FILES['lng_image']['tmp_name'], CORE_LANG_PATH.$new_fn)){
                    $item->lng_img = $new_fn;
                    $rows = $model->updateItem($item);
                    $this->setVar('new_fn', $new_fn);
                }
            }
            $this->setVar('id', $lang_id);
        }
    }

    function save()
    {

        $model = rad_instances::get('model_core_lang');
        $id = (int) $this->request('lng_id');
        if($id > 0) {
            $item = $model->getItem($id);
            $item->lng_id = $id;
        } else {
            $item = new struct_core_lang();
        }
        $item->lng_name = $this->request('lng_name');
        $item->lng_code = $this->request('lng_code');
        $item->lng_position = $this->request('lng_position');
        $item->lng_active = (int) $this->request('lng_active');
        $item->lng_mainsite = (int) $this->request('lng_mainsite');
        $item->lng_mainadmin = (int) $this->request('lng_mainadmin');
        $item->lng_maincontent = (int) $this->request('lng_maincontent');
        if($id > 0) {
            $model->updateItem($item);
        } else {
            $model->insertItem($item);
            $id = rad_dbpdo::lastInsertId();
        }
        echo $this->request('lng_id') > 0 ? 0 : $id;
        exit;
    }

}