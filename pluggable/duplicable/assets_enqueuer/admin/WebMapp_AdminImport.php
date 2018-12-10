<?php

add_action( 'current_screen' , 'webmapp_admin_import_assets' );

function webmapp_admin_import_assets()
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
        ));
    new WebMapp_AssetEnqueuer( $args,'admin', 'script' );

}




