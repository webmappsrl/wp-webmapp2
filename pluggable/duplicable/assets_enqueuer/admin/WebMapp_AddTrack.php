<?php



//if ( get_post_meta($post->ID, "n7webmap_geojson", TRUE ) == '' );
add_action( 'current_screen' , 'webmapp_remove_post_custom_fields' );

/**
 * Remove Custom Fields meta box
 */
function webmapp_remove_post_custom_fields() {
    $screen = get_current_screen();

    $base = $screen->base;
    $action = isset( $screen->action ) ? $screen->action : false ;
    $post_type = isset( $screen->post_type ) ? $screen->post_type : false;

    if ( $base && $action && $post_type
        && $action == 'add'
        && $base == 'post'
        && $post_type == 'track'
    )
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

        //var_dump( $screen );
        //acf_after_title-sortables

        $args = array(
            'webmapp_add_new_track' => array(
                'src' => WebMapp_ASSETS . 'css/admin-add-new-track.css'

            ),
            'webmapp-import-gpx' => array(
                'src' => WebMapp_ASSETS . 'js/import-gpx.js',
                'deps' => array('jquery'),
                'localize' => array(
                    'object_name' => 'webmapp_config',
                    'data' => $data
                )
            )
        );

        new WebMapp_AssetEnqueuer( $args,'admin', 'style' );

        $args = array(
            'webmapp_add_new_track' => array(
                'src' => WebMapp_ASSETS . 'js/admin-add-new-track.js'

            )
        );
        new WebMapp_AssetEnqueuer( $args,'admin', 'script' );




    }

}