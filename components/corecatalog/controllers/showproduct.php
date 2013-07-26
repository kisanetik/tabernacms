<?php
/**
 * Class for showing the one product
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_showproduct extends rad_controller
{

    private $_premoderation = null;
    private $_showComments = 0;

    private $_mail_format = 'html';

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('product');
        $bco->add('category');
        $bco->add('parents');
        return $bco;
    }

    function __construct()
    {
        if ($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->setVar('params', $params );
            $this->_commentsPerPage = $params->commentsPerPage;
            $this->_onlyRegistered = $params->onlyRegistered;
            $this->_premoderation = $params->premoderation;
            $this->_showComments = $params->_get('showComments', $params->showComments);
            $user = $this->getCurrentUser();

            $allowComments = $params->onlyRegistered && empty($this->getCurrentUser()->u_id) ? false : true;

            $this->setVar('allowComments', $allowComments);
            $this->setVar('premoderation', $this->_premoderation);
        }
        $this->setVar('user', $this->getCurrentUser());
        /* Add a new comment */
        $action = $this->request('action');
        if ($allowComments && $action == 'comment_add') {
            if ( empty($this->getCurrentUser()->u_id) ) {
                $captcha = new model_coresession_captcha('product');
                if ( $captcha->check($this->request('captcha')) ) {
                    $this->addComment();
                } else {
                    $this->setVar('message',$this->lang('wrongcaptcha.session.error'));
                    //die($this->lang('wrongcaptcha.session.error'));
                    die('captcha');
                }
            } else {
                $this->addComment();
            }
        }

        $this->setVar('action', $this->request('action'));
        $this->setVar('curr' , model_corecatalog_currcalc::$_curcours);
        $this->assignProduct();
        $this->assignParams();
    }

    /**
     * Assign default params!
     */
    function assignParams()
    {
        $this->setVar('onlyRegistered', $this->_onlyRegistered);
    }

    /**
     * Assign product to the template
     */
    function assignProduct()
    {
        $pId = (int)$this->request('p');
        if(strlen($pId)!==strlen($this->request('p'))) {
            $this->redirect('404');
        }
        if ($pId) {
            $this->setVar('comments_show', $this->_showComments);
            $this->setVar('tab', $this->request('tab', 1));

            $model = rad_instances::get('model_corecatalog_catalog');
            $model->setState('with_download_files', true);
            $model->setState('with_vv', true);
            $product = $model->getItem($pId);
            if(!empty($product->cat_id)) {
                if(count($product->tree_catin_link) and ($product->tree_catin_link[0]->cit_tre_id)) {
                    $modelTree = rad_instances::get('model_coremenus_tree');
                    $category = $modelTree->getItem($product->tree_catin_link[0]->cit_tre_id);
                    $this->addBC('category', $category);
                    if( $this->getParamsObject()->getcategories ) {
                        /* for template need category of product */
                        foreach($product->tree_catin_link as &$tcl) {
                            $tcl->tree = $modelTree->getItem($tcl->cit_tre_id);
                        }
                    }
                    /* if have already geted categories, get link from it */
                    if( ($category->tre_pid!=0) and ($category->tre_pid!=$this->getParamsObject()->treestart) ){
                        $parents = array();
                        $modelTree->clearState();
                        $parents[] =  $modelTree->getItem($category->tre_pid);
                        $treestart = $this->getParamsObject()->treestart;
                        while($parents[count($parents)-1]->tre_pid!=$treestart and $parents[count($parents)-1]->tre_pid!=0){
                            $modelTree->clearState();
                            $parents[] = $modelTree->getItem( $parents[count($parents)-1]->tre_pid );
                        }

                        $parents = array_reverse($parents);
                        $this->addBC('parents',$parents);
                    }

                }
                if(count($product->type_vl_link)) {
                    foreach($product->type_vl_link as $tvlkey => $tvl) {
                        if($product->type_vl_link[$tvlkey]->vl_measurement_id) {
                            $mesId = $product->type_vl_link[$tvlkey]->vl_measurement_id;
                            $mes = new struct_corecatalog_measurement( array('ms_id'=>$mesId) );
                            $mes->load();
                            $product->type_vl_link[$tvlkey]->ms_value = $mes->ms_value;
                        }
                    }
                }
                if($this->config('partners.3dbin.license')) {
                    rad_instances::get('model_corecatalog_3dimages')->assign3Dimage($product);
                }
                $this->setVar('item', $product);
                $product->cat_showed++;
                $product->save();
                $this->addBC('product', $product);
                if(count($product->images_link)) {
                    $images = array();
                    foreach($product->images_link as $id) {
                        if(!$id->img_main) {
                            $images[] = $id;
                        }
                    }//foreach
                    $this->setVar('t_images', $images);
                }//if images_link
                if($this->_showComments) {
                    $modelComments = rad_instances::get('model_coreresource_comments');
                    $modelComments->setState('active', 1);
                    $modelComments->setState('item_id', $pId);
                    $modelComments->setState('type', 'product');
                    $commentsTotal = $modelComments->getCount();
                    $modelComments->setState('order','rcm_datetime DESC');
                    $limit = '';
                    if ($commentsTotal > $this->_commentsPerPage) {
                        $paginator = new rad_paginator(
                                        array(
                                                'total'        => $commentsTotal,
                                                'itemsperpage' => $this->_commentsPerPage,
                                        )
                        );
                        $pageNumber = (int) $this->request('page');
                        $limit = $paginator->getSQLLimit($pageNumber);
                    } else {
                        $paginator = false;
                    }
                    $this->setVar('paginator', $paginator);
                    $comments = $modelComments->getItems($limit);

                    $comments = array_reverse($comments);
                    $this->fixSubComments($comments);

                    $this->setVar('comments', $comments);
                    $this->setVar('comments_total', $commentsTotal);
                    $this->setVar('hash', $this->hash());

                    //$this->sendMail($insert_id);

                }
            }//!empty product
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function fixSubComments(&$items)
    {
        foreach($items as $key=>$id) {
            if($id->rcm_parent_id!=0) {
                $this->_findAndPasteSubComment($items, $id);
                unset($items[$key]);
            }
        }
    }

    function _findAndPasteSubComment(&$items, $id)
    {
        foreach($items as &$item) {
            if($item->rcm_id==$id->rcm_parent_id) {
                $item->subcomments[] = $id;
                return ;
            } elseif (!empty($item->subcomments)) {
                $this->_findAndPasteSubComment($item->subcomments, $id);
            }
        }
    }

    function addComment()
    {
        if ($this->request('hash')!=$this->hash()) {
            return $this->redirect('404');
        }
        $item = new struct_coreresource_comments();

        $item->rcm_datetime = now();
        $item->rcm_type = 'product';

        $item->rcm_active = $this->_premoderation ? 0 : 1;

        //$item->rcm_parent_id = 0;
        $item->rcm_parent_id = strip_tags(stripslashes($this->request('parent_id')));

        if($this->getCurrentUser() and $this->getCurrentUser()->u_id) {
            $item->rcm_nickname = $this->getCurrentUser()->u_login;
            $item->rcm_user_id = $this->getCurrentUser()->u_id;
        } else { // @TODO: What really should we do if user is anonymous?
            $item->rcm_nickname = strip_tags(stripslashes($this->request('nickname')));
            $item->rcm_user_id = 0;

        }
        $item->rcm_item_id = (int)$this->request('p');
        $item->rcm_text = strip_tags(stripslashes($this->request('txt')));
        $table = new model_core_table('comments','coreresource');
        $table->insertItem($item);
        $item->rcm_id = $table->inserted_id();

        $parentComm = $table->getItem($item->rcm_parent_id);
        $modelUser = rad_instances::get('model_core_users');
        if ($parentComm->rcm_user_id != 0) {
            $userCommParent = $modelUser->getItem($parentComm->rcm_user_id);
            if (filter_var($userCommParent->u_email, FILTER_VALIDATE_EMAIL)) {
                //$link_to_comment = $this->makeURL('alias=product&products_action=i&i='.$item->rcm_id);
                $link_to_comment = $this->makeURL('alias=product&p='.$item->rcm_item_id); 
                $this->_sendMail($userCommParent->u_email, $item->rcm_text, $parentComm->rcm_text, $link_to_comment);
            }
        }
        //$this->_sendMail($parent->rcm_user_id);
    }

    function _sendMail($email, $comment, $parent_comment, $link_to_comment)
    {
        $template_name = $this->config('comments.new_comment');
        rad_mailtemplate::send($email, $template_name, array('comment' => $comment,'parent_comment'=> $parent_comment,'link_to_comment' => $link_to_comment), $this->_mail_format); 
    }

}
