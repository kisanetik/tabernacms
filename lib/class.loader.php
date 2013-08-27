<?php
/**
 * базовый класс загрузки шаблонов
 * каждый класс-загрузчик должен быть статический и унаследован от этого!
 * в любом случае он должен иметь запускную ф-ю init() без параметров и может овверрайдить другие методы
 * @author Denys Yackushev
 * @package RADCMS
 */
abstract class rad_loader
{
    /**
     * Alias from request
     *
     * @var string
     */
    protected static $alias=null;

    /**
     * Getted alias from request
     *
     * @var struct_core_alias
     */
    protected static $_alias=null;

    /**
     * Template array records
     *
     * @var mixed array()
     */
    protected static $template=null;

    /**
     * Includes that needs template
     * NOTICE: Includes already parsed with fullpath
     *
     * @var mixed Array
     */
    protected static $_includes=null;

    /**
     * Results data from the controller's
     * @var mixed array
     */
    protected static $_controllerResults=array();

    /**
     * @var rad_lang_container
     */
    public static $_langContainer = null;

    /**
     * Params from templates to the other templates
     * @var mixed array
     */
    protected static $sendedParams = array();

    /**
     * Sends some vars to some templates by name
     * @param string $template
     * @param string $key
     * @param mixed $value
     */
    public static function sendToTemplate($template,$key,$value)
    {
        //TODO обработать несуществующие имена template
        self::$sendedParams[$template][$key] = $value;
    }

    public function __construct()
    {
        throw new rad_exception('Can\'t create core class - this is only static classes!');
    }

    /**
     * Main function to init the loader
     * @access public
     */
    public static function init()
    {
        self::$alias = rad_input::request('alias');
        if(!self::$alias) {
            self::$alias = rad_config::getParam('defaultAlias');
            self::$template = rad_config::getParam('defaultTemplate');
        }
        self::$_alias = self::getAliasByName(self::$alias);
        if (is_null(self::$_alias)) {
            throw new rad_exception('Aliases not found! Even the default aliases and alias for the 404 error! Insert those aliases into database please and try again!');
        }
        if (strlen(self::$_alias->input_class)) {
            rad_input::reparseGetWithPlug(self::$_alias->input_class);
        }
        self::parseIncludes(self::$_alias->includes);
        self::$_langContainer = new rad_lang_container();
        self::parseController();
        if(! rad_breadcrumbs::initandmake(self::$_alias->title_script, self::$_alias->navi_script, self::$_alias->metatitle_script, self::$_alias->metadescription_script) ) {
            rad_dblogger::logerr('Can\'t create and init breadcrumbs! file: '.__FILE__.' and line: '.__LINE__);
        }
    }

    /**
     * If exemplar of lang_container not exists, set it!
     * @access public
     */
    public static function checkLangContainer()
    {
        if(!self::$_langContainer)
            self::$_langContainer = new rad_lang_container();
    }

    /**
     * Returns lang container;
     * @return rad_lang_container
     */
    public static function getLangContainer()
    {
        return self::$_langContainer;
    }

    /**
     * Sets the lang container class from different class
     * @param $lc
     * @return unknown_type
     */
    public static function setLangContainer($lc)
    {
        self::$_langContainer = $lc;
    }

    /**
     * Returns current active theme
     * @obsolete Use rad_themer::getCurrentTheme()
     * @deprecated
     * @return string
     */
    public static function getCurrentTheme()
    {
        return rad_themer::getCurrentTheme();;
    }

    /**
     * Gets the clone of the current alias
     * @return struct_core_alias
     */
    public static function getCurrentAlias()
    {
        return clone self::$_alias;
    }

    public static function setIncludes($includes)
    {
        if(count($includes))
            self::$_includes=$includes;
    }

    public static function getIncludes()
    {
        return self::$_includes;
    }

    public static function addInclude($key,$file)
    {
        if((!empty($key)) and (!empty($file)) and (file_exists($file))){
            self::$_includes[$key]=$file;
            return true;
        }else{
            return false;
        }
    }

    public static function unsetInclude($key)
    {
        if(isset(self::$_includes[$key]))
            unset(self::$_includes[$key]);
    }

    /**
     * Get alias record
     * @return struct_core_alias
     */
    protected static function getAliasRecord(&$alias)
    {
        return new struct_core_alias(rad_dbpdo::query('select a.id,a.alias,a.template_id,a.active,t.filename,a.input_class,
                                      a.title_script,a.navi_script,a.metatitle_script,a.metadescription_script,
                                      th.theme_id as themeid,th.theme_folder as themefolder, a.ali_admin as ali_admin,
                                      a.caching as caching, a.group_id as group_id '
                                    .'from '.RAD.'aliases a '
                                    .'inner join '.RAD.'templates t on a.template_id=t.id '
                                    .'left join '.RAD.'themes th on th.theme_aliasid=a.id and th.theme_folder=? '
                                    .'where a.`alias`=? limit 1'
                                    , array(rad_themer::getCurrentTheme(), $alias)));
    }

    /**
     * Get's alias by name
     *
     * @param string $aliasname
     * @var struct_core_alias
     */
    //TODO Create the reserved aliases! not in DB, for adminmenu - just in php file the same structure and check it here!
    public static function getAliasByName(&$aliasname='')
    {
        $result = self::getAliasRecord($aliasname);
        if (!$result->id || !$result->active) {
            rad_session::setVar('message',$aliasname);
            $aliasname = rad_config::getParam('alias.404');
            $result = self::getAliasRecord(self::$alias);
            header(rad_config::getParam('header.404'));
        }
        if ($result->ali_admin && !rad_session::adminAccess()) {
            rad_session::setVar('message',$aliasname);
            rad_session::logout();
            $aliasname = rad_config::getParam('alias.loginform');
            $result = self::getAliasRecord(self::$alias);
        }
        if ($result->id) {
            $result->includes = array();
            $themeId = ($result->themeid)?$result->themeid:0;
            $sqlParams = array('alias_1_id'=>$result->id,'theme_1_id'=>$themeId);
            if($result->group_id) {
                $sqlParams['alias_2_id'] = $result->group_id;
                $theme2Id = rad_dbpdo::query('SELECT theme_id FROM '.RAD.'themes WHERE theme_aliasid=? AND theme_folder=?', array($result->group_id, rad_themer::getCurrentTheme()));
                $theme2Id = (!empty($theme2Id['theme_id']))?(int)$theme2Id['theme_id']:$themeId;
                $sqlParams['theme_2_id'] = $theme2Id;
            }
            $sql = 'SELECT inc_id,inc_name,inc_filename,controller,order_sort,rp_name,id_module,m_name,params_hash,ina.id as incinal_id,ina.params_presonal as params_presonal, ip.ip_params as original_params '
                                    .'FROM '.RAD.'includes_in_aliases ina '
                                    .'INNER JOIN '.RAD.'includes on include_id=inc_id '
                                    .'INNER JOIN '.RAD.'modules m on m.m_id=id_module '
                                    .'INNER JOIN '.RAD.'positions p on position_id=p.rp_id '
                                    .'LEFT JOIN '.RAD.'includes_params ip on ip.ip_incid=ina.include_id '
                                    .'WHERE alias_id=:alias_1_id'
                                    .' AND ina.theme_id=:theme_1_id'
                                    .($result->group_id?' UNION (SELECT inc_id,inc_name,inc_filename,controller,order_sort,rp_name,id_module,m_name,params_hash,ina.id as incinal_id,ina.params_presonal as params_presonal, ip.ip_params as original_params '
                                    .'FROM '.RAD.'includes_in_aliases ina '
                                    .'INNER JOIN '.RAD.'includes on include_id=inc_id '
                                    .'INNER JOIN '.RAD.'modules m on m.m_id=id_module '
                                    .'INNER JOIN '.RAD.'positions p on position_id=p.rp_id '
                                    .'LEFT JOIN '.RAD.'includes_params ip on ip.ip_incid=ina.include_id '
                                    .'WHERE alias_id=:alias_2_id'
                                    .' AND ina.theme_id=:theme_2_id'
                                    .')':'')
                                    .' ORDER BY order_sort, rp_name';
            foreach (rad_dbpdo::queryAll($sql, $sqlParams) as $id) {
                $result->includes[]=new struct_core_include($id);
            }
        } else {
            $result = NULL;
        }
        return $result;
    }

    protected static function parseIncludes(&$includes)
    {
        self::$_includes = array();
        foreach($includes as $id) {
            self::$_includes[$id->inc_name] = rad_themer::getFilePath(null, 'templates', $id->m_name, $id->inc_filename);
        }
    }

    public static function show()
    {

    }

    /**
     * Parse al functions!
     */
    public static function parseController()
    {
        header(base64_decode('WC1wb3dlcmVkLWJ5OiBUYWJlcm5hIGVDb21tZXJjZSBDTVM='));
        header(base64_decode('WC1wb3dlcmVkLXZlcnNpb246IA==').json_encode(rad_update::getInstance()->getVersions()));
        header(base64_decode('WC1wb3dlcmVkLXNpdGU6IGh0dHA6Ly90YWJlcm5hY21zLmNvbQ=='));
        ob_start();
        foreach(self::$_alias->includes as $id) {
            if(strlen($id->controller)) {
                rad_instances::setCurrentController($id->controller);
                if( ($id->params_presonal) and strlen($id->params_hash) ) {
                    rad_instances::setParamsFor($id->controller, new rad_paramsobject($id->params_hash) );
                } elseif( (!$id->params_presonal) and strlen($id->original_params) ) {
                    rad_instances::setParamsFor($id->controller, new rad_paramsobject($id->original_params) );
                }
                self::$_controllerResults[$id->incinal_id] = new $id->controller();
            } else {
                self::$_controllerResults[$id->incinal_id] = null;
            }
        }
        ob_end_flush();
    }

    /**
     * Gets the Template path by it controller name in current alias
     * @param $controller
     */
    public static function getTemplatePathByController($controller)
    {
         if(count(self::$_alias->includes)) {
            foreach(self::$_alias->includes as $id) {
                if($controller==$id->controller) {
                    return dirname( self::$_includes[$id->inc_name] );
                }
            }
         }
        return null;
    }

    /**
     * Parse breadcrumbs string and assign it to use it in the template
     */
    public static function parseBreadCrumbs()
    {
        /*
        self::$_alias->title_script
        self::$_alias->navi_script
        self::$_alias->metatitle_script
        self::$_alias->metadescription_script
         */
    }

    /**
     * Returns array with all input data
     * @return mixed array
     */
    public static function getFlushData()
    {
        $res['alias'] = self::$alias;
        $res['template'] = self::$template;
        $res['_includes'] = self::$_includes;
        return $res;
    }

    /**
     * Returns the aliases with input_class name array
     * @return mixed array
     */
    public static function getAliasInputClasses()
    {
        $result = array();
        $res = rad_dbpdo::queryAll('SELECT alias,input_class from '.RAD.'aliases where input_class!=\'\';');
        foreach($res as $id) {
            $result[$id['alias']] = $id['input_class'];
        }
        return $result;
    }
}