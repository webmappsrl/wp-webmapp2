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



function webmapp_load_icons() {
    wp_register_style( 'webmapp-icons', 'https://icon.webmapp.it/style.css' );
    wp_enqueue_style( 'webmapp-icons' );
}

add_action( 'wp_enqueue_scripts', 'webmapp_load_icons' );
add_action( 'admin_enqueue_scripts', 'webmapp_load_icons' );

function webmapp_enqueue_style() {
    wp_enqueue_style( 'login_css', trailingslashit(plugin_dir_url(__FILE__)) .'includes/css/webmapp-login.css', false );
}

function webmapp_enqueue_script() {
    wp_enqueue_script( 'login_js', trailingslashit(plugin_dir_url(__FILE__)) .'includes/js/webmapp-login.js', false );
}

add_action( 'login_enqueue_scripts', 'webmapp_enqueue_style', 10 );
add_action( 'login_enqueue_scripts', 'webmapp_enqueue_script', 1 );


add_action('admin_print_scripts-edit.php', 'webmapp_manage_qe_admin_scripts');
function webmapp_manage_qe_admin_scripts() {

    // if using code as plugin
    wp_enqueue_script('webmapp-manage-bulk-quick-edit', trailingslashit(plugin_dir_url(__FILE__)) . 'includes/js/bulk_quick_edit.js', array(
        'jquery',
        'inline-edit-post'
    ), '', TRUE);

}


add_action('init', 'webmap_load_textdomain');


function webmap_load_textdomain() {
    load_plugin_textdomain('webmap_net7', FALSE, dirname(plugin_basename(__FILE__)) . '/lang');
    wp_enqueue_style("webmap_font_awesome", plugin_dir_url(__FILE__) . 'third-part/font-awesome-4.7.0/css/font-awesome.min.css');
    wp_enqueue_style("webmap_style_net7", plugin_dir_url(__FILE__) . 'includes/css/style.css');
    wp_enqueue_style("webmap_leaflet", plugin_dir_url(__FILE__) . 'third-part/leaflet/leaflet.css');
    wp_enqueue_script("webmap_leaflet_js", plugin_dir_url(__FILE__) . 'third-part/leaflet/leaflet.js');
    wp_enqueue_style("webmap_leaflet_vector_markers", plugin_dir_url(__FILE__) . 'third-part/leaflet/leaflet-vector-markers.css');
}



function webmapp_load_gpx_script() {
    wp_enqueue_script('webmapp-import-gpx', plugin_dir_url(__FILE__) . 'includes/js/import-gpx.js', array('jquery'), '0.1.0', TRUE);
    wp_enqueue_script('webmapp-leaflet-map', plugin_dir_url(__FILE__) . 'includes/js/leaflet-map.js');
    wp_enqueue_script('webmapp-leaflet-vector-markers', plugin_dir_url(__FILE__) . 'includes/js/leaflet-vector-markers.min.js', array('webmapp-leaflet-map'));
    wp_enqueue_script("jquery-ui-dialog");
    $data = array(
        'upload_url' => admin_url('async-upload.php'),
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('media-form'),
        'loading_gif_path' => plugin_dir_url(__FILE__) . "includes/images/spinner.gif",
        'loading_text' => __("Loading", "webmap_net7"),
        'import_completed' => __("Import completed succesfully.", "webmap_net7"),
        'track_created_success' => __("Track imported succesfully.", "webmap_net7"),
        'track_created_subtitle' => __("You will see new imported tracks in the route's related tracks after route update", "webmap_net7"),
        'track_created_view' => __("view the track", "webmap_net7")
    );

    wp_localize_script('webmapp-import-gpx', 'webmapp_config', $data);
}

add_action('init', 'webmapp_load_gpx_script');