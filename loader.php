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


/**
 *
 * Core
 *
 */


/**
 * User interfaces - esemplificate php classes
 */
WebMapp_Utils::load_dir('core/interfaces');

/**
 * Core Classes :D
 */
WebMapp_Utils::load_dir('core/classes');
WebMapp_Utils::load_dir('core/classes/AbstractFields');
WebMapp_Utils::load_dir('core/classes/AdminColumns');
WebMapp_Utils::load_dir('core/classes/AdminOptionsPage');


/**
 *
 *  Duplicables
 *
 */


/**
 * Enqueue custom post type registration
 * init hooks
 */
WebMapp_Utils::load_dir('duplicable/custom_types/post_types');

/**
 * Enqueue custom taxonomies registration
 * init hooks
 */
WebMapp_Utils::load_dir('duplicable/custom_types/taxonomies');

/**
 * Enqueue custom fields registration
 * Enqueue custom fields in rest-api
 * init hooks
 */
WebMapp_Utils::load_dir('duplicable/custom_fields');

/**
 * Register rest-api routes
 * init hooks
 */
WebMapp_Utils::load_dir('duplicable/rest_routes');

/**
 * Register css/js resources
 * admin_enqueue_scripts , login_enqueue_scripts , wp_enqueue_scripts hooks
 */
WebMapp_Utils::load_dir('duplicable/assets_enqueuer');

/**
 * Enqueue custom taxonomies registration
 * ac/ready hooks -> admin-columns-pro plugin hook
 */
WebMapp_Utils::load_dir('duplicable/admin/columns');

/**
 * Load admin pages or subpages
 * _admin_menu and admin_menu hooks
 */
WebMapp_Utils::load_dir('duplicable/admin/pages');


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




