<?php

add_action( "save_post_poi", "update_poi_job_hoqu", 10, 3);
function update_poi_job_hoqu( $post_id, $post, $update ){

    $site_url = site_url();
    $hoqu_token = get_option("webmapp_hoqu_token");
    if ($hoqu_token) {

        $CURLOPT_POSTFIELDS_ARRAY = "{
            \"instance\": \"$site_url\",
            \"job\": \"mptupdate\",
            \"parameters\": {
                \"id\": \"$post_id\",
            }
          }";
        
          $curl = curl_init();
        
          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://hoqustaging.webmapp.it/api/store",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $CURLOPT_POSTFIELDS_ARRAY,
            CURLOPT_HTTPHEADER => array(
              "Accept: application/json",
              "Content-type: application/json",
              "Authorization : Bearer $hoqu_token"
            ),
          ));
        
          $response = curl_exec($curl);
          $err = curl_error($curl);
          
          print_r($response);
          curl_close($curl);
    }
    
}