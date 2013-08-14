<?php
/**
 * System class for managing repository and install\deinstall components
 * @package RADCMS
 * @author Denys Yackushev
 */
class controller_core_repository extends rad_controller
{
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
            $this->setVar('params', $params);
        }
        $this->setVar('hash', $this->hash());
        if($this->request('action')) {
            $this->addBC('action',  $this->request('action'));
            $this->setVar('action', $this->request('action'));
            switch($this->request('action')) {
                case 'install':
                    break;
                case 'network':
                    break;
                case 'getjs':
                    $this->setVar('main_action', $this->request('ma'));
                    $this->setVar('current_lang', $this->getCurrentLang());
                    break;
                case 'getnodes':
                    if($this->request('ma')=='install') {
                        $this->getLocalNodes();
                    } elseif($this->request('ma')=='network') {
                        $this->getNetworkNodes();
                    } else {
                        $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                    }
                    break;
                case 'getinc'://GETS the include
                    $this->getIncludeInfo();
                    break;
                case 'getmod'://Gets the module
                    $this->setVar('subaction', 'getmod');
                    if( (int)$this->request('i') ) {
                        $table = new model_core_table('modules');
                        $this->setVar('item', $table->getItem( (int)$this->request('i') ) );
                    } else {
                        $this->setVar('i', $this->request('i'));
                    }
                    break;
                case 'getxmlparamsstring':
                    $this->getXMLParamsString();
                    break;
                case 'getParamsSettings':
                    $this->getParamsSettings();
                    break;
                case 'savexmlparamsstring':
                    $this->saveXMLParamsString();
                    break;
                case 'getfullxmlparams':
                    $this->getFullXMLParamsString();
                    break;
                case 'savefullxmlparams':
                    $this->saveFullXMLParamsString();
                    break;
                case 'installXML':
                    $this->installXML();
                    break;
                case 'saveinclude':
                    echo $this->saveInclude();
                    break;
                case 'getfile':
                    $this->setVar('params','');
                    $system = new stdClass();
                    $system->module = new stdClass();
                    $system->module->folder = $this->request('folder');
                    $system->module->filename = $this->request('fn');
                    $this->setVar('system', $system);
                    $names = new stdClass();
                    $names->url = 'http://';
                    $this->setVar('names', $names);
                    break;
                case 'validateXML':
                    $this->validateXML();
                    break;
                case 'deleteComponent':
                    $this->deleteComponent();
                    break;
                default:
                    $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
                break;
            }
        }
    }

    /**
    * plant component of XML-file
    */
    function validateXML() 
    {
        if ($this->request('folder') and $this->request('fn')) {
            $model_params = rad_instances::get('model_core_params');
            $rs['success'] = $model_params->checkXmlFile($this->request('folder'), $this->request('fn'));
            echo json_encode($rs);
        }
    }

    function installXML()
    {
        if ($this->request('folder') and $this->request('filename')) {
            $model_params = rad_instances::get('model_core_params');
            if ($model_params->checkXmlFile($this->request('folder'), $this->request('filename'))) {
                $xmlstring = $model_params->getXmlFile($this->request('folder'), $this->request('filename'), false);
                $xmlObj = simplexml_load_string($xmlstring);

                $names = $xmlObj->xpath('/metadata/names');
                $this->setVar('names', $names[0]);

                $system = $xmlObj->xpath('/metadata/system');
                $this->setVar('system',$system[0]);

                $params_xml = $xmlObj->xpath('/metadata/params');
                $paramsstring = $params_xml[0]->asXML();
                //$paramsstring = substr($paramsstring, 8, strlen($paramsstring)-7);
                //$paramsstring = substr($paramsstring, 0, strlen($paramsstring)-9);
                $paramsstring = substr($paramsstring, 8, -8);

                $params = array();
                $params['names.title'] = $names[0]->title;
                $params['names.description'] = $names[0]->description;
                $params['names.author'] = $names[0]->author;
                $params['names.url'] = $names[0]->url;
                $params['system.ver'] = $system[0]->ver;
                $params['system.prelogic'] = $system[0]->prelogic;
                $params['system.themes'] = '';
                $params['system.module.name'] = $system[0]->module->name;
                $params['system.module.folder'] = $system[0]->module->folder;
                $params['system.module.ver'] = $system[0]->module->ver;
                $params['system.name'] = 'rad_sloader';//TODO - realize that
                $params['loader_class'] = 'rad_sloader';
                $params['system.access'] = $system[0]->access;
                $params['params'] = $paramsstring;

                if(!$model_params->createParamsForTemplate($params, $this->request('folder'), $this->request('filename')) ) {
                    echo json_encode(array('permission_error'=>true));
                    return false;
                }
                $model_params->installTemplate($this->request('folder'), $this->request('filename'));
                $i = $model_params->inserted_id();
                if($i) {
                    $obj = $model_params->getItem($i);
                    $par['PID'] = $obj['id_module'];
                    $par['i'] = $i;
                    echo json_encode($par);
                    return;
                }
            }
        }
        return false;
    }

    function getParamsSettings()
    {
        if( (int)$this->request('i') ) {
            $model_params = rad_instances::get('model_core_params');
            $model_aliases = rad_instances::get('model_core_aliases');
            $include = $model_aliases->getIncludeById( (int)$this->request('i') );
            $xmlstring = $model_params->getXmlFile( $include['m_name'], $include['inc_filename'], false);
            $xmlObj = simplexml_load_string( $xmlstring );

            $param = array();
            if($xmlObj){
                foreach($xmlObj->params->param as $v) {
                    $param[] = $v;
                }
            }
            if(is_array($param) and count($param) > 0) {
                $ok['success'] = true;
            } else {
                $ok['success'] = false;
            }
            echo json_encode($ok);

        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function deleteComponent()
    {
        if($this->request('hash') == $this->hash()) {
            if((int)$this->request('i')) {
                $model_params = rad_instances::get('model_core_params');
                $delete = $model_params->deleteComponent($this->request('i'));
                $par = array();
                $par['i'] = (int)$this->request('i');
                $par['success'] = $this->lang('-deleted');
                echo json_encode($par);
            } else {
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function saveInclude()
    {
        if ($this->request('hash') == $this->hash()) {
            $model_params = rad_instances::get('model_core_params');
            $model_aliases = rad_instances::get('model_core_aliases');
            $paramsstring = '';
            if ($id = (int)$this->request('i')) {
                $include = $model_aliases->getIncludeById($id);
                if ($model_params->checkXmlFile($include['m_name'], $include['inc_filename'])) {
                    $xmlstring = $model_params->getXmlFile($include['m_name'], $include['inc_filename'], false);
                    $xmlObj = simplexml_load_string($xmlstring);
                    $params_xml = $xmlObj->xpath('/metadata/params');
                    $paramsstring = $params_xml[0]->asXML();
                    //$paramsstring = substr($paramsstring, 8, strlen($paramsstring)-7);
                    //$paramsstring = substr($paramsstring, 0, strlen($paramsstring)-9);
                    $paramsstring = substr($paramsstring, 8, -8);
                }
            } elseif($this->request('filename') and $this->request('folder')) {
                $include['m_name'] = $this->request('folder');
                $include['inc_filename'] = $this->request('filename');
            }
            $params = array();
            $params['names.title'] = $this->request('inc_name','');
            $params['names.description'] = $this->request('names_description','');
            $params['names.author'] = $this->request('names_author','');
            $params['names.url'] = $this->request('names_url','');
            $params['system.ver'] = $this->request('system_ver','');
            $params['system.prelogic'] = $this->request('system_prelogic','');
            $params['system.themes'] = '';
            $params['system.module.name'] = $this->request('system_module_name');
            $params['system.module.folder'] = $this->request('system_module_folder');
            $params['system.module.ver'] = $this->request('system_module_ver');
            $params['system.name'] = 'rad_sloader';//TODO - realize that
            $params['loader_class'] = 'rad_sloader';
            $params['system.access'] = '1000';
            $params['params'] = $paramsstring;

            if(!$model_params->createParamsForTemplate($params, $include['m_name'], $include['inc_filename']) ) {
                echo json_encode(array('permission_error'=>true));
                return false;
            }

            if(!$this->request('method') and $this->request('method') !== 'save') {
                if($this->request('filename') and $this->request('folder')){
                    $model_params->installTemplate($include['m_name'], $include['inc_filename']);
                    $i = $model_params->inserted_id();
                    if($i) {
                        $obj = $model_params->getItem($i);
                        $par['PID'] = $obj['id_module'];
                        $par['i'] = $i;
                    }
                }else{
                    $model_params->updateTitle($include['inc_id'], $params['names.title']);
                }
                return json_encode($par);
            } else {
                if($this->request('filename') and $this->request('folder')){
                    $model_params->installTemplate($include['m_name'], $include['inc_filename']);
                    die($model_params->inserted_id());
                }else{
                    $model_params->updateTitle($include['inc_id'], $params['names.title']);
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function saveXMLParamsString()
    {
        if($this->request('hash') == $this->hash()) {
            if( (int)$this->request('i') AND $this->request('xmlstring') ) {
                $model_params = rad_instances::get('model_core_params');
                $model_aliases = rad_instances::get('model_core_aliases');
                $include = $model_aliases->getIncludeById( (int)$this->request('i') );
                $this->setVar('include', $include);
                $params = stripslashes($this->request('xmlstring'));
                if( !$model_params->setParamsForTemplate($params, $include['m_name'], $include['inc_filename']) ) {
                    echo json_encode(array('permission_error'=>true));
                    return false;
                }
                /**
                $table_params = new model_core_table('includes_params');
                $table_params->setState('where','ip_incid='.$this->request('i'));
                */
            }else{
                $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    function getXMLParamsString()
    {
        if ($id = (int)$this->request('i')) {
            $model_params = rad_instances::get('model_core_params');
            $model_aliases = rad_instances::get('model_core_aliases');
            $include = $model_aliases->getIncludeById($id);
            $this->setVar('include', $include);
            $xmlstring = $model_params->getXmlFile($include['m_name'], $include['inc_filename'], false);
            $xmlObj = simplexml_load_string($xmlstring);
            $params = $xmlObj->xpath('/metadata/params');
            $paramsstring = $params[0]->asXML();
            //$paramsstring = substr( $paramsstring, 8, strlen($paramsstring)-7);
            //$paramsstring = substr( $paramsstring, 0, strlen($paramsstring)-9);
            $paramsstring = substr($paramsstring, 8, -8);
            $this->setVar('params', $paramsstring );
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }
    
    function saveFullXMLParamsString()
    {
        if($this->request('hash') == $this->hash()) {
            if((int)$this->request('i')) {
                $model_aliases = rad_instances::get('model_core_aliases');
                $include = $model_aliases->getIncludeById( (int)$this->request('i') );
                $model_params = rad_instances::get('model_core_params');
                if(!$model_params->setXMLStringForTemplate( stripslashes($this->request('xmlstring')), $include['m_name'], $include['inc_filename'] ) ) {
                    echo json_encode(array('permission_error'=>true));
                    return false;
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }
    
    function getFullXMLParamsString() 
    {
        if ($id = (int)$this->request('i')) {
            $model_aliases = rad_instances::get('model_core_aliases');
            $include = $model_aliases->getIncludeById($id);
            $this->setVar('include', $include);
            $model_params = rad_instances::get('model_core_params');
            $xmlstring = $model_params->getXmlFile($include['m_name'], $include['inc_filename'], false);
            $this->setVar('xmlstring' ,$xmlstring);
        }
    }
    
    function getIncludeInfo()
    {
        if ($id = (int)$this->request('i')) {
            $model_params = rad_instances::get('model_core_params');
            $model_aliases = rad_instances::get('model_core_aliases');
            $include = $model_aliases->getIncludeById($id);
            $this->setVar('include',$include);
            $xmlstring = $model_params->getXmlFile($include['m_name'], $include['inc_filename'], false);

            $xmlObj = simplexml_load_string( $xmlstring );
            if($xmlObj){
                $names = $xmlObj->xpath('/metadata/names');
                $this->setVar( 'names', $names[0] );
                $system = $xmlObj->xpath('/metadata/system');
                $this->setVar('system',$system[0]);
                $params = $xmlObj->xpath('/metadata/params');
                if(count($params)) {
                    $paramsstring = $params[0]->asXML();
                    //$paramsstring = substr( $paramsstring, 8, strlen($paramsstring)-7);
                    //$paramsstring = substr( $paramsstring, 0, strlen($paramsstring)-9);
                    $paramsstring = substr($paramsstring, 8, -8);
                    $this->setVar('params', $paramsstring);
                } else {
                    $this->setVar('params', '');
                }
            }
        } else {
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Returns the local groups\components for installation\remoove the components
     * Also gets the calculated error components
     */
    function getLocalNodes()
    {
        $local_nodes = array();
        if((int)$this->request('pid')) {
            $modules = rad_instances::get('model_core_aliases')->getIncludes(false,(int)$this->request('pid'));
            if(count($modules))
            foreach($modules as $id){
                $local_nodes[] = array( 'id'=>$id['inc_id'], 'text'=>$id['inc_filename'].' ('.$id['inc_name'].')', 'islast'=>'1' );
            }
        } elseif($this->request('pid')) {
            switch($this->request('pid')) {
                case 'reindex'://find
                    $local_nodes[] = array( 'id'=>'nem', 'text'=>'Ошибочные каталоги', 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid=nem') );//$not_exists_modules
                    $local_nodes[] = array( 'id'=>'nim', 'text'=>'Не существующие каталоги', 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid=nim') );//$not_inserted_modules
                    $local_nodes[] = array( 'id'=>'rd', 'text'=>'Не опознанные шаблоны/компоненты', 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid=rd') );//$real_diff
                    $local_nodes[] = array( 'id'=>'idf', 'text'=>'Не найденные файлы', 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid=idf') );//$includes_diff
                    break;
                case 'nim'://not exist folders
                    $res = $this->getIncludesDiff();
                    break;
                case 'rd':
                    $res = $this->getIncludesDiff();
                    if(!empty($res['real_diff']))
                    foreach($res['real_diff'] as $ln_folder=>$ln_id)
                    foreach($ln_id as $ln_id1=>$ln_fn)
                    $local_nodes[] = array('id'=>'rd'.($ln_id1+1), 'text'=>$ln_folder.'/'.$ln_fn, 'islast'=>'1', 'data'=>'folder="'.$ln_folder.'" file="'.$ln_fn.'"' );
                    break;
            }//switch
        } else {
            $modules = rad_instances::get('model_core_aliases')->getModules();
            foreach($modules as $m_id) {
                $local_nodes[] = array('id'=>$m_id['m_id'], 'text'=>$m_id['m_name'], 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid='.$m_id['m_id']) );
            }
            $local_nodes[] = array('id'=>'reindex', 'text'=>$this->lang('-find'), 'islast'=>'0', 'url'=>$this->makeURL('action=getnodes&ma=install&pid=reindex') );
        }
        $this->setVar('items', $local_nodes);
        $this->header('Content-Type: application/xml');
    }

    /**
     * Gets the components from the server that can be installed
     */
    function getNetworkNodes()
    {

    }

    /**
     * Start search the difference betwen files and DB and new components
     * @return mixed array
     * @access private
     */
    private function getIncludesDiff()
    {
        $model = rad_instances::get('model_core_aliases');
        $res = $model->getIncludes(true);
        $this->setVar('includes',$res);
        //собираем файлы и папки содержащиеся в базе
        $includes = array();
        foreach($res as $id) {
            $includes[$id['m_name']][] = $id['inc_filename'];
        }
        //собираем физически расположенные папки и файлы
        $real = array();
        $d = dir(COMPONENTSPATH);
        while( false !== ( $moduleName = $d->read() ) ){
            if( ($moduleName!='.') and ($moduleName!='..') and ($moduleName!='set') and ($moduleName!='.svn') and ( is_dir(COMPONENTSPATH.$moduleName) ) ) {
                $real[$moduleName] = array();
            }
        }//while       
        foreach($real as $dir=>$mas) {
            $d = dir(COMPONENTSPATH.$dir.DS.'templates');
            while( false !== ( $fn = $d->read() ) ) {
                if( is_file(COMPONENTSPATH.$dir.DS.'templates'.DS.$fn) ) {
                    $real[$dir][] = $fn;
                }
            }
        }
        /**
         * Правила таковы:
         * с модулями: если найденны новые папки на диске - тогда выдавать просто сообщение о том что найдены папки новые в ненадлежащем каталоге, поскольку система не прописала в rad_modules эти папки и значчит их сделал юзер и не должны быть там!
         * если не найденны модули которые должны быть на диске - выдавать что не найденны папки с шаблонами !!!!!
         *
         */
        //массив содержит модули (папки) которых нет еще в базе
        $result['not_exists_modules']     = array_diff(array_keys($real), array_keys($includes));
        //массив содержит модули в базе, которых нет фактически
        $result['not_inserted_modules']   = array_diff(array_keys($includes), array_keys($real));
        //массив инвалидных модулей
        $result['error_modules']          = array_merge($result['not_exists_modules'], $result['not_inserted_modules']);
        //массив файлов фактический без инвалидных модулей
        $result['real_ex']                = $real;
        foreach($result['error_modules'] as $module) unset($result['real_ex']['module']);
        //массив файлов в базе без инвалидных модулей
        $result['includes_ex']            = $includes;
        foreach($result['error_modules'] as $module) unset($result['includes_ex']['module']);
//die(print_r(array($real, $includes), true));
        //проверяем новые файлы, которых нет в базе
        $real_diff = array();
        foreach($real as $module=>$id) {
            foreach($id as $ids=>$filename) {
                if(!isset($includes[$module]) or !in_array($filename,$includes[$module])) {
                    $real_diff[$module][] = $filename;
                }
            }
        }
        $result['real_diff'] = $real_diff;

        //проверяем несуществующие на диске файлы
        $includes_diff = array();
        foreach($includes as $module=>$id) {
            foreach($id as $ids=>$filename) {
                if(!isset($real[$module]) or !in_array($filename,$real[$module])) {
                    $includes_diff[$module][] = $filename;
                }
            }//foreach $filename
        }//foreach $module
        $result['includes_diff'] = $includes_diff;
        return $result;
    }
}