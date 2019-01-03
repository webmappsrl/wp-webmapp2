<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'webmapp_anypost_js' => array(
        'src' => WebMapp_URL . 'pluggable/duplicable/frontend/shortcodes/AnyPost/assets/main.js',
        'deps' => array('jquery'),
        'in_footer' => false,
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
    'webmapp_anypost_all_templates' => array(
        'src' => WebMapp_URL . 'pluggable/duplicable/frontend/shortcodes/AnyPost/assets/all_templates.css'
    ),
    'webmapp_anypost_template_compact_css' => array(
        'src' => WebMapp_URL . 'pluggable/duplicable/frontend/shortcodes/AnyPost/assets/template_compact.css'
    )

);

new WebMapp_AssetEnqueuer( $args , 'wp', 'style' );