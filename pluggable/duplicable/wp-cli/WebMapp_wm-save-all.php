<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Updates all custom post types (ROUTE,TRACK and POI)
 *
 *
 * @when after_wp_load
 */
$wm_save_all = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => array('route', 'track', 'poi'),'post_status' => 'public', 'posts_per_page' => -1) );
    
            foreach ( $results->posts as $post ) {
                WP_CLI::success('Updating post ID # ' . $post->ID);
                wp_update_post( $post );
            }



};

WP_CLI::add_command( 'wm-save-all', $wm_save_all );