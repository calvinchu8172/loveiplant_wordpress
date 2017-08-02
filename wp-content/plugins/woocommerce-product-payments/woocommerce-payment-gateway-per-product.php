<?php
/**
 * Plugin Name: Woocommerce Payment Gateway Per Product
 * Plugin URI: https://www.dreamfoxmedia.com/shop/plugins/woocommerce-payment-gateway-per-product-premium/
 * Version: 2.0.0
 * Author: Dreamfox Media
 * Author URI: www.dreamfoxmedia.com 
 * Description: Extend Woocommerce plugin to add payments methods to a product
 * Requires at least: 3.7
 * Tested up to: 4.8
 * Text Domain: dfm-wcpgpp-f
 * Domain Path: /languages
 * @Developer : Anand Rathi / Hoang Xuan Hao / Marco van Loghum Slaterus
 */
 if( !defined('ABSPATH') ){ exit();}
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}
/**
 * For multi Network
 */
if (!function_exists('is_plugin_active_for_network')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}
/**
 * Check is paid plugin is installed then we not activate this
 */
if (is_plugin_active('woocommerce-product-payments-premium/woocommerce-product-payments-premium.php')) {
    add_action('admin_notices', 'dreamfox_wcpgppf_wpp_activation_notice');
    function dreamfox_wcpgppf_wpp_activation_notice() {
    echo '<div class="error notice is-dismissible"><p><strong>';
    _e( 'Woocommerce Payment Gateway Per Product Premium', 'dfm-wcpgpp-f' );
	echo '</strong>';
	_e( 'plugin is activate so free plugin will not work.', 'dfm-wcpgpp-f' );
    echo '</p></div>';    
    }
    deactivate_plugins(__FILE__);
}
/**
 * Check if WooCommerce is active
 */
if (!is_plugin_active('woocommerce-product-payments-premium/woocommerce-product-payments-premium.php') && in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	add_action('admin_enqueue_scripts', 'dreamfox_wcpgppf_product_payments_enqueue');
    add_action('admin_menu', 'dreamfox_wcpgppf_product_payments_submenu_page');
	
    function dreamfox_wcpgppf_product_payments_enqueue() {
        wp_enqueue_style('dreamfox_wcpgppf_pd_payments_enqueue', plugin_dir_url(__FILE__) . '/css/style.css');
    }
    function dreamfox_wcpgppf_product_payments_submenu_page() {
        add_submenu_page('woocommerce', __('Product Payments', 'dreamfox_wcpgppf'), __('Product Payments', 'dreamfox_wcpgppf'), 'manage_options', 'dreamfox_wcpgppf-product-payments', 'dreamfox_wcpgppf_product_payments_settings');
    }
    function dreamfox_wcpgppf_product_payments_footer_text($text) {
        if (!empty($_GET['page']) && strpos($_GET['page'], 'dreamfox_wcpgppf-product-payments') === 0) {
            $text = sprintf(__( 'If you enjoy using <strong>Woocommerce Payments Gateway per Product</strong>, please <a href="%s" target="_blank">leave us a ★★★★★ rating</a>. A <strong style="text-decoration: underline;">huge</strong> thank you in advance!', 'dfm-wcpgpp-f' ), 'https://wordpress.org/support/view/plugin-reviews/woocommerce-product-payments' );
        }
        return $text;
    }
    function dreamfox_wcpgppf_product_payments_update_footer($text) {
        if (!empty($_GET['page']) && strpos($_GET['page'], 'dreamfox_wcpgppf-product-payments') === 0) {
            $text = 'Version 2.0';
        }
        return $text;
    }
     function dreamfox_wcpgppf_product_payments_settings() {
        add_filter('admin_footer_text', 'dreamfox_wcpgppf_product_payments_footer_text');
        add_filter('update_footer', 'dreamfox_wcpgppf_product_payments_update_footer');
        echo '<div class="wrap "><div id="icon-tools" class="icon32"></div>';
        echo '<h2 style="padding-bottom:15px; margin-bottom:20px; border-bottom:1px solid #ccc">' . __('Woocommerce Payment Gateway per Product', 'dreamfox_wcpgppf') . '</h2>';
		echo '<div class="left-mc-setting">';
		_e( 'This plugin for WooCommerce Payment Gateway per Product lets you select the available payment method for each individual product. This plugin will allow the admin to select the available payment gateway for each individual product. Admin can select for each individual product the payment gateway that will be used by checkout. If no selection is made, then the default payment gateways are displayed. If you for example only select paypal then only paypal will available for that product by checking out.', 'dfm-wcpgpp-f' );
		_e( '<p>This version is for small shops with maximal <b>2 categories<b>.<br>For a really small fee of 19,95 you can get the Premium version with <a href="https://www.dreamfoxmedia.com/shop/plugins/woocommerce-payment-gateway-per-product-premium#utm_source=plugin&utm_medium=unlimited_cats&utm_campaign=dfm-wcpgpp-f">Unlimited Categories</a>!</p>', 'dfm-wcpgpp-f' );
		/** Show options  */
        dreamfox_wcpgppf_sdwpp_plugin_settings();           			
		/** End show options  */
		echo '</div><div class="right-mc-setting"><div style="border: 5px dashed #B0E0E6; padding: 0 20px; background: white;">';
		_e( '<h3>WooCommerce Payment per Product Premium</h3><p>This plugin has a Premium version with More Features. <a href="https://www.dreamfoxmedia.com/shop/plugins/woocommerce-payment-gateway-per-product-premium#utm_source=plugin&utm_medium=premium_right&utm_campaign=dfm-wcpgpp-f">Have a look at its benefits</a>!</p></div>', 'dfm-wcpgpp-f' );
		$current_user = wp_get_current_user(); 
		$nlurl = plugin_dir_url(__FILE__);
        $nlimageurl = $nlurl.'images/newsletter-button.png';
		$helpimageurl = $nlurl.'images/Need-Help.png';
		

            /** Begin Newsletter Signup Form */
				echo '<br><hr><img src="'.$nlimageurl.'" alt="newsletter-button"><label for="mce-EMAIL">';
				_e( 'Stay informed when new features or updates are available!<br>Subscribe to our mailinglist below:', 'dfm-wcpgpp-f' );
				echo '</label><iframe width="100%" height="85" allowTransparency="true" frameborder="0" scrolling="no" style="border:none" src="https://www.dreamfoxmedia.com/wp-content/plugins/mailster/form.php?id=3"></iframe>';
			/** End Newsletter Signup Form */	
		
			
			/**Begin Paypal donation Form */	
                echo '<form style="text-align:center; border-bottom:1px solid #ccc; border-top:1px solid #ccc; padding:20px 0; margin:20px 0;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">';
                _e( '<center>Like this product we’ve made and want to contribute to its future development? Donate however much you’d like with the below donate button.<br><br></center>', 'dfm-wcpgpp-f' );  
                echo '<input type="hidden" name="cmd" value="_s-xclick">';
                echo '<input type="hidden" name="hosted_button_id" value="UNTLWQSLRH85U">';
                echo '<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">';
                echo '<img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">';
                echo '</form></div>';
		    /** End Paypal donation Form */	
			
            /** Begin help section */			
				echo '<img src="'.$helpimageurl.'" alt="help-button"><p>';
				_e( 'Below you will find the top 5 questions in our FAQ. Maybe they can help you in the right direction.', 'dfm-wcpgpp-f' );
                ?>
				<ul class="ul-square">
                    <li><a href="https://www.dreamfoxmedia.com/ufaqs/plugin-not-working#utm_source=plugin&utm_medium=faq_link&utm_campaign=dfm-wcpgpp-f"><?php echo __('The plugin is not working', 'dfm-wcpgpp-f'); ?></a></li>
                    <li><a href="https://www.dreamfoxmedia.com/ufaqs/can-select-2-categories#utm_source=plugin&utm_medium=faq_link&utm_campaign=dfm-wcpgpp-f"><?php echo __('I can only select 2 categories', 'dfm-wcpgpp-f'); ?></a></li>
                    <li><a href="https://www.dreamfoxmedia.com/ufaqs/can-set-different-payments-methods#utm_source=plugin&utm_medium=faq_link&utm_campaign=dfm-wcpgpp-f"><?php echo __('Where can I set different payments methods?', 'dfm-wcpgpp-f'); ?></a></li>
                    <li><a href="https://www.dreamfoxmedia.com/ufaqs/video-instructions#utm_source=plugin&utm_medium=faq_link&utm_campaign=dfm-wcpgpp-f"><?php echo __('Video Instructions', 'dfm-wcpgpp-f'); ?></a></li>
                    <li><a href="https://www.dreamfoxmedia.com/faq-woocommerce-payment-gateway-per-product-free-version#utm_source=plugin&utm_medium=faq_link&utm_campaign=dfm-wcpgpp-f"><?php echo __('See here the complete FAQ', 'dfm-wcpgpp-f'); ?></a></li>
				</ul>
                <p><?php echo sprintf(__('If your answer can not be found in the resources listed above, please use our support from on <a href="%s" target="_new">dreamfoxmedia.com</a>.'), 'https://www.dreamfoxmedia.com/support-request-free-plugins/'); ?></p>
        </div>
		<?php
			/** End help section */
				
        
    }
    add_action('add_meta_boxes', 'wpp_meta_box_add');
    function wpp_meta_box_add() {
        global $post;
        if (isset($post->ID) && is_product_eligible($post->ID)) {
            add_meta_box('payments', 'Payments', 'wpp_payments_form', 'product', 'side', 'core');
        }
    }
    /**
     * 
     * @global type $post
     * @global WC_Payment_Gateways $woo
     * @return type
     */
    function wpp_payments_form() {
        global $post, $woo;
        $html ='';
        $productIds = get_option('woocommerce_product_apply', array());
        if (is_array($productIds)) {
            foreach ($productIds as $key => $product) {
                if (!get_post($product) || !count(get_post_meta($product, 'payments', true))) {
                    unset($productIds[$key]);
                }
            }
        }
        update_option('woocommerce_product_apply', $productIds);
        $postPayments = get_post_meta($post->ID, 'payments', true) ? get_post_meta($post->ID, 'payments', true) : array();
        $woo = new WC_Payment_Gateways();
        $payments = $woo->payment_gateways;
        foreach ($payments as $pay) {
            /**
             *  skip if payment in disbled from admin
             */
            if ($pay->enabled == 'no') {
                continue;
            }
            $checked = '';
            if (is_array($postPayments) && in_array($pay->id, $postPayments)) {
                $checked = ' checked="yes" ';
            }
            $html .=' 
            <input type="checkbox" '.$checked.' value="'.$pay->id.'" name="pays[]" id="payment_'.$pay->id.' />
            <label for="payment_'.$pay->id.'">'.$pay->title.'</label> 
            <br /> ';
        }
    echo $html;
  }
    add_action('save_post', 'wpp_meta_box_save', 10, 2);
    /**
     * 
     * @param type $post_id
     * @param type $post
     * @return type
     */
    function wpp_meta_box_save($post_id, $post) {
        // Restrict to save for autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        // Restrict to save for revisions
        if (isset($post->post_type) && $post->post_type == 'revision') {
            return $post_id;
        }
        if (isset($_POST['post_type']) && $_POST['post_type'] == 'product' && isset($_POST['pays'])) {
            $productIds = get_option('woocommerce_product_apply', array());
            if (is_array($productIds) && !in_array($post_id, $productIds)) {
                $productIds[] = $post_id;
                update_option('woocommerce_product_apply', $productIds);
            }
            //delete_post_meta($post_id, 'payments');    
            $payments = array();
            if ($_POST['pays']) {
                foreach ($_POST['pays'] as $pay) {
                    $payments[] = $pay;
                }
            }
            update_post_meta($post_id, 'payments', $payments);
        } elseif (isset($_POST['post_type']) && $_POST['post_type'] == 'product') {
            update_post_meta($post_id, 'payments', array());
        }
    }
    /**
     * 
     * @global type $woocommerce
     * @param type $available_gateways
     * @return type
     */
    function wpppayment_gateway_disable_country($available_gateways) {
        global $woocommerce;
        $arrayKeys = array_keys($available_gateways);
        /**
         * default setting
         */
        $dreamfox_wcpgppf_wpp_plugin_settings = get_option('sdwpp_plugin_settings', array('default_payment' => ''));
        $default_payment = $dreamfox_wcpgppf_wpp_plugin_settings['default_payment'];
        $is_default_pay_needed = false;
        /**
         * checking all cart products
         */
        if (count($woocommerce->cart)) {
            $items = $woocommerce->cart->cart_contents;
            $itemsPays = '';
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (!is_product_eligible($item['product_id'])) {
                        continue;
                    }
                    $itemsPays = get_post_meta($item['product_id'], 'payments', true);
                    if (is_array($itemsPays) && count($itemsPays)) {
                        foreach ($arrayKeys as $key) {
                            if (array_key_exists($key, $available_gateways) && !in_array($available_gateways[$key]->id, $itemsPays)) {
                                if ($default_payment == $key) {
                                    $is_default_pay_needed = true;
                                    $default_payment_obj = $available_gateways[$key];
                                    unset($available_gateways[$key]);
                                } else {
                                    unset($available_gateways[$key]);
                                }
                            }
                        }
                    }
                }
            }
            /**
             * set default payment if there is none
             */
            if ($is_default_pay_needed && count($available_gateways) == 0) {
                $available_gateways[$default_payment] = $default_payment_obj;
            }
        }
        return $available_gateways;
    }
    add_filter('woocommerce_available_payment_gateways', 'wpppayment_gateway_disable_country');
    function dreamfox_wcpgppf_get_category_ul($categories, $selected_cats, $class, $parent_id, $id = '', $name = '') {
        if ($parent_id > 0) {
            ?>
            <optgroup label="<?php echo $name; ?>">
            <?php
        }
        foreach ($categories[$parent_id] as $data) {
            $child_id = $data->term_taxonomy_id;
            ?>
                <option value="<?php echo $data->term_taxonomy_id; ?>" <?php if (in_array($data->term_taxonomy_id, $selected_cats)) { ?> selected="selected" <?php } ?>><?php echo $data->name; ?></option>
                <?php
            if (isset($categories[$child_id])) {
                dreamfox_wcpgppf_get_category_ul($categories, $selected_cats, 'children', $child_id, '', $data->name);
            }
        }
        if ($parent_id > 0) {
            echo '</optgroup>';
        }
    }
    function is_product_eligible($product_id) {
        # Product object
        $product_object = wc_get_product($product_id);
        if( !$product_object || $product_object->post_type != 'product'){
                return false;	
        }	
        $dreamfox_wcpgppf_selected_cats = get_option('dreamfox_wcpgppf_selected_cats');
        if ($dreamfox_wcpgppf_selected_cats) {
            $is_eligible = false;
            # Get visiblity
            $current_visibility = $product_object->get_catalog_visibility();
            # Get Category Ids
            $cat_ids = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'ids'));
            # Convert saved array in to list
            $dreamfox_wcpgppf_selected_cats = is_array($dreamfox_wcpgppf_selected_cats) ? $dreamfox_wcpgppf_selected_cats : array($dreamfox_wcpgppf_selected_cats);
            foreach ($cat_ids as $cat_id) {
                if (in_array($cat_id, $dreamfox_wcpgppf_selected_cats)) {
                    $is_eligible = true;
                    break;
                }
            }
            # check visiblity in array or now define
            if ($is_eligible && in_array($current_visibility, array('catalog', 'visible'))) {
                $is_eligible = true;
            } else {
                $is_eligible = false;
            }
            # return eligiblity
            return $is_eligible;
        }
        return false;
    }

    /**
         * Setting form
         */
        function dreamfox_wcpgppf_sdwpp_plugin_settings() {
            /**
             * Settings default
             */
            if (isset($_POST['sdwpp_setting'])) {
                if (isset($_POST['tax_input']['product_cat'])) {
                    update_option('dreamfox_wcpgppf_selected_cats', implode(',', $_POST['tax_input']['product_cat']));
                }
                update_option('sdwpp_plugin_settings', $_POST['sdwpp_setting']);
                dreamfox_wcpgppf_notice('Woocommerce Payment Gateway per Product setting is updated.', 'updated');
            }
            $dreamfox_wcpgppf_wpp_plugin_settings = get_option('sdwpp_plugin_settings', array('default_payment' => ''));
            $default_payment = $dreamfox_wcpgppf_wpp_plugin_settings['default_payment'];
            $dreamfox_wcpgppf_selected_cats = explode(',', get_option('dreamfox_wcpgppf_selected_cats'));
            $args = array(
                'hide_empty' => 0,
                'orderby' => 'id',
                'order' => 'ASC',
            );
            $product_categories = get_terms('product_cat', $args);
            foreach ($product_categories as $cat_data) {
                $cats[$cat_data->parent][] = $cat_data;
            }
            ?>
        <form id="woo_sdwpp" action="<?php echo $_SERVER['PHP_SELF'] . '?page=dreamfox_wcpgppf-product-payments' ?>" method="post">
            <div class="postbox " style="padding: 10px 0; margin: 10px 0px;">
                <h3 class="hndle">Select Categories: </h3>
					<small>
				<?php echo __('You can only select 2 categories with the free version', 'dreamfox_wcpgppf'); ?>
				</small>
                <div class="categorydiv">
                    <select class="multi_select" name="tax_input[product_cat][]" multiple>
                    <?php dreamfox_wcpgppf_get_category_ul($cats, $dreamfox_wcpgppf_selected_cats, 'categorychecklist form-no-clear', 0, 'product_catchecklist'); ?>
                                </select>
                            </div>

                            <h3 class="hndle"><?php echo __('Default Payment option( If not match any.)', 'dreamfox_wcpgppf'); ?></h3>
                    <?php
                    $woo = new WC_Payment_Gateways();
                    $payments = $woo->payment_gateways;
                    ?>
                    <select id="sdwpp_default_payment" name="sdwpp_setting[default_payment]">
                        <option value="">None</option>
                        <?php
                        foreach ($payments as $pay) {
                            /**
                             *  skip if payment in disbled from admin
                             */
                            if ($pay->enabled == 'no') {
                                continue;
                            }
                            echo "<option value = '" . $pay->id . "' " . selected($default_payment, $pay->id) . ">" . $pay->title . "</option>";
                        }
                        ?>
                    </select><br />
                    <small>
                        <?php echo __('If in some case payment option not show then this will default one set', 'dreamfox_wcpgppf'); ?>
                    </small>
            </div>
            <input class="button-large button-primary" type="submit" value="Save changes" />
            </form>
                 <Script>
                var on_s_change  = true;
                function updateSelectBox() {
                    var selectedValues = jQuery(this).val();  
                    if(selectedValues.length >= 2){
                        jQuery('.multi_select option:not(:selected)').attr('disabled', 'disabled');
                        if( on_s_change )
                            alert("You can not select more then 2 categories.")
                    }else{
                        jQuery('.multi_select option').removeAttr('disabled');
                    }
                    on_s_change = true;                
                }
                jQuery(document).ready(function(){
                    on_s_change = false;
                    jQuery('.multi_select').trigger('change');
                });
                jQuery('.multi_select').change(updateSelectBox);
            </script>
	<?php
        }
    }
	 /**
     * Type: updated,error,update-nag
     */
    if (!function_exists('dreamfox_wcpgppf_notice')) {
        function dreamfox_wcpgppf_notice($message, $type)
        {
            $html = <<<EOD
<div class="{$type} notice">
<p>{$message}</p>
</div>
EOD;
            echo $html;
        }
    }
?>