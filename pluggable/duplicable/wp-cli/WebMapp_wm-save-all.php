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
    $cmd = "wp wm-save-pois --allow-root";
    system($cmd);
    $cmd = "wp wm-save-tracks --allow-root";
    system($cmd);
    $cmd = "wp wm-save-routes --allow-root";
    system($cmd);

};

WP_CLI::add_command( 'wm-save-all', $wm_save_all );