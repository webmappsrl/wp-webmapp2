<?php
/*
  Plugin Name: Webmapp 2
  Plugin URI: http://download.be.webmapp.it
  Description: Worpdress WebMapp core plugin.
  Version: 2.1.1
  Author URI: http://www.netseven.it
 */

/**
 * Todo control plugins dependency, force reactivation of webmapp
 * acf-pro
 * admin-columns-pro
 * acf-to-rest-api
 * ac-addon-acf
 * wpml ?
 *
 */


/**
 * CONSTANTS
 */
//global const text-domain, to change it in all project
define('WebMapp_TEXTDOMAIN', 'webmap_net7');

//global const to get __FILE__ of main php page of project
define('WebMapp_FILE', __FILE__);

//global const to get url of plugin root, useful to load resources as css/js
define('WebMapp_URL', plugin_dir_url(WebMapp_FILE));

//global const to get __DIR__ of main php page of project
define('WebMapp_DIR', __DIR__);

//global const to get assets url
define('WebMapp_ASSETS', WebMapp_URL . 'assets/');

define('WebMapp_PLUGIN_MAIN_FILE', 'wp-webmapp2/webmapp2.php');


//shortcodes constants

define('WebMapp_ShortcodeTemplates_AnyPost_DIR', WebMapp_DIR . '/pluggable/duplicable/frontend/shortcodes/AnyPost/templates/');


//save version of datamodel
define('WM_DATAMODEL_VERSION', '2');

//wpml_cf_preferences

// WPML_IGNORE_CUSTOM_FIELD // => 0 for Don't translate
// WPML_COPY_CUSTOM_FIELD // => 1 for Copy
// WPML_TRANSLATE_CUSTOM_FIELD // => 2 for Translate
// WPML_COPY_ONCE_CUSTOM_FIELD // => 3 for Copy once

define('WEBMAPP_TRANSLATE_CUSTOM_FIELD', 2);
define('WEBMAPP_COPY_CUSTOM_FIELD', 1);

/**
 * LOAD PHP PARTS
 */
include_once('loader.php');
