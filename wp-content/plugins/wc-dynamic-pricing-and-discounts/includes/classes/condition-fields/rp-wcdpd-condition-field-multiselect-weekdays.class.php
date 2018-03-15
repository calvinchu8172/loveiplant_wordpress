<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Load dependencies
if (!class_exists('RP_WCDPD_Condition_Field_Multiselect')) {
    include_once('rp-wcdpd-condition-field-multiselect.class.php');
}

/**
 * Condition Field: Multiselect - Weekdays
 *
 * @class RP_WCDPD_Condition_Field_Multiselect_Days_Weekdays
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Condition_Field_Multiselect_Days_Weekdays')) {

class RP_WCDPD_Condition_Field_Multiselect_Days_Weekdays extends RP_WCDPD_Condition_Field_Multiselect
{
    protected $key = 'weekdays';

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
     * Load multiselect options
     *
     * @access public
     * @param array $ids
     * @param string $query
     * @return array
     */
    public function load_multiselect_options($ids = array(), $query = '')
    {
        return RightPress_Conditions_Helper::get_all_weekdays($ids, $query);
    }





}

RP_WCDPD_Condition_Field_Multiselect_Days_Weekdays::get_instance();

}
