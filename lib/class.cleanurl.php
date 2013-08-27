<?php
/**
 * Class to map user-friendly URLs
 *
 * @author Roman Chertov
 * @package Taberna
 * @datecreated 31.07.2013
 */
class rad_cleanurl
{
    /**
     * Remove URL alias
     * @static
     * @param string $item_type
     * @param int $item_id
     */
    public static function removeAlias($item_type, $item_id)
    {
        rad_dbpdo::query('DELETE FROM '.RAD.'url_aliases WHERE item_type=:item_type AND item_id=:item_id', array('item_type'=>$item_type, 'item_id'=>$item_id));
    }

    /**
     * Save URL alias
     * @static
     * @param string $item_type
     * @param int $item_id
     * @param int $lang_id
     * @param string $alias - string does not contain symbols: space tab ? # : <> @ & $ [] {} ^ " ; =
     */
    public static function setAlias($item_type, $item_id, $lang_id, $alias)
    {
        if (empty($alias)) {
            self::removeAlias($item_type, $item_id);
        } else {
            rad_dbpdo::query('REPLACE INTO '.RAD.'url_aliases SET item_type=:item_type, item_id=:item_id, lang_id=:lang_id, alias=:alias', array(
                'item_type'=>$item_type,
                'item_id'=>$item_id,
                'lang_id'=>$lang_id,
                'alias'=>$alias
            ));
        }
    }

    /**
     * Get URL alias
     * @static
     * @param string $item_type
     * @param int $item_id
     * @return string
     */
    public static function getAlias($item_type, $item_id)
    {
        $result = rad_dbpdo::query('SELECT alias FROM '.RAD.'url_aliases WHERE item_type=:item_type AND item_id=:item_id', array('item_type'=>$item_type, 'item_id'=>$item_id));
        return (empty($result['alias']) ? '' : $result['alias']);
    }

    /**
     * Get URL alias using GET parameters
     * @static
     * @param array $params
     * @return bool|string
     */
    public static function getAliasByParams($params)
    {
        if (($params['alias'] == 'product') && $params['p'] && (count($params) == 2)) {
            return self::getAlias($params['alias'], $params['p']);
        }
        return false;
    }

    /**
     * Get URL using URL alias
     * @static
     * @param string $alias
     * @return false|string
     */
    public static function getUrlByAlias($alias)
    {
        $result = rad_dbpdo::query('SELECT item_type, item_id, lang_id FROM '.RAD.'url_aliases WHERE alias=:alias', array('alias'=>$alias));
        if (empty($result['item_type'])) return false;

        $lng = rad_lang::getLangByID($result['lang_id']);
        rad_lang::changeLanguage($lng->lng_code);

        switch ($result['item_type']) {
            //List all supported item types here (if they don't need some special processing)
            case 'product':
                return rad_input::makeURL('alias='.$result['item_type'].'&p='.$result['item_id'], false);
            default:
                return false; //For not supported item types
        }
    }

    /**
     * Get URL alias from REQUEST_URI
     * @static
     * @return string
     */
    private static function getAliasFromRequest()
    {
        $alias = substr($_SERVER['REQUEST_URI'], 1);
        if (($pos = strpos($alias, '?')) !== false) {
            $alias = substr($alias, 0, $pos);
        }
        return urldecode($alias);
    }

    /**
     * Method returns overridden URL, if REQUEST_URI contains the alias
     * @static
     * @return string|false
     */
    public static function getOverriddenUrl()
    {
        if ($alias_url = self::getAliasFromRequest()) {
            return self::getUrlByAlias($alias_url);
        }
        return false;
    }
}