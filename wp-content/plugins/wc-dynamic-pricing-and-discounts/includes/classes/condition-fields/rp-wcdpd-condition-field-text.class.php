<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Condition_Field')) {
    include_once('rp-wcdpd-condition-field.class.php');
}

/**
 * Condition Field Group: Text
 *
 * @class RP_WCDPD_Condition_Field_Text
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Condition_Field_Text')) {

abstract class RP_WCDPD_Condition_Field_Text extends RP_WCDPD_Condition_Field
{

    /**
     * Display field
     *
     * @access public
     * @param string $context
     * @return void
     */
    public function display($context)
    {
        RP_WCDPD_Form::text($this->get_field_attributes($context));
    }

    /**
     * Get placeholder
     *
     * @access public
     * @return string
     */
    public function get_placeholder()
    {
        return __('value', 'rp_wcdpd');
    }

    /**
     * Sanitize field value
     *
     * @access public
     * @param array $posted
     * @param array $condition
     * @param string $method_option_key
     * @return mixed
     */
    public function sanitize($posted, $condition, $method_option_key)
    {
        if (isset($posted[$this->key])) {
            return (string) $posted[$this->key];
        }

        return null;
    }





}
}
