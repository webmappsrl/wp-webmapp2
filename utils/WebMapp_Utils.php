<?php

/**
 * Class WebMapp_Utils
 * General helpers methods class
 *
 * Here you will find:
 * load_dir function that loads all plugin php
 *
 */
class WebMapp_Utils
{

    /**
     * Todo check su path - filter
     * Todo load sub directories
     * @param $rel_dir
     */
    static function load_dir( $rel_dir )
    {

        $files = glob( WebMapp_DIR . "/$rel_dir/*.php" );

        // Load WebMapp php files
        foreach ( (array) $files as $file )
        {
            if ( $file && strpos( $file , 'WebMapp_' ) !== false )
            {
                require_once $file;
            }
        }
    }

    static function load_theme()
    {

        $theme = wp_get_theme();
        $theme_exists = $theme->exists();

        if ( ! $theme_exists )
            return;

       $theme_template = isset( $theme->template ) ? $theme->template : '';

       if ( ! $theme_template )
           return;

        $functions_path = WebMapp_DIR . "/themes_templates/$theme_template/functions.php";
        $functions = file_exists( $functions_path );

        // Load WebMapp theme functions files
        if ( $functions )
        {
            require_once $functions_path;
        }

        $style_partial ="themes_templates/$theme_template/style.css";
        $style = file_exists(  WebMapp_DIR . '/' . $style_partial );
        // Load WebMapp theme functions files
        if ( $style )
        {
            $args = array(
                'webmapp_plugin_theme' => array(
                    'src' => WebMapp_URL . $style_partial
                )
            );
            new WebMapp_AssetEnqueuer( $args , 'wp','style' );
        }
    }

    /**
     * Alias of get_tax_archive_link method
     *
     * @param $tax_name
     */

    /**
     * @param $tax_name
     * @return string
     */
    public static function get_tax_archive_link( $tax_name )
    {
        return WebMapp_TemplatesRedirect::get_tax_archive_link( $tax_name );
    }

    /**
     * Check if in this project has routes checked in options page
     * todo Move to RegisterPostType
     * @return bool
     */
    static function project_has_route()
    {
        $r = false;
        $option = get_option('webmapp_has_route');
        if ( ! empty( $option ) && $option != false )
            $r = true;
        return $r;
    }

    /**
     * Check if in this project tracks post type have webmapp_category
     * todo Move to RegisterPostType
     * @return bool
     */
    static function tracks_has_webmapp_category()
    {
        $r = false;
        $option = get_option('webmapp_tracks_has_webmapp_category');
        if ( ! empty( $option ) && $option != false )
            $r = true;
        return $r;
    }

    /**
     * Useful tool to create custom capabilities with singolar word provided
     * @param $single_post_type_label
     * @return array
     */
    static function build_custom_capabilities( $single_post_type_label )
    {
        $single = $single_post_type_label;
        $plural = (string) $single . 's';
        $capabilities = array(
            'delete_others_posts' => "delete_others_$plural",
            'delete_posts' => "delete_$plural",
            'delete_private_posts' => "delete_private_$plural",
            'delete_published_posts' => "delete_published_$plural",
            'edit_others_posts' => "edit_others_$plural",
            'edit_posts' => "edit_$plural",
            'edit_private_posts' => "edit_private_$plural",
            'edit_published_posts' => "edit_published_$plural",
            'publish_posts' => "publish_$plural",
            'read_private_posts' => "read_private_$plural"
        );
        return $capabilities;
    }

   static public function get_unique_id()
   {
       return str_replace( '.' , '' , uniqid('webmapp_' , true ) );
   }


    static public function array_unique_terms( $terms )
    {
        $new_terms = array();
        $terms_ids = array_map( function($e){ return isset($e->term_id) ? $e->term_id : null; },$terms );
        $terms_ids = array_unique( $terms_ids );
        foreach ( $terms_ids as $key => $term_id )
            $new_terms[ $key ] = $terms[ $key ];
        return $new_terms;
    }


    /**
     * @param $files - array of post media id, values of inputs
     * @param string $input_name - input name
     *
     * @return string - input html
     */
    static public function upload_files_input ( $files , $input_name = 'img' ) {
        
        if ( $files && is_string( $files ) )
            $files = array( $files );

        $id = WebMapp_Utils::get_unique_id();


        ob_start();
        ?>
        <div id="<?php echo $id?>" class="custom-file-container" data-input="<?php echo $input_name?>">
            <?php
            if ( ! empty( $files ) ) {
                foreach ( $files as $file ) {

                    $your_img_src = wp_get_attachment_image($file , 'thumbnail', true);
                    ?>
                    <div class="file-container">
                        <div class="webmapp-file-box">
                            <?php echo $your_img_src ?>
                            <input type="button" class="webmapp-remove-element remove-this-file button" value="X" style="display:none"/>
                            <input type="hidden" class="<?php echo $input_name ?>" name="<?php echo $input_name ?>" value="<?php echo $file ?>" />
                        </div>
                        <?php echo "<p><a href='" . wp_get_attachment_url($file) . "' target='blank'>" . get_the_title($file) . "</a></p>" ?>
                    </div>
                    <?php
                }//end foreach
            }
            ?>

        <!-- Your add & remove image links -->
        <a class="upload-custom-file button">
            <?php _e('Add') ?>
        </a>
        </div>
        <script>
            jQuery(document).ready( function( $ )
            {
                $('#<?php echo $id?>').webmappFileInput({
                    name : "<?php echo $input_name ?>"
                });
            }
            );
        </script>
        <?php

        return ob_get_clean();

    }

    /**
     * Alias function
     * Get multilanguage option with WPML ( "_{ lang_code }" postfix in option name )
     * @param $option_name
     * @return mixed
     */
    public static function get_option( $option_name )
    {
        return WebMapp_AdminOptionsPage::get_option( $option_name );
    }

    public static function get_main_tax( $post_id )
    {
        $post_type = get_post_type( $post_id );
        $main_tax_c = '';
        if ( $post_type != 'poi' )
            $main_tax_c = 'activity';
        elseif( $post_type == 'poi' )
            $main_tax_c = 'webmapp_category';
        return $main_tax_c;
    }

    /**
     * Alias function
     */
    public static function getShortInfo()
    {
        $template_functions = new WebMapp_TemplateSingle();
        return $template_functions->getShortInfo();
    }

    /**
     * Alias function
     */
    public static function theShortInfo()
    {
        $template_functions = new WebMapp_TemplateSingle();
        $template_functions->theShortInfo();
    }

    /**
     * Recursive function that convert object and his properties in array format
     * @param $object
     * @return mixed
     */
    public static function object_to_array( $object )
    {

        if ( ! is_object( $object) )
            return $object;

        else
        {
            $array = get_object_vars ( $object );
            foreach ( $array as $key => $value )
            {
                if ( is_object( $value ) )
                    $array[$key] = array_filter(
                            WebMapp_Utils::object_to_array( $value ) ,
                            function($data)
                        {
                            return $data !== array();
                        }
                    );
            }

            return $array;
        }
    }


    public static function get_featured_image_header( $featured_image, $taxonomy , $term_id = array() , $post_id = 0 )
    {
        if ( $featured_image )
        {
            if ( ! empty( $term_id ) )
                $term_id = array( $term_id );

            $terms = array();

            if ( $taxonomy ) :
                if ( $post_id )
                {

                    $this_post_type = get_post_type( $post_id );


                    if ( $taxonomy == 'activity' && $this_post_type == 'route' )
                        $terms = WebMapp_ActivityRoute::get_route_activities( $post_id );
                    else
                        $terms = get_the_terms( $post_id , $taxonomy );

                }
                elseif ( $term_id )
                    $terms = get_terms( array( 'taxonomy' => $taxonomy, 'include' => $term_id ) );
            endif;

            ?>
            <!-- LAYER 1 -->
            <div id='webmapp-layer-1' class="webmapp-featured-image">
                <div class="webmapp-featured-image-img" style="background-image: url('<?php echo $featured_image; ?>')">
                    <div class="container">
                        <?php if ( $terms && is_array( $terms ) ) :

                            $class = '';
                            if ( count($terms) > 1 )
                                $class= ' multiple';
                            ?>

                            <h2 class='webmapp-main-tax-name<?php echo $class?>'>
                                <?php foreach( $terms as $term ) :
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    $term_link = get_term_link( $term->term_id );
                                    ?>
                                <span class="webmapp-main-tax-span-wrapper webmapp_customizer_general_color1-background-color-brightness webmapp_customizer_general_font2-font-size webmapp_customizer_general_size6-font-size webmapp_customizer_general_font2-font-family">
                                    <a href="<?php echo $term_link?>" title="<?php echo $term->name ?>">
                                        <?php if ( isset($term_icon) ) { ?>
                                        <i class='<?php echo $term_icon?> webmapp_customizer_general_color1-background-color'></i>
                                        <?php } ?>
                                        <span><?php echo $term->name ?></span>
                                    </a>
                                </span>
                                <?php endforeach; ?>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- END LAYER 1 -->
<?php

        }
    }


    /**
     * Load Any Post shortcode template
     * @param $template_name
     */
    public static function get_anypost_shortcode_template( $template_name )
    {
        $template_actual_name = "webmapp_anypost-$template_name.php";

        $located = locate_template( $template_actual_name );

        if ( $located == '' && file_exists( WebMapp_ShortcodeTemplates_AnyPost_DIR . $template_actual_name ) )
            $located = WebMapp_ShortcodeTemplates_AnyPost_DIR . $template_actual_name;

        if ( $located )
            load_template( $located , false );
        else
            echo "Template $template_name, provided to any post shortcode, is wrong.";

    }


}