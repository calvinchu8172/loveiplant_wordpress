<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Methods related to scripts and stylesheets
 *
 * @class RP_WCDPD_Assets
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RP_WCDPD_Assets')) {

class RP_WCDPD_Assets
{
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
        // Enqueue frontend assets
        add_action('wp_enqueue_scripts', array('RP_WCDPD_Assets', 'enqueue_frontend_assets'));

        // Enqueue backend assets
        add_action('admin_enqueue_scripts', array('RP_WCDPD_Assets', 'enqueue_backend_assets'), 20);

        // Enqueue Select2
        add_action('init', array($this, 'enqueue_select2'), 1);
    }

    /**
     * Load frontend stylesheets
     *
     * @access public
     * @return void
     */
    public static function enqueue_frontend_assets()
    {
        global $post;

        // Checkout scripts
        if (is_checkout()) {
            wp_enqueue_script('rp-wcdpd-checkout-scripts', RP_WCDPD_PLUGIN_URL . '/assets/js/checkout.js', array(), RP_WCDPD_VERSION);
        }
    }

    /**
     * Enqueue Select2
     *
     * @access public
     * @return void
     */
    public static function enqueue_select2()
    {
        // Load backend assets conditionally
        if (!RP_WCDPD_Settings::is_settings_page()) {
            return;
        }

        // Enqueue Select2 related scripts and styles
        wp_enqueue_script('rp-wcdpd-select2-scripts', RP_WCDPD_PLUGIN_URL . '/assets/select2/js/select2.min.js', array('jquery'), '4.0.3');
        wp_enqueue_script('rp-wcdpd-select2-rp', RP_WCDPD_PLUGIN_URL . '/assets/js/rp-select2.js', array(), RP_WCDPD_VERSION);
        wp_enqueue_style('rp-wcdpd-select2-styles', RP_WCDPD_PLUGIN_URL . '/assets/select2/css/select2.min.css', array(), '4.0.3');

        // Print scripts before WordPress takes care of it automatically (helps load our version of Select2 before any other plugin does it)
        add_action('wp_print_scripts', array('RP_WCDPD_Assets', 'print_select2'));
    }

    /**
     * Print Select2 scripts
     *
     * @access public
     * @return void
     */
    public static function print_select2()
    {
        remove_action('wp_print_scripts', array('RP_WCDPD_Assets', 'print_select2'));
        wp_print_scripts('rp-wcdpd-select2-scripts');
        wp_print_scripts('rp-wcdpd-select2-rp');
    }

    /**
     * Load backend assets conditionally
     *
     * @access public
     * @return void
     */
    public static function enqueue_backend_assets()
    {
        // Load backend assets conditionally
        if (!RP_WCDPD_Settings::is_settings_page()) {
            return;
        }

        // Prepare values for JS
        $current_tab = RP_WCDPD_Settings::get_tab();

        // jQuery UI Accordion
        wp_enqueue_script('jquery-ui-accordion');

        // jQuery UI Sortable
        wp_enqueue_script('jquery-ui-sortable');

        // jQuery UI Datepicker
        wp_enqueue_script('jquery-ui-datepicker');

        // jQuery UI Tooltip
        wp_enqueue_script('jquery-ui-tooltip');

        // Rules page
        if (in_array($current_tab, array('product_pricing', 'cart_discounts', 'checkout_fees'), true)) {
            wp_enqueue_script('rp-wcdpd-rules-scripts', RP_WCDPD_PLUGIN_URL . '/assets/js/rules.js', array('jquery'), RP_WCDPD_VERSION);
            wp_enqueue_script('rp-wcdpd-rules-validation-scripts', RP_WCDPD_PLUGIN_URL . '/assets/js/rules-validation.js', array('jquery'), RP_WCDPD_VERSION);
        }

        // Settings page
        if (in_array($current_tab, array('promo', 'settings'), true)) {
            wp_enqueue_script('rp-wcdpd-settings-scripts', RP_WCDPD_PLUGIN_URL . '/assets/js/settings.js', array('jquery'), RP_WCDPD_VERSION);
        }

        // Backend styles
        wp_enqueue_style('rp-wcdpd-settings-styles', RP_WCDPD_PLUGIN_URL . '/assets/css/settings.css', array(), RP_WCDPD_VERSION);

        // jQuery UI Datepicker styles
        self::enqueue_or_inject_stylesheet('rp-wcdpd-jquery-ui-styles', RP_WCDPD_PLUGIN_URL . '/assets/jquery-ui/jquery-ui.min.css', '1.11.4');

        // jQuery UI Datepicker language file
        $locale = RightPress_Helper::get_optimized_locale('mixed');
        if (file_exists(RP_WCDPD_PLUGIN_PATH . 'assets/jquery-ui/i18n/datepicker-' . $locale . '.js')) {
            wp_enqueue_script('rp-wcdpd-jquery-ui-language', RP_WCDPD_PLUGIN_URL . '/assets/jquery-ui/i18n/datepicker-' . $locale . '.js', array('jquery-ui-datepicker'), RP_WCDPD_VERSION);
        }

        if ($current_tab === 'cart_discounts') {
            $row_note_placeholder = __('Cart Discount', 'rp_wcdpd');
        }
        else if ($current_tab === 'checkout_fees') {
            $row_note_placeholder = __('Checkout Fee', 'rp_wcdpd');
        }
        else {
            $row_note_placeholder = __('Pricing Rule', 'rp_wcdpd');
        }

        // Pass variables to settings JS UI
        wp_localize_script('rp-wcdpd-settings-scripts', 'rp_wcdpd', array(
            'ajaxurl'       => RP_WCDPD_Ajax::get_url(),
            'current_tab'   => $current_tab,
        ));

        // Pass variables to rules JS UI
        wp_localize_script('rp-wcdpd-rules-scripts', 'rp_wcdpd', array(
            'ajaxurl'           => RP_WCDPD_Ajax::get_url(),
            'current_tab'       => $current_tab,
            'config'            => array(
                'decimal_support'   => !!RP_WCDPD_Settings::get('decimal_quantities'),
            ),
            'datepicker_config' => RP_WCDPD_Assets::get_datepicker_config(),
            'labels'            => array(
                'select2_placeholder'   => __('Select values', 'rp_wcdpd'),
                'select2_no_results'    => __('No results found', 'rp_wcdpd'),
                'row_note_placeholder'  => '<span style="color: #cccccc;">' . $row_note_placeholder . '</span>',
            ),
            'error_messages'    => array(
                'generic_error'                     => __('Error: Please fix this element.', 'rp_wcdpd'),
                'required'                          => __('Value is required.', 'rp_wcdpd'),
                'number_natural'                    => __('Value must be positive.', 'rp_wcdpd'),
                'number_min_0'                      => __('Value must be positive.', 'rp_wcdpd'),
                'number_min_1'                      => __('Value must be greater than or equal to 1.', 'rp_wcdpd'),
                'number_whole'                      => __('Value must be a whole number.', 'rp_wcdpd'),
                'no_quantity_ranges'                => __('At least one quantity range is required for this pricing rule.', 'rp_wcdpd'),
                'no_group_products'                 => __('At least one product must be added to a group.', 'rp_wcdpd'),
                'no_conditions'                     => __('At least one condition is required for this rule.', 'rp_wcdpd'),
                'quantity_ranges_from_more_than_to' => __('Closing quantity must not be lower than opening quantity.', 'rp_wcdpd'),
                'quantity_ranges_last_to_open'      => __('Quantity range cannot be left open when adding subsequent quantity ranges.', 'rp_wcdpd'),
                'quantity_ranges_last_from_higher'  => __('Quantity range must start with a higher value than previous quantity range.', 'rp_wcdpd'),
                'quantity_ranges_overlap'           => __('Quantity ranges must not overlap.', 'rp_wcdpd'),
            ),
        ));
    }

    /**
     * Inject or enqueue stylesheet depending on wether or not it's too late
     * to print them in the head section
     *
     * @access public
     * @param string $handle
     * @param string $url
     * @param string $version
     * @return void
     */
    public static function enqueue_or_inject_stylesheet($handle, $url, $version)
    {
        // Enqueue in a regular fashion
        if (!did_action('wp_print_styles')) {
            wp_enqueue_style($handle, $url, array(), $version);
        }
        // Inject via Javascript
        else {
            self::inject_stylesheet($url, $version);
        }
    }

    /**
     * Inject stylesheet into head section from within body
     *
     * @access public
     * @param string $url
     * @param string $version
     * @return void
     */
    public static function inject_stylesheet($url, $version = null)
    {
        // Append version
        if ($version !== null) {
            $url .= '?ver=' . $version;
        }

        $script = "jQuery('<link>').appendTo('head').attr({type: 'text/css', rel: 'stylesheet'}).attr('href', '{$url}');";
        echo '<script type="text/javascript" style="display: none;">' . $script . '</script>';
    }

    /**
     * Get jQuery UI Datepicker config
     *
     * @access public
     * @param string $context
     * @return array
     */
    public static function get_datepicker_config()
    {
        return apply_filters('rp_wcdpd_datepicker_config', array(
            'dateFormat' => 'yy-mm-dd',
        ));
    }




}

RP_WCDPD_Assets::get_instance();

}
