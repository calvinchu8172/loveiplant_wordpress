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
 * Product Pricing Method: BOGO
 *
 * @class RP_WCDPD_Method_Product_Pricing_Quantity_BOGO
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Method_Product_Pricing_Quantity_BOGO')) {

abstract class RP_WCDPD_Method_Product_Pricing_Quantity_BOGO extends RP_WCDPD_Method_Product_Pricing_Quantity
{
    protected $group_key        = 'bogo';
    protected $group_position   = 40;

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
        return __('BOGO', 'rp_wcdpd');
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

        // Sort cart items by price descending so that we use more expensive items to trigger a rule and leave the cheaper ones to adjust
        $cart_items_desc = RP_WCDPD_WC_Cart::sort_cart_items_by_price($cart_items, 'descending');

        // Group cart item quantities
        $quantity_groups = $this->group_quantities($cart_items_desc, $rule);

        // Prepare target quantity group if needed
        if ($rule['bogo_receive_products'] !== 'matched') {
            $receive_quantity_group = $this->get_target_quantity_group($rule, $cart_items);
        }

        // Track cart item quantities that can no longer be considered (i.e. were either used to trigger rule or adjustment was applied to them)
        $used_quantities = array();

        // Iterate over quantity groups
        foreach ($quantity_groups as $quantity_group_key => $quantity_group) {

            // Start infinite loop to take care of repetition, will break out of it by ourselves
            while (true) {

                // Get quantities to purchase
                if ($quantities_to_purchase = $this->reserve_quantities($quantity_group, $used_quantities, $rule['bogo_purchase_quantity'], true)) {

                    // Mark quantities used temporary until we check if there are any items to be adjusted based this
                    $temporary_used_quantities = $this->merge_cart_item_quantities($used_quantities, $quantities_to_purchase);

                    // Select correct group of cart items to adjust
                    if ($rule['bogo_receive_products'] === 'matched') {
                        $quantity_group_to_adjust = $this->sort_quantity_group_by_price_ascending($quantity_group, $cart_items);
                    }
                    else {
                        $quantity_group_to_adjust = $receive_quantity_group;
                    }

                    // Get quantities to receive at adjusted price
                    if ($quantities_to_receive = $this->reserve_quantities($quantity_group_to_adjust, $temporary_used_quantities, $rule['bogo_receive_quantity'])) {

                        // Mark quantities used
                        $used_quantities = $this->merge_cart_item_quantities($temporary_used_quantities, $quantities_to_receive);

                        // Add to main array
                        $adjust = $this->merge_cart_item_quantities($adjust, $quantities_to_receive);

                        // Maybe repeat this again
                        if ($this->repeat) {
                            continue;
                        }
                    }
                }

                // This loop can only be iterated explicitly, break out of it otherwise
                break;
            }
        }

        return $adjust;
    }

    /**
     * Get other cart items to adjust
     *
     * @access public
     * @param array $rule
     * @param array $cart_items
     * @return array
     */
    public function get_target_quantity_group($rule, $cart_items)
    {
        $matched = array();

        // Condition mockup
        $multiselect_keys = array(
            'product__product'      => 'products',
            'product__variation'    => 'product_variations',
            'product__category'     => 'product_categories',
            'product__attributes'   => 'product_attributes',
            'product__tags'         => 'product_tags'
        );

        $multiselect_key = $multiselect_keys[$rule['bogo_receive_products']];

        $conditions = array(
            array(
                'type'              => $rule['bogo_receive_products'],
                'method_option'     => 'in_list',
                $multiselect_key    => $rule['bogo_' . $multiselect_key],
            ),
        );

        // Check each cart item
        foreach ($cart_items as $cart_item_key => $cart_item) {

            // Check condition against current cart item
            if (RP_WCDPD_Conditions::conditions_are_matched($conditions, array('cart_item' => $cart_item))) {
                $matched[$cart_item_key] = $cart_item['quantity'];
            }
        }

        return $matched;
    }

    /**
     * Sort quantity group by cart item prices ascending
     *
     * @access public
     * @param array $quantity_group
     * @param array $cart_items
     * @return array
     */
    public function sort_quantity_group_by_price_ascending($quantity_group, $cart_items)
    {
        return array_merge(array_flip(array_intersect(array_keys($cart_items), array_keys($quantity_group))), $quantity_group);
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

        // Get adjusted amount of single unit
        $adjusted_amount = RP_WCDPD_Pricing::adjust_amount($amount, $rule['bogo_pricing_method'], $rule['bogo_pricing_value']);

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
