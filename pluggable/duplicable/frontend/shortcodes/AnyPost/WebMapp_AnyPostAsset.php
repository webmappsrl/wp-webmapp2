<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'webmapp_anypost_js' => array(
        'src' => WebMapp_URL . 'duplicable/frontend/shortcodes/AnyPost/assets/main.js',
        'deps' => array('jquery'),
        'in_footer' => 'false',
        'localize' => array(
            'object_name' => 'shortcode_conf',
            'data' => array(
                'ajaxurl' => '/wp-admin/admin-ajax.php',
                //'nonce' => wp_create_nonce('webmapp_anypost_shortcode')
            )
        )
    )
);


new WebMapp_AssetEnqueuer( $args , 'wp', 'script' );

$args = array(
    'webmapp_anypost_css' => array(
        'src' => WebMapp_URL . 'duplicable/frontend/shortcodes/AnyPost/assets/style.css'
    )

);

new WebMapp_AssetEnqueuer( $args , 'wp', 'style' );