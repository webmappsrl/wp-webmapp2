<?php

function update_poi_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        
        $home_url = home_url();
        $home_url = preg_replace('#^https?://#', '', $home_url);

        $requestJson = array(
            'instance' => $home_url,
            'job' => 'mptupdate',
            'parameters' => array(
                'id' => $post_id
            )
        );
    
        $response = wp_remote_post(
            "$hoqu_baseurl",
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


    
}
add_action( "save_post_poi", "update_poi_job_hoqu", 10, 3);