<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'my_test_mmm' => array(
        'src' => WebMapp_ASSETS . 'js/leaflet-map.js',
        'deps' => '',
        'in_footer' => '',
        'screen_base' => '',//works only in admin pages
        'screen_id' => '',//works only in admin pages
        'localize' => array(
            'object_name' => '',
            'data' => ''
        )
    )

);

//new WebMapp_AssetEnqueuer( $args , array( 'login' ), 'script' );

/**
 * Open popup in current page with screen_base and screen_id info
 * Only for develop use !!!
 * Please Authorize popups for your project domain to permit to static method works properly
 */
//WebMapp_AssetEnqueuer::see_where_i_am();

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