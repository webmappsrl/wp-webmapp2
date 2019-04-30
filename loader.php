<?php

/**
 * Php directories loader
 *
 * Only files that contains WebMapp string in filename !!! todo?
 *
 * Useful to debug code
 *
 * TODO when subdirectory support ?
 *
 */


/**
 *
 * Loader
 *
 */


/**
 * Load generic utilities class ( has loader method )
 */
require_once('utils/WebMapp_Utils.php');
require_once('third-part/gisconverter/gisconverter.php');

/**
 * ICONS CONF
 */

require_once('icons_conf.php');



/**
 *
 * Core
 *
 */



/**
 * Core Classes :D
 */
WebMapp_Utils::load_dir('core/classes');
WebMapp_Utils::load_dir('core/classes/AbstractFields');
WebMapp_Utils::load_dir('core/classes/AdminColumns');
WebMapp_Utils::load_dir('core/classes/AdminOptionsPage');
WebMapp_Utils::load_dir('core/classes/ThemeCustomizer');


/**
 *
 *  Duplicables
 *
 */

/**
 * WP Customizer modules
 */
WebMapp_Utils::load_dir('pluggable/duplicable/admin/theme_customizer');
//WebMapp_Utils::load_dir('pluggable/duplicable/admin/theme_customizer/ShortcodesCustomizer');

/**
 * Enqueue custom post type registration
 * wp_ajax_ wp_ajax_nopriv_ hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/ajax');

/**
 * Enqueue custom post type registration
 * init hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/custom_types/post_types');

/**
 * Enqueue custom taxonomies registration
 * init hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/custom_types/taxonomies');


/**
 * Enqueue only rest api custom attributes
 */
WebMapp_Utils::load_dir('pluggable/duplicable/rest_api');

/**
 * Enqueue custom fields registration
 * Enqueue custom fields in rest-api
 * init hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/custom_fields');


/**
 * Register rest-api routes
 * init hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/rest_routes');

/**
 * Register css/js resources
 * hooks: admin_enqueue_scripts , login_enqueue_scripts , wp_enqueue_scripts hooks
 */
WebMapp_Utils::load_dir('pluggable/duplicable/assets_enqueuer');
WebMapp_Utils::load_dir('pluggable/duplicable/assets_enqueuer/admin');
WebMapp_Utils::load_dir('pluggable/duplicable/assets_enqueuer/login');
WebMapp_Utils::load_dir('pluggable/duplicable/assets_enqueuer/wp');

/**
 * Enqueue custom taxonomies registration
 * ac/ready hooks -> admin-columns-pro plugin hook
 */
WebMapp_Utils::load_dir('pluggable/duplicable/admin/columns');




if ( is_admin() ) ://load only in admin side

    /**
     * Load admin pages or subpages
     * _admin_menu and admin_menu hooks
     */
    WebMapp_Utils::load_dir('pluggable/duplicable/admin/pages');

else ://load in frontend side ( login too )

    /**
     * Load generic frontend elements
     */
    WebMapp_Utils::load_dir('pluggable/duplicable/frontend/');

    /**
     * Load shorcodes
     * add_shortcode and admin_menu hooks
     */
    WebMapp_Utils::load_dir('pluggable/duplicable/frontend/shortcodes');
    WebMapp_Utils::load_dir('pluggable/duplicable/frontend/shortcodes/AnyPost');
    WebMapp_Utils::load_dir('pluggable/duplicable/frontend/shortcodes/AnyTerm');


endif;

WebMapp_Utils::load_theme();


/**
 *
 * General hooks functions
 *
 */

/**
 * Hooks examples and functions
 * wp hooks
 * webmapp hooks
 * plugins hooks
 * pluggable functions?
 */
WebMapp_Utils::load_dir('pluggable');






/**
 * Load WP CLI commands and utils
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    require_once('utils/WebMapp_WpCli_Utils.php');
    WebMapp_Utils::load_dir('pluggable/duplicable/wp-cli');
}




