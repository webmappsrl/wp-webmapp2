<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 18:01
 */

class WebMapp_PluginHandler
{

    private $necessary_plugins = array(
        'ac-addon-acf/ac-addon-acf.php',
        //'acf-to-rest-api/class-acf-to-rest-api.php',
        'admin-columns-pro/admin-columns-pro.php',
        'advanced-custom-fields-pro/acf.php',
        'sitepress-multilingual-cms/sitepress.class.php',
        'wpml-rest-api-master/wpml-rest-api.php',
        'wpml-translation-management/plugin.php',
        'wpml-media-translation/plugin.php'
    );

    private $deactivate_plugins = array();

    function __construct()
    {
        add_action( 'plugins_loaded', array( $this , 'load_plugin_textdomain' ) );
        add_filter('upload_mimes', array( $this , 'my_mime_types') );
        add_action( 'admin_init' , array( $this , 'check_plugin_existence' ) );

    }


    function check_plugin_existence()
    {
        foreach ( $this->necessary_plugins as $plugin )
        {
            if( ! is_plugin_active($plugin ) )
            {
                //deactivate_plugins( plugin_basename( WebMapp_FILE ) );//deactivate this plugin
                $this->deactivate_plugins[] = $plugin;
                add_action( 'admin_notices', array( $this , 'webmapp_plugin_dependencies__error' ) );
            }
        }

    }



    function webmapp_plugin_dependencies__error()
    {
        $class = 'notice notice-error';
        $message = __( 'Webmapp plugin dependencies error. This plugins must be active : ', WebMapp_TEXTDOMAIN ) . "<b>" . implode( ', ' , $this->deactivate_plugins ) . "</b>.";
        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
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

    function my_mime_types($mime_types)
    {
        $mime_types['gpx'] = 'application/gpx+xml'; //Adding svg extension
        return $mime_types;
    }
}

new WebMapp_PluginHandler();


