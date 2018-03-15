<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Condition_Product')) {
    include_once('rp-wcdpd-condition-product.class.php');
}

/**
 * Condition: Product - Category
 *
 * @class RP_WCDPD_Condition_Product_Category
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Condition_Product_Category')) {

class RP_WCDPD_Condition_Product_Category extends RP_WCDPD_Condition_Product
{
    protected $key      = 'category';
    protected $contexts = array('product_pricing', 'product_pricing_group_product');
    protected $method   = 'list';
    protected $fields   = array(
        'after' => array('product_categories'),
    );
    protected $position = 30;
    protected $is_cart  = false;

    // Singleton instance
    protected static $instance = false;

    /**
     * Singleton control
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor class
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->hook();
    }

    /**
     * Get label
     *
     * @access public
     * @return string
     */
    public function get_label()
    {
        return __('Product category', 'rp_wcdpd');
    }

    /**
     * Get value to compare against condition
     *
     * @access public
     * @param array $params
     * @return mixed
     */
    public function get_value($params)
    {
        return RightPress_Helper::get_wc_product_category_ids_from_product_ids(array($params['item_id']));
    }




}

RP_WCDPD_Condition_Product_Category::get_instance();

}
