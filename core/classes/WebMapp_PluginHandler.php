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
        add_action( 'plugins_loaded', array( $this , 'load_plugin_textdomain' ) );
        add_filter('upload_mimes', array( $this , 'my_myme_types' ) );


    }

    /**
     * Load plugin textdomain.
     *
     * @since 1.0.0
     */
    function load_plugin_textdomain() {
        load_plugin_textdomain( WebMapp_TEXTDOMAIN, false, basename( dirname( WebMapp_TEXTDOMAIN ) ) . '/languages' );
    }


    /**
     *
     * @param $mime_types
     * @return mixed
     */

    function my_myme_types($mime_types) {

        $mime_types['gpx'] = 'application/gpx+xml'; //Adding svg extension

        return $mime_types;
    }
}