<?php
/**
 * Managing comments for the sitemap
 * @author Denys Yackushev
 * @version 0.2
 * @pachage Taberna
 */
class controller_coreresource_managecomments extends rad_controller
{
    /**
     * Items per page
     * @var integer
     */
    private $_itemsperpage = 20;

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_itemsperpage = (int)$params->_get('itemsperpage', $this->_itemsperpage);
            $this->setVar('params', $params);
        }
        if($this->request('action')) {
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'getjs':
                    $this->getJS();
                    break;
                case 'ei'://show edit form for comment
                    $this->editItem();
                    break;
                case 'si'://save item - one comment
                    $this->saveItem();
                    break;
                case 'ri'://refresh items
                    $this->assignComments();
                    break;
                case 'di'://Delete item (1 comment)
                    $this->deleteItem();
                    break;
                case 'dmi'://Deelete item from mail by url
                    $this->deleteItem();
                    $this->assignComments();
                    $this->assignMailTemplate();
                    break;
                default:
                    $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
                    break;
            }
        } else {
            $this->assignComments();
            //$this->assignMailTemplate();
        }
    }

    function getJS()
    {
        //GETS JS
        $this->header('Content-type: text/javascript');
        $this->setVar('hash', $this->hash());
    }

    function assignComments()
    {
        $limit = $this->_itemsperpage;
        if((int)$this->request('page')) {
            $limit = ( ((int)$this->request('page')-1)*$this->_itemsperpage).','.$this->_itemsperpage;
        }
        $model = rad_instances::get('model_coreresource_comments');
        $model->setState('join.news', true)
              ->setState('join.articles', true)
              ->setState('join.products', true)
              ->setState('join.orders', true)
              ->setState('order','rcm_id DESC');
        $itemsCount = $model->getCount();
        $items = $model->getItems($limit);
        $this->setVar('items', $items);
        $this->setVar('paginator', new rad_paginator(array('total'=>$itemsCount, 'itemsperpage'=>$this->_itemsperpage, 'getparams'=>'' )));
    }

    function assignMailTemplate()
    {
        //Ассоциируем шаблон
        $model = rad_instances::get('model_coremail_mailtemplate');
        $model->setState('name', $this->config('comments.new_comment') );
        $model->setState('lang',$this->getCurrentLangID());
        $template = $model->getItem();
        $this->setVar('mailtemplate', array($this->getCurrentLangID()=>$template) );
        $this->setVar('langs', $this->getAllLanguages() );
        $this->setVar('currlang', $this->getCurrentLangID() );
    }


    function editItem()
    {
        if((int)$this->request('i')) {
            $table = new model_core_table('comments','coreresource');
            $this->setVar('item', $table->getItem( (int)$this->request('i') ));
            $this->setVar('hash', $this->hash());
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function saveItem()
    {
        //Saves the comment
        if($this->request('hash')!=$this->hash()) {
            $this->redirect('404');
        }
        if((int)$this->request('i')) {
            $table = new model_core_table('comments','coreresource');
            $item = $table->getItem((int)$this->request('i'));
            $item->rcm_text = stripslashes( $this->request('c_txt') );
            $item->rcm_active = (int)(bool)$this->request('active');
            $table->updateItem($item);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function deleteItem()
    {
        if($this->request('hash')!=$this->hash()) {
            $this->redirect('404');
        }
        if((int)$this->request('i')) {
            $table = new model_core_table('comments','coreresource');
            $item = $table->getItem( (int)$this->request('i') );
            if($item->rcm_id) {
                $table->deleteItem($item);
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }
}