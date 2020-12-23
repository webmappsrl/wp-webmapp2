<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Reset custom fields encoding in WPML options
 *
 *
 * @when after_wp_load
 */
$wm_wpml_fields_encoding = function( $args, $assoc_args )
{
    $option = get_option('icl_sitepress_settings');
    if ( isset( $option['translation-management']['custom_fields_encoding'] ) )
    {
        $encoding = $option['translation-management']['custom_fields_encoding'];
        if ( in_array( 'reset' , $args ) )
        {
            WP_CLI::line("Reset mode. Resetting ...");
            $option['translation-management']['custom_fields_encoding'] = [];
            update_option('icl_sitepress_settings',  $option);
        }
        else
        {
            WP_CLI::line("Read mode. Printing ... (reset mode with 'reset' command arg)");
            print_r($encoding);
        }
        
    }   
    else
    {
        WP_CLI::error("No encoding is set for custom fields");
    }

    WP_CLI::success("DONE!");


};

WP_CLI::add_command( 'wm-wpml-fields-encoding', $wm_wpml_fields_encoding );