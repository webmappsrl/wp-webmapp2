<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Returns all post meta of post id provided
 *
 *
 * @when after_wp_load
 */
$wm_save_routes = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => 'route', 'posts_per_page' => -1) );
    
            foreach ( $results->posts as $post ) {
                WP_CLI::success('Updating Route ID # ' . $post->ID);
                wp_update_post( $post );
            }



};

WP_CLI::add_command( 'wm-save-routes', $wm_save_routes );