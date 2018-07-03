<?php

/**
 * Php directories loader
 *
 * Only files that contains WebMapp string in filename !!! todo?
 *
 * Useful to debug code
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
 * Enqueue custom fields registration
 * Enqueue custom fields in rest-api
 * init hooks
 */
WebMapp_Utils::load_dir('duplicable/rest_routes');

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
 */
WebMapp_Utils::load_dir('pluggable');




