<?php
/**
 * Comments model
 * @author Yackushev Denys
 * @package RADCMS
 */
class model_resource_comments extends rad_model
{
    /**
     * Products type
     * @var string
     */
    const TYPE_PRODUCT = 'product';

    /**
     * Order type
     * @var string
     */
    const TYPE_ORDER = 'order';

    /**
     * News type
     * @var string
     */
    const TYPE_NEWS = 'news';

    /**
     * Articles type
     * @var string
     */
    const TYPE_ARTICLES = 'articles';

    function getItem($id=null)
    {
        if($id and !(int)$this->getState('rcm_id', $this->getState('id'))) {
            $this->setState('id', (int)$id);
        }
        $q = $this->_getListQuery();
        $item = $this->query($q->toString().' LIMIT 1', $q->getValues());
        $item = (!empty($item)?new struct_comments($item):null);
        return $item;
    }

    function getItems($limit = null)
    {
        $q = $this->_getListQuery($this->getStates());
        $result = array();
        $limit = ($limit) ? ' LIMIT ' . $limit : '';
        if ($this->getState('select')!=='count(*)') {
            foreach ( $this->queryAll( $q->toString().$limit, $q->getValues() ) as $key) {
                $result[] = new struct_comments($key);
                if ($this->getState('join.news') and (int)$key['nw_id']) {
                    $result[count($result)-1]->news = new struct_news($key);
                }
                if ($this->getState('join.articles') and (int)$key['art_id']) {
                    $result[count($result)-1]->articles = new struct_articles($key);
                }
                if ($this->getState('join.products') and (int)$key['cat_id']) {
                    $result[count($result)-1]->product = new struct_catalog($key);
                }
                if ($this->getState('join.orders') and (int)$key['order_id']) {
                    $result[count($result)-1]->order = new struct_orders($key);
                }
            }
        } else {
            $result = $this->query($q->toString(), $q->getValues());
            if (count($result)) {
                $result = $result['count(*)'];
            }
        }
        return $result;
    }

    private function _getListQuery()
    {

        $qb = new rad_query();

        if($this->getState('from')) {
            $qb->from($this->getState('from'));
        } else {
            $qb->from(RAD.'comments a');
        }
        if($this->getState('select')) {
            $qb->select($this->getState('select'));
        } else {
            $qb->select('*');
        }
        if($this->getState('join.news')) {
            $qb->join('LEFT', RAD.'news ON nw_id=a.rcm_item_id AND rcm_type="'.self::TYPE_NEWS.'"');
        }
        if($this->getState('join.articles')) {
            $qb->join('LEFT', RAD.'articles ON art_id=a.rcm_item_id AND rcm_type="'.self::TYPE_ARTICLES.'"');
        }
        if($this->getSTate('join.orders')) {
            $qb->join('LEFT', RAD.'orders o ON o.order_id=a.rcm_item_id AND rcm_type="'.self::TYPE_ORDER.'"');
        }
        if($this->getSTate('join.products')) {
            $qb->join('LEFT', RAD.'catalog c ON c.cat_id=a.rcm_item_id AND rcm_type="'.self::TYPE_PRODUCT.'"');
        }
        if($this->getState('order', $this->getState('order by'))) {
            $qb->order($this->getState('order', $this->getState('order by')));
        }
        if($this->getState('group')) {
            $qb->group($this->getState('group'));
        }

        if ($this->getState('rcm_item_id', $this->getState('item_id'))) {
            $qb ->where('rcm_item_id=:item_id')
                ->value(array(
                    'item_id' => $this->getState('rcm_item_id',  $this->getState('item_id'))
                ));
        }
        if ($this->getState('rcm_active', $this->getState('active'))) {
            $qb ->where('rcm_active=:rcm_active')
                ->value(array(
                    'rcm_active' => $this->getState('rcm_active',  $this->getState('active'))
                ));
        }
        if ($this->getState('rcm_type', $this->getState('type'))) {
            $qb ->where('rcm_type=:rcm_type')
                ->value(array(
                    'rcm_type' => $this->getState('rcm_type',  $this->getState('type'))
                ));
        }
        if((int)$this->getState('rcm_id', $this->getState('id'))) {
            $qb->where('rcm_id=:id')->value(array('id'=>(int)$this->getState('rcm_id', $this->getState('id'))));
        }
        return $qb;

    }

    /**
     * Get count of products in tree_id
     * @return integer
     */
    function getCount($treid=null)
    {
        $select = $this->getState('select');
        $this->setState('select', 'count(rcm_id) counter');
        $q = $this->_getListQuery($this->getStates());
        $result = $this->query($q->toString(), $q->getValues());
        $this->setState('select', $select);
        return is_array($result) ? (int) $result['counter'] : 0;
    }

    /**
     * Insert one row
     * @param struct_photoalbum $item
     */
    function insertItem(struct_comments $item)
    {
        return $this->insert_struct($item,RAD.'comments');
    }

    /**
     * update one row
     * @param struct_photoalbum $item
     */
    function updateItem(struct_comments $item)
    {
        return $this->update_struct($item,RAD.'comments');
    }

    /**
     * Delete one row
     * @param struct_photoalbum $item
     */
    function deleteItem(struct_comments $item)
    {
        return $this->delete_struct($item, RAD.'comments');
    }

    /**
     * Sets the "active" state in item
     */
    function setActive($pha_id,$v)
    {
        return $this->exec('UPDATE '.RAD.'comments set rcm_active='.$v.' where rcm_id='.(int)$pha_id);
    }
}