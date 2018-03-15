<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Method_Product_Pricing')) {
    include_once('rp-wcdpd-method-product-pricing.class.php');
}

/**
 * Product Pricing Method: Volume
 *
 * @class RP_WCDPD_Method_Product_Pricing_Volume
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Method_Product_Pricing_Volume')) {

abstract class RP_WCDPD_Method_Product_Pricing_Volume extends RP_WCDPD_Method_Product_Pricing
{
    protected $group_key        = 'volume';
    protected $group_position   = 20;

    /**
     * Constructor class
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->hook_group();
    }

    /**
     * Get group label
     *
     * @access public
     * @return string
     */
    public function get_group_label()
    {
        return __('Volume', 'rp_wcdpd');
    }

    /**
     * Get cart item adjustments by rule
     *
     * @access public
     * @param array $rule
     * @param array $cart_items
     * @return array
     */
    public function get_adjustments($rule, $cart_items = null)
    {
        $adjustments = array();

        // No quantity ranges defined
        if (empty($rule['quantity_ranges'])) {
            return $adjustments;
        }

        // Get cart item quantities allocated to quantity ranges
        $allocated_quantities = $this->get_quantities_allocated_to_quantity_ranges($cart_items, $rule);

        // Iterate over cart items
        foreach ($cart_items as $cart_item_key => $cart_item) {

            // Check if rule applies to current cart item
            // Note: conditions are not checked here as they were checked when fetching applicable quantity ranges, if cart item is not there - conditions do not match
            if (!RP_WCDPD_Controller_Methods_Product_Pricing::is_already_processed($rule['uid'], $cart_item_key) && isset($allocated_quantities[$cart_item_key])) {

                // Get product base price
                $base_price = RP_WCDPD_Pricing::get_product_base_price($cart_item['data']);

                // Add adjustment to main array
                $adjustments[$cart_item_key] = array(
                    'rule'              => $rule,
                    'quantity_ranges'   => $allocated_quantities[$cart_item_key],
                    'reference_amount'  => $this->get_reference_amount($rule, $base_price, $cart_item['quantity'], array('quantity_ranges' => $allocated_quantities[$cart_item_key])),
                );
            }
        }

        return $adjustments;
    }

    /**
     * Get cart item quantities allocated to quantity ranges
     *
     * @access public
     * @param array $cart_items
     * @param array $rule
     * @return array
     */
    public function get_quantities_allocated_to_quantity_ranges($cart_items, $rule)
    {
        $ranges = array();

        // Group quantities
        $quantity_groups = $this->group_quantities($cart_items, $rule);

        // Iterate over quantity groups
        foreach ($quantity_groups as $quantity_group_key => $quantity_group) {

            // Get matching quantity range keys with allocated cart item quantities
            $quantity_range_keys_with_quantities = $this->get_quantity_ranges_with_allocated_quantities($rule, $quantity_group);

            // Iterate over quantity range keys with quantities
            foreach ($quantity_range_keys_with_quantities as $quantity_range_key => $cart_items_with_quantities) {

                // Iterate over cart items with quantities
                foreach ($cart_items_with_quantities as $cart_item_key => $quantity) {
                    $ranges[$cart_item_key][$quantity_range_key] = $quantity;
                }
            }
        }

        return $ranges;
    }

    /**
     * Get adjusted amount
     *
     * @access public
     * @param array $rule
     * @param float $base_amount
     * @param int $cart_item_quantity
     * @param array $adjustment
     * @return float
     */
    public function get_adjusted_amount($rule, $base_amount, $cart_item_quantity = 1, $adjustment = array())
    {
        $total_amount   = 0;
        $total_quantity = 0;

        // Iterate over quantity ranges
        foreach ($adjustment['quantity_ranges'] as $quantity_range_key => $quantity) {

            // Reference quantity range
            $quantity_range = $rule['quantity_ranges'][$quantity_range_key];

            // Add amount and quantity
            $total_amount   += (RP_WCDPD_Pricing::adjust_amount($base_amount, $quantity_range['pricing_method'], $quantity_range['pricing_value']) * $quantity);
            $total_quantity += $quantity;
        }

        // Some quantity units may not be adjusted in case of tiered pricing
        if ($cart_item_quantity > $total_quantity) {

            // Check how many units are missing
            $missing_quantity = $cart_item_quantity - $total_quantity;

            // Add missing quantity
            $total_amount   += ($base_amount * $missing_quantity);
            $total_quantity += $missing_quantity;
        }

        // Return reference amount
        return (float) ($total_quantity > 0 ? ($total_amount / $total_quantity) : 0);
    }


}
}
