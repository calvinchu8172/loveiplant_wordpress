<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parent method class
 *
 * @class RP_WCDPD_Method
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Method')) {

abstract class RP_WCDPD_Method extends RP_WCDPD_Item
{
    protected $item_key = 'method';

    /**
     * Get custom item properties to register
     *
     * @access public
     * @return array
     */
    public function custom_item_properties()
    {
        return array(
            'label'                         => $this->get_label(),
            'get_adjustments_callback'      => array($this, 'get_adjustments'),
            'apply_adjustment_callback'     => array($this, 'apply_adjustment'),
            'get_adjusted_amount_callback'  => array($this, 'get_adjusted_amount'),
        );
    }

    /**
     * Get adjustments
     *
     * @access public
     * @param array $rule
     * @param array $cart_items
     * @return array
     */
    public function get_adjustments($rule, $cart_items = null)
    {
        $adjustments = array();

        // Check if rule conditions are matched
        if (RP_WCDPD_Conditions::rule_conditions_are_matched($rule)) {

            // Add to adjustments array
            $adjustments[] = array(
                'rule'              => $rule,
                'reference_amount'  => $this->get_reference_amount($rule),
            );
        }

        return $adjustments;
    }

    /**
     * Get reference amount
     *
     * @access public
     * @param array $rule
     * @param float $base_amount
     * @return mixed
     */
    public function get_reference_amount($rule, $base_amount = null)
    {
        // Get base amount if not passed in
        if ($base_amount === null) {
            $base_amount = $this->get_cart_subtotal();
        }

        // Get rule selection method
        $selection_method = RP_WCDPD_Settings::get($this->context . '_rule_selection_method');

        // Calculate reference amount
        if (in_array($selection_method, array('bigger_discount', 'smaller_discount', 'bigger_fee', 'smaller_fee'), true)) {
            $reference_amount = (float) RP_WCDPD_Pricing::get_adjustment_value($rule['pricing_method'], $rule['pricing_value'], $base_amount);
            return abs($reference_amount);
        }
        // Reference amount is not needed
        else {
            return null;
        }
    }


}
}
