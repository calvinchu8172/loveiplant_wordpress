<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Promotion: Display Price Override
 *
 * @class RP_WCDPD_Promotion_Display_Price_Override
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Promotion_Display_Price_Override')) {

class RP_WCDPD_Promotion_Display_Price_Override extends RightPress_WC_Price_Override
{
    protected $cache_prefix = 'rp_wcdpd';

    protected $rules = null;
    protected $product_condition_values = array();
    protected $non_product_condition_values = null;

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
    }

    /**
     * Check if price can be changed
     *
     * @access public
     * @param object $product
     * @return bool
     */
    public function price_can_be_changed($product)
    {
        // Don't change prices in admin ui
        if (is_admin() && !defined('DOING_AJAX')) {
            return false;
        }

        // Don't run if cart was not loaded yet (we need to flag products that are in cart first for this to work fine)
        if (!did_action('woocommerce_cart_loaded_from_session')) {
            return false;
        }

        // Make sure that product is not cart item
        if (!empty($product->rp_wcdpd_in_cart)) {
            return false;
        }

        // Don't change regular prices
        if ($this->price_type === 'regular_price') {
            return false;
        }

        // Get product pricing rules
        if ($this->rules === null) {
            $this->rules = RP_WCDPD_Rules::get('product_pricing', array('methods' => array('simple')));
        }

        // No rules configured
        if (empty($this->rules)) {
            return false;
        }

        return true;
    }

    /**
     * Get adjusted price
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return float
     */
    public function get_adjusted_price($price, $product)
    {
        $controller = RP_WCDPD_Controller_Methods_Product_Pricing::get_instance();

        // Get simple product pricing rules applicable to this product
        $applicable_rules = RP_WCDPD_Product_Pricing::get_applicable_rules_for_product($product, array('simple'), !RP_WCDPD_Settings::get('promo_display_price_override_cart_conditions'));

        // Apply adjustments
        foreach ($applicable_rules as $applicable_rule) {
            if ($method = $controller->get_method($applicable_rule)) {
                $price = call_user_func($method['get_adjusted_amount_callback'], $applicable_rule, $price);
            }
        }

        return $price;
    }

    /**
     * Get cached price validation hash
     * Used to identify outdated cached prices
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return string
     */
    public function get_cached_price_hash($price, $product)
    {
        // Data for hash
        $data = array(

            // Price type
            $this->price_type,

            // Request price
            (float) $price,

            // Prices set in product settings
            (float) RightPress_WC_Legacy::product_get_price($product, 'edit'),
            (float) RightPress_WC_Legacy::product_get_regular_price($product, 'edit'),
            (float) RightPress_WC_Legacy::product_get_sale_price($product, 'edit'),

            // Plugin settings hash
            $this->get_settings_hash(),

            // Get product condition values
            $this->get_product_condition_values($product),

            // Get non-product condition values
            $this->get_non_product_condition_values(),
        );

        // Return hash
        return RightPress_Helper::get_hash(false, $data);
    }

    /**
     * Get settings hash
     *
     * @access public
     * @return string
     */
    public function get_settings_hash()
    {
        return $this->cache_prefix . '_' . RightPress_Helper::get_hash(false, array(
            RP_WCDPD_Rules::get('product_pricing', array('methods' => array('simple'))),
            RP_WCDPD_Settings::get('product_pricing_rule_selection_method'),
            RP_WCDPD_Settings::get('promo_display_price_override_cart_conditions'),
        ));
    }

    /**
     * Get values for all product conditions for all rules
     *
     * @access public
     * @param object $product
     * @return array
     */
    public function get_product_condition_values($product)
    {
        // Get product id
        $product_id = RightPress_WC_Legacy::product_get_id($product);

        // Get values and store in cache
        if (!isset($this->product_condition_values[$product_id])) {

            // Define condition params
            $params = array(
                'item_id'               => $product->is_type('variation') ? RightPress_WC_Legacy::product_variation_get_parent_id($product) : $product_id,
                'child_id'              => $product->is_type('variation') ? $product_id : null,
                'variation_attributes'  => $product->is_type('variation') ? $product->get_variation_attributes() : null,
            );

            // Get values
            $this->product_condition_values[$product_id] = $this->get_condition_values(true, $params);
        }

        // Return from cache
        return $this->product_condition_values[$product_id];
    }

    /**
     * Get values for all non-product conditions for all rules
     *
     * @access public
     * @return array
     */
    public function get_non_product_condition_values()
    {
        // Get values and store in cache
        if ($this->non_product_condition_values === null) {
            $this->non_product_condition_values = $this->get_condition_values(false);
        }

        // Return from cache
        return $this->non_product_condition_values;
    }

    /**
     * Get values for all conditions for all rules
     * Checks either product or non-product conditions during one run
     *
     * @access public
     * @param bool $product_conditions
     * @param array $params
     * @return array
     */
    public function get_condition_values($product_conditions, $params = array())
    {
        $values = array();
        $processed = array();

        // Check if cart conditions need to be included
        $include_cart_conditions = (bool) RP_WCDPD_Settings::get('promo_display_price_override_cart_conditions');

        // Iterate over rules
        foreach ($this->rules as $rule) {

            // Iterate over conditions
            if (!empty($rule['conditions'])) {
                foreach ($rule['conditions'] as $rule_condition) {

                    // Check if condition is product condition
                    $is_product = RightPress_Helper::string_begins_with_substring($rule_condition['type'], 'product__');

                    // Check if we need to get value for current condition
                    if ($is_product && !$product_conditions || !$is_product && $product_conditions) {
                        continue;
                    }

                    // Maybe skip cart and cart item conditions
                    if (!$include_cart_conditions && (RightPress_Helper::string_begins_with_substring($rule_condition['type'], 'cart__') || RightPress_Helper::string_begins_with_substring($rule_condition['type'], 'cart_items__'))) {
                        continue;
                    }

                    // Set condition
                    $params['condition'] = $rule_condition;

                    // Get condition value
                    if ($condition = RP_WCDPD_Controller_Conditions::get_item($rule_condition['type'])) {
                        $values[][$rule_condition['type']] = call_user_func($condition['get_value_callback'], $params);
                    }
                }
            }
        }

        return $values;
    }




}

RP_WCDPD_Promotion_Display_Price_Override::get_instance();

}
