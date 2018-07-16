<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 12/07/18
 * Time: 21:06
 */

class WebMapp_TemplatesRedirect
{


    function __construct()
    {
        add_action( 'init', array( $this , 'add_my_rewrites' ), 10 , 0 );
        add_filter( 'template_include', array( $this , 'taxonomy_archive_template_redirect' ), 99 );
        register_activation_hook( WebMapp_FILE , array( $this , 'flush_rewrites' ) );

        /**
         * Filters the list of template filenames that are searched for when retrieving a template to use.
         *
         * The last element in the array should always be the fallback template for this query type.
         *
         * Possible values for `$type` include: 'index', '404', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date',
         * 'embed', 'home', 'frontpage', 'page', 'paged', 'search', 'single', 'singular', and 'attachment'.
         *
         * @since 4.7.0
         *
         * @param array $templates A list of template candidates, in descending order of priority.
         *
         *
         */

        $template_types = array(
            'index',
            '404',
            'archive',
            'author',
            'category',
            'tag',
            'taxonomy',
            'date',
            'embed',
            'home',
            'frontpage',
            'page',
            'paged',
            'search',
            'single',
            'singular',
            'attachment'
        );

        foreach ( $template_types as $template_type)
            add_filter( "{$template_type}_template", array( $this , 'change_templates_hierarchy') , 10 , 3 );
    }

    public function change_templates_hierarchy( $template, $type, $templates )
    {
        $params = $this->get_current_theme();
        if ( empty( $params ) )
            return $template;

        extract( $params );

        /**
         * Search template in plugin and child theme
         * todo write better here
         */
        $plugin_template_index = $this->calculate_template_index( $templates , $plugin_themes_templates );
        $theme_template_index = $this->calculate_template_index( $templates , $active_theme_path );
        if ( $plugin_template_index && $theme_template_index )
        {
            if ( realpath( $plugin_themes_templates . $templates[ $plugin_template_index ] )//plugin theme folder must exists
                && ( $plugin_template_index < $theme_template_index
                || ( $plugin_template_index == $theme_template_index && $theme_template == $theme_stylesheet ) // doesnt esist child theme
                )
            )
                $template = $plugin_themes_templates . $templates[ $plugin_template_index ];

        }
        elseif ( $plugin_template_index !== false && $theme_template_index === false )
            $template = $plugin_themes_templates . $templates[ $plugin_template_index ];




        /**
         * Child theme templates priority
         *
        if ( $active_theme_path && $theme_template !== $theme_stylesheet ) //child theme exists
            if ( strpos( $template ,$active_theme_path ) !== false )//child theme templates priority on plugins
                return $template;



        /**
         * Redirect generic templates
         *
        if ( realpath( $plugin_themes_templates ) )
        {
            $template_name = basename( $template );
            $plugin_template = $plugin_themes_templates . $template_name;
            if ( file_exists( $plugin_template ) )
                return $plugin_template;
        }
         *
         */




        return $template;
    }

    public function calculate_template_index( $templates , $path )
    {
        $r = false;
        $i = 0;

        if ( ! is_array( $templates) )
            return $r;
        if ( ! realpath( $path ) )
            return $r;

        while ( $r === false && $i < count( $templates ) ) :
            if ( file_exists( $path . $templates[$i] ) )
                $r = $i;
            $i++;
        endwhile;

        return $r;
    }

    public function add_my_rewrites()
    {
        add_rewrite_tag('%taxonomy%', '([^&]+)');
        add_rewrite_rule('^taxonomy/([^&]+)/?', 'index.php?taxonomy=$matches[1]', 'top');
    }

    public static function get_tax_archive_link( $tax_name )
    {
        $home = home_url();
        $link = '';

        if ( ! taxonomy_exists( $tax_name ) )
            return $link;

        $link = $home . '/index.php?taxonomy=' . $tax_name ;

        $structure = get_option( 'permalink_structure' );

        if ( $structure == '/%postname%/')
            $link = $home . '/taxonomy/' . $tax_name;

        return $link;
    }

    public function get_current_theme()
    {
        $params = array();
        $theme = wp_get_theme();
        $theme_exists = $theme->exists();

        if ( ! $theme_exists )
            return $params;

        $params['theme_stylesheet'] = isset( $theme->stylesheet ) ? $theme->stylesheet : '';
        $params['theme_template'] = isset( $theme->template ) ? $theme->template : '';
        $params['theme_root'] = isset( $theme->theme_root ) ? $theme->theme_root : '';
        $params['active_theme_path'] = $params['theme_root'] && $params['theme_template'] ? $params['theme_root'] . '/' . $params['theme_stylesheet'] . '/' : '';
        $params['plugin_themes_templates'] = WebMapp_DIR . '/themes_templates/' . $params['theme_template'] . '/';

        return $params;

    }

    public function taxonomy_archive_template_redirect( $template ) {

        $params = $this->get_current_theme();
        if ( empty( $params ) )
            return $template;

        extract( $params );
            /**
             * Taxonomy archive templates redirect
             */
            global $wp_query;
            if ( isset( $wp_query->query )
                && isset( $wp_query->query['taxonomy'] )
                && count( $wp_query->query ) == 1
            )
            {
                $tax_template = $active_theme_path . 'archive-taxonomy.php';
                if ( ! file_exists( $tax_template ) )
                {
                    $tax_template = $plugin_themes_templates . 'archive-taxonomy.php';
                    if ( ! file_exists( $tax_template ) )
                        return $template;
                    else
                        return $tax_template;
                }
                else
                    return $tax_template;

            }


        return $template;
    }

    /**
     * Refresh link routes
     */
    public function flush_rewrites()
    {
        flush_rewrite_rules();
    }



}
new WebMapp_TemplatesRedirect();
//add_action( 'init', 'add_my_rewrites', 10 , 0 );


//add_action( 'init', 'add_my_rewrites2' );








