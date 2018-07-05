<?php


$args = array(
    'webmap_font_awesome' => array(
        'src' => WebMapp_URL . 'third-part/font-awesome-4.7.0/css/font-awesome.min.css'
    ),
    'webmap_style_net7' => array(
        'src' => WebMapp_ASSETS . 'css/style.css'
    ),
    'webmap_leaflet' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet.css'
    ),
    'webmap_leaflet_vector_markers' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet-vector-markers.css'
    )
);

//use all sides
//copied from function called with init hook
new WebMapp_AssetEnqueuer( $args,array( 'login' , 'wp' , 'admin' ),'style' );


/**
 * Init hook is necessary to permit wp_create_nonce() function to work properly
 */
add_action( 'init' , 'WebMapp_webmapp_import_gpx_localize_data' );
function WebMapp_webmapp_import_gpx_localize_data()
{
    $data = array(
        'upload_url' => admin_url('async-upload.php'),
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('media-form'),
        'loading_gif_path' => WebMapp_ASSETS . "images/spinner.gif",
        'loading_text' => __("Loading", WebMapp_TEXTDOMAIN),
        'import_completed' => __("Import completed succesfully.", WebMapp_TEXTDOMAIN),
        'track_created_success' => __("Track imported succesfully.", WebMapp_TEXTDOMAIN),
        'track_created_subtitle' => __("You will see new imported tracks in the route's related tracks after route update", WebMapp_TEXTDOMAIN),
        'track_created_view' => __("view the track", WebMapp_TEXTDOMAIN)
    );

    $args = array(
        'webmapp-import-gpx' => array(
            'src' => WebMapp_ASSETS . 'js/import-gpx.js',
            'deps' => array('jquery'),
            'localize' => array(
                'object_name' => 'webmapp_config',
                'data' => $data
            )
        ),
        'webmapp-leaflet-map' => array(
            'src' => WebMapp_ASSETS . 'js/leaflet-map.js',
            'deps' => array('jquery','webmap_leaflet_js'),
            'in_footer' => false
        ),
        'webmapp-leaflet-vector-markers' => array(
            'src' => WebMapp_ASSETS . 'js/leaflet-vector-markers.min.js',
            'deps' => array('webmapp-leaflet-map')
        ),
        'jquery-ui-dialog' => array(),//format to enqueue already registered handles
        'webmap_leaflet_js' => array(
            'src' => WebMapp_URL . 'third-part/leaflet/leaflet.js',
            'in_footer' => false
        ),
    );
//use all sides
//copied from function called with init hook
    new WebMapp_AssetEnqueuer( $args,array( 'login' , 'wp' , 'admin' ),'script' );
}
