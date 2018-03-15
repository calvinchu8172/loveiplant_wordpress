<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Method')) {
    include_once('rp-wcdpd-method.class.php');
}

/**
 * Product Pricing Method
 *
 * @class RP_WCDPD_Method_Product_Pricing
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Method_Product_Pricing')) {

abstract class RP_WCDPD_Method_Product_Pricing extends RP_WCDPD_Method
{
    protected $context = 'product_pricing';

    /**
     * Group quantities of matching cart items
     *
     * @access public
     * @param array $cart_items
     * @param array $rule
     * @return array
     */
    public function group_quantities($cart_items, $rule)
    {
        $quantities = array();

        // Get Quantities Based On method
        $based_on = $rule['quantities_based_on'];

        // Filter out cart items that are not affected by this rule so we don't count them
        $cart_items = RP_WCDPD_Product_Pricing::filter_items_by_rules($cart_items, array($rule));

        // Iterate over cart items
        foreach ($cart_items as $cart_item_key => $cart_item) {

            // Get absolute product id (i.e. parent product id for variations)
            $product_id = RP_WCDPD_WC_Product::product_get_absolute_id($cart_item['data']);

            // Individual Products - Each individual product
            // Individual Products - Each individual variation (variation not specified)
            if ($based_on === 'individual__product' || ($based_on === 'individual__variation' && empty($cart_item['variation_id']))) {
                $quantities[$product_id][$cart_item_key] = $cart_item['quantity'];
            }

            // Individual Products - Each individual variation (variation specified)
            else if ($based_on === 'individual__variation') {
                $quantities[$cart_item['variation_id']][$cart_item_key] = $cart_item['quantity'];
            }

            // Individual Products - Each individual cart line item
            else if ($based_on === 'individual__configuration') {
                $quantities[$cart_item_key][$cart_item_key] = $cart_item['quantity'];
            }

            // All Matched Products - Quantities added up by category
            else if ($based_on === 'cumulative__categories') {

                // Get category ids
                $categories = RightPress_Helper::get_wc_product_category_ids_from_product_ids(array($product_id));

                // Iterate over categories and add quantities
                foreach ($categories as $category_id) {
                    $quantities[$category_id][$cart_item_key] = $cart_item['quantity'];
                }
            }

            // All Matched Products - All quantities added up
            else if ($based_on === 'cumulative__all') {
                $quantities['_all'][$cart_item_key] = $cart_item['quantity'];
            }
        }

        // Return quantities
        return $quantities;
    }

    /**
     * Get reference amount
     *
     * @access public
     * @param array $rule
     * @param float $base_amount
     * @param int $total_quantity
     * @param array $adjustment
     * @return mixed
     */
    public function get_reference_amount($rule, $base_amount = null, $total_quantity = null, $adjustment = array())
    {
        // Get rule selection method
        $selection_method = RP_WCDPD_Settings::get($this->context . '_rule_selection_method');

        // Calculate reference amount
        if (in_array($selection_method, array('smaller_price', 'bigger_price'), true)) {

            // Get adjusted amount
            $adjusted_amount = $this->get_adjusted_amount($rule, $base_amount, $total_quantity, $adjustment);

            // Calculate reference amount
            return (float) ($base_amount - $adjusted_amount);
        }
        // Reference amount is not needed
        else {
            return null;
        }
    }

    /**
     * Get adjusted amount
     *
     * @access public
     * @param array $rule
     * @param float $amount
     * @param int $total_quantity
     * @param array $adjustment
     * @return float
     */
    public function get_adjusted_amount($rule, $amount, $total_quantity = 1, $adjustment = array())
    {
        // Get adjusted amount
        $amount = RP_WCDPD_Pricing::adjust_amount($amount, $rule['pricing_method'], $rule['pricing_value']);

        // Round amount to get predictable results
        $amount = RP_WCDPD_Pricing::round($amount);

        // Allow developers to override
        $amount = apply_filters('rp_wcdpd_product_pricing_adjusted_amount', $amount, $adjustment);

        // Return adjusted amount
        return $amount;
    }

    /**
     * Apply adjustment to cart item
     *
     * @access public
     * @param array $adjustment
     * @param object $cart
     * @param string $cart_item_key
     * @return void
     */
    public function apply_adjustment($adjustment, $cart, $cart_item_key)
    {
        // Get base price
        if (isset($cart->cart_contents[$cart_item_key]['rp_wcdpd_data']['initial_price'])) {

            // Use actual price since previous pricing method already adjusted it
            $base_price = RightPress_WC_Legacy::product_get_price($cart->cart_contents[$cart_item_key]['data']);
        }
        else {

            // Get base price from product
            $base_price = RP_WCDPD_Pricing::get_product_base_price($cart->cart_contents[$cart_item_key]['data']);

            // Get initial price
            $initial_price = apply_filters('rp_wcdpd_product_pricing_initial_price', $base_price, $cart->cart_contents[$cart_item_key]);

            // Set initial cart item price
            $cart->cart_contents[$cart_item_key]['rp_wcdpd_data']['initial_price'] = RP_WCDPD_WC_Cart::get_cart_item_price_for_display($cart->cart_contents[$cart_item_key], $initial_price);
        }

        // Get adjusted amount
        $adjusted_amount = $this->get_adjusted_amount($adjustment['rule'], $base_price, $cart->cart_contents[$cart_item_key]['quantity'], $adjustment);

        // Set adjusted amount to cart item
        RightPress_WC_Legacy::product_set_price($cart->cart_contents[$cart_item_key]['data'], RP_WCDPD_Pricing::round($adjusted_amount));

        // Set extra data
        $cart->cart_contents[$cart_item_key]['rp_wcdpd_data']['adjustments'][$adjustment['rule']['uid']] = array();
    }




}
}
