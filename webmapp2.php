<?php
/*
  Plugin Name: Webmapp 2
  Plugin URI: http://download.be.webmapp.it
  Description: Worpdress WebMapp core plugin.
  Version: 2.0
  Author URI: http://www.netseven.it
 */


/**
 * CONSTANTS
 */
//global const text-domain, to change it in all project
define ( 'WebMapp_TEXTDOMAIN' , 'webmap_net7' );

//global const to get __FILE__ of main php page of project
define ( 'WebMapp_FILE' , __FILE__ );

//global const to get __DIR__ of main php page of project
define ( 'WebMapp_DIR' , __DIR__ );

//global const to get assets url
define ( 'WebMapp_ASSETS' , plugin_dir_url( WebMapp_FILE ) . 'assets/' );



/**
 * LOAD PHP PARTS
 */
include_once( 'loader.php' );
