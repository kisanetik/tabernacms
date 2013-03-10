<?php
/**
 * Comments for news and articles...
 * @author Denys Yackushev
 * @deprecated 26 October 2010
 * @version 0.1
 * @pachage RADCMS
 */
class controller_resource_comments extends rad_controller
{
    /**
     * Сколько показывать записей для короткого предпросмотра, (внизу новости, статьи)
     * @var integer
     */
    private $_shortItemsCount = 3;

    /**
     * Кол-во айтемов на страницу, при отображении всех комментариев
     */
    private $_itemsperpage = 20;

    /**
     * Имя параметра в гет-запросе для item_id
     * @var string
     */
    private $_getParam = 'nid';

    /**
     * Тип айтема, articles,news
     * @var string
     */
    private $_itemType = 'news';

    private $_premodere = 1;

    private $_onlyRegistered = false;

    private $_ordering = 'DESC';

    private $_mail_format = 'html';

    public static function getBreadcrumbsVars()
	{
		$bco = new rad_breadcrumbsobject();
		$bco->add('item');
		$bco->add('comments_action');
		$bco->add('item_title');
		return $bco;
	}

    function __construct()
    {
         $params = $this->getParamsObject();
         if ($params) {
             $this->_shortItemsCount = $params->_get('short_itemsperpage', $this->_shortItemsCount);
             $this->_itemsperpage = $params->_get('itemsperpage', $this->_itemsperpage);
             $this->_itemType = $params->_get('type_comments', $this->_itemType);
             $this->_getParam = trim($params->_get('get_itemid', $this->_getParam));
             $this->_onlyRegistered = (bool)$params->_get('only_registered', $this->_onlyRegistered);
             $this->_ordering = $params->_get('ordering', $this->_ordering);
             if($this->_getParam=='a' and $this->request('p')) {
             	$this->_getParam = 'p';
             }
             $this->_premodere = $params->_get('premodere', $this->_premodere);
             $this->setVar('params', $params);
         }
         $this->setVar('typ', $this->_itemType);
         $this->setVar('item_id', (int)$this->request( $this->_getParam ));
         $this->setVar('user', ($this->getCurrentUser())?$this->getCurrentUser():new struct_users());
         $this->setVar('onlyregistered', $this->_onlyRegistered);
         $this->setVar('hash', $this->hash());
         if($this->request('comments_action',false)) {
             $this->setVar('comments_action', strtolower($this->request('comments_action')) );
             $this->addBC('comments_action', strtolower($this->request('comments_action')));
             switch(strtolower($this->request('comments_action'))) {
                 case 'getjs':
                     $this->getJS();
                     break;
                 case 'a'://add a comment
                     $this->setVar('item_id', (int)$this->request('i', $this->request('item')));
                     $reg = $this->_onlyRegistered;
                     if (!empty($this->getCurrentUser()->u_id) or ($reg and $this->checkCapcha())) {
                         $this->addComment();
                     } elseif(!$this->checkCapcha()) {
                         die('captcha');
                     } else {
                         $this->setVar('message', $this->lang('wrongcaptcha.session.error'));
                     }
                     $this->getComments($this->_shortItemsCount);
                     break;
                 case 'f'://Показываем полные комментарии
                     $this->showFullComments();
                     break;
                 case 'af'://Добавляем комментарий и показываем полные комментарии
                      $this->setVar('item_id', (int)$this->request('i', $this->request('item')));
                     if($this->checkCapcha()) {
                         $this->addComment();
                     } else {
                         $this->setVar('message',$this->lang('wrongcaptcha.session.error'));
                     }
                     $this->showFullComments();
                     break;
                 case 'i':
                     $this->assignItem();
                     break;
            }//switch
         } else {
             $this->setVar('comments_action', '');
             $this->getComments($this->_shortItemsCount);
         }
    }

    protected function checkCapcha()
    {
        if(!$this->request('fromSA')) {
            $modelCaptcha = rad_instances::get('model_session_captcha');
        } else {
            $modelCaptcha = $modelCaptcha = new model_session_captcha($this->request('fromSA'));
        }
        return $modelCaptcha->check(trim($this->request('captcha_fld', $this->request('capcha_fld'))));
    }

    function addComment()
    {   
        if($this->hash()!==$this->request('hash')) {
            $this->redirect(SITE_URL);
            die;
        }
        $item = new struct_comments();
        $item->rcm_datetime = now();
        $item->rcm_nickname = ( $this->_onlyRegistered && !empty($this->getCurrentUser()->u_id))
            ? $this->getCurrentUser()->u_login
            : strip_tags( $this->request('nickname') );
        $item->rcm_text = str_replace(array('<p>','</p>'), array('<br/>',''), $item->rcm_text);
        $item->rcm_text = strip_tags($this->request('txt'), '<strong><ul><li><em><ol><br><br/>');
        if($this->getCurrentUser() and $this->getCurrentUser()->u_id) {
            $item->rcm_user_id = $this->getCurrentUser()->u_id;
        }
        if(!$this->request('t',false)) {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        if(!(int)$this->request('i', $this->request('item', false))) {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        if (in_array($this->request('t'), array('news', 'articles', 'folknews', 'tracker', 'product', 'order'))) {
            $item->rcm_type =$this->request('t');
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        $item->rcm_item_id = (int)$this->request('i', $this->request('item'));
        $item->rcm_active = (int)(bool)$this->_premodere;//Делаем без премодерации, сразу активный отзыв, или нет
        if((int)$this->request('parent_id')) {
            $item->rcm_parent_id = (int)$this->request('parent_id');
        }
        $model = rad_instances::get('model_resource_comments');
        $model->insertItem($item);
        $item->rcm_id = $model->inserted_id();

        //type rcm_type and rcm_item_id needed
        $parentComm = $model->getItem($item->rcm_parent_id);
        $modelUser = rad_instances::get('model_system_users');
        if ($parentComm->rcm_user_id != 0) {
            $userCommParent = $modelUser->getItem($parentComm->rcm_user_id);
            if (filter_var($userCommParent->u_email, FILTER_VALIDATE_EMAIL)) {
                $link_to_comment = $this->makeURL('alias=comments&comments_action=f&t='.$item->rcm_type.'&item='.$item->rcm_item_id); 
                $this->_sendMail($userCommParent->u_email, $item->rcm_text, $parentComm->rcm_text, $link_to_comment);
            }
        }
    }


    function _sendMail($email, $comment, $parent_comment, $link_to_comment)
    {
        $template_name = $this->config('comments.new_comment');
        rad_mailtemplate::send($email, $template_name, array('comment' => $comment,'parent_comment'=> $parent_comment,'link_to_comment' => $link_to_comment), $this->_mail_format); 
    }


    function getJS()
    {
        //GET JS
    }

    function getComments($limit=3)
    {
        if((int)$this->getVar('item_id', $this->request($this->_getParam, (int)$this->request('i', $this->request('item'))))) {
            $this->setVar('getParamExists', true);
            $model = rad_instances::get('model_resource_comments')
                        ->setState('order', 'rcm_datetime '.$this->_ordering)
                        ->setState('item_id', (int)$this->getVar('item_id', $this->request($this->_getParam, (int)$this->request('i', $this->request('item')))))
                        ->setState('active', 1);
            $type = in_array($this->request('t'), array('news', 'articles', 'folknews', 'tracker', 'product', 'order'))
                ? $this->request('t')
                : $this->_itemType;
            $model->setState('type', $type);
            $items = $model->getItems($limit);

            $items = array_reverse($items);

            $this->fixSubComments($items);
            $this->setVar('items', $items);
            //var_dump($items); die();
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

    /**
     * Отсылаем письмо админу, о новом комментарии
     * @param struct_comments $item - Комментарий.
     */
    function sendMail(struct_comments $item)
    {
        //Посылаем письмо администратору, о новом комментарии
        $model = rad_instances::get('model_mail_mailtemplate');
        $model->setState('name', $this->config('comments.new_comment') );
        $model->setState('lang',$this->getCurrentLangID());
        $template = $model->getItem();
        $email_to = $template->sct_to;
        //echo ($email_to); die();
        if($template->sct_id) {
            $mail = model_mail_mail::getMailer();
            $mail->IsHTML(false);
            $mail->AddAddress($email_to);
            $mail->Body = $template->sct_mailtemplate;
            //Ссылки-опции на сайт
            $link_to_comment = $this->makeURL('alias=comments&comments_action=i&i='.$item->rcm_id);//На страницу с комментарием
            $link_to_delete_comment = $this->makeURL('alias=RESmanageComments&comments_action=dmi&i='.$item->rcm_id);//прямой линк для удаления комментария - dmi
            $link_to_edit_comment = $this->makeURL('alias=RESmanageComments').'#'.$item->rcm_id;//на страницу редактирования комментариев
            $link_to_adm_comments = $this->makeURL('alias=RESmanageComments');//на страницу управления комментариями
            $ali = 'alias=';
            switch($item->rcm_type) {
                case 'news':
                    $ali .= 'alias=news&nid=';
                    break;
                case 'folknews':
                    $ali .= 'alias=folknews&nid=';
                    break;
                case 'articles':
                    $ali .= 'alias=articles&a=';
                    break;
                case 'tracker':
                    $ali .= 'alias=TRAtasks.html&action=showt&i=';
                    break;
                case 'product':
                    // @TODO: Может понадобиться
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    break;
            }
            $link_to_page = $this->makeURL($ali.$item->rcm_item_id);//На страницу с комментарием
            $mail->Body = str_replace('%%link_to_comment%%',$link_to_comment,$mail->Body);
            $mail->Body = str_replace('%%link_to_delete_comment%%',$link_to_delete_comment,$mail->Body);
            $mail->Body = str_replace('%%link_to_edit_comment%%',$link_to_edit_comment,$mail->Body);
            $mail->Body = str_replace('%%link_to_adm_comments%%',$link_to_adm_comments,$mail->Body);
            $mail->Body = str_replace('%%link_to_page%%',$link_to_page,$mail->Body);
            if($this->getCurrentUser()) {
                foreach($this->getCurrentUser() as $key=>$value) {
                        $mail->Body = str_replace('%%'.$key.'%%',$value,$mail->Body);
                }
            }
            foreach($item as $key=>$value) {
                if(!is_array($value)) {
                    $mail->Body = str_replace('%%'.$key.'%%',$value,$mail->Body);
                }
            }
            $mail->Subject = $template->sct_mailtitle;
            $mail->From = $template->sct_backemail;
            $mail->FromName = $template->sct_backemailname;
            $mail->Send();
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function showFullComments()//Показываем полные новости
    {
        if(!$this->request('t',false)) {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        if(!(int)$this->request('item',false)) {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
        $this->setVar('typ',$this->request('t'));
        //Временная заглушка безопасности
        switch($this->getVar('typ')){
        	case 'folknews':
            case 'news':
                $tbi = new model_system_table(RAD.'news');
                $toItem = $tbi->getItem( (int)$this->request('item') );
                $this->setVar('item_title', $toItem->nw_title);
                $this->addBC('item_title', $toItem->nw_title);
                break;
            case 'articles':
                $tbi = new model_system_table(RAD.'articles');
                $toItem = $tbi->getItem( (int)$this->request('item') );
                $this->setVar('item_title', $toItem->art_title);
                $this->addBC('item_title', $toItem->art_title);
                break;
            case 'product':
                $tbi = new model_system_table(RAD.'catalog');
                $toItem = $tbi->getItem( (int)$this->request('item') );
                $this->setVar('item_title', $toItem->cat_name);
                $this->addBC('item_title', $toItem->cat_name);
                break;
            default:
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                break;
        }//switch
        $this->setVar('to_item', $toItem);
        $this->setVar('item_id', (int)$this->request('item'));
        $model = rad_instances::get('model_resource_comments')
                 ->setState('order by', 'rcm_datetime DESC')
                 ->setState('item_id', (int)$this->getVar('item_id'))
                 ->setState('type', $this->getVar('typ'))
                 ->setState('active', 1);
        //GETS THE COUNT
        $model->setState('select','count(*)');
        $itemsCount = $model->getItems();
        $model->unsetState('select');
        $limit = $this->_itemsperpage;
        if((int)$this->request('page')) {
            $limit = ( ((int)$this->request('page')-1)*$this->_itemsperpage).','.$this->_itemsperpage;
        }
        $this->setVar('items', $model->getItems($limit));
        $gp = 'comments_action=f&t='.$this->request('t').'&item='.(int)$this->request('item').'';
        $this->setVar('paginator', new rad_paginator(array('total'=>$itemsCount, 'itemsperpage'=>$this->_itemsperpage, 'getparams'=>$gp )));
    }

    function assignItem()
    {
        if((int)$this->request('i')) {
            $table = new model_system_table(RAD.'comments');
            $item = rad_instances::get('model_resource_comments')
                    ->setState('active', 1)
                    ->setState('type', $this->request('t'))
                    ->getItem((int)$this->request('i'));
            if($item->rcm_id) {
                $this->setVar('item', $item);
                $this->addBC('item', $item);
            } else {
                 $this->redirect(SITE_URL);
            }
        } else {
             $this->redirect(SITE_URL);
        }
    }
}//class