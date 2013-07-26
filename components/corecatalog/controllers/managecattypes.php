<?php
/**
 * Class for managing types for products
 *
 * @author Yackushev Denys
 * @package Taberna
 *
 */
class controller_corecatalog_managecattypes extends rad_controller
{
    private $_pid = '47';

    private $_showinlist = false;
    private $_showindetail = false;
    private $_showinbin = false;

    private $_showinlistID = 1;
    private $_showindetailID = 2;
    private $_showinbinID = 3;

    function __construct()
    {
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            //$this->_pid = $params->treestart;
            $this->_pid = $params->_get('treestart', $this->_pid, $this->getContentLangID() );
            $this->_showinlist = $params->showinlist_option;
            $this->_showindetail = $params->showindetail_option;
            $this->_showinbin = $params->showinbin_option;
            $this->setVar('params', $params);
        }
        $this->setVar('hash', $this->hash());
        if($this->request('action')){
            $this->setVar('action', $this->request('action') );
            switch($this->request('action')){
                case 'getnodes':
                    $this->getNodes();
                    break;
                case 'getjs':
                    $this->getJS();
                    break;
                //shows the edit one node in right panel
                case 'editnode':
                    $this->showEditNode();
                    break;
                case 'deletenode':
                    $this->deleteNode();
                    break;
                case 'reparent':
                    $this->changeParent();
                    break;
                case 'reorder':
                    $this->changeOrder();
                    break;
                //List values of one type in table at the botton in Ajax
                case 'showlist':
                    $this->showNodeList();
                    break;
                case 'addnewnode':
                    $this->addNewNode();
                    break;
                case 'savenode':
                    $this->saveNode();
                    break;
                //Show form to add new field in type
                case 'addfieldform':
                    $this->addTypeFieldForm();
                    break;
                //adds the field from addtypefieldform
                case 'addfield':
                    $this->addTypeField();
                    break;
                //Deletes one field
                case 'delfield':
                    if($this->request('hash')==$this->hash())
                    $this->delTypeField();
                    break;
                //save Field from JS form
                case 'savefield':
                    $this->saveTypeField();
                    break;
                case 'newlngpid':
                    $this->newLngPID();
                    break;
                case 'deleteitemsfromtree':
                    $this->deleteItemsFromTree();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }//switch
        }//if request('action')
    }//function __construct

    function registerAutoloadPlugins()
    {
        rad_autoload_register(array('model_corecatalog_types', 'autoloadPlugins'));
    }

    function getNodes()
    {
        $model = rad_instances::get('model_coremenus_tree');
        $model->setState('pid',$this->request('pid',$this->_pid));
        $items = $model->getItems();
        $s = '<?xml version="1.0"?><nodes>';
        if(count($items)) {
            foreach($items as $id) {
                $s.='<node text="'.$id->tre_name.'"';
                $s.=($id->tre_active)?'':' color="#808080"';
                $s.=($id->tre_islast)?'':' load="'.SITE_URL.SITE_ALIAS.'/action/getnodes/pid/'.$id->tre_id.'/"';
                $s.=' id="'.$id->tre_id.'"';
                $s.=' islast="'.$id->tre_islast.'"';
                $s.=' />';
            }//foreach
        }//if
        $s.='</nodes>';
        //echo json_encode($result);
        $this->header('Content-Length: '.strlen($s));
        $this->header('Content-Type: application/xml');
        echo $s;
    }//function getNodes

    function getJS()
    {
        $this->setVar('ROOT_PID', $this->_pid);
    }//function getJS

    /**
     * Show panel with edit node fields
     *
     * @return html
     */
    function showEditNode()
    {
        if((int)$this->request('id')) {
            $this->setVar('id',(int)$this->request('id'));
            $model = rad_instances::get('model_coremenus_tree');
            $item = $model->getItem(  (int)$this->request('id') );
            $this->setVar( 'item', $item );
            $model->setState('pid',$this->_pid);
            $nodes = $model->getItems(true);
            array_unshift($nodes, new struct_coremenus_tree( array('tre_id'=>$this->_pid,'tre_name'=>$this->lang('rootnode.catalog.text')) ) );
            $this->setVar('nodes',$nodes);
        } else {
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Deleted tnhe node from tree
     * @return JS code
     */
    function deleteNode()
    {
        if($this->request('hash') == $this->hash()) {
            $node_id = (int)$this->request('node_id');
            if($node_id) {
                $model = rad_instances::get('model_coremenus_tree');
                $current_node = $model->getItem($node_id);
                $rows = 0;
                //get current tree
                $parent_node = $model->getItem($current_node->tre_pid);
                $toDeleteTreeIds = array();
                if($current_node->tre_id != $this->_pid) {
                    $toDeleteTreeIds[] = $current_node->tre_id;
                }
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
                $typesModel = rad_instances::get('model_corecatalog_types');
                $rows += $typesModel->deleteItemsByTreeId($toDeleteTreeIds);
                //delete seleted tree and child trees
                $rows += $model->deleteItemById($toDeleteTreeIds);
                if($rows) {
                    echo 'RADMooTree.message("'.addslashes( $this->lang('-deleted') ).': '.$rows.'");';
                    echo 'RADCatTypesAction.cancelSEditForm();';
                } else {
                    echo 'RADMooTree.message("'.addslashes( $this->lang('deletedrows.catalog.error') ).': '.$rows.'");';
                    echo 'RADCatTypesAction.cancelSEditForm();';
                }
                echo 'RADMooTree.refresh();';
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function changeParent()
    {

    }

    function changeOrder()
    {

    }

    /**
     * List values of one type in table at the botton in Ajax
     *
     * @return html from managetypes/list.html
     */
    function showNodeList()
    {
        if((int)$this->request('id')) {
            $this->setVar('id', (int)$this->request('id'));
            $model = rad_instances::get('model_corecatalog_types');
            $model->setState('vl_active', '1');
            $model->setState('vl_tre_id', (int)$this->request('id') );
            $this->setVar( 'items', $model->getItems(true) );
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Save data from Edit node form
     *
     * @return JavaScript code
     */
    function saveNode()
    {
        if($this->request('hash') == $this->hash()) {
            if( $this->request('id') ) {
                $id = (int)$this->request('id');
                if($id) {
                    rad_instances::get('controller_core_managetree')->save($id);
                    /*
                    $model = rad_instances::get('model_coremenus_tree');
                    $item = $model->getItem($id);
                    $item->CopyToStruct( $this->getAllRequest() );
                    $item->tre_id = $id;
                    $rows = $model->updateItem($item);
                    if($rows) {
                        echo 'RADMooTree.refresh();';
                    } else {
                        echo 'RADMooTree.message("'.addslashes($this->lang('norowsupdated.catalog.message')).'");';
                    }
                    echo 'RADCatTypesAction.cancelSEditForm();';
                    echo "$('list_block').style.visibility = 'hidden';";
                    */
                } else {
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                }
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Adds new node and go to the edit it!
     * @return js
     */
    function addNewNode()
    {
        $nodeId = (int)$this->request('node_id');
        if($nodeId) {
            rad_instances::get('controller_core_managetree')->addItem($nodeId);
            echo 'RADCatTypesAction.showSEditForm();';
            /*
            $new_node_name = 'new node u_'.now();
            $node = new struct_coremenus_tree(array('tre_pid'=>$nodeId,'tre_name'=>$new_node_name,
                            'tre_islast'=>'1', 'tre_lang'=>$this->getContentLangID()));
            $rows = rad_instances::get('model_coremenus_tree')->insertItem($node);
            $id = rad_instances::get('model_coremenus_tree')->inserted_id();
            $parent_item = rad_instances::get('model_coremenus_tree')->getItem($nodeId);
            if($parent_item->tre_islast){
                $parent_item->tre_islast = '0';
                rad_instances::get('model_coremenus_tree')->updateItem($parent_item);
            }
            if($rows) {
                echo 'RADMooTree.addItemNode("'.$id.'","'.$new_node_name.'");';
                echo 'RADCatTypesAction.showSEditForm('.$id.');';
            } else {
                echo 'alert("'.addslashes( $this->lang('-error') ).': '.__LINE__.'");';
            }
            */
        }else{
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Show form to add new field in type
     *
     * @return html for ajax
     */
    function addTypeFieldForm()
    {
        if((int)$this->request('id')) {
            $this->setVar('id', $this->request('id'));
            $model_types = rad_instances::get('model_corecatalog_types');
            if($this->request('vl_id')) {
                $vl_id = (int)$this->request('vl_id');
                $this->setVar('vl_id', $vl_id);
                $model_types->setState('vl_id',(int)$this->request('vl_id'));
                $item = $model_types->getItem();
            } else {
                $item = new struct_corecatalog_cat_val_names();
            }
            $this->setVar('item',$item);
            $model = new model_core_table('measurement','corecatalog');
            $model->setState('order by','ms_position,ms_value')
                  ->setState('where', 'ms_langid='.(int)$this->getContentLangID());
            $measurements = $model->getItems();
            $this->setVar('measurements',$measurements);
            //assign the selected measurement value
            $this->setVar('vl_measurement_id',$item->vl_measurement_id );
            //gets the input types
            $this->registerAutoloadPlugins();
            $this->setVar('inputTypes', $model_types->getInputTypes());
            $this->setVar('outputTypes', $model_types->getOutputTypes());
            $types_show = array();
            //Types show
            if($this->_showinlist) {
                $types_show[] = 'showinlist.catalog.option';
            }
            if($this->_showindetail) {
                $types_show[] = 'showindetail.catalog.option';
            }
            if($this->_showinbin) {
                $types_show[] = 'showinbin_catalog.option';
            }
            if(count($types_show)) {
                $this->setVar('types_show', $types_show);
            }
            $ts_sh = array();
            if($this->request('vl_id')) {
                $model_sh = new model_core_table('ct_showing','corecatalog');
                $model_sh->setState('where',' cts_vl_id='.$vl_id.' ');
                $items_sh = $model_sh->getItems();
                foreach($items_sh as $id_sh) {
                    if($id_sh->cts_show == 1) {
                        $ts_sh['showinlist.catalog.option'] = 1;
                    }
                    if($id_sh->cts_show == 2) {
                        $ts_sh['showindetail.catalog.option'] = 1;
                    }
                    if($id_sh->cts_show == 3) {
                        $ts_sh['showinbin_catalog.option'] = 1;
                    }
                }
            }
            $this->setVar('ts_sh', $ts_sh);
        } else {
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Delete all rows from rad_ct_showing where cts_vl_id eq $type_id
     * @param integer $type_id
     * @return integer count of deleted rows
     */
    private function clearTypeFieldsShow($type_id)
    {
        if($type_id) {
            $model = new model_core_table('ct_showing','corecatalog');
            $model->setState('where',' cts_vl_id='.(int)$type_id.' ');
            $items = $model->getItems();
            $rows = 0;
            if(count($items)) {
                foreach($items as $id) {
                    $rows += $model->deleteItem($id);
                }
            }
            return $rows;
        } else {
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Saves the type showed fields
     * @param integer $type_id
     */
    private function saveTypeFieldsShow($type_id)
    {
        if($type_id) {
            $model = new model_core_table('ct_showing','corecatalog');
            $model->setState('where',' cts_vl_id='.$type_id.' ');
            $items = $model->getItems();
            if(count($items)) {
                foreach($items as $id) {
                    $model->deleteItem($id);
                }//foreach
            }//if
            $added_items = array();
            if($this->_showinlist) {
                if($this->request('CTshowing_showinlist_catalog_option')) {
                    $added_items[] = new struct_corecatalog_ct_showing( array(
                            'cts_vl_id'=>$type_id,
                            'cts_show'=>$this->_showinlistID
                            ) );
                }
            }
            if($this->_showindetail) {
                if($this->request('CTshowing_showindetail_catalog_option')) {
                    $added_items[] = new struct_corecatalog_ct_showing( array(
                            'cts_vl_id'=>$type_id,
                            'cts_show'=>$this->_showindetailID
                            ) );
                }
            }
            if($this->_showinbin) {
                if($this->request('CTshowing_showinbin_catalog_option')) {
                    $added_items[] = new struct_corecatalog_ct_showing( array(
                            'cts_vl_id'=>$type_id,
                            'cts_show'=>$this->_showinbinID
                            ) );
                }
            }
            $rows = 0;
            if(count($added_items)) {
                foreach($added_items as $id) {
                    $rows += $model->insertItem($id);
                }
                if(!count($rows)) {
                    throw new rad_exception('Can\'t save the showing type! file: '.__FILE__.', line: '.__LINE__);
                }
                return $rows;
            }
        }else{
            $this->securityHoleAlert( __FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Adds the new field from AddTypeFieldForm
     *
     * @return JavaScript
     *
     */
    function addTypeField()
    {
        if($this->request('hash') == $this->hash()) {
            $item = new struct_corecatalog_cat_val_names($this->getAllRequest());
            if( ($item->vl_measurement_id)
                            and (strlen($item->vl_name)>0)
                            and (strlen($item->vl_type_in)>0)
                            and (strlen($item->vl_type_print)>0)
                            and($item->vl_tre_id) ) {
                $model = rad_instances::get('model_corecatalog_types');
                $rows = $model->insertItem($item);
                $type_id = $model->inserted_id();
                $rows += $this->saveTypeFieldsShow($type_id);
                if($rows) {
                     echo '$("messageBarTypeAddFieldWindow").set(\'html\',\'<b>'.addslashes($this->lang('-inserted')).'</b>\');';
                     echo 'if($(\'TypeAddFieldWindow\')){$(\'TypeAddFieldWindow\').destroy();}';
                     echo 'RADCatTypesAction.showListTypes("'.$item->vl_tre_id.'");';
                } else {
                    echo 'alert("'.$this->lang('cantinserttypefield.catalog.text').'");';
                }
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Deletes field from type
     * also deletes all rad_ct_showing with this record
     */
    function delTypeField()
    {
        if( ((int)$this->request('id')) and ((int)$this->request('tre_id')) ) {
            $item = new struct_corecatalog_cat_val_names( array('vl_id'=>(int)$this->request('id')) );
            $rows = $item->remove();
            if($rows) {
                echo 'RADCatTypesAction.showListTypes('.(int)$this->request('tre_id').')';
            } else {
                echo 'alert("'.$this->lang('cantdelete.catalog.error').'")';
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Save one changed field
     *
     */
    function saveTypeField()
    {
        if($this->request('hash') == $this->hash()) {
            $item = new struct_corecatalog_cat_val_names($this->getAllRequest());
            if($item->vl_id) {
                $model = rad_instances::get('model_corecatalog_types');
                $rows = $model->updateItem($item);
                $rows += $this->saveTypeFieldsShow($item->vl_id);
                if($rows) {
                    echo 'RADCatTypesAction.showListTypes('.(int)$item->vl_tre_id.');';
                    echo 'if($(\'TypeAddFieldWindow\')){$(\'TypeAddFieldWindow\').destroy();}';
                } else {
                    echo 'alert("'.$this->lang('norowsupdated.catalog.message').'")';
                }
            }else{
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        }else{
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * When deleting some tree, also deletes all records from other tables;
     */
    function deleteItemsFromTree()
    {
        $nodeId = (int)$this->request('node_id');
        if($nodeId) {
            $model = rad_instances::get('model_corecatalog_types');
            $items = $model->setState('vl_tre_id', $nodeId)
                        ->getItems(true);
            if(count($items)) {
                foreach($items as $item) {
                    $model->deleteItem($item);
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

/**
   * Sets the new PID for the tree and return the JS commands
   * @return JavaScript
   *
   */
  function newLngPID()
  {
      $lngid = (int)$this->request('i');
      if($lngid) {
          $params = $this->getParamsObject();
          echo 'ROOT_PID = '.$params->_get('treestart', $this->_pid, $lngid).';';
          echo 'RADMooTree.refresh();';
      } else {
          $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
      }
  }
}//class