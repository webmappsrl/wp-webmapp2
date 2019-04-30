<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Patch acf gallery fields
 *
 *
 * @when after_wp_load
 */
$wm_patch_fields = function( $args, $assoc_args )
{

    global $wpdb;

    WP_CLI::line( "######################## START PATCHING FIELDS ########################\n\n" );
    $wp = new WebMapp_WpCli_Utils();
    $wp->backup_db('presave' . date('d_m_Y__G_i_s') .'.sql');

    $fucking_key = "field_5853f586c83cd";
    $posts_meta = array(
        'poi' => array(
            'key' => 'wm_poi_gallery',
            'name' => 'n7webmap_media_gallery'
        ),
        'track' => array(
            'key' => 'wm_track_gallery',
            'name' => 'n7webmap_track_media_gallery'
        ),
        'route' => array(
            'key' => 'wm_route_gallery',
            'name' => 'n7webmap_route_media_gallery'
        )
    );


    foreach ( $posts_meta as $post_type => $val )
    {
        $new_key = $val['key'];
        $new_name = $val['name'];
        $queries = array();

        $tmp = $posts_meta;
        unset( $tmp[$post_type] );
        $tmp = array_values( $tmp );
        $field_name1 = $tmp[0]['name'];
        $field_name2 = $tmp[1]['name'];



        WP_CLI::line( "\n ****** Init patching $post_type fields in {$wpdb->prefix}postmeta table ... \n");

        //fixing fields keys and controller
        $queries['FIELD KEY AND ACF CONTROLLER'] = <<<EOT
    UPDATE {$wpdb->prefix}postmeta as pm
    INNER JOIN {$wpdb->prefix}posts as p
    ON pm.meta_value='$fucking_key' AND pm.post_id=p.ID AND p.post_type='$post_type'
    SET pm.meta_value='$new_key' , pm.meta_key = '_$new_name'
EOT;


        //fixing fields names
        $queries['FIELD NAME'] = <<<EOT
    UPDATE {$wpdb->prefix}postmeta as pm
    INNER JOIN {$wpdb->prefix}posts as p
    ON pm.post_id=p.ID AND p.post_type='$post_type' AND (pm.meta_key='$field_name1' OR pm.meta_key='$field_name2')
    SET pm.meta_key='$new_name'
EOT;


        foreach ( $queries as $string => $query )
        {
            WP_CLI::line( "Query: $string");
            $test = $wpdb->query( "$query" );
            WP_CLI::line( "Rows patched: $test");
            if ( $test )
                WP_CLI::success( "$post_type $string patched.");
        }





    }

    WP_CLI::line( "\n");
    WP_CLI::success( "######################## DONE ########################" );
};

WP_CLI::add_command( 'wm-patch-fields', $wm_patch_fields );