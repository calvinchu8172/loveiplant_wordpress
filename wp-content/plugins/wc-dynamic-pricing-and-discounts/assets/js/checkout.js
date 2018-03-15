/**
 * WooCommerce Dynamic Pricing & Discounts - Checkout Scripts
 */
jQuery(document).ready(function() {

    /**
     * Checkout totals update on email change
     */
    jQuery('form.checkout input#billing_email').change(function() {
        jQuery('body').trigger('update_checkout');
    }).change();


});
