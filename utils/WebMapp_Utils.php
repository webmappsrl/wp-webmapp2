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
}