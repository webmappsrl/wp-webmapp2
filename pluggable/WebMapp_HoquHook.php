<?php

// Function that adds hoqu job to poi save and create
function update_poi_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ($post->post_status == 'publish') {
            
            $post_type = $post->post_type;
            //get post language
            $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
            //get wpml default language
            $default_lang = apply_filters('wpml_default_language', NULL );
            if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang ) {
                $wm_post_id = $post_id;
            } else {
                $post_default_language_id = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $default_lang );
                $wm_post_id = $post_default_language_id;
            }

            $job = 'update_poi';
            wm_hoqu_job_api($wm_post_id, $job, $hoqu_token, $hoqu_baseurl);
        }
    }
}
add_action( "save_post_poi", "update_poi_job_hoqu", 10, 3);


// Function that adds hoqu job to track save and create
function update_track_job_hoqu( $post_id){

    $post = get_post( $post_id );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {

                $post_type = $post->post_type;
                //get post language
                $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
                //get wpml default language
                $default_lang = apply_filters('wpml_default_language', NULL );
                if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang ) {
                    $wm_post_id = $post_id;
                } else {
                    $post_default_language_id = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $default_lang );
                    $wm_post_id = $post_default_language_id;
                }

                $osmid = get_field('osmid',$wm_post_id);
                if ($osmid) {
                    $job = 'update_track_metadata';
                    wm_hoqu_job_api($wm_post_id, $job, $hoqu_token, $hoqu_baseurl);
                }
            }
        }
    }    
}
add_action( "acf/save_post", "update_track_job_hoqu", 20, 1);

// Updates's track osmid on demand
add_action('acfe/fields/button/name=update_track_osmid', 'update_track_osmid_hoqu', 10, 2);
function update_track_osmid_hoqu($field, $post_id){
    
    $post = get_post( $post_id );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {
                $job = 'update_track_geometry';
                wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl);
            }
        }
    }    
}

// Function that sends a create API to hoqu
function wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl) {
    
    $home_url = home_url();
    $home_url = preg_replace('#^https?://#', '', $home_url); //removes https:// and https:// from home url

    $requestJson = array(
        'instance' => $home_url,
        'job' => $job,
        'parameters' => array(
            'id' => $post_id
        )
    );

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
        error_log("Something went wrong: $error_message");
    } 
    // elseif ($response['job'] == 'update_track_geometry') {
        
    // }
}