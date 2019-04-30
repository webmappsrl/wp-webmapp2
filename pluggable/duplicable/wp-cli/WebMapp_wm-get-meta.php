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
$wm_get_meta = function( $args, $assoc_args )
{


    $ID = isset( $args[0] ) && get_post_status( $args[0] ) !== FALSE ? $args[0] : FALSE;

    if ( $ID === FALSE )
        WP_CLI::error("Post id provided doesn't exists");
    else
        {
        WP_CLI::line("ALL METAFIELDS OF POST WITH ID $ID");
        print_r(get_post_meta($ID));
    }



};

WP_CLI::add_command( 'wm-get-meta', $wm_get_meta );