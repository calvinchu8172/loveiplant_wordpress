<?php
add_action( 'vc_before_init', 'twi_woo_car_VC_Version' );
function twi_woo_car_VC_Version() {
    global $wpdb;
    $allPageTemplate = array('');
    $rs = $wpdb->get_results( "
        SELECT ID, post_title
        FROM $wpdb->posts
        WHERE post_type = 'twi_woo_g_car'	AND post_status = 'publish'
        ORDER BY ID DESC"
    );
    foreach ( $rs as $r )
    {
        $allPageTemplate[$r->post_title]=$r->ID;
    }

    vc_map( array(
        "name" => __("TWI Woocommerce Grid/Carousel/Slider",'asdfasdf'),
        "base" => "twi_woo_shortcode",
        "class" => "",
        "category" => __('TWI'),
//      'admin_enqueue_js' => array(get_template_directory_uri().'/vc_extend/bartag.js'),
        //'admin_enqueue_css' => array(get_template_directory_uri().'/css/vc.css'),
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                'admin_label' => true,
                "heading" => __("Select your Grid/Carousel/Slider",'asdfasdfasdf'),
                "param_name" => "p_id",
                "value" =>$allPageTemplate
            )
        )
    ) );
}