<?php
/**
 * System params module
 * @package RADCMS
 * @author Denys Yackushev
 */
final class model_core_params extends rad_model
{
    function __construct()
    {

    }

    /**
     * Parse params from filename to array
     *
     * @param string $fn
     *
     * @return array() mixed
     */
    function parseParams($fn)
    {

    }

    /**
     * Check the XML file, if exists!
     * @param string $module
     * @param string $fn
     * @return boolean
     */
    function checkXmlFile($module,$fn)
    {
        return (boolean)is_file($this->_getFN($module, $fn));
    }

    /**
     * Gets the XML-file name for module and component
     * @param string $module
     * @param string $fn
     * @return string - Full file name
     */
    private function _getFN($module, $fn)
    {
        $tail = $module.DS.'set'.DS.$fn.'.xml';
        if (defined('THEMESPATH') and file_exists($file = THEMESPATH.rad_loader::getCurrentTheme().DS.$tail)) {
            return $file;
        } elseif (defined('COMPONENTSPATH') and file_exists($file = COMPONENTSPATH.$tail)) {
            return $file;
        }
        return null;
    }

    /**
     * Gets params-file srting
     * @param string $module
     * @param string $fn
     * @return string|NULL
     */
    function getXmlFile($module,$fn)
    {
        $file = $this->_getFN($module, $fn);
        if(file_exists($file)) {
            $string = file_get_contents($file);
            return stripslashes($string);
        } else {
            return null;
        }
    }

    /**
     * Set the params xml-string for the file
     *
     * @param string $params - array of fieldnames and fieldvalues
     * @param string $module - module name
     * @param string $fn
     * @return boolean
     */
    function setParamsForTemplate($params,$module,$fn)
    {
        $file = $this->_getFN($module, $fn);
        if($file) {
            $xmlstring = $this->getXmlFile($module, $fn);
            $xmlObj = simplexml_load_string( $xmlstring );
            $xmlObj->params = '%%params%%';
            $xmlObj = simplexml_load_string( str_replace('%%params%%', $params, $xmlObj->asXML()) );
            if( is_writable($file) ) {
                return safe_put_contents($file, $xmlObj->asXML() );
            } else {
                return false;
            }
        }else{
            $this->securityHoleAlert(__FILE__, __LINE__, $this->getClassName());
        }
    }

    /**
     * Owerride or set the XML string for the file
     * @param string $xmlstring
     * @param string $module
     * @param string $fn
     * @return boolean
     */
    function setXMLStringForTemplate($xmlstring, $module, $fn)
    {
        $file = $this->_getFN($module, $fn);
        if( $file and is_writable($file) ) {
            return !safe_put_contents($file, $xmlstring );
        } else {
            return false;
        }
    }

    /**
     * Create the xml file from array
     * Сдесь xml файл генерируется без помощи библиотек для лучшей совместимости.
     *
     * @param array $params - array of fieldnames and fieldvalues
     * @param string $module - module name
     * @return boolean
     */
    function createParamsForTemplate($params, $module, $fn)
    {
        $file = $this->_getFN($module, $fn);
        if(!is_dir(dirname($file))) {
            if(!recursive_mkdir(dirname($file))) {
                return false;
            }
        }
        if(!is_writable(dirname($file))) {
            return false;
        }
        if(file_exists($file) and !is_writable($file)) {
            return false;
        }
        //CREATE THE DEFAULT STRUCTURE
        $s = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<metadata>'
                .'<names>'
                    .'<title>'.$this->_getLangValue($params['names.title']).'</title>'
                    .'<description>'.$this->_getLangValue($params['names.description']).'</description>'
                    .'<author>'.$this->_getLangValue($params['names.author']).'</author>'
                    .'<date>'.time().'</date>'
                    .'<url>'.$this->_getLangValue($params['names.url']).'</url>'
                .'</names>'
                .'<system>'
                    .'<ver>'.stripslashes($params['system.ver']).'</ver>'
                    .'<prelogic>'.$this->_getItems( $params['system.prelogic'] ).'</prelogic>'
                    .'<themes>'.$this->_getItems( $params['system.themes'] ).'</themes>'
                    .'<module>'
                        .'<name>'.$this->_getLangValue($params['system.module.name']).'</name>'
                        .'<folder>'.stripslashes($params['system.module.folder']).'</folder>'
                        .'<ver>'.stripslashes($params['system.module.ver']).'</ver>'
                        .'<ident>'.$this->genereModuleIdent().'</ident>'//идентификатор модуля с которым идет в поставке шаблон
                    .'</module>'
                    .'<name>'.stripslashes($params['system.name']).'</name>'
                    .'<ident>'.$this->genereTmplIdent($params['system.name'],$params['system.module.folder'],rad_config::getParam('loader_class')).'</ident>'
                    .'<template>'
                        .'<lower>'.(!empty($params['system.ver'])?$params['system.ver']:'0.1').'</lower>'
                        .'<name>'.rad_config::getParam('loader_class').'</name>'
                    .'</template>'
                    .'<access>'.stripslashes($params['system.access']).'</access>'
                 .'</system>'
                 .'<params>'//тут параметры непосредственно самого модуля
                 .$this->_getLangValue($params['params'])
                 .'</params>'
             .'</metadata>';
        return safe_put_contents($file, $s );
    }

    /**
     * Gets the params items for XML file from params array
     * @param mixed $array
     * @return string
     */
    private function _getItems($array)
    {
        $s = '';
        if( is_array( $array ) ) {
            foreach( $array as $id=>$value ) {
                   $value = trim($value);
                if(strlen($value)) {
                    $s.='<item>'.stripslashes($value).'</item>';
                }
            }//foreach
        } elseif(is_object($array) && isset($array->item)) {
            foreach($array->item as $value) {
                $value = trim($value);
                if(strlen($value)) {
                    $s.='<item>'.stripslashes($value).'</item>';
                }
            }
        } else {//if is_array
            if(strstr($array,':')) {
                $mas = explode(':',$array);
                foreach( $mas as $id=>$value ) {
                    $value = trim($value);
                    if(strlen($value)) {
                        $s.='<item>'.stripslashes($value).'</item>';
                    }
                }//foreach
            } else {
                $array = trim($array);
                if(strlen($array)) {
                    $s = '<item>'.stripslashes($array).'</item>';
                }
            }
        }
        return $s;
    }

    /**
     * Make the string for xml-file with lang support
     * @param string | mixed $value
     * @example array('ru'=>'значение', 'en'=>value, 'ua'=>'значення')
     * r@return string
     */
    private function _getLangValue($value)
    {
        $str = '';
        if(is_array($value)) {
            foreach($value as $lng=>$value) {
                $str .= '<'.$lng.'>'.stripslashes($value).'</'.$lng.'>';
            }//foreach
        } else {//if langs
            $str = stripslashes($value);
        }
        return $str;
    }

    public function genereModuleIdent()
    {

    }

    /**
     * Generes the template identificator
     *
     * @param string $tmplname - Name of the template
     * @param string $tmplmodule - Module name
     * @param string $templateclass - class of the template machine (rad_config::getParam('loader_class'))
     *
     * @return string
     */
    public function genereTmplIdent($tmplname,$tmplmodule,$templateclass)
    {
        return md5($tmplname.$tmplmodule.$templateclass);
        /**
         * Существует для ищентификации измененных шаблонов, езакачки и обновления их с главного сервера
         * При обновлении шаблонов с репозитория должна существовать таблица измененных шаблонов для сравнения перед закачкой
         * если шаблон изменился - тогда надо сообщить пользователю что этот шаблон был им изменен и подлежит устранению конфликтов!
         */
    }

    /**
     * Remove (delete) xml file for component
     * @param string $module
     * @param string $fn
     * @return boolean
     */
    public function rmXmlFileFor($module, $fn)
    {
        $file = $this->_getFN($module, $fn);
        if( is_file($file) ) {
            return unlink($file);
        }
    }

    /**
     * Install the template by it XML file
     * @param string $module
     * @param string $fn
     */
    public function installTemplate($module, $fn)
    {
        if( $this->checkXmlFile($module,$fn) ) {
            $file = $this->_getFN($module, $fn);
            $xmlstring = file_get_contents($file);
            $xml = simplexml_load_string($xmlstring);
            $max_pos = $this->query('SELECT (max(inc_position)+1) as new_id FROM '.RAD.'includes');
            $module_id = $this->query('SELECT m_id from '.RAD.'modules where m_name=?', array($module));
            if(empty($module_id['m_id'])) {
                $this->query('INSERT INTO '.RAD.'modules SET m_name=?', array($module));
                $module_id = $this->inserted_id();
                if(!$module_id) {
                    die('ERROR: '.__FILE__.' line: '.__LINE__);
                }
            } else {
                $module_id = (int)$module_id['m_id'];
            }
            //DO NOT USE select max(position)in sql! use query as $max_pos = $this->query('SELECT (max(inc_position)+1) as new_id FROM '.RAD.'includes');
            return $this->query('INSERT INTO '.RAD.'includes(`inc_name`,`inc_filename`,`inc_position`,`id_module`) VALUES ('
            .'?'
            .',?'
            .',?'
            .',?'
            .')', array($xml->names->title, $fn, $max_pos['new_id'], $module_id));
        } else {
            die('ERROR: '.__FILE__.' line: '.__LINE__);
        }
    }

    /**
     * Deletes fully the component by it ID
     * @param integer $id
     */
    public function deleteComponent($id)
    {
        if($id) {
            $inc_id = $this->query('SELECT inc.inc_id as id, inc.inc_filename as f_name, m.m_name as name, par.ip_id as par_id FROM '.RAD.'includes as inc
                                        LEFT JOIN '.RAD.'modules as m ON m.m_id = inc.id_module
                                        LEFT JOIN '.RAD.'includes_params as par ON par.ip_incid = inc.inc_id
                                            WHERE inc.inc_id=?', array($id));
            if(is_array($inc_id)) {
                $fn = $inc_id['f_name'].'.xml';
                $module = $inc_id['name'];
                $file = $this->_getFN($module, $fn);
                if( is_file($file) ) {
                    unlink($file);
                }

                if($inc_id['par_id']) {
                    $this->query('DELETE FROM '.RAD.'includes_params WHERE ip_id=?', array($inc_id['par_id']));
                }

                if($inc_in_alies = $this->query('SELECT inc_in_al.alias_id as inc_al, inc_in_al.include_id as inc, al.id as al_id FROM '.RAD.'includes_in_aliases as inc_in_al
                                                    LEFT JOIN '.RAD.'aliases as al ON al.id = inc_in_al.alias_id
                                                    WHERE inc_in_al.include_id=?', array($inc_id['id']))) {
                    if($inc_in_alies['al_id']) {
                        $this->query('DELETE FROM '.RAD.'aliases WHERE id=?', array($inc_in_alies['al_id']));
                    }
                    $this->query('DELETE FROM '.RAD.'includes_in_aliases WHERE include_id=?', array($inc_id['id']));
                }
                $this->query('DELETE FROM '.RAD.'includes WHERE inc_id=?', array($inc_id['id']));
            }

        }
    }

    /**
     * Gets the include from includes.id table
     * @param integer $id
     * @return array | null
     */
    function getItem($id)
    {
        if((int)$id) {
            $res = $this->query('SELECT * FROM '.RAD.'includes WHERE inc_id=?', array($id));
            return $res;
        }
        return NULL;
    }

    /**
     * Updates title of the component
     * @param integer $id
     * @param string $title
     * @return Ambigous <mixed, PDOStatement, boolean>
     */
    function updateTitle($id, $title)
    {
        if((int)$id) {
            return $this->query('UPDATE '.RAD.'includes SET inc_name=? WHERE inc_id=?', array($title, $id));
        }
    }

}