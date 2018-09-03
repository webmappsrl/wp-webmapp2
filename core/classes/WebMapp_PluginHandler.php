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
        'Admin Columns Pro - Advanced Custom Fields (ACF)' => 'ac-addon-acf/ac-addon-acf.php',
        //'acf-to-rest-api/class-acf-to-rest-api.php',
        'Admin Columns Pro' => 'admin-columns-pro/admin-columns-pro.php',
        'Advanced Custom Fields PRO' => 'advanced-custom-fields-pro/acf.php',
        'WPML Multilingual CMS' => 'sitepress-multilingual-cms/sitepress.php',
        'WPML REST API' => 'wpml-rest-api-master/wpml-rest-api.php',
        //'wpml-translation-management/plugin.php',
        //'WPML Media' => 'wpml-media-translation/plugin.php'
    );

    private $deactivate_plugins = array();

    function __construct()
    {
        add_action( 'plugins_loaded', array( $this , 'load_plugin_textdomain' ) );
        add_filter('upload_mimes', array( $this , 'my_mime_types') );
        add_action( 'admin_init' , array( $this , 'check_plugin_existence' ) );//notices in admin header

    }


    function check_plugin_existence()
    {
        foreach ( $this->necessary_plugins as $label => $plugin_main_file )
        {
            if( ! is_plugin_active($plugin_main_file ) )
            {
                //deactivate_plugins( plugin_basename( WebMapp_FILE ) );//deactivate this plugin
                $this->deactivate_plugins[] = $label;
                add_action( 'admin_notices', array( $this , 'webmapp_plugin_dependencies__error' ) );

            }
        }

    }


    /**
     * Admin header error
     */
    function webmapp_plugin_dependencies__error()
    {

        printf(
            '<div class="notice notice-error">%s</div>',
            $this->get_error_message()
        );
    }

    function get_error_message()
    {
        ob_start();

        ?>
        <h3>
            <span class="dashicons dashicons-warning" style="color:#dc3232"></span>
            <?php echo __( 'Webmapp plugin dependencies error.', WebMapp_TEXTDOMAIN ); ?>
        </h3>
        <p>
            <?php echo __( 'This plugins must be active : ', WebMapp_TEXTDOMAIN ); ?>
            <ul style="list-style-position: inside; padding-left: 20px">
                <?php
                foreach ( $this->deactivate_plugins as $plugin_label )
                    echo "<li><b>$plugin_label</b></li>"
                ?>
            </ul>
        </p>
        <?php
        $html = ob_get_clean();

        return $html;

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


