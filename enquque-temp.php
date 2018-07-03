<?php


/**
 * /wp-content/plugins/webmapp/includes/custom_map.php
 */
function webmap_custom_map_scripts() {

    wp_register_script( 'custom-map', plugin_dir_url(__FILE__) . '/js/custom-map.js', array('jquery'), '1.0.0', true );

    $tiles_url = get_option('webmapp_map_tilesUrl');
    $zoom = get_option( 'webmapp_map_zoom' );
    $app_url = get_option( 'webmapp_map_appUrl' );
    $pin = !empty( get_option( 'webmapp_map_show-pin' ) ) ? get_option( 'webmapp_map_show-pin' ) : 'true';
    $expand = get_option( 'webmapp_map_show-expand' );
    $click = !empty( get_option( 'webmapp_map_click-iframe' ) ) ? get_option( 'webmapp_map_click-iframe' ) : 'true';
    $no_app = get_option( 'webmapp_map_no_app' );
    $filter = get_option( 'webmapp_map_filter' );
    $activateZoom = get_option( 'webmapp_map_activate_zoom' );

    if (empty($tiles_url)){
        $tiles_url = 'https://api.webmapp.it/trentino/tiles/map/{z}/{x}/{y}.png';
    }

    if (empty($zoom)){
        $zoom = '14';
    }

    if (empty($app_url)){
        $app_url = 'http://pnab.j.webmapp.it';
    }

    $data = array(
        'label' => 'Mappa',
        'tilesUrl' => $tiles_url,
        'zoom' => $zoom,
        'appUrl' => $app_url,
        'show_pin' => $pin,
        'show_expand' => $expand,
        'click_iframe' => $click,
    );

    if (!empty($no_app)){
        $data['no_app'] = $no_app;
    }

    if (!empty($filter)){
        $data['filter'] = $filter;
    }

    if (!empty($activateZoom)){
        $data['activate_zoom'] = $activateZoom;
    }

    wp_localize_script( 'custom-map', 'data', $data );
    wp_enqueue_script( 'custom-map' );

}

add_action( 'wp_enqueue_scripts', 'webmap_custom_map_scripts' );