<?php
/**
 * Votes class for Votes on the site
 * @author Denys Yackushev
 * @version 0.1
 * @pachage Taberna
 */
class controller_coreothers_votes extends rad_controller
{
    private $_pid = 17;

    private $_ordering = 'random';

    private $_isLeftMenu = false;

    private $_title = 'Votes';

    private $_limit = 1;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('items');
        return $bco;
    }
    
    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getCurrentLangID());
            $this->_isLeftMenu = $params->is_left_menu;
            $this->_title = $params->_get('title',$this->_title,$this->getCurrentLangID());
            $this->_limit = $params->_get('itemsperpage',$this->_limit);
            $this->setVar('params',$params);
        }
        if((bool)$this->request('iscenter') and $this->request('iscenter')=='true') {
            $this->setVar('is_center', true);
        }
        if ($this->_isLeftMenu) {
            if ($this->request('vote')) {
                $this->setVar('vote','true');
                $this->VoteJS();
            } else {
                $this->showVoteRandom();
            }
        } else {
            $this->assignVotesCategories();
            $this->assignRubricVotes();
            //echo 'SHOW CENTER VOTE';
        }
    }

    /**
     * Shows the random votes on the site
     * @return string HTML
     */
    function showVoteRandom($vt_id=NULL)
    {
        $model = rad_instances::get('model_coreothers_votes');
        if($this->getParamsObject() and $this->getParamsObject()->order_type == 'random'){
            $model->setState('order by','RAND()');
        }else{
            $model->setState('order by','vt_position');
        }
        $model->setState('with_questions',true);
        $model->setState('lang',$this->getCurrentLangID());
        $model->setState('!vta_hash', md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']) );
        if($vt_id){
            $model->setState('vt_id',$vt_id);
        }
        $items = $model->getItems($this->_limit);
        //print_r($items);
        if(!count($items) or $items[0]->vt_active == 0){
            $model->unsetState('!vta_hash');
            $model->setState('with_questions',true);
            $model->setState('with_answers',true);
            $items = $model->getItems($this->_limit);
            if(count($items))
                for($i=0;$i<count($items);$i++)
                    if(isset($items[$i]->vt_answers) and count($items[$i]->vt_answers))
                        $this->_calcVotesSumm($items[$i]->vt_answers);
            $this->setVar('showVote',true);
            $this->setVar('showTitle',true);
        }
        
        $this->setVar('items',$items);
        $this->addBC('items',$items);
    }

    /**
     * При самом голосовании... ф-я когда голосуют за понравившийся ответ
     */
    private function _vote()
    {
        $vtq_id = (int)$this->request('vtq_id');
        $vt_id = (int)$this->request('vote');
        if($vt_id and $vtq_id) {
            $item = new struct_coreothers_votes_answers();
            $item->vta_browser = $_SERVER['HTTP_USER_AGENT'];
            $item->vta_datevote = now();
            $item->vta_ip = $_SERVER['REMOTE_ADDR'];
            if($this->getCurrentUser()) {
                $item->vta_userid = $this->getCurrentUser()->u_id;
            } else {
                $item->vta_userid = 0;
            }
            $item->vta_vtid = $vt_id;
            $item->vta_vtqid = $vtq_id;
            $item->vta_hash = md5($item->vta_ip.$item->vta_browser);
            $item->save();
            $this->showVoteVoted($item);
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Calculate the Votes percent in Vote
     */
    private function _calcVotesSumm(&$mas)
    {
        if(count($mas)) {
            $count = 0;
            for($i=0;$i<count($mas);$i++) {
                $count += $mas[$i]->cnt_ans;
            }//for
            if($count>0) {
                for($i=0;$i<count($mas);$i++) {
                    $mas[$i]->percent_vote = round( $mas[$i]->cnt_ans*100/$count, 2 );
                }
            }
        }//if
    }

    /**
     * Shows the voted vote
     * @return string HTML
     */
    function showVoteVoted($item = NULL)
    {
        if($item) {
            $this->setVar('showVote',true);
            $vt_id = $item->vta_vtid;
            $model = rad_instances::get('model_coreothers_votes');
            $model->setState('with_questions',true);
            $model->setState('with_answers',true);
            $model->setState('vt_id',$vt_id);
            $model->setState('lang',$this->getCurrentLangID());
            $items = $model->getItems();
            if(count($items)) {
                for($i=0;$i<count($items);$i++) {
                    if(isset($items[$i]->vt_answers) and count($items[$i]->vt_answers)) {
                        $this->_calcVotesSumm($items[$i]->vt_answers);
                    }
                }
            }
            $this->setVar('items',$items);
            $this->addBC('items',$items);
        } else {
            $vt_id = (int)$this->request('vt_id');
        }

    }

    /**
     * Vote the vote
     * @return JS
     */
    function VoteJS()
    {
        $this->_vote();
    }

    /**
     * For showing the votes categories on the site
     */
    function assignVotesCategories()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->request('vcp',$this->_pid));
        $model->setState('lang',$this->getCurrentLangID());
        $items = $model->getItems();
        $this->setVar('categories',$items);
    }

    /**
     * Assign Votes in category ans for showing on site
     */
    function assignRubricVotes()
    {
        $vt_id = (int)$this->request('v');
        if($vt_id) {
            $this->setVar('$showOneVote', true);
            $this->showVoteRandom($vt_id);
        } else {
            $table = new model_core_table('votes','coreothers');
            $table->setState('where', 'vt_lngid='.$this->getCurrentLangID().' and vt_treid='.(int)$this->request('vcp',$this->_pid));
            $table->setState('showSQL', true);
            $items = $table->getItems();
            $this->setVar('votes',$items);
        }
    }
}//class