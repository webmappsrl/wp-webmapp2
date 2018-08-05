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

        //var_dump( $screen );
        //acf_after_title-sortables

        $args = array(
            'webmapp_add_new_track' => array(
                'src' => WebMapp_ASSETS . 'css/admin-add-new-track.css'

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