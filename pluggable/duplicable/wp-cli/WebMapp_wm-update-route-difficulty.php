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
$wm_update_route_difficulty = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => 'route', 'posts_per_page' => -1) );
    
            foreach ( $results->posts as $post ) {
                $vn_diff = get_field('vn_diff', $post->ID);
                $wm_difficulty = get_field('n7webmapp_route_difficulty', $post->ID);
                if ($vn_diff) {
                    update_field('n7webmapp_route_difficulty',$vn_diff,$post->ID);
                    WP_CLI::success('Updating difficulty of Route ID # ' . $post->ID .' from value: '.$wm_difficulty.' to new value: ' .$vn_diff );
                }
            }



};

WP_CLI::add_command( 'wm-update-route-difficulty', $wm_update_route_difficulty );