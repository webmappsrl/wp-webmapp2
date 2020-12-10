<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Updates all the custom post types ROUTE, for routes in a specific language type the language code as the first parameter (ex. en)
 *
 *
 * @when after_wp_load
 */
$wm_save_routes = function( $args, $assoc_args )
{
    global $sitepress;
    $default_lang = $sitepress->get_default_language();
    $lang = '';
    if ( !empty($args)) {
        $sitepress->switch_lang($args[0]);
    }

    $results = new WP_Query( array( 'post_type' => 'route','post_status' => 'publish','suppress_filters' => false, 'posts_per_page' => -1) );
            
            foreach ( $results->posts as $post ) {
                WP_CLI::success('Updating Route ID # ' . $post->ID);
                wp_update_post( $post );
            }


    $sitepress->switch_lang( $default_lang);


};

WP_CLI::add_command( 'wm-save-routes', $wm_save_routes );