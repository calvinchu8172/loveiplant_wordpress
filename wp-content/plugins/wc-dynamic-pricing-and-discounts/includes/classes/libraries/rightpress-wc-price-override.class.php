<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Parent class for classes overriding WooCommerce product prices in store
 *
 * @class RightPress_WC_Price_Override
 * @package WooCommerce Dynamic Pricing & Discounts
 * @author RightPress
 */
if (!class_exists('RightPress_WC_Price_Override')) {

abstract class RightPress_WC_Price_Override
{
    protected $hook_removed         = null;
    protected $price_type           = null;
    protected $calculating_prices   = false;
    protected $observed_prices      = array();
    protected $store_on_shutdown    = false;

    private $price_cache = array(
        'price'         => array(),
        'regular_price' => array(),
        'sale_price'    => array(),
    );

    /**
     * Constructor class
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        // Set up price hooks
        $this->add_all_price_hooks();

        // Invalidate outdated WooCommerce variation price sets when plugin settings change
        add_filter('woocommerce_get_variation_prices_hash', array($this, 'invalidate_outdated_variation_prices'));
    }

    /**
     * Add all price hooks
     *
     * @access public
     * @return void
     */
    public function add_all_price_hooks()
    {
        foreach ($this->get_all_price_hooks() as $hook_data) {
            if (!isset($hook_data['wc_version']) || ($hook_data['wc_version'] === '>=3.0' && RightPress_Helper::wc_version_gte('3.0')) || ($hook_data['wc_version'] === '<3.0' && !RightPress_Helper::wc_version_gte('3.0'))) {
                $this->add_price_hook($hook_data);
            }
        }
    }

    /**
     * Remove all price hooks
     *
     * @access public
     * @return void
     */
    public function remove_all_price_hooks()
    {
        foreach ($this->get_all_price_hooks() as $hook_data) {
            if (!isset($hook_data['wc_version']) || ($hook_data['wc_version'] === '>=3.0' && RightPress_Helper::wc_version_gte('3.0')) || ($hook_data['wc_version'] === '<3.0' && !RightPress_Helper::wc_version_gte('3.0'))) {
                $this->remove_price_hook($hook_data);
            }
        }
    }

    /**
     * Add single price hook
     *
     * @access public
     * @param array $hook_data
     * @return void
     */
    public function add_price_hook($hook_data)
    {
        add_filter($hook_data['name'], $hook_data['callback'], $hook_data['priority'], $hook_data['accepted_args']);
    }

    /**
     * Remove single price hook
     *
     * @access public
     * @param array $hook_data
     * @return void
     */
    public function remove_price_hook($hook_data)
    {
        remove_filter($hook_data['name'], $hook_data['callback'], $hook_data['priority']);
    }

    /**
     * Add previously removed price hook
     *
     * @access public
     * @return void
     */
    public function add_current_price_hook()
    {
        if ($this->hook_removed) {
            $hook_data = $this->get_price_hook($this->hook_removed);
            $this->add_price_hook($hook_data);
            $this->hook_removed = null;
        }
    }

    /**
     * Remove current price hook to prevent potential infinite loop
     *
     * @access public
     * @return void
     */
    public function remove_current_price_hook()
    {
        // Get current hook name
        $current_hook = current_filter();

        // Check if this is one of our price hooks
        if ($hook_data = $this->get_price_hook($current_hook)) {
            $this->remove_price_hook($hook_data);
            $this->hook_removed = $current_hook;
        }
    }

    /**
     * Get price hook by name
     *
     * @access public
     * @param string $name
     * @return mixed
     */
    public function get_price_hook($name)
    {
        // Iterate over price hooks
        foreach ($this->get_all_price_hooks() as $hook_data) {
            if ($hook_data['name'] === $name) {
                return $hook_data;
            }
        }

        return false;
    }

    /**
     * Get all price hooks
     *
     * @access public
     * @return array
     */
    public function get_all_price_hooks()
    {
        return array(
            array(
                'name'          => 'woocommerce_product_get_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_product_get_sale_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_product_get_regular_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_get_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '<3.0',
            ),
            array(
                'name'          => 'woocommerce_get_sale_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '<3.0',
            ),
            array(
                'name'          => 'woocommerce_get_regular_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '<3.0',
            ),
            array(
                'name'          => 'woocommerce_product_variation_get_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_product_variation_get_sale_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_product_variation_get_regular_price',
                'callback'      => array($this, 'maybe_change_product_price'),
                'priority'      => 10,
                'accepted_args' => 2,
                'wc_version'    => '>=3.0',
            ),
            array(
                'name'          => 'woocommerce_variation_prices_price',
                'callback'      => array($this, 'maybe_change_variation_price'),
                'priority'      => 10,
                'accepted_args' => 3,
            ),
            array(
                'name'          => 'woocommerce_variation_prices_regular_price',
                'callback'      => array($this, 'maybe_change_variation_price'),
                'priority'      => 10,
                'accepted_args' => 3,
            ),
            array(
                'name'          => 'woocommerce_variation_prices_sale_price',
                'callback'      => array($this, 'maybe_change_variation_price'),
                'priority'      => 10,
                'accepted_args' => 3,
            ),
        );
    }

    /**
     * Get current price type by filter hook
     *
     * @access public
     * @return string
     */
    public function get_current_price_type()
    {
        // Get current filter
        $current_filter = current_filter();

        // Get price type
        if (strstr($current_filter, 'regular')) {
            return 'regular_price';
        }
        else if (strstr($current_filter, 'sale')) {
            return 'sale_price';
        }
        else {
            return 'price';
        }
    }

    /**
     * Maybe change product price
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return float
     */
    public function maybe_change_product_price($price, $product)
    {
        return $this->maybe_change_price($price, $product);
    }

    /**
     * Maybe change variation price
     *
     * Only runs on WC >= 2.4.7, in older versions variation prices are processed through maybe_change_product_price()
     * Only runs on specific occasions, like when printing variable product price in product list view, otherwise price is retrieved via get_price()
     * Need to monitor further changes to WC_Product_Variable::get_variation_prices() just in case they start retrieving prices through get_price()
     *
     * @access public
     * @param float $price
     * @param object $variation
     * @param object $product
     * @return float
     */
    public function maybe_change_variation_price($price, $variation, $product)
    {
        return $this->maybe_change_price($price, $variation);
    }

    /**
     * Maybe change product or variation price
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return float
     */
    public function maybe_change_price($price, $product)
    {
        // Get product id
        $product_id = RightPress_WC_Legacy::product_get_id($product);

        // Get price type
        $this->price_type = $this->get_current_price_type();

        // Observe price at current hook position
        if ($this->calculating_prices) {
            $this->observed_prices[$product_id][$this->price_type] = $price;
            return $price;
        }

        // Skip variable products (that does not affect individual variations)
        if ($product->is_type('variable')) {
            return $price;
        }

        // Check if price can be changed for this product
        if (!$this->price_can_be_changed($product)) {
            return $price;
        }

        // Remove current price hook to prevent potential infinite loop
        // Note: Removed this for use in WCDPD, need to check if it's still needed for other plugins
        // $this->remove_current_price_hook();

        // Get cached price hash
        $hash = $this->get_cached_price_hash($price, $product);

        // Get cached price
        $adjusted_price = $this->get_cached_price($product, $hash);

        // Calculate price if not in cache
        if ($adjusted_price === false) {
            $adjusted_price = $this->get_calculated_price($product, $product_id, $hash);
        }

        // Add current price hook back
        // Note: Removed this for use in WCDPD, need to check if it's still needed for other plugins
        // $this->add_current_price_hook();

        // Return adjusted price
        return $adjusted_price;
    }

    /**
     * Get calculated price
     *
     * @access public
     * @param object $product
     * @param int $product_id
     * @param string $hash
     * @return float
     */
    public function get_calculated_price($product, $product_id, $hash)
    {
        // Add flag
        $this->calculating_prices = true;

        // Run price methods to observe prices
        $product->get_price();
        $product->get_sale_price();
        $product->get_regular_price();

        // Extract observed prices
        $_price         = $this->observed_prices[$product_id]['price'];
        $_sale_price    = $this->observed_prices[$product_id]['sale_price'];
        $_regular_price = $this->observed_prices[$product_id]['regular_price'];

        // Pick price for calculation
        if (RP_WCDPD_Settings::get('product_pricing_sale_price_handling') === 'regular' && ($_sale_price !== $_regular_price && $_sale_price !== $_regular_price)) {
            $price_for_calculation = $_regular_price;
        }
        else {
            $price_for_calculation = $_price;
        }

        // Calculate adjusted price and set it to main price
        $_price = $this->get_adjusted_price($price_for_calculation, $product);

        // Fix sale price
        $_sale_price = $_price < $_regular_price ? $_price : '';

        // Cache prices
        $this->cache_price($product, 'price', $_price, $hash);
        $this->cache_price($product, 'sale_price', $_sale_price, $hash);
        $this->cache_price($product, 'regular_price', $_regular_price, $hash);

        // Cleanup
        $this->observed_prices = array();
        $this->calculating_prices = false;

        // Return price for current request
        if ($this->price_type === 'price') {
            return $_price;
        }
        else if ($this->price_type === 'sale_price') {
            return $_sale_price;
        }
        else if ($this->price_type === 'regular_price') {
            return $_regular_price;
        }
    }

    /**
     * Check if price can be changed
     *
     * @access public
     * @param object $product
     * @return bool
     */
    public function price_can_be_changed($product)
    {
        return true;
    }

    /**
     * Get adjusted price
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return float
     */
    public function get_adjusted_price($price, $product)
    {
        return $price;
    }

    /**
     * Get cached price validation hash
     * Used to identify outdated cached prices
     *
     * @access public
     * @param float $price
     * @param object $product
     * @return string
     */
    public function get_cached_price_hash($price, $product)
    {
        return RightPress_Helper::get_hash(false, array(
            (float) $price,
            $product,
        ));
    }

    /**
     * Get valid cached price
     *
     * @access public
     * @param object $product
     * @param string $hash
     * @return mixed
     */
    public function get_cached_price($product, $hash)
    {
        // Get product id
        $product_id = RightPress_WC_Legacy::product_get_id($product);

        // Try memory first
        if (isset($this->price_cache[$this->price_type][$product_id]) && $this->price_cache[$this->price_type][$product_id]['h'] = $hash) {
            return $this->price_cache[$this->price_type][$product_id]['p'];
        }

        // Get cached price from storage
        $cached_price = RightPress_WC_Meta::product_get_meta($product, ($this->cache_prefix . '_cached_' . $this->price_type), true);

        // Check if cached price exists and is not outdated
        if (is_array($cached_price) && isset($cached_price['h']) && $cached_price['h'] === $hash) {

            // Set to memory
            $this->price_cache[$this->price_type][$product_id] = $cached_price;

            // Return cached price
            return (float) $cached_price['p'];
        }

        return false;
    }

    /**
     * Cache price
     *
     * @access public
     * @param object $product
     * @param string $price_type
     * @param float $price
     * @param string $hash
     * @return void
     */
    public function cache_price($product, $price_type, $price, $hash)
    {
        // Get product id
        $product_id = RightPress_WC_Legacy::product_get_id($product);

        // Cache price
        $this->price_cache[$price_type][$product_id] = array('p' => $price, 'h' => $hash);

        // Dump cached prices to product meta on shutdown
        if ($this->store_on_shutdown === false) {
            register_shutdown_function(array($this, 'store_cached_prices'));
            $this->store_on_shutdown = true;
        }
    }

    /**
     * Store cached prices in product meta
     *
     * @access public
     * @return void
     */
    public function store_cached_prices()
    {
        foreach ($this->price_cache as $price_type => $values) {
            foreach ($values as $product_id => $value) {
                RightPress_WC_Meta::product_update_meta_data($product_id, ($this->cache_prefix . '_cached_' . $price_type), $value);
            }
        }
    }

    /**
     * Invalidate outdated WooCommerce variation price sets when plugin settings change
     *
     * @access public
     * @param array $price_hash
     * @return array
     */
    public function invalidate_outdated_variation_prices($price_hash)
    {
        $price_hash[] = $this->get_settings_hash();
        return $price_hash;
    }



}
}
