<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Controller_Methods')) {
    include_once('rp-wcdpd-controller-methods.class.php');
}

/**
 * Product Pricing method controller
 *
 * @class RP_WCDPD_Controller_Methods_Product_Pricing
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Controller_Methods_Product_Pricing')) {

class RP_WCDPD_Controller_Methods_Product_Pricing extends RP_WCDPD_Controller_Methods
{
    protected $context = 'product_pricing';

    // Track which rules were processed for cart items
    protected $rules_processed = array();

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
        // Apply pricing rules to cart
        add_action('woocommerce_cart_loaded_from_session', array($this, 'cart_loaded_from_session'), 100);
        add_action('woocommerce_before_calculate_totals', array($this, 'apply'), 100);

        // TBD: Problems applying pricing rules instantly when coupon condition is used in Flatsome theme
        // add_action('woocommerce_applied_coupon', array($this, 'apply'));

        // Maybe change cart item display price
        add_filter('woocommerce_cart_item_price', array($this, 'cart_item_price'), 10, 3);
    }

    /**
     * Cart loaded from session
     *
     * @access public
     * @param object $cart
     * @return void
     */
    public function cart_loaded_from_session($cart)
    {
        // Iterate over cart items
        foreach ($cart->cart_contents as $cart_item_key => $cart_item) {

            // Add flag that indicates that cart item's product is in cart
            $cart->cart_contents[$cart_item_key]['data']->rp_wcdpd_in_cart = true;

            // Unset any previously set adjustment meta data
            if (isset($cart->cart_contents[$cart_item_key]['rp_wcdpd_data'])) {
                unset($cart->cart_contents[$cart_item_key]['rp_wcdpd_data']);
            }
        }

        // Apply pricing rules to cart
        $this->apply($cart);

        // Force calculation of totals so that they are updated in mini-cart
        if (defined('WC_DOING_AJAX') && WC_DOING_AJAX) {
            $cart->subtotal = false;
        }
    }

    /**
     * Apply pricing rules to cart
     *
     * @access public
     * @param object $cart
     * @return void
     */
    public function apply($cart = null)
    {
        if (!is_a($cart, 'WC_Cart')) {
            global $woocommerce;
            $cart = $woocommerce->cart;
        }

        // Sort cart items by price from cheapest
        $cart_items = RP_WCDPD_WC_Cart::sort_cart_items_by_price($cart->cart_contents, 'ascending');

        // Apply exclude rules and allow developers to exclude items
        $cart_items = apply_filters('rp_wcdpd_product_pricing_cart_items', $cart_items);

        // Maybe exclude items that are already on sale
        if (RP_WCDPD_Settings::get('product_pricing_sale_price_handling') === 'exclude') {
            $cart_items = $this->exclude_cart_items_already_on_sale($cart_items);
        }

        // Get applicable product pricing adjustments
        $adjustments = $this->get_applicable_adjustments($cart_items);

        // Iterate over adjustments for cart items
        foreach ($adjustments as $cart_item_key => $cart_item_adjustments) {

            // Filter cart item adjustments by rule selection method and exclusivity settings
            $cart_item_adjustments = RP_WCDPD_Rules::filter_by_exclusivity($this->context, $cart_item_adjustments);

            // Apply all remaining cart item adjustments
            foreach ($cart_item_adjustments as $rule_uid => $adjustment) {

                // Apply pricing adjustment
                if ($method = $this->get_method($adjustment['rule'])) {
                    call_user_func($method['apply_adjustment_callback'], $adjustment, $cart, $cart_item_key);
                }
            }

            // Round cart item price so that we end up with correct cart line subtotal
            $price = RightPress_WC_Legacy::product_get_price($cart->cart_contents[$cart_item_key]['data']);
            RightPress_WC_Legacy::product_set_price($cart->cart_contents[$cart_item_key]['data'], RP_WCDPD_Pricing::round($price));
        }
    }

    /**
     * Maybe change cart item display price
     *
     * @access public
     * @param string $price_html
     * @param array $cart_item
     * @param string $cart_item_key
     * @return string
     */
    public function cart_item_price($price_html, $cart_item, $cart_item_key)
    {
        // Check if pricing was adjusted for this cart item
        if (isset($cart_item['rp_wcdpd_data']['initial_price'])) {

            // Get adjusted price
            $adjusted_price = RP_WCDPD_WC_Cart::get_cart_item_price_for_display($cart_item);

            // Adjusted price is lower than initial price
            if ($adjusted_price < $cart_item['rp_wcdpd_data']['initial_price']) {
                $price_html = '<del>' . wc_price($cart_item['rp_wcdpd_data']['initial_price']) . '</del> <ins>' . wc_price($adjusted_price) . '</ins>';
            }
        }

        return $price_html;
    }

    /**
     * Exclude cart items that are already on sale
     *
     * @access public
     * @param array $cart_items
     * @return array
     */
    public function exclude_cart_items_already_on_sale($cart_items)
    {
        foreach ($cart_items as $cart_item_key => $cart_item) {
            if ($cart_item['data']->is_on_sale()) {
                unset($cart_items[$cart_item_key]);
            }
        }

        return $cart_items;
    }

    /**
     * Check if rule is already processed for cart item
     * Mark processed if it is not processed yet
     *
     * @access public
     * @param string $rule_key
     * @param string $cart_item_key
     * @return bool
     */
    public static function is_already_processed($rule_key, $cart_item_key)
    {
        // Get instance
        $instance = RP_WCDPD_Controller_Methods_Product_Pricing::get_instance();

        // Rule already processed
        if (isset($instance->rules_processed[$rule_key]) && in_array($cart_item_key, $instance->rules_processed[$rule_key], true)) {
            return true;
        }
        // Rule not processed yet - mark as processed
        else {
            $instance->rules_processed[$rule_key][] = $cart_item_key;
            return false;
        }
    }




}

RP_WCDPD_Controller_Methods_Product_Pricing::get_instance();

}
