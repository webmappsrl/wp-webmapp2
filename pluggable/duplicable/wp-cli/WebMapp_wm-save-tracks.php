<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Updates all the custom post types TRACK
 *
 *
 * @when after_wp_load
 */
$wm_save_tracks = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => 'track','post_status' => 'publish', 'posts_per_page' => -1) );
    
            foreach ( $results->posts as $post ) {
                WP_CLI::success('Updating track ID # ' . $post->ID);
                wp_update_post( $post );
            }



};

WP_CLI::add_command( 'wm-save-tracks', $wm_save_tracks );