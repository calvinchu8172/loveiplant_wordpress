<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Condition_Field_Select')) {
    include_once('rp-wcdpd-condition-field-select.class.php');
}

/**
 * Condition Field: Select - Time
 *
 * @class RP_WCDPD_Condition_Field_Select_Time
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Condition_Field_Select_Time')) {

class RP_WCDPD_Condition_Field_Select_Time extends RP_WCDPD_Condition_Field_Select
{
    protected $key = 'time';

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
        $this->hook();
    }

    /**
     * Get options
     *
     * @access public
     * @return array
     */
    public function get_options()
    {
        return RightPress_Helper::get_hour_list();
    }

    /**
     * Validate field value
     *
     * @access public
     * @param array $posted
     * @param array $condition
     * @param string $method_option_key
     * @return bool
     */
    public function validate($posted, $condition, $method_option_key)
    {
        $times = $this->get_options();
        return isset($posted[$this->key]) && isset($times[$posted[$this->key]]);
    }





}

RP_WCDPD_Condition_Field_Select_Time::get_instance();

}
