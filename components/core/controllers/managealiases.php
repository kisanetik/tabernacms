<?php
/**
 * System managing aliases (Carcases)
 * @author Denys Yackushev
 * @package RADCMS
 */
class controller_core_managealiases extends rad_controller
{
    private $_banner_places = 0;

    public static function getBreadcrumbsVars()
    {
        $bco = new rad_breadcrumbsobject();
        $bco->add('action');
        $bco->add('aliasname');
        return $bco;
    }

    function __construct()
    {
        parent::__construct();
        if($this->request('search')){
            $this->setVar('searchword', $this->request('search'));
        } else {
            $this->setVar('searchword', '');
        }
        $this->setVar('powercache',$this->config('cache.power',false));
        if($this->getParamsObject()){
            $params = $this->getParamsObject();
            $this->_banner_places = $params->treestart;
            $this->setVar('params',$params);
        }
        $this->setVar('hash', $this->hash());
        if( $this->request('action') ){
            $this->addBC('action', $this->request('action'));
            switch( $this->request('action') ){
                case 'edit':
                    $this->editRecord();
                    $this->_assignIncludesAndModules();
                    $this->assignPositions();
                    $this->assignThemes();
                    $this->assignAliasGroups();
                    break;
                case 'add':
                    $this->addAlias();
                    break;
                case 'addinc':
                    $this->addInclude();
                    break;
                case 'delinc':
                    $this->deleteInclude();
                    break;
                case 'delete':
                    $this->deleteAlias();
                    break;
                case 'search':
                    $this->search();
                    break;
                case 'getjs_aliaslist':
                case 'getjs':
                    $this->getJS();
                    break;
                //ajax functions
                case 'save':
                    $this->saveAlias();
                    break;
                case 'applyinc':
                    $this->applyIncludes();
                    break;
                case 'addincludewindow':
                    $this->showAddWindow();
                    $this->_assignIncludesAndModules();
                    $this->assignPositions();
                    break;
                case 'addWinclude':
                    $this->addIncludeW();
                    break;
                case 'getincludeslist':
                    $this->editRecord();
                    $this->_assignIncludesAndModules();
                    $this->assignPositions();
                    break;
                case 'confinclude':
                    $this->configInclude();
                    if($this->request('onlymain')) {
                        $this->setVar('onlymain', true);
                    }
                    break;
                case 'saveconfinclude':
                    $this->saveConfigInclude();
                    break;
                case 'getcontrollerjs':
                    $this->getControllerJS();
                    break;
                case 'showeditscript':
                    $this->showEditScript();
                    break;
                case 'saveeditscript':
                    $this->saveEditScript();
                    break;
                case 'refreshlist':
                    $this->showAliases();
                    break;
                case 'savedescription':
                    $this->saveDescription();
                    break;
                case 'descriptionwindow':
                    $this->descriptionWindow();
                    break;
                case 'createtheme':
                    $this->createTheme();
                    break;
                case 'deletetheme':
                    $this->deleteTheme();
                    break;
                default:
                    $this->badRequest();
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                    break;
            }
            $this->setVar('action', $this->request('action'));
        } else {//if action
            $this->showAliases();
        }
    }

    function showAliases()
    {
        $model = rad_instances::get('model_core_aliases');
        $model->setState('is_admin',0);
        if($this->request('onlyadmin'))
            $model->setState('is_admin',(int)$this->request('onlyadmin'));
        $items = $model->getItems();
        $this->setVar('items', $items);
    }

    function editRecord()
    {
        $model = rad_instances::get('model_core_aliases');
        $model->setState('join_description',true);
        $model->setState('join.aliasgroup',true);
        $theme = trim($this->request('theme'));
        if(strlen($theme)) {
            $model->setState('theme',$theme);
        }
        $item = $model->getItem( (int)$this->request( 'id' ) );
        for($i=0;$i<count($item->includes);$i++) {
            $item->includes[$i]->hasOptions = rad_xmlparams::checkXMLFor($item->includes[$i]->m_name,$item->includes[$i]->inc_filename);
            if($item->includes[$i]->hasOptions) {
                $item->includes[$i]->controllers = rad_xmlparams::getControllerList($item->includes[$i]->m_name,$item->includes[$i]->inc_filename);
            }//if
        }//for
        //DO NOT REMEMBER WHERE I CREATED BEFORE CONTROLLERS PARAM!
        $this->setVar('item', $item);
        $this->addBC('aliasname', $item->alias);
        $model = new model_core_table('templates');
        $model->setState('order by','filename');
        $templates = $model->getItems();
        $this->setVar('templates',$templates);
        $this->setVar('inclasses', rad_input::getPluginsFGet() );
        $this->setVar('langs', $this->getAllLanguages() );
        $this->setVar('curr_lng', $this->getCurrentLangID() );
    }

    /**
     * just for show the menu for adding alias
     *
     */
    function addAlias()
    {
        $this->assignTemplates();
        $this->assignAliasGroups();
        if( $this->request('aliasname1') and $this->request('template_id') ) {
            $this->_assignIncludesAndModules();
            $model = rad_instances::get('model_core_aliases');
            $add = new struct_core_alias();
            $add->alias = $this->request('aliasname1');
            $add->template_id = $this->request('template_id');
            $item->active = ( $this->request('active') )?1:0;
            $item->ali_admin = ( $this->request('ali_admin') )?1:0;
            $model->insertItem($add);
            $id = $model->inserted_id();
            $this->redirect( $this->makeURL('action=edit&id='.$id) );
        } else {//не указанно имя и не выбран темплейт
            $item = new struct_core_alias();
            if( $this->request('aliasname1') ) {
                $item->alias = $this->request('aliasname1');
            }
            if( $this->request('template_id') ) {
                $item->template_id = $this->request('template_id');
            }
            if($this->request('ta')) {
                $item->ali_admin = 2;
            }
            if($this->request('oa')) {
                $item->ali_admin = 1;
            }
        }
        $this->setVar('item',$item);
    }

    function addInclude()
    {
        if( ( $this->request('include_id')>0 ) and ( $this->request('position_id') ) and ($this->request('alias_id')) ) {
            $struct = new struct_core_includes_in_aliases($this->getAllRequest());
            $model = rad_instances::get('model_core_includes');
            $rows = $model->insertItem($struct);
            if( $rows ) {
                $this->setMessage($this->lang('-added'));
                $this->redirect( $this->makeURL('alias='.SITE_ALIAS.'&action=edit&id='.$this->request('alias_id')) );
                $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem((int)$this->request('id')));
            } else {
                die('can\'t insert!!!! '.__LINE__);
            }
        } else {
            $this->badRequest(__LINE__);
        }
    }

    function addIncludeW()
    {
        if($this->request('hash') == $this->hash()) {
            if( ($this->request('include_id')) and ($this->request('position_id')) and ($this->request('order_sort')) ){
                $struct = new struct_core_includes_in_aliases();
                $aliasid = (int)$this->request('alias_id');
    
                $theme = trim($this->request('theme'));
                if( strlen($theme) and (is_dir(THEMESPATH.$theme)) ){
                    $table = new model_core_table('themes');
                    $table->setState('where','theme_aliasid='.$aliasid.' and theme_folder="'.$theme.'"');
                    $item = $table->getItem();
                    $struct->theme_id = $item->theme_id;
                }
    
                $struct->include_id = (int)$this->request('include_id');
                $struct->controller = $this->request('controller');
                $struct->order_sort = (int)$this->request('order_sort');
                $struct->position_id = (int)$this->request('position_id');
                $struct->alias_id = $aliasid;
                $model_aliases = rad_instances::get('model_core_aliases');
                $mitem = $model_aliases->getIncludeById( $struct->include_id );
                $params = rad_xmlparams::getParamsObject($mitem['m_name'],$mitem['inc_filename']);
                foreach($params->_getParamsNames() as $id=>$pname) {
                    $params->_set($pname, $params->_default($pname) );
                }
                $struct->params_hash = $params->_hash();
                $model = rad_instances::get('model_core_includes');
                $rows = $model->insertItem($struct);
                if($rows) {
                    $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem($struct->alias_id));
                    echo 'if($(\'IncAddFieldWindow\')){$(\'IncAddFieldWindow\').destroy();}';
                    echo '$(\'IncInAlInfoMessage\').set("html","'.str_replace('"','\\\"',$this->lang('-added')).'");';
                    echo 'RADIncInAlAction.refresh();';
                    echo 'RADIncInAlAction.clearTimeout();';
                } else {
                    echo 'alert("ERROR!!!! '.__LINE__.' Problem in DB");';
                }
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function deleteInclude()
    {
        if($this->request('hash') == $this->hash()) {
            if($this->request('id')>0) {
                $model = rad_instances::get('model_core_includes');
                $struct = new struct_core_includes_in_aliases( $this->getAllRequest() );
                $struct->id = (int)$struct->id;
                if($struct->id) {
                    $rows = $model->deleteItem($struct);
                    if(count($rows)) {
                        $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem($struct->alias_id));
                        $this->setMessage( $this->lang('-deleted').'&nbsp;'.$rows );
                    } else {
                        $this->setMessage( $this->lang('-someerror').' class: '.$this->getClassName().' line: '.__LINE__ );
                    }
                    if($this->request('js')=='true') {
                        $this->header('Content-type: text/javascript');
                        echo 'RADIncInAlAction.deleteDynamiclyRow('.$struct->id.');';
                    } else {
                        $this->redirect( $this->makeURL('action=edit&id='.$this->request('alias_id')) );
                    }
                } else {
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                }
            } else {
                $this->badRequest(__LINE__);
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function deleteAlias()
    {
        if($this->request('hash') == $this->hash()) {
            if( $this->request('id') ){
                $model = rad_instances::get('model_core_aliases');
                $cnt = $model->deleteAlias( $this->request('id') );
                $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem((int)$this->request('id')));
                $this->setMessage( $this->lang('-deleted :').$cnt );
                $this->redirect($this->makeURL('alias='.SITE_ALIAS));
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,get_class($this));
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,get_class($this));
        }
    }

    /**
     * Assign theme folders
     *
     */
    function assignThemes()
    {
        $themes = array();
        if(is_dir(THEMESPATH)) {
            $d = dir(THEMESPATH);
            while (false !== ($entry = $d->read())) {
                if( ($entry!='.') and ($entry!='..') and (is_dir(THEMESPATH.$entry)) and (file_exists(THEMESPATH.$entry.'/description.txt')) and (is_file(THEMESPATH.$entry.'/description.txt')) ){
                    $themes[] = $entry;
                }
            }
        }
        $this->setVar('themes',$themes);
        if(!empty($themes)) {
            $table = new model_core_table('themes');
            $alias_id = (int)$this->request('id');
            $table->setState('where','theme_aliasid='.$alias_id);
            $themes_rules = $table->getItems();
            $this->setVar('themes_rules',$themes_rules);
        }
    }

    function search()
    {
        $word = $this->request('word');
        if($word) {
            $model = rad_instances::get('model_core_aliases');
            $model->setState('is_admin',0);
            if($this->request('onlyadmin')) {
                $model->setState('is_admin',(int)$this->request('onlyadmin'));
            }
            $items = $model->search($word);
            $this->setVar('items',$items);
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function assignTemplates()
    {
        $table = new model_core_table('templates');
        $templates = $table->getItems();
        $this->setVar('templates',$templates);
    }

    /**
     * Assign the alias groups
     */
    function assignAliasGroups()
    {

        $table = new model_core_table('aliases');
        $table->setState('where','ali_admin=2');
        $table->setState('order by','alias');
        $group_alias = $table->getItems();
        $this->setVar('group_alias',$group_alias);
    }

    function assignPositions()
    {
        $table = new model_core_table('positions');
        $table->setState('order by','rp_name');
        $items = $table->getItems();
        $this->setVarByRef('positions',$items);
    }

    function assignModules()
    {

    }

    private function _assignIncludesAndModules()
    {
        $theme = trim($this->request('theme'));
        $model = rad_instances::get('model_core_aliases');
        $modules = $model->getModules();
        $res = $model->getIncludes();
        $includes = array();
        $theme_ex = strlen($theme);
        $modules_sort = array();
        foreach($modules as $id) {
            $modules_sort[$id['m_id']] = $id['m_name'];
        }
        $cnt_res = count($res);
        for($i=0;$i<$cnt_res;$i++) {
            if($theme_ex) {
                if( file_exists(THEMESPATH.$theme.DS.$modules_sort[$res[$i]['id_module']].DS.'templates'.DS.$res[$i]['inc_filename']) and is_file(THEMESPATH.$theme.DS.'micros'.DS.$modules_sort[$res[$i]['id_module']].DS.$res[$i]['inc_filename']) ) {
                    $res[$i]['is_theme'] = 1;
                } else {
                    $res[$i]['is_theme'] = 0;
                }
            }
            if(!file_exists(COMPONENTSPATH.$modules_sort[$res[$i]['id_module']].DS.'set'.DS.$res[$i]['inc_filename'].'.xml')) {
                unset($res[$i]);
            }
            if(isset($res[$i])) {
                $includes[$res[$i]['id_module']][] = $res[$i];
            }
        }
        $this->setVarByRef('modules',$modules);
        $this->setVarByRef('includes',$includes);
    }

    function saveAlias()
    {
        if($this->request('hash') == $this->hash()) {
            if((int)$this->request('alias_id')) {
                $id = (int)$this->request('alias_id');
                $model = rad_instances::get('model_core_aliases');
                $item = $model->getItem($id);
                $item->template_id = (int)$this->request('tempate_id');
                $item->alias = $this->request('alias_name');
                $item->active = ( $this->request('active') )?'1':'0';
                $item->group_id = (int)$this->request('alias_group');
                if($item->group_id) {
                    $table = new model_core_table('aliases');
                    $grp_item = $table->getItem($item->group_id);
                    $item->template_id = $grp_item->template_id;
                }
                if((int)$this->request('ali_admin')==2) {
                    $item->ali_admin = 2;
                    $item->active = 1;
                } else {
                    $item->ali_admin = ( $this->request('ali_admin') )?'1':'0';
                }
                if($this->config('cache.power')) {
                    $item->caching =  ( $this->request('ali_cached') )?1:0;
                }
                if($this->request('input_class')) {
                    if($this->request('input_class')!='0') {
                        $item->input_class = $this->request('input_class');
                    }
                } else {
                    $item->input_class = '';
                }
                $rows = $model->updateItem($item);
                if($rows) {
                    $this->clearAliasCache($item->alias);
                    echo '$(\'aliasInfoMessage\').set("html","'.str_replace('"','\\\"', $this->lang('-updated') ).'");';
                    echo 'RADIncInAlAction.refresh();';
                } else {
                    echo 'RADIncInAlAction.refresh();';
                }
                echo 'RADAliasesAction.clearTimeout();';
            } else {
                if(($this->request('tempate_id') or $this->request('alias_group')) and $this->request('alias_name') ) {
                    $model = rad_instances::get('model_core_aliases');
                    $struct= new struct_core_alias();
                    $struct->active = ($this->request('active')?1:0);
                    $struct->alias = $this->request('alias_name');
                    $struct->ali_admin = ($this->request('ali_admin')?1:0);
                    if($this->request('alias_group')) {
                        $group_ali = $model->getItem((int)$this->request('alias_group'));
                        if($group_ali->id) {
                            $struct->template_id = $group_ali->template_id;
                            $struct->group_id = $group_ali->id;
                        } else {
                            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                        }
                    } else {
                        $struct->template_id = (int)$this->request('tempate_id');
                        if((int)$this->request('ali_admin')==2) {
                            $struct->ali_admin = 2;
                            $struct->active = 1;
                        } else {
                            $struct->ali_admin = ( $this->request('ali_admin') )?1:0;
                        }
                    }
                    $rows = $model->insertItem($struct);
                    $alias_id = $model->inserted_id();
                    if($rows and $alias_id){
                        echo '$(\'aliasInfoMessage\').set("html","'.str_replace('"','\\\"', $this->lang('-added') ).'");';
                        echo 'RADAliasesAction.clearTimeout();';
                        echo 'location="'.$this->makeURL('alias='.str_replace('XML','',SITE_ALIAS).'&action=edit&id='.$alias_id).'";';
                    } else {
                        echo 'alert("'.addslashes($this->lang('norowsupdated.system.message')).'");';
                    }
                } else {
                    $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function applyIncludes()
    {
        if($this->request('hash') == $this->hash()) {
            $this->header('Content-type: text/javascript');
            $model = rad_instances::get('model_core_includes');
            $count = 0;
            if($this->request('withDel')) {
                $dels = $this->request('ch_del');
                if( count( $dels ) ) {
                    $mas = array();
                    foreach($this->request('ch_del') as $id=>$val) {
                        $idi = (int)$id;
                        $mas[] = $idi;
                        echo 'RADIncInAlAction.deleteDynamiclyRow('.$idi.');';
                        echo 'RADIncInAlAction.clearTimeout();';
                    }
                    $count += $model->deleteRows( $mas );
                } else {
                    echo 'alert("ERROR!!!! '.__LINE__.' Problem in DB");';
                }
            }
            if(count( $this->request('position_id') )) {
                $update_items = array();
                $controllers = $this->request('controller_inc_in_al');
                $orders = $this->request('order_sort');
                foreach( $this->request('position_id') as $id=>$val) {
                    $idi = (int)$id;
                    if(isset($dels[$idi])) {
                        continue;
                    }
                    $update_items[$idi] = $model->getItem($idi);
                    $update_items[$idi]->controller = $controllers[$idi];
                    $update_items[$idi]->position_id = (int)$val;
                    $update_items[$idi]->order_sort = (int)$orders[$idi];
                    $count += $model->updateItem($update_items[$idi]);
                }//foreach $this->request('position_id')
            } else {
                $this->badRequest(__LINE__);
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
            if($count) {
                $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem((int)$this->request('id')));
                echo '$(\'IncInAlInfoMessage\').set("html","'.str_replace('"','\\\"', $this->lang('-updated') ).' '.addslashes( $this->lang('-rows') ).': '.$count.'");';
                echo 'RADIncInAlAction.clearTimeout();';
                if( (strlen($this->request('returnURL'))) and ( stristr($this->request('returnURL'), SITE_URL) )) {
                    echo 'location = \''.$this->request('returnURL').'\';';
                }
            } else {
                echo '$(\'IncInAlInfoMessage\').set("html","'.str_replace('"','\\\"', $this->lang('norowsupdated.system.message') ).'");';
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function showAddWindow()
    {
        if($this->request('alias_id')){
            $this->setVar('alias_id',$this->request('alias_id'));
            $this->setVar('theme', trim($this->request('theme') ) );
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function getJS()
    {
        $this->setVar('lang',$this->getCurrentLang());
    }



    function configInclude()
    {
        $inc_id = (int)$this->request('inc_id');
        if($inc_id) {
            if($this->request('onlymain')) {
                // configinclude components
                $this->setVar('onlymain', $this->request('onlymain'));
                $this->setVar('inc_id', $inc_id);
                $table = new model_core_table('includes_params');
                $table->setState('ip_incid', $inc_id);
                $rs = $table->getItem();
                $params_real = new rad_paramsobject($rs->ip_params);
                $model = rad_instances::get('model_core_aliases');
                $item = $model->getIncludeById( $inc_id );
            } else {
                $this->setVar('inc_id',$inc_id);
                $item = rad_instances::get('model_core_includes')->getItem($inc_id);
                $this->setVar('inc_item',$item);
                $params_real = new rad_paramsobject($item->params_hash);
                $item = rad_instances::get('model_core_aliases')->getIncludeById( $item->include_id );
            }

            $params = rad_xmlparams::getParamsObject($item['m_name'], $item['inc_filename'], $this->request('themeC', $this->config('theme.default')));
            $this->setVar('items', $params);
            $this->setVar('params_orig',$params_real);
            $table = new model_core_table('includes_params');
            $table->setState('where','ip_incid='.$item['inc_id']);
            $orig_params_record = $table->getItem();
            $params_orig = new rad_paramsobject($orig_params_record->ip_params);
            $this->setVar('values', $params_orig);
            $model = rad_instances::get('model_coremenus_tree');
            $model->setState('pid','0');
            foreach($this->getAllLanguages() as $lng) {
                $model->setState('lang',$lng->lng_id);
                $tree[$lng->lng_id] = $model->getItems(true);
            }
            $this->setVar('tree', $tree);
            $model = rad_instances::get('model_corearticles_pages');
            $model->setState('active',1);
            $model->setState('select', 'pg_id, pg_title, pg_name, pg_langid');
            $this->setVar('pages', $model->getItems());
            if($this->_banner_places){
                $banner_places = array();//lng_id
                $params = $this->getParamsObject();
                foreach($this->getAllLanguages() as $lng) {
                    $model->clearState();
                    $model->setState('pid', $params->_get('treestart', $this->_banner_places, $lng->lng_id ) );
                    $banner_places[$lng->lng_id] = $model->getItems(true);
                }
                $this->setVar('banner_places',$banner_places);
            }
               $this->setVar('langs', $this->getAllLanguages() );
            $this->setVar('cur_lng_id',$this->getCurrentLangID());
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function saveConfigInclude()
    {
        if($this->request('hash') == $this->hash()) {
            $inc_id = (int)$this->request('inc_id');
            $personal = (int)$this->request('personal');
            $onlymain = (int)$this->request('onlymain');
            if ($inc_id) {
                $params = $this->request('param');
                $types = $this->request('paramtype');
                $multilang = $this->request('multilang');
    
                if(!$multilang and !count($multilang)) {
                    $multilang = array();
                }
                $paramsobject = new rad_paramsobject();
                if(count($params)) {
                    foreach($params as $paramname=>$paramvalue){
                        $multilang_prm = (isset($multilang[$paramname]))?true:false;
                        $paramsobject->_set($paramname,$paramvalue,$types[$paramname],$multilang_prm);
                    }//foreach params
                }

                if(!$onlymain) {
                    if($personal) {
                        $rows = rad_instances::get('model_core_aliases')->setParamsHash($inc_id, addslashes($paramsobject->_hash()));
                        $use_personal = (int)$this->request('useit');
                        $table_ina = new model_core_table('includes_in_aliases');
                        $ina_item = $table_ina->getItem($inc_id);
                        $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem( $ina_item->alias_id )->alias);
                        if($ina_item->params_presonal!=$use_personal) {
                            $ina_item->params_presonal = $use_personal;
                            $table_ina->updateItem($ina_item);
                        }
                    } else {
                        //add to main settings
                        $table_ina = new model_core_table('includes_in_aliases');
                        $ina_item = $table_ina->getItem($inc_id);

                        if(!$ina_item->include_id) {
                             $table_params = new model_core_table('includes_params');
                             $table_params->setState('where','ip_incid='.$inc_id);
                        } else {
                          $table_params = new model_core_table('includes_params');
                          $table_params->setState('where','ip_incid='.$ina_item->include_id);
                        }

                        $item_update = $table_params->getItem();
                        $item_update->ip_params = $paramsobject->_hash();
                        $item_update->ip_incid =  ($ina_item->include_id?$ina_item->include_id:$inc_id);
                        if($item_update->ip_id) {
                            $table_params->updateItem($item_update);
                        } else {
                            $table_params->insertItem($item_update);
                        }
                    }
                } else {
                    $table_params = new model_core_table(RAD.'includes_params');
                    $table_params->setState('where','ip_incid='.$inc_id);
                    $item_update = $table_params->getItem();
                    $item_update->ip_params = $paramsobject->_hash();
                    $item_update->ip_incid =  $inc_id;
                    if($item_update->ip_id) {
                        $table_params->updateItem($item_update);
                    } else {
                        $table_params->insertItem($item_update);
                    }
                }
                echo 'RADIncInAlAction.configCount++;';
                echo 'if(RADIncInAlAction.configCount>=2){';
                echo 'RADIncInAlAction.message("'.str_replace('"','\\\"',$this->lang('-saved')).'");';
                echo 'RADIncInAlAction.configCancelClick('.$inc_id.');';
                echo '}';
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    function getControllerJS()
    {
        $inc_id = (int)$this->request('inc_id');
        if($inc_id) {
            $model = rad_instances::get('model_core_aliases');
            $item = $model->getIncludeById( $inc_id );
            $params = rad_xmlparams::getControllerList($item['m_name'],$item['inc_filename']);
            echo 'clearSel($("controller"));';
            if($params and count($params)) {
                echo '$("controller_tr").style.display="";';
                foreach($params as $id=>$controller) {
                    echo 'addSel($("controller"),"'.$controller.'","'.$controller.'");';
                }//foreach
            } else {//if params
                echo '$("controller_tr").style.display="none";';
            }
        }
    }

    /**
     * In windows from AJAX shows edit script for titles
     *
     */
    function showEditScript()
    {
        $alias_id = (int)$this->request('alias_id');
        if($alias_id){
            $model = rad_instances::get('model_core_aliases');
            $item = $model->getItem($alias_id);
            $this->setVar('item',$item);
            $this->setVar('alias_id',$alias_id);
            /**
             * Get the aliases and includes
             */
            $alias = rad_loader::getAliasByName($item->alias);
            $helpers = array();
            foreach($alias->includes as $id_i=>$id){
                $controller = trim($id->controller);
                if( strlen($controller) ){
                    $bco = rad_breadcrumbs::getBCOFromClass($controller);
                    if($bco){
                         $helpers[$controller]['object'] = $bco;
                         $vrs = $bco->getVars();
                         if(count($vrs))
                             foreach($vrs as $id_v=>$varname){
                                 $helpers[$controller]['vars'][$varname] = str_replace("\"","\\\"", $this->lang($varname.'.'.$controller.'.breadcrumbs') );
                             }//foreach $bco->getVars()
                         $vrs = $bco->getVars(2);
                         if(count($vrs))
                             foreach($vrs as $id_v=>$varname){
                                 $helpers[$controller]['vars2'][$varname] = str_replace("\"","\\\"", $this->lang($varname.'.'.$controller.'.breadcrumbs2') );
                             }
                    }//if bco
                }//if controller
            }//foreach includes
            $this->setVar('helpers',$helpers);
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Save script for titles
     *
     */
    function saveEditScript()
    {
        if($this->request('hash') == $this->hash()) {
            $alias_id = (int)$this->request('alias_id');
            if($alias_id) {
                $model = rad_instances::get('model_core_aliases');
                $model->setState('without_joins',true);
                $item = $model->getItem($alias_id);
                $item->title_script = stripslashes( $this->request('txt_script') );
                $item->navi_script = stripslashes( $this->request('navi_script') );
                $item->metatitle_script = stripslashes( $this->request('metatitle_script') );
                $item->metadescription_script = stripslashes( $this->request('metadescription_script') );
                $rows = $model->updateItem($item);
                echo '$(\'aliasInfoMessage\').set("html","'.str_replace('"','\\\"', $this->lang('-added') ).': '.$rows.'");';
                echo 'RADAliasesAction.clearTimeout();';
                echo 'RADScriptWindow.cancelClick();';
                $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem($alias_id)->alias);
            } else {
                $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__,__LINE__,$this->getClassName());
        }
    }

    /**
     * Saves the description to the alias
     * @return JavaScript
     */
    function saveDescription()
    {
        if($this->redirect('hash') == $this->hash()) {
            $descriptiontxt = $this->request('descriptiontxt');
            $description_ids = $this->request('id_description_for');
            $alias_id = (int)$this->request('alias_id');
            if( count($descriptiontxt) and $alias_id){
                $table = new model_core_table('aliases_description');
                $rows = 0;
                foreach($descriptiontxt as $lng_id=>$description){
                    $description = trim($description);
                    if( strlen($description) ){
                        $item = new struct_core_aliases_description();
                        $item->ald_aliasid = $alias_id;
                        $item->ald_langid = $lng_id;
                        $item->ald_txt = stripslashes( $description );
                        if( isset($description_ids[$lng_id]) and ($description_ids[$lng_id]>0) ){//UPDATE
                            $item->ald_id = (int)$description_ids[$lng_id];
                            $rows += $table->updateItem($item);
                        } else {//INSERT
                            $rows += $table->insertItem($item);
                            echo '$("id_description_for_'.$lng_id.'").value="'.$table->inserted_id().'";';
                        }
                    }
                }
                echo 'RADAliDescr.message("'.str_replace('"','\\\"',$this->lang('-updated')).': '.$rows.'");';
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Displays the description window
     *
     */
    function descriptionWindow()
    {
        $alias_id = (int)$this->request('a');
        if($alias_id){
            $this->setVar('alias_id',$alias_id);
            $this->setVar('langs', $this->getAllLanguages() );
            $model = rad_instances::get('model_core_aliases');
            $model->setState('join_description',true);
            $item = $model->getItem( $alias_id );
            $this->setVar('item',$item);
            $this->setVar('currLngId', $this->getCurrentLangID() );
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    /**
     * Creates new theme
     *
     */
    function createTheme()
    {
        $theme = trim($this->request('theme'));
        $alias_id = (int)$this->request('alias_id');
        if($alias_id) {
            $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem($alias_id));
            if( strlen($theme) and (is_dir(THEMESPATH.$theme)) ){
                $table = new model_core_table('themes');
                $theme_item = new struct_core_themes();
                $theme_item->theme_aliasid = $alias_id;
                $theme_item->theme_folder = $theme;
                $table->insertItem($theme_item);
            } else {
                //default theme here
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function deleteTheme()
    {
        $theme = trim($this->request('theme'));
        $alias_id = (int)$this->request('alias_id');
        if($alias_id) {
            $this->clearAliasCache(rad_instances::get('model_core_aliases')->getItem($alias_id));
            if( strlen($theme) and (is_dir(THEMESPATH.$theme)) ) {
                $table = new model_core_table('themes');
                $table->setState('where','theme_aliasid='.$alias_id.' and theme_folder="'.$theme.'"');
                $item = $table->getItem();
                $table->deleteItem($item);
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName() );
        }
    }

    function badRequest($code='0')
    {
        die('BAD REQUEST!!! in file: '.__FILE__.' line: '.__LINE__.' code='.$code);
    }
    
    /**
     * Clear alias from cache
     * @param string $alias
     */
    function clearAliasCache($alias)
    {
        //rad_cacheutils::getInstance()->clearAlias($alias);
    }
}