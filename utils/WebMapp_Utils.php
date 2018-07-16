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

    /**
     * Alias of get_tax_archive_link method
     *
     * @param $tax_name
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




}