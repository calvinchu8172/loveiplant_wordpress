<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Method_Product_Pricing_Quantity')) {
    include_once('rp-wcdpd-method-product-pricing-quantity.class.php');
}

/**
 * Product Pricing Method: Group
 *
 * @class RP_WCDPD_Method_Product_Pricing_Quantity_Group
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Method_Product_Pricing_Quantity_Group')) {

abstract class RP_WCDPD_Method_Product_Pricing_Quantity_Group extends RP_WCDPD_Method_Product_Pricing_Quantity
{
    protected $group_key        = 'group';
    protected $group_position   = 30;

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
        return __('Group', 'rp_wcdpd');
    }

    /**
     * Get cart items with quantities to adjust
     *
     * @access public
     * @param array $rule
     * @param array $cart_items
     * @return array
     */
    public function get_cart_items_to_adjust($rule, $cart_items = null)
    {
        $adjust = array();

        // Group cart item quantities
        $quantity_groups = $this->group_quantities($cart_items, $rule);
        $untouched_items = $quantity_groups;

        // Start infinite loop to take care of rule repetition, will break out of it by ourselves
        while (true) {

            // Store reserved quantities in a separate array temporary until we are sure that all group products have sufficient quantities
            $current = array();

            // Track cart item quantities that can no longer be considered
            $used_quantities = $adjust;

            // Iterate over quantity groups
            foreach ($quantity_groups as $quantity_group_key => $quantity_group) {

                // Reserve quantities for this quantity group
                if ($reserved_quantities = $this->reserve_quantities($quantity_group, $used_quantities, $rule['group_products'][$quantity_group_key]['quantity'], true)) {

                    // Add to used quantities array
                    $used_quantities = $this->merge_cart_item_quantities($used_quantities, $reserved_quantities);

                    // Add to current array
                    $current = $this->merge_cart_item_quantities($current, $reserved_quantities);

                    // Remove items from untouched items array
                    foreach ($untouched_items as $untouched_item_key => $untouched_item) {

                        if ($untouched_item === null) {
                            unset($untouched_items[$untouched_item_key]);
                            continue;
                        }

                        foreach ($untouched_item as $cart_item_key => $quantity) {
                            if (isset($reserved_quantities[$cart_item_key])) {
                                unset($untouched_items[$untouched_item_key][$cart_item_key]);
                            }
                        }

                        if (isset($untouched_items[$untouched_item_key]) && empty($untouched_items[$untouched_item_key])) {
                            unset($untouched_items[$untouched_item_key]);
                        }
                    }
                }
                // At least one product missing
                else {

                    // Void current array
                    $current = array();

                    // Clear untouched items array
                    $untouched_items = array();

                    // Do not check other group products
                    break;
                }
            }

            // Check if full group of products was made up
            if (!empty($current)) {

                // Add to main array
                $adjust = $this->merge_cart_item_quantities($adjust, $current);

                // Rule repetition is enabled
                if ($this->repeat) {
                    continue;
                }
                // We still have untouched items (e.g. we need to repeat in case repetition is disabled, the group is "3 of any" and we have 3 x AAA and 3 x BBB in cart)
                else if (!empty($untouched_items)) {
                    continue;
                }
            }

            // This loop can only be iterated explicitly, break out of it otherwise
            break;
        }

        return $adjust;
    }

    /**
     * Group quantities of matching cart items for Group rules
     *
     * @access public
     * @param array $cart_items
     * @param array $rule
     * @return array
     */
    public function group_quantities($cart_items, $rule)
    {
        $quantities = array();

        // Iterate over group products
        foreach ($rule['group_products'] as $group_product_key => $group_product) {

            $match_found = false;

            // Iterate over cart items
            foreach ($cart_items as $cart_item_key => $cart_item) {

                // Check condition against current cart item
                if (RP_WCDPD_Conditions::conditions_are_matched(array($group_product), array('cart_item' => $cart_item))) {

                    // Add to main array
                    $quantities[$group_product_key][$cart_item_key] = $cart_item['quantity'];
                    $match_found = true;
                }
            }

            // Match not found
            if (!$match_found) {
                $quantities[$group_product_key] = null;
            }
        }

        // Return quantities
        return $quantities;
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
        // Get adjusted quantity
        $quantity_adjusted = !empty($adjustment['receive_quantity']) ? (int) $adjustment['receive_quantity'] : 1;

        // Special handling - pricing is set per group
        if (in_array($rule['group_pricing_method'], array('discount__amount_per_group', 'fixed__price_per_group'), true)) {

            // Get total quantity of all items in this group
            $all_item_quantity = 0;

            foreach ($rule['group_products'] as $group_product) {
                $all_item_quantity += $group_product['quantity'];
            }

            // Get pricing value
            $pricing_value = RightPress_Helper::get_amount_in_currency($rule['group_pricing_value']);

            // Get adjusted amount based on pricing method
            if ($rule['group_pricing_method'] === 'discount__amount_per_group') {
                $adjusted_amount = ($amount - ($pricing_value / $all_item_quantity));
                $adjusted_amount = (float) ($adjusted_amount >= 0 ? $adjusted_amount : 0);
            }
            else if ($rule['group_pricing_method'] === 'fixed__price_per_group') {
                $adjusted_amount = (float) ($pricing_value / $all_item_quantity);
            }
        }
        // Regular handling
        else {
            $adjusted_amount = RP_WCDPD_Pricing::adjust_amount($amount, $rule['group_pricing_method'], $rule['group_pricing_value']);
        }

        // Round adjusted amount to get predictable results
        $adjusted_amount = RP_WCDPD_Pricing::round($adjusted_amount);

        // Get average amount including non-adjusted units
        $average_amount = (($adjusted_amount * $quantity_adjusted) + (($total_quantity - $quantity_adjusted) * $amount)) / $total_quantity;

        // Round average amount to get predictable results
        $average_amount = RP_WCDPD_Pricing::round($average_amount);

        // Return average price
        return $average_amount;
    }


}
}
