<?php

# Register a custom 'foo' command to output a supplied positional param.
#
# $ wp foo bar --append=qux
# Success: bar qux

/**
 * Updates all the custom post types TRACK and updates osmid if exists. plus checks for the image size pdf-large
 *
 *
 * @when after_wp_load
 */
$wm_save_tracks = function( $args, $assoc_args )
{
    $results = new WP_Query( array( 'post_type' => 'track','post_status' => 'publish', 'posts_per_page' => -1) );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");
    $home_url = wm_create_clean_home_url();

    foreach ( $results->posts as $post ) {
        WP_CLI::success('Updating track ID # ' . $post->ID);

        $osmid = get_field('osmid', $post->ID);

        $requestJson = array();
        if (!empty($osmid) && $osmid) {
            $requestJson = array(
                'instance' => $home_url,
                'job' => 'update_track',
                'parameters' => array(
                    'id' => $post->ID,
                    'update_geometry' => true 
                )
            );
        } else {
            $requestJson = array(
                'instance' => $home_url,
                'job' => 'update_track',
                'parameters' => array(
                    'id' => $post->ID,
                )
            );
        }


        $response = wp_remote_post(
            "$hoqu_baseurl/store",
            array(
                'method'      => 'POST',
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'Content-Type' => 'application/json; charset=utf-8',
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer $hoqu_token"
                ),
                'body'        => json_encode($requestJson),
                'cookies'     => array()
            )
        );

        // error_log(print_r($requestJson), print_r($response));

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            WP_CLI::error('Error track ID # ' . $post->ID . 'Meddage: '. $error_message);
        } 
        else {
            $response = json_decode(wp_remote_retrieve_body($response), true);
            WP_CLI::success('Hoqu update job ID # ' . $response['id']);
        }
        
        // Create image siz pdf-large if it does not exists
        $feature_id = get_post_thumbnail_id($post->ID);
        if ($feature_id && !empty($feature_id)) {
            $cmd = "wp media regenerate $feature_id --image_size=pdf-large --allow-root";
            system($cmd);
        } else {
            WP_CLI::warning( "Track #$post->ID has no featured image");
        }
    }
};

WP_CLI::add_command( 'wm-save-tracks', $wm_save_tracks );