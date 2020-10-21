<?php

// Function that adds hoqu job to poi save and create
function update_poi_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ($post->post_status == 'publish') {
            $job = 'update_poi';
            wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl);
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
                $osmid = get_field('osmid',$post_id);
                if ($osmid) {
                    $job = 'update_track_metadata';
                    wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl);
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
}