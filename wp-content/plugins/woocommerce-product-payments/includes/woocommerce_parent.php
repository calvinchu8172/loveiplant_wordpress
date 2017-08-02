<?php
Class woocommerce_parent{
	function __construct(){
		add_filter('woocommerce_available_payment_gateways', array($this,'wpppayment_gateway_disable_country'));
		add_action('save_post', array($this,'wpp_meta_box_save'), 10, 2);
		add_action('add_meta_boxes', array($this,'wpp_meta_box_add'));
	}
	function softsdev_get_category_ul($categories, $selected_cats, $class, $parent_id, $id = '', $name = '') {
        ?>

        <?php
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
                    softsdev_get_category_ul($categories, $selected_cats, 'children', $child_id, '', $data->name);
                }
                ?>  
            <?php
            }

            if ($parent_id > 0) {
                echo '</optgroup>';
            }
            ?>                 

            <?php
        }
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
    function wpp_meta_box_add() {
        global $post;
        if (isset($post->ID) && is_product_eligible($post->ID)) {
            add_meta_box('payments', 'Payments', 'wpp_payments_form', 'product', 'side', 'core');
        }
    }
    function wpp_payments_form() {
        global $post, $woo;
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
            ?>  
            <input type="checkbox" <?php echo $checked; ?> value="<?php echo $pay->id; ?>" name="pays[]" id="payment_<?php echo $pay->id; ?>" />
            <label for="payment_<?php echo $pay->id; ?>"><?php echo $pay->title; ?></label>  
            <br />  
            <?php
        }
    }
}
?>