<?php

/**
 * Php directories loader
 *
 * Only files that contains WebMapp string in filename !!! todo?
 *
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
 */
WebMapp_Utils::load_dir('duplicable/custom_types/post_types');

/**
 * Enqueue custom taxonomies registration
 */
WebMapp_Utils::load_dir('duplicable/custom_types/taxonomies');

/**
 * Load admin pages or subpages
 */
WebMapp_Utils::load_dir('duplicable/backend/pages');




