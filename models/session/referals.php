<?php
/**
 * Referals model
 * @author Yackushev Denys
 * @package Taberna
 * @datecreated 07 Agust 2012
 *
 */
class model_session_referals extends rad_model
{
    /**
     * Alias name for make urk function
     * @var string
     */
    const ALIAS = 'r';

    /**
     * Product type for rrf_item_type
     * @var string
     */
    const TYPE_PRODUCT = 'product';

    /**
     * Catalog of products type for rrf_item_type
     * @var string
     */
    const TYPE_CATALOG = 'catalog';

    /**
     * News type for rrf_item_type
     * @var string
     */
    const TYPE_NEWS = 'news';

    /**
     * Page type for rrf_item_type
     * @var string
     */
    const TYPE_PAGE = 'page';

    /**
     * Article type for rrf_item_type
     * @var string
     */
    const TYPE_ARTICLE = 'article';

    const TYPE_INDEX = 'index';

    /**
     * Making URL for ref-link
     * @param integer $userId - for what user(partner)?
     * @param mixed $params
     * @example:
     * makeUrl(1, array(
     *     'type'=>model_session_referals::TYPE_PAGE,
     *     'item_id'=>34
     * ))
     */
    public static function makeUrl($userId=NULL, $params=array())
    {
        $string = 'alias='.self::ALIAS.($userId?'&user_id='.$userId.'&':'');
        if(!isset($params['type'])) {
            throw new rad_exception('Not enouph actual params "type"');
        }
        $string .= 'type='.$params['type'].'&';
        if(!isset($params['item_id'])) {
            if($params['type']==self::TYPE_INDEX) {
                return rad_input::makeURL($string);
            }
            throw new rad_exception('Not enouph actual params "item_id"');
        }
        $string .= 'ralias=';
        switch($params['type']) {
            case self::TYPE_ARTICLE:
                $string .= 'articles&id='.(int)$params['item_id'];
                break;
            case self::TYPE_CATALOG:
                $string .= 'catalog&id='.(int)$params['item_id'];
                break;
            case self::TYPE_NEWS:
                $string .= 'news&id='.(int)$params['item_id'];
                break;
            case self::TYPE_PAGE:
                $string .= 'page&id='.(int)$params['item_id'];
                break;
            case self::TYPE_PRODUCT:
                $string .= 'product&id='.(int)$params['item_id'];
                break;
        }
        rad_input::makeURL($string);
    }


    public static function redirectUrl($params)
    {
        $string = 'alias=';
        switch($params['type']) {
            case self::TYPE_INDEX:
                $string .= rad_config::getParam('defaultAlias');
                break;
            case self::TYPE_ARTICLE:
                $string .= 'articles&a='.(int)$params['item_id'];
                break;
            case self::TYPE_CATALOG:
                $string .= 'catalog&cat='.(int)$params['item_id'];
                break;
            case self::TYPE_NEWS:
                $string .= 'news&nid='.(int)$params['item_id'];
                break;
            case self::TYPE_PAGE:
                $string .= 'page&pgid='.(int)$params['item_id'];
                break;
            case self::TYPE_PRODUCT:
                $string .= 'product&p='.(int)$params['item_id'];
                break;
        }
        rad_input::redirect( rad_input::makeURL($string) );
    }

    function getItem($id=null)
    {
        if($id) {
            $this->setState('id', $id);
        }
        $q = $this->_getListQuery();
        $res = $this->query($q->toString(), $q->getValues());
        if($res) {
            return new struct_referals($res);
        } else {
            return null;
        }
    }

    function getItems()
    {
        $q = $this->_getListQuery();
        $res = $this->queryAll($q->toString(), $q->getValues());
        if($res) {
            $result = array();
            foreach($res as $id) {
                $result[] = new struct_referals($id);
                if($this->getState('select.subcount') and isset($id['subcount'])) {
                    $result[count($result)-1]->subcount = $id['subcount'];
                }
            }
            return $result;
        }
        return null;
    }

    function _getListQuery()
    {
        $q = new rad_query();

        if($this->getState('from')) {
            $q->from($this->getState('from'));
        } else {
            $q->from(RAD.'referals a');
        }
        if($this->getState('select')) {
            $q->select($this->getState('select'));
        } else {
            $q->select('a.*');
        }
        if($this->getState('cookie')) {
            $q->where('rrf_cookie=:rrf_cookie')->value(array('rrf_cookie'=>$this->getState('cookie')));
        }
        if($this->getState('date.from')) {
            $date = (is_int($this->getState('date.from'))?date($this->config('date.format'), $this->getState('date.from')):$this->getState('date.from'));
            $q->where('rrf_date>=:dateFrom')->value(array('dateFrom'=>$date));
        }
        if($this->getState('date.to')) {
            $date = (is_int($this->getState('date.to'))?date($this->config('date.format'), $this->getState('date.to')):$this->getState('date.to'));
            $q->where('rrf_date<=:dateTo')->value(array('dateTo'=>$date));
        }
        if($this->getState('group', $this->getState('group by'))) {
            $q->group($this->getState('group', $this->getState('group by')));
            if($this->getState('select.subcount')) {
                $q->select('count(a.rrf_id) as subcount');
            }
        }
        if($this->getState('order', $this->getState('order by'))) {
            $q->order( $this->getState('order', $this->getState('order by')) );
        }
        return $q;
    }

    /**
     * <en>Gets the user who cited userid in params</en>
     * <ru>Добывает пользователя, который пригласил этого клиента</ru>
     * @param integer|struct_user $userId
     * @return struct_referals_users | NULL
     */
    function getUserPartner($userId)
    {
        if($userId instanceof struct_users) {
            $userId = $userId->u_id;
        }
        $userId = (int)$userId;
        $res = $this->query('SELECT * FROM '.RAD.'referals_users WHERE rru_user_id=:user_id', array('user_id'=>$userId));
        if(!empty($res['rru_id'])) {
            return new struct_referals_users($res);
        }
        return NULL;
    }

    /**
     * Gets percent for partner
     * @param integer | struct_users $parnerId
     * @state rrf_user_id integer | struct_users $parnerId
     * @return float
     */
    function getParntnerPercent($partnerId=NULL)
    {
        if(!$partnerId and $this->getState('rrf_user_id')) {
            $partnerId = $this->getState('rrf_user_id');
        } elseif(!$partnerId) {
            throw new rad_exception('Not enough actual param "rrf_user_id" in referals model!', __LINE__);
        }
        if($partnerId instanceof struct_users) {
            $partnerId = $parnerId->u_id;
        }
        return (float)$this->config('referals.percent');
    }

    /**
     * Get all orders of the partner
     * @throws rad_exception
     * @return multitype:struct_referals_orders |NULL
     */
    function getPartnerOrders()
    {
        if(!$this->getState('rrf_user_id')) {
            throw new rad_exception('Not enough actual param "rrf_user_id" in referals model!', __LINE__);
        }
        if(!$this->getState('date.from')) {
            print_h($this->getStates());
            throw new rad_exception('Not enough actual param "date.from" in referals model!!', __LINE__);
        }
        if(!$this->getState('date.to')) {
            throw new rad_exception('Not enough actual param "date.to" in referals model!', __LINE__);
        }
        $q = new rad_query();
        $q->from(RAD.'referals_orders a')
          ->select('a.*, o.order_status, o.order_dt, o.order_currency')
          ->join('INNER', RAD.'orders o ON o.order_id=a.rro_order_id')
          ->join('INNER', RAD.'referals r ON r.rrf_id=a.rro_referals_id')
          ->where('r.rrf_user_id=:rrf_user_id')->value(array('rrf_user_id'=>(int)$this->getState('rrf_user_id')))
          ->where('o.order_dt BETWEEN :date_from AND :date_to')->value(
                          array(
                                  'date_from' => date($this->config('date.format'), $this->getState('date.from')),
                                  'date_to'   => date($this->config('date.format'), $this->getState('date.to')+86400)
                               )
                  );
        $res = $this->queryAll($q->toString(), $q->getValues());
        if($res) {
            $result = array();
            foreach($res as $id) {
                $result[] = new struct_referals_orders($id);
            }
            return $result;
        }
        return NULL;
    }

    /**
     * Gets the partners statistics by period
     * @state date.from
     * @state date.ro
     * @return mixed array | NULL
     */
    function getRefStatistics($limit = null)
    {
        $limit = (empty($limit)&&$this->getState('limit'))?$this->getState('limit'):$limit;
        $limit = !empty($limit)?' LIMIT '.$limit:'';
        if(!$this->getState('date.from')) {
            throw new rad_exception('Not enough actual param "date.from" in referals model!', __LINE__);
        }
        if(!$this->getState('date.to')) {
            throw new rad_exception('Not enough actual param "date.to" in referals model!', __LINE__);
        }
        /* calc ref count */
        $qRefCount = new rad_query();
        $qRefCount->select('count(t1.rrf_id)')
                  ->from(RAD.'referals t1')
                  ->where('t1.rrf_user_id=a.u_id')
                  ->where('t1.rrf_date BETWEEN :date_from AND :date_to');
        /* calc orders count */
        $qOrderCount = new rad_query();
        $qOrderCount->select('count(*) AS ro_cnt')
                    ->from(RAD.'referals_orders ro')
                    ->join('INNER', RAD.'orders ON order_id=rro_order_id AND order_dt BETWEEN :date_from AND :date_to')
                    ->join('INNER', RAD.'referals r ON rrf_id=rro_referals_id')
                    ->where('r.rrf_user_id=a.u_id');
        /* full query */
        $q = new rad_query();
        $q->from(RAD.'users a');
        $q->select('a.*, ('.$qRefCount->toString().') refCount, ('.$qOrderCount->toString().') ordersCount')
                ->value(array(
                        'date_from'=>date($this->config('date.format'), $this->getState('date.from')),
                        'date_to'=>date($this->config('date.format'), $this->getState('date.to')+86400)
                        ))
          ->where('a.u_email_confirmed=1')
          ->having('refCount > 0 OR ordersCount > 0');
        if($this->getState('search')) {
            $q->where('(u_login LIKE :search or u_email LIKE :search OR u_fio LIKE :search OR u_address LIKE :search OR u_phone LIKE :search)')->value(array('search'=>'%'.$this->getState('search').'%'));
        }
        $res = $this->queryAll($q->toString().$limit, $q->getValues());
//         die($q->toString().$limit.print_h($q->getValues(),true));
        if($res) {
            $userIds = array();
            foreach($res as &$id) {
                $userIds[] = $id['u_id'];
            }
            return $res;
        }
        return NULL;
    }

    /**
     * Get orders sum for users
     * @param $users - integer|mixed array of integer
     */
    protected function _getOrdersSum($users)
    {

    }

    /**
     * Deletes all records when deletes the order
     * @param integer $order
     * @param boolean $deleted - default is true
     */
    function deleteOrderEvent($order, $deleted = true)
    {
        return $this->exec('UPDATE '.RAD.'referals_orders SET rro_order_deleted='.(int)(boolean)$deleted.' WHERE rro_order_id='.(int)$order);
    }

    /**
     * ReCalc referal order sum
     * @param integer $order
     * @return boolean
     */
    function recalcOrderSum($order)
    {
        $orderPositions = array();
        rad_instances::get('model_catalog_order')->assignPositions($orderPositions, $order);
        $orderSum = 0;
        if(!empty($orderPositions)) {
            foreach($orderPositions as $id) {
                $orderSum += model_catalog_currcalc::calcCours( $id->orp_cost, $id->orp_curid )*$id->orp_count;
            }
        }
        $this->query('UPDATE '.RAD.'referals_orders SET rro_order_sum=:order_sum WHERE rro_order_id=:order_id',
                        array('order_sum'=>$orderSum,'order_id'=>(int)$order)
                    );
        return true;
    }

    /**
     * Insert record to the referals_orders table
     * @param struct_referals_orders $item
     * @return struct_referals_orders
     */
    function insertOrder(struct_referals_orders $item)
    {
        $this->insert_struct($item, RAD.'referals_orders');
        $item->rro_id = $this->inserted_id();
        return $item;
    }

    /**
     * Insert record to the referals_users table
     * @param struct_referals_users $item
     * @return struct_referals_users
     */
    function insertUser(struct_referals_users $item)
    {
        $this->insert_struct($item, RAD.'referals_users');
        $item->rru_id = $this->inserted_id();
        return $item;
    }

    function insertItem(struct_referals $item)
    {
        return $this->insert_struct($item, RAD.'referals');
    }
}