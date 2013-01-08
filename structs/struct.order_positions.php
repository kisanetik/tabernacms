<?php
/**
 * Composite structure for the order
 * Used by core
 *
 * @author Yackushev Denys
 * @version 0.1
 * @package Taberna
 * @return composite struct
 *
 */
class struct_order_positions extends rad_struct
{
    /**
     * Id
     *
     * @var integer
     */
    public $orp_id=0;

    /**
     * link to product_id from rad_catalog.cat_id
     * @var int
     */
    public $orp_catid = 0;

    /**
     * order id
     * @var int
     */
    public $orp_orderid = 0;

    /**
     * Count of product
     * @var float (decimal 10,3)
     */
    public $orp_count = '';

    /**
     * Cost of each position
     * @var float ( decimal 9,2 )
     */
    public $orp_cost = 0;

    /**
     * ink to the currency id
     * @var integer
     */
    public $orp_curid = 0;

    /**
     * currency name
     * @var string (100)
     */
    public $orp_currency = '';

    /**
     * Name of product
     * @var string(255)
     */
    public $orp_name = '';

    /**
     * Article of the product
     * @var string(150)
     */
    public $orp_article = 0;

    /**
     * Product code
     * @var string(150)
     */
    public $orp_code = '';

    /**
     * Dump of the full product (serialized)
     * @var string (text)
     */
    public $orp_dump = '';
    
    public function __get($key)
    {
        switch ($key) {
            case 'photo':
                $dump = unserialize($this->orp_dump);
                if (is_array($dump->images_link)) {
                    foreach ($dump->images_link as $image) {
                        if ($image instanceof struct_cat_images) {
                            if ($image->img_main > 0) {
                                return $image->img_filename;
                            }
                        }
                    }
                }
                return '';
        }
        return null;
    }

    function __construct($array = NULL)
    {
        parent::__construct($array,'orp_id');
    }
}