<?php
/**
 * Votes class for managing Votes on the site
 * @author Denys Yackushev
 * @version 0.1
 * @pachage RADCMS
 */
class controller_others_managevotes extends rad_controller
{
    private $_pid = 17;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        return $bco;
    }

    function __construct()
    {
        if($this->getParamsObject()) {
            $params = $this->getParamsObject();
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID() );
            $this->setVar('params',$params);
        }
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->setVar('action', strtolower($this->request('action')));
            switch(strtolower($this->request('action'))) {
                case 'getjs_addedit':
                case 'getjs':
                    $this->getJS();
                    break;
                case 'edittree':
                    $this->editTree();
                    break;
                case 'addnode':
                    if( isset($params) and ($params->hassubcats) ) {
                        $this->addNode();
                    }
                    break;
                case 'savenode':
                    $this->saveNode();
                    break;
                case 'deletenode':
                    $this->deleteNode();
                    break;
                case 'setactive':
                    $this->setActive();
                    break;
                case 'getitems':
                    $this->getRows();
                    break;
                case 'additem':
                    if($this->request('action_sub')=='add') {
                        $this->addRow();
                    } else {
                        $this->addItemForm();
                    }
                    $this->addBC('action', 'add');
                    break;
                case 'editrow':
                    if($this->request('action_sub')=='edit') {
                        $this->saveRow();
                        if((int)$this->request('returntorefferer')) {
                            $this->editRow();
                        } else {
                            $this->redirect($this->makeURL('alias=SITE_ALIAS'));
                        }
                    } else {
                        $this->editRow();
                    }
                    $this->addBC('action', 'edit');
                    break;
                case 'deleterow':
                    $this->deleteRow();
                    break;
                case 'chpos':
                    $this->changePosition();
                    break;
                case 'newlngpid':
                    $this->newLngPID();
                    break;

                /***   MANAGE ANSWERS WITH AJAX   ***/
                case 'listquestions':
                    $this->listQuestions();
                    break;
                case 'editanswer':
                    $this->editAnswer();
                    break;
                case 'moveanswer':
                    $this->moveAnswer();
                    break;
                case 'deleteanswer':
                    $this->deleteAnswer();
                    break;
                case 'editanswerform':
                    $this->addEditAnswerForm();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }
        }
    }

    function getJS()
    {
        $this->setVar('ROOT_PID',$this->_pid);
    }

    function editTree()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            $item = rad_instances::get('model_menus_tree')->getItem($node_id);
            $this->setVar('item',$item);
            $model = rad_instances::get('model_menus_tree');
            $model->setState('pid', $this->_pid);
            $model->setState('lang',$this->getContentLangID());
            $parents = array(new struct_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.votes.text')) ));
            $parents[0]->child = $model->getItems(true);
            $this->setVar('parents', $parents);
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Adds new default node to groups-tree
     * @return JavaScript code
     */
    function addNode()
    {
        $node_id = (int)$this->request('node_id');
        if($node_id) {
            rad_instances::get('controller_system_managetree')->addItem($node_id);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Save the tree node and return JS instructions
     * @return JavaScript
     */
    function saveNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                rad_instances::get('controller_system_managetree')->save($node_id);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Deletes news group from tree
     * @return JavaScript
     */
    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                $model = rad_instances::get('model_menus_tree');
                $current_node = $model->getItem($node_id);
                $rows = 0;
                //get current tree
                $parent_node = $model->getItem($current_node->tre_pid);
                $toDeleteTreeIds = array();
                $toDeleteTreeIds[] = $current_node->tre_id;
                //get all child trees
                if(!$current_node->tre_islast) {
                    $model->setState('pid',$node_id);
                    $child_nodes = $model->getItems(true);
                    $toDeleteTreeIds = $model->getRecurseNodeIDsList($child_nodes, $toDeleteTreeIds);
                }
                $model->setState('pid',$parent_node->tre_id);
                $child_parents = $model->getItems();
                if(count($child_parents) <= 1) {
                    $parent_node->tre_islast = 1;
                    $model->updateItem($parent_node);
                }
                //delete all items from deleted trees
                $newsModel = rad_instances::get('model_others_votes');
                $rows += $newsModel->deleteItemsByTreeId($toDeleteTreeIds);
                //delete seleted tree and child trees
                $rows += $model->deleteItemById($toDeleteTreeIds);
                if($rows) {
                    echo 'RADVotesTree.message("'.addslashes( $this->lang('-deleted') ).': '.$rows.'");';
                    echo 'RADVotesTree.cancelClick();';
                } else {
                    echo 'RADVotesTree.message("'.addslashes( $this->lang('deletedrows.catalog.error') ).': '.$rows.'");';
                    echo 'RADVotesTree.cancelClick();';
                }
                echo 'RADVotesTree.refresh();';                
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function setActive()
    {
        if($this->request('hash') == $this->hash()) {
            $v = (int)$this->request('v');
            $item_id = (int)$this->request('c');
            if($item_id) {
                $r = rad_instances::get('model_others_votes')->setActive($item_id,$v);
                $r = ($v and $r)?false:true;
                if($r) {
                    echo '$("active_votes_link_'.$item_id.'_1").style.display="none";';
                    echo '$("active_votes_link_'.$item_id.'_0").style.display="";';
                } else {
                    echo '$("active_votes_link_'.$item_id.'_1").style.display="";';
                    echo '$("active_votes_link_'.$item_id.'_0").style.display="none";';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function getRows()
    {
        $pid = (int)$this->request('pid');
        if($pid) {
            $model = rad_instances::get('model_others_votes');
            $model->setState('pid',$pid);
            $model->setState('lang',$this->getContentLangID());
            $items = $model->getItems();
            $this->setVar('items',$items);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Shows the form with add product
     * @return HTML
     */
    function addItemForm()
    {
        $cat_id = (int)$this->request('pid');
        if($cat_id) {
            $this->setVar('cat_id',$cat_id);
            $model_tree = rad_instances::get('model_menus_tree');
            $model_tree->setState('pid',$this->_pid);
            $categories = $model_tree->getItems(true);
            $this->setVar('categories',$categories);
            $item = new struct_votes();
            $this->setVar('item',$item);
            $this->setVar('ROOT_PID',$this->_pid);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Assigns the struct from request
     * @return struct_votes
     */
    private function _assignRowFromRequest()
    {
        $item = new struct_votes($this->getAllRequest());
        $item->vt_active = ($item->vt_active)?1:0;
        $item->vt_lngid = $this->getContentLangID();
        $item->vt_usercreated = $this->getCurrentUser()->u_id;
        $item->vt_datecreated = now();
        $item->vt_position = (int)$item->vt_position;
        $item->vt_metadescription = stripslashes($item->vt_metadescription);
        $item->vt_metakeywords = stripslashes($item->vt_metakeywords);
        $item->vt_metatitle = stripslashes($item->vt_metatitle);
        $item->vt_question = stripslashes($item->vt_question);
        $item->vt_treid = (int)$item->vt_treid;
        return $item;
    }

    /**
     * Adds the row
     * @return JavaScript
     */
    function addRow()
    {
        if($this->request('hash') == $this->hash()) {
            $item = $this->_assignRowFromRequest();
            if($item->vt_treid and strlen($item->vt_question)) {
                $model = rad_instances::get('model_others_votes');
                $rows = $model->insertItem($item);
                if((int)$this->request('returntorefferer')) {
                    $this->redirect($this->makeURL('action=editrow&id='.(int)$model->inserted_id()));
                } else {
                    $this->redirect($this->makeURL('alias=SITE_ALIAS'));
                }
            } else {
                $this->redirect($this->makeURL('alias=SITE_ALIAS'), addslashes($this->lang('votenotadded_tre.others.error')));
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Shows the edit form
     * @return string HTML
     */
    function editRow()
    {
        $item_id = (int)$this->request('i',$this->request('id'));
        if($item_id) {
            $model = rad_instances::get('model_others_votes');
            $model->setState('with_answers',true);
            $item = $model->getItem($item_id);
            $this->setVar('item',$item);
            $this->setVar('cat_id',$item->vt_treid);
            $model_tree = rad_instances::get('model_menus_tree');
            $model_tree->setState('pid',$this->_pid);
            $categories = $model_tree->getItems(true);
            $this->setVar('categories',$categories);
            $this->setVar('ROOT_PID',$this->_pid);
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Saves the Item
     * @return null
     */
    function saveRow()
    {
        if($this->request('hash') == $this->hash()) {
            $item = $this->_assignRowFromRequest();
            $item->vt_id = (int)$this->request('i',$this->request('id'));
            if($item->vt_treid and strlen($item->vt_question) and $item->vt_id) {
                rad_instances::get('model_others_votes')->updateItem($item);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function changePosition()
    {
        if($this->request('hash') == $this->hash()) {
            $item_id = (int)$this->request('b');
            $newpos = (int)$this->request('p');
            if($item_id and $newpos) {
                $table = new model_system_table(RAD.'votes');
                $item = $table->getItem($item_id);
                $item->vt_position = $newpos;
                $rows = $table->updateItem($item);
                echo 'RADVotes.refresh();';
                echo 'RADVotes.message("'.addslashes($this->lang('updatedrows.system.text')).': '.$rows.'");';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Deletes the video record
     */
    function deleteRow()
    {
        if($this->request('hash') == $this->hash()) {
            $item_id = (int)$this->request('vt_id');
            if($item_id) {
                $item_old = rad_instances::get('model_others_votes')->getItem($item_id);
                $rows = rad_instances::get('model_others_votes')->deleteItem($item_old);
                if((int)$this->request('returnmain')) {
                    $this->redirect($this->makeURL('alias='.str_replace('XML','',SITE_ALIAS)));
                } else {
                    echo 'RADVotes.refresh();';
                    echo 'RADVotes.message("'.addslashes($this->lang('deletedrows.system.text')).': '.$rows.'");';
                }
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

   /**
   * Sets the new PID for the tree and return the JS commands
   * @return JavaScript
   *
   */
    function newLngPID()
    {
        $lngid = (int)$this->request('i',$this->request('id'));
        if($lngid) {
            $params = $this->getParamsObject();
            echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
            echo 'RADVotesTree.refresh();';
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * List of the questions
     * @return JS
     */
    function listQuestions()
    {
        $item_id = (int)$this->request('id',$this->request('i'));
        if($item_id) {
            $model = rad_instances::get('model_others_votes');
            $model->setState('item_id',$item_id);
            $this->setVar('items',$model->getQuestions());
        } else {
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Shows the add answer form
     * @return html
     */
    function addEditAnswerForm()
    {
        $item_id = (int)$this->request('vt_id');
        if($item_id) {
            if($this->request('id')) {
                $table = new model_system_table(RAD.'votes_questions');
                $item = $table->getItem((int)$this->request('id'));
            } else {
                $item = new struct_votes_questions();
                $item->vtq_vtid = $item_id;
            }
            $this->setVar('item',$item);
        } else {
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * @return struct_votes_questions
     */
    private function _getAnswerFromRequest()
    {
        $item = new struct_votes_questions($this->getAllRequest());
        $item->vtq_id = (int)$item->vtq_id;
        $item->vtq_vtid = (int)$item->vtq_vtid;
        $item->vtq_position = (int)$item->vtq_position;
        $item->vtq_name = stripslashes($item->vtq_name);
        return $item;
    }

    /**
     * Edit answer
     * @return JS
     */
    function editAnswer()
    {
        if($this->request('hash') ==$this->hash()) {
            $item_id = (int)$this->request('vtq_vtid');
            if($item_id) {
                $item = $this->_getAnswerFromRequest();
                $table = new model_system_table(RAD.'votes_questions');
                if($item->vtq_id) {
                    $rows = $table->updateItem($item);
                } else {
                    $rows = $table->insertItem($item);
                }
                echo 'RADVotesQuestions.message("'.addslashes($this->lang('insertedrows.system.message ')).': '.$rows.'");';
                echo 'RADVotesQuestions.cancelWindowClick();';
                if($rows) {
                    echo 'RADVotesQuestions.refresh();';
                }
            } else {
               $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Changes the position of the answer
     * @return JS
     */
    function moveAnswer()
    {
        if($this->request('hash') ==$this->hash()) {
            $item_id = (int)$this->request('id');
            if($item_id) {
                $table = new model_system_table(RAD.'votes_questions');
                $item = $table->getItem($item_id);
                $item->vtq_position = (int)$this->request('v');
                if($item->vtq_position and $item_id) {
                    $table->updateItem($item);
                    echo 'RADVotesQuestions.message("'.addslashes($this->lang('updatedrows.system.message ')).': 1");';
                    echo 'RADVotesQuestions.refresh();';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Deletes the answer from vote
     * @return JS
     */
    function deleteAnswer()
    {
        if($this->request('hash') ==$this->hash()) {
            $item_id = (int)$this->request('id',$this->request('i'));
            if($item_id) {
                $model = new model_system_table(RAD.'votes_questions');
                $rows = $model->deleteItem(new struct_votes_questions(array('vtq_id'=>$item_id)));
                echo 'RADVotesQuestions.message("'.addslashes($this->lang('deletedrows.sustem.message')).': '.$rows.'");';
                if($rows) {
                    echo 'RADVotesQuestions.refresh();';
                }
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }
}//class