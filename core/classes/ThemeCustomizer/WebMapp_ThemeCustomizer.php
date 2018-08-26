<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 14/07/18
 * Time: 13:17
 */

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link http://codex.wordpress.org/Theme_Customization_API
 * @since WebMapp 2.0
 */
class WebMapp_ThemeCustomizer
{

    private $sections;

    private $wm_sections = array();

    private $css_properties;


    function __construct( $sections )
    {
        if ( ! is_array( $sections ) )
            return;

        $this->sections = $sections;

        add_action( 'init' , array( $this , 'init') );



    }


    function init()
    {



        $this->register_sections();

        $this->prepare_css_properties();

        // Enqueue live preview javascript in Theme Customizer admin screen
        add_action( 'customize_preview_init' , array( $this , 'localize' ) );




    }

    function register_sections()
    {
        foreach ( $this->sections as $key => $section )
        {

            $s_id = isset( $section['id'] ) ? $section['id'] : false;
            $s_title = isset( $section['title'] ) ? $section['title'] : false;
            $s_settings = isset( $section['settings'] ) ? $section['settings'] : false;
            $s_js_url = isset( $section['js_url'] ) ? $section['js_url'] : false;

            $s_description = isset( $section['description'] ) ? $section['description'] : '';

            $check = $s_id && $s_title && $s_settings && $s_js_url;

            if( $check )
            {
                $this->wm_sections[ $key ] = new WebMapp_ThemeCustomizerSection(
                    $s_id ,
                    $s_title,
                    $s_description,
                    $s_settings,
                    $s_js_url
                );
            }



        }
    }


    function prepare_css_properties()
    {
        foreach ( $this->wm_sections as $key => $wm_section )//scan sections
        {
            if ( isset( $this->sections[ $key ][ 'id' ] )
                && isset( $this->sections[ $key ][ 'settings' ] )
                && is_array( $this->sections[ $key ][ 'settings' ] )
            )
            {

                foreach ( $this->sections[ $key ][ 'settings' ] as $id => $setting )//scan section settings
                {
                    if ( isset( $setting['css_properties'] )
                        && is_array( $setting['css_properties'] ) )
                    {
                        $class_name = '.' . $id;
                        $this->css_properties[$id] = array();

                        foreach ( $setting['css_properties'] as $property_name)//scan css properties to add
                        {
                            $this->css_properties[$id][] = $property_name;
                            $wm_section->generate_css( $class_name . '-' . $property_name , $property_name, $id );
                        }

                        $this->css_properties = array_filter($this->css_properties );

                    }

                }

            }// foreach ( $this->wm_sections as $key => $wm_section )
        }

    }


    function localize()
    {


        $data = array();
        foreach ( $this->css_properties as $id => $properties )
        {
            $data[] = array( 'id' => $id , 'properties' => $properties );
        }

        wp_enqueue_script( 'wm_customizer_main',
            WebMapp_URL . '/pluggable/duplicable/admin/theme_customizer/js/main_customizer.js',
            array(  'jquery', 'customize-preview' ),
        '',
        true
        );
        wp_localize_script('wm_customizer_main' , 'wm_customizer_data' , $data );
    }



}


