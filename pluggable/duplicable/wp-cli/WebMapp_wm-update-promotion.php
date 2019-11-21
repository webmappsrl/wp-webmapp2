<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux


// Activate this command only with ecommerce option activated
if(get_option('webmapp_has_ecommerce')):

/**
 * Update all routes promotion readonly values
 *
 *
 * @when after_wp_load
 */
$wm_update_promotion = function( $args, $assoc_args )
{

	WP_CLI::line("\n\nAll routes will be updated with promotion values\n\n");
	Webmapp_UpdatePromotion::run(true);

};

WP_CLI::add_command( 'wm-update-promotion', $wm_update_promotion );

endif;