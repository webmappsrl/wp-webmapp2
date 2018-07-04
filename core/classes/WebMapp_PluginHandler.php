<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 18:01
 */

class WebMapp_PluginHandler
{

    function __construct()
    {
        add_action( 'plugins_loaded', 'myplugin_load_textdomain' );


    }

    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    function myplugin_load_textdomain() {
        load_plugin_textdomain( 'my-plugin', false, basename( dirname( __FILE__ ) ) . '/languages' );
    }

}