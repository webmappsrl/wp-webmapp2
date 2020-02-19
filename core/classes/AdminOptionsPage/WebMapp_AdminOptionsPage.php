<?php
/**
 * Questa interfaccia rappresenta la classe ( e subclassi )  WebMapp_OptionsPage
 */
/*
 *
 */
class WebMapp_AdminOptionsPage
{

    /**
     * @var string - defaul tab if isn't set in settings arguments
     */
    public $default_tab = 'webmapp_general_options';

    /**
     * @var string - label for default tab
     */
    public $default_tab_label = 'WebMapp Options';

    /**
     * @var string - current tab of options page
     */
    public $current_tab = '';


    /**
     * @var string - menu slug identifier for menu element
     */
    public $menu_slug;

    /**
     * @var string - menu label
     */
    public $menu_title;

    /**
     * @var string - page title ( on the tabs )
     */
    public $page_title;

    public $icon_url;

    /**
     * @var array - settings must be registered in groups, 1 options_group per tab
     */
    public $settings_groups = array();

    /**
     * @var string - associative array tab-slug => tab-label
     */
    public $tabs = array();

    /**
     * @var array - all settings with arguments to render option in page
     */
    public $settings;

    /**
     * @var string - user capability to control page visibility
     */
    protected $capability;

    /**
     * WebMapp_AdminOptionsPage constructor.
     * @param $page_title
     * @param $menu_title
     * @param string $capability
     * @param string $menu_slug
     * @param array $settings
     * @param array $tabs
     * @param string $icon_url
     */

    function __construct( $page_title, $menu_title, $capability = 'manage_options', $menu_slug = 'webmapp', $settings = array(), $tabs = array() , $icon_url = '' )
    {
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->menu_slug = sanitize_title($menu_slug );
        $this->capability = $capability;
        $this->tabs = $tabs;
        $this->icon_url = $icon_url;

        $temp = $settings;
        if ( has_filter('wpml_default_language' ) && has_filter('wpml_current_language' ) )
        {
            $default_language = apply_filters('wpml_default_language', NULL );
            $current_language = apply_filters( 'wpml_current_language', NULL );
            if ( $default_language != $current_language )
            {
                $temp = array();
                foreach ( $settings as $name => $setting )
                {
                    if ( isset( $setting['multilang'] ) && $setting['multilang'] )
                        $temp[$name.'_'.$current_language] = $setting;
                    else
                        $temp[$name] = $setting;
                }
            }

        }
        $this->settings = $temp;

        

        $this->start();

    }


    /**
     *
     * Hooks to register options and add elements in admin menu
     *
     */
    public function start()
    {
        add_action( 'admin_init', array( $this , 'register_page_settings' ) );
        add_action( 'admin_menu', array( $this , 'add_menu_page' ) );
        register_activation_hook( WebMapp_FILE , array( $this , 'set_default_values' ) );
    }

    public function set_default_values()
    {
        $temp = $this->settings;
        foreach ( $temp as $setting_key => $setting )
        {
            if ( isset( $setting['default'] ) && ! empty( $setting['default'] ) )
            {
                $get_option = get_option( $setting_key );

                if ( $get_option === false )
                {
                    add_option( $setting_key , $setting['default'] );
                }
                elseif( $get_option === '' )
                    update_option( $setting_key , $setting['default'] );
            }


        }
    }

    /**
     *
     * Cp.
     *
     */
    public function register_page_settings()
    {
        $settings = $this->settings;
        foreach ( $settings as $option_name => $args )
        {
            $option_name = esc_attr( $option_name );
            if ( ! isset( $args['tab'] ) || ! isset( $this->tabs[ $args['tab'] ] ) )
            {
                $this->settings[$option_name]['tab'] = $this->default_tab;
                $this->tabs[$this->default_tab] = $this->default_tab_label;
            }


            $tab_slug = $this->settings[$option_name]['tab'];

            $settings_group = $this->add_settings_group( $tab_slug );

            register_setting($settings_group, $option_name );
        }

    }


    /**
     *
     * @reference : https://developer.wordpress.org/reference/functions/add_menu_page/
     *
     */
    public function add_menu_page()
    {
        add_menu_page($this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array( $this , 'render_menu_page' ),
            $this->icon_url
        );
    }

    /**
     *
     * Main wrap of options page
     * Contains methods to :
     *  check user permissions
     *  render tab navigation
     *  render tab content
     */
    public function render_menu_page()
    {
        $this->user_can_see_this_page();

        ?>
        <h1><?php echo $this->page_title ?></h1>
        <p>Webmapp is a plugin developed by <a href="http://webmapp.it" target="_blank">WEBMAPP s.r.l.</a></p>
        <div class="wrap">
            <?php
            $this->current_tab = $this->get_current_tab();
            $this->render_tab_nav();
            $this->render_tab_content();
            ?>
        </div>
        <?php



    }

    /**
     * Todo : Protected
     * @return string - return current tab of options page
     */
    public function get_current_tab()
    {
        return isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : array_keys( $this->tabs )[0];
    }

    /**
     * Adds settings_group with tab slug provided
     * ( For each tab a new settings_group )
     * The format of settings groups names : "{$tab_slug}_{$this->menu_slug}"
     *
     * @param $tab_slug - necessary tab slug to build a new settings_group slug
     * @return string
     */
    protected function add_settings_group( $tab_slug )
    {
        $settings_group = "{$tab_slug}_{$this->menu_slug}";
        if ( ! isset( $this->settings_groups[$settings_group] )
            || ! is_array( $this->settings_groups[$settings_group] )
        )
            $this->settings_groups[$settings_group] = array();

        $this->settings_groups[$tab_slug] = $settings_group;
        return $settings_group;
    }

    /**
    *  Retrieve settings_group of current tab
     * @return mixed|string
     */
    protected function get_settings_group()
    {
        $settings_group = '';
        if ( isset( $this->settings_groups[ $this->current_tab ] ) )
            $settings_group = $this->settings_groups[ $this->current_tab ];

        return $settings_group;
    }

    /**
     * Check user permissions
     * can die !
     */
    protected function user_can_see_this_page()
    {
        if ( ! current_user_can($this->capability ) )
        {
            wp_die(_x('You do not have sufficient permissions to access this page.' , 'WebMapp option page capability error', WebMapp_TEXTDOMAIN ) );
        }
    }

    /**
     * Render tabs navigation menu
     * todo add css classes ?
     */
    protected function render_tab_nav() {
        ?>
        <nav class="nav-tab-wrapper">
            <?php
            foreach ( $this->tabs as $slug => $name ) {
                $url     = get_admin_url( get_current_blog_id(), "admin.php?page=$this->menu_slug&tab=$slug" );
                $classes = $slug == $this->current_tab ? 'nav-tab nav-tab-active' : 'nav-tab';
                $html = '';
                echo "<a href='$url' class='$classes'>".$name."$html</a>";
            }
            ?>
        </nav>
        <?php
    }

    /**
     * TODO rendere espandibile tramite hooks
     */
    public function print_settings()
    {

        echo "<table class='form-table'>";

        foreach ( $this->settings as $setting_name => $setting_args ) {

            if ( $setting_args['tab'] == $this->current_tab ) :

                $label = isset( $setting_args['label'] ) ? $setting_args['label'] : '';
                $info = isset( $setting_args['info'] ) ? $setting_args['info'] : '';
                $value = isset( $setting_args['value'] ) ? $setting_args['value'] : esc_attr( get_option( $setting_name ) );

                $th = '';
                if ( $label )
                    $th = "<th scope=\"row\">$label</th>";

                echo "<tr valign=\"top\">$th<td>";

                if ( ! isset( $setting_args['html'] ) )
                {
                    $attrs = array();
                    if ( isset( $setting_args['attrs'] ) && is_array( $setting_args['attrs'] ) )
                    {
                        foreach ( $setting_args['attrs'] as $attr_name => $attr_value )
                            $attrs[] = "$attr_name=\"" . esc_attr( $attr_value ) . "\"";
                    }


                    $attrs_to_print = implode(' ' , $attrs );

                    $type = isset( $setting_args['type'] ) ? esc_attr( $setting_args['type'] ) : 'text';

                    /**
                     * TODO - Espandere i tipi
                     */
                    switch ( $type )
                    {
                        /**
                         * Select type
                         * todo support for multiselect?
                         */
                        case 'select':
                            if ( isset( $setting_args['options'] ) && is_array($setting_args['options'] ) )
                            {
                                $options = $setting_args['options'];

                                echo "<select name=\"$setting_name\" $attrs_to_print>";
                                foreach ( $options as $option_value => $option_label ) :
                                    $selected = selected($value, $option_value , false );
                                    echo "<option value=\"$option_value\" $selected>$option_label</option>";
                                endforeach;
                                echo "</selected>";
                            }

                            break;
                        case 'textarea':
                            echo "<textarea name=\"$setting_name\" $attrs_to_print>$value</textarea>";
                            break;

                        case 'radio':
                        case 'checkbox':
                            $checked = checked($value, 'true', false );
                            echo "<input type=\"$type\" name=\"$setting_name\" id=\"$setting_name\" value=\"true\" $attrs_to_print $checked/>";
                            break;

                        case 'media':
                            echo WebMapp_Utils::upload_files_input( $value,$setting_name );
                            break;
                        default:
                            echo "<input type=\"$type\" name=\"$setting_name\" id=\"$setting_name\" value=\"$value\" $attrs_to_print/>";
                            break;
                    }
                }
                else
                    echo $setting_args['html'];



                echo "<p class='description'>$info</p></td></tr>";


            endif;
        }

        echo "</table><div>";

        echo "<input type='hidden' name='tab' id='tab_slug' value='$this->current_tab'>";

        echo "</div>";
    }

    /**
     *
     * Render current tab options form
     * todo submit_button support ?
     *
     */
    protected function render_tab_content()
    {
        ?>
        <form method="post" action="options.php">
            <?php
            $option_group = $this->get_settings_group();
            settings_fields( $option_group );
            do_settings_sections($option_group );
            ?>
            <p>
                <a href="<?php echo WebMapp_DIR; ?>../documentation/Piattaformaeditorialemuticanale.pdf" target="_blank"><?php echo __("Download documentazione", WebMapp_TEXTDOMAIN); ?></a>
            </p>
            <?php $this->print_settings(); ?>
            <?php submit_button(); ?>
        </form>
        <?php
    }

    /**
     * Get option with WPML compatibility
     * @param $option_name
     * @return mixed
     */
    public static function get_option( $option_name )
    {
        $language_suffix = '';
        if ( has_filter('wpml_current_language') && has_filter('wpml_default_language') )
        {
            $current_language = apply_filters( 'wpml_current_language', NULL );
            $default_language = apply_filters('wpml_default_language', NULL );
            if ( $current_language != $default_language )
                $language_suffix = '_' . $current_language;

        }

        return get_option( $option_name . $language_suffix );


    }


}