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
class WebMapp_ThemeCustomizer {


    private $wp_customize;
    private $section_id;
    private $section_title;
    private $frontend_css = '' ;
    private $settings ;
    private $js_url;
    private $section_description;



    function __construct( $section_id, $section_title, $section_description = '' , $settings , $js_url = '' )
    {
        $this->section_id = $section_id;
        $this->section_title = $section_title;
        $this->settings = $settings;
        $this->section_description = $section_description;
        $this->js_url = $js_url;



        // Setup the Theme Customizer settings and controls...
        add_action( 'customize_register' , array( $this , 'register' ) );

// Output custom CSS to live site
        add_action( 'wp_head' , array( $this , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
        add_action( 'customize_preview_init' , array( $this , 'live_preview' ) );

    }


    /**
     * This hooks into 'customize_register' (available as of WP 3.4) and allows
     * you to add new sections and controls to the Theme Customize screen.
     *
     * Note: To enable instant preview, we have to actually write a bit of custom
     * javascript. See live_preview() for more.
     *
     * @see add_action('customize_register',$func)
     * @param \WP_Customize_Manager $wp_customize
     * @link http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
     * @since WebMapp 2.0
     */
    public function register ( $wp_customize ) {

        $this->wp_customize = $wp_customize;

        //1. Define a new section (if desired) to the Theme Customizer
        $this->wp_customize->add_section( $this->section_id,
            array(
                'title'       => $this->section_title, //Visible title of section
                'priority'    => 35, //Determines what order this appears in
                'capability'  => 'edit_theme_options', //Capability needed to tweak
                'description' => $this->section_description, //Descriptive tooltip
            )
        );



        foreach ( $this->settings as $setting_id => $args )
        {
            $this->add_setting( $setting_id , $args['default'] );
            $description = isset( $args['description'] ) ? $args['description'] : '';
            $this->add_control($args['label'],$setting_id ,$description );
        }



        //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
        /**
        $check_settings = array(
        'blogname',
        'blogdescription',
        'header_textcolor',
        'background_color'
        );

        foreach ( $check_settings as $setting )
        {
        $temp = $wp_customize->get_setting( $setting );
        if ( $temp )
        $wp_customize->get_setting( $setting )->transport = 'postMessage';

        }
         * **/
    }



    public function add_setting( $id, $default )
    {
        //2. Register new settings to the WP database...
        $this->wp_customize->add_setting( $id, //No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
            array(
                'default'    => $default, //Default setting/value to save
                'type'       => 'theme_mod', //Is this an 'option' or a 'theme_mod'?
                //'capability' => 'edit_theme_options', //Optional. Special permissions for accessing this setting.
                'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
            )
        );
    }

    public function add_control( $label, $setting_id , $description = '' )
    {
        //3. Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
        if ( strpos($setting_id,'color') !== false )
        {
            $this->wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
                $this->wp_customize, //Pass the $wp_customize object (required)
                $setting_id . '_control', //Set a unique ID for the control
                array(
                    'label'      => $label, //Admin-visible name of the control
                    'settings'   => $setting_id, //Which setting to load and manipulate (serialized is okay)
                    'priority'   => 10, //Determines the order this control appears in for the specified section
                    'section'    => $this->section_id, //ID of the section this control should render in (can be one of yours, or a WordPress default section)
                    'description' => $description
                )
            ) );
        }
        else
        {
            $this->wp_customize->add_control(
                $setting_id . '_control',
                array(
                    'label'    => $label,
                    'section'  => $this->section_id,
                    'settings' => $setting_id,
                    'type'     => 'text',
                    'description' => $description
                )
            );
        }




    }

    /**
     * This will output the custom WordPress settings to the live theme's WP head.
     *
     * Used by hook: 'wp_head'
     *
     * @see add_action('wp_head',$func)
     * @since MyTheme 1.0
     */
    public function header_output() {
        ?>
        <!--Customizer CSS-->
        <style type="text/css">
            <?php echo $this->frontend_css ?>
        </style>
        <!--/Customizer CSS-->
        <?php
    }

    /**
     * This outputs the javascript needed to automate the live settings preview.
     * Also keep in mind that this function isn't necessary unless your settings
     * are using 'transport'=>'postMessage' instead of the default 'transport'
     * => 'refresh'
     *
     * Used by hook: 'customize_preview_init'
     *
     * @see add_action('customize_preview_init',$func)
     * @since MyTheme 1.0
     */
    public function live_preview()
    {
        if ( $this->js_url )
            wp_enqueue_script(
                $this->section_id . '_webmapp-themecustomizer', // Give the script a unique ID
                $this->js_url, // Define the path to the JS file
                array(  'jquery', 'customize-preview' ), // Define dependencies
                '', // Define a version (optional)
                true // Specify whether to put in footer (leave this true)
            );

    }

    /**
     * This will generate a line of CSS for use in header output. If the setting
     * ($mod_name) has no defined value, the CSS will not be output.
     *
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     * @param string $prefix Optional. Anything that needs to be output before the CSS property
     * @param string $postfix Optional. Anything that needs to be output after the CSS property
     * @since WebMapp 2.0
     */
    public function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='' )
    {
        $return = '';
        $default = isset( $this->settings[$mod_name]['default'] ) ? $this->settings[$mod_name]['default'] : false;
        $mod = get_theme_mod($mod_name , $default );
        if ( ! empty( $mod ) ) {
            $return = sprintf('%s { %s:%s; }',
                $selector,
                $style,
                $prefix.$mod.$postfix
            );

        }
        $this->frontend_css .= $return;
    }
}


