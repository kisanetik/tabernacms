<?php

/**
 * Currency calc model
 * @author Denys Yackushev
 * @package Taberna
 *
 */
class model_corecatalog_currcalc
{

    /**
     * Array of currencys
     * @var struct_corecatalog_currency
     */
    public static $_currs = NULL;

    /**
     * Main current currency on the site
     * @var struct_corecatalog_currency
     */
    public static $_curcours = NULL;

    /**
     * Return name of the current SITE currency
     * @return string
     */
    public static function currName() {
        self::init();
        return self::$_curcours->cur_name;
    }

    /**
     * Return short name of the current SITE currency
     * @return string
     */
    public static function currShortName()
    {
        self::init();
        return (self::$_curcours->cur_shortname ? self::$_curcours->cur_shortname : self::$_curcours->cur_ind);
    }

    /**
     * Return the cost of current currency
     * @return float
     */
    public static function currCours() {
        self::init();
        return self::$_curcours->cur_cost;
    }

    /**
     * Return Indicate of the current SITE currency
     * @return string
     */
    public static function currInd() {
        self::init();
        return self::$_curcours->cur_ind;
    }

    /**
     * To init this class and select all currency rates!
     */
    public static function init() {
        if (!self::$_currs) {
            $_currs = rad_instances::get('model_corecatalog_currency')->getItems();
            if (count($_currs)) {
                for ($i = 0; $i < count($_currs); $i++) {
                    self::$_currs[$_currs[$i]->cur_id] = $_currs[$i];
                }//for i
            }
            foreach (self::$_currs as $id) {
                if (!isset($_SESSION['cur_default_site']) and $id->cur_default_site) {
                    self::$_curcours = $id;
                    break;
                } elseif (isset($_SESSION['cur_default_site']) and $_SESSION['cur_default_site'] == $id->cur_id) {
                    self::$_curcours = $id;
                    break;
                }
            }//foreach
        }
    }

    public static function getDefaultCurrencyId() {
        self::init();
        return self::$_curcours->cur_id;
    }

    public static function setDefaultCurrencyId($cur_id) {
        self::init();
        if (isset(self::$_currs[$cur_id])) {
            self::$_curcours = self::$_currs[$cur_id];
            $_SESSION['cur_default_site'] = $cur_id;
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public static function calcCours($cost, $cur_id) { // $cost = 500.0, $cur_id = 1.0
        if(!$cost) {
            return 0;
        }
        self::init();
        if ($cur_id == self::$_curcours->cur_id) {
            return $cost;
        } else {
            if (isset(self::$_currs[$cur_id])) {
                return round(($cost) * (self::$_currs[$cur_id]->cur_cost / self::$_curcours->cur_cost), (int) rad_config::getParam('currency.precision'));
            } else {
                throw new rad_exception('ERROR: cours_id does not exists!', __LINE__);
            }
            //return
        }
    }

    /**
     * Gets the currency name by it ID
     * @param integer $cur_id
     * @return string
     */
    public static function getCurrencyByID($cur_id=0) {
        self::init();
        if ($cur_id) {
            if (isset(self::$_currs[$cur_id])) {
                return self::$_currs[$cur_id]->cur_ind;
            } else {
                return 'id_s=' . $cur_id;
            }
        } else {
            return 'id=' . $cur_id;
        }
    }

    /**
     * Makes the difference betwen difference in cources
     * @return float;
     */
    public static function makeDifference($cost, $cur_id, $cur_cost) {
        if (isset(self::$_currs[$cur_id]) and (float) $cur_cost > 0) {
            return $cost * self::$_currs[$cur_id]->cur_cost / $cur_cost;
        } else {
            //throw ???
            return $cost;
        }
    }

}