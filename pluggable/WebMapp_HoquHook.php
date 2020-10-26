<?php

// Function that adds hoqu job to poi save and create
function update_poi_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ($post->post_status == 'publish') {
            
            $wm_post = wm_get_original_post_it($post_id);

            $job = 'update_poi';
            wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
        }
    }
}
add_action( "save_post_poi", "update_poi_job_hoqu", 10, 3);





// Function that adds hoqu job on track acf update
function update_track_job_hoqu( $post_id){

    $post = get_post( $post_id );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {

                $wm_post = wm_get_original_post_it($post_id);

                $has_gpx = get_field('n7webmap_geojson',$wm_post['id']);
                if ($has_gpx) {
                    $job = 'update_track';
                } else {
                    $job = 'update_track_metadata';
                }
                
                $risposta = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
                $ris = $risposta;

            }
        }
    }    
}
add_action( "acf/save_post", "update_track_job_hoqu", 20, 1);




// Function that adds hoqu job to track save and create the translation
function update_track_translation_job_hoqu( $post_id, $post, $update){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {

                $wm_post = wm_get_original_post_it($post_id);

                if ($wm_post['is_translation'] == true ) {
                    $job = 'update_track';
                    wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
                }
            }
        }
    }    
}
add_action( "save_post_track", "update_track_translation_job_hoqu", 10, 3);


// Updates's track osmid on demand
add_action('acfe/fields/button/name=update_track_osmid', 'update_track_osmid_hoqu', 20, 2);
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


// creates ajax function in admin footer that listens to update osmid button
function wm_acf_input_admin_footer() {
    ?>
    <script type="text/javascript">
    (function($) {
        $(window).load(function() {
            var osmid;
            $( "#acf-wm_track_osmid" ).keyup(function( e ) { 
                  
                osmid = this.value;
                $("#update_button_track_osmid_success").css({"display":"none"});
                
            });
            $( "#update_button_track_osmid" ).on( "click", function() {
                var post_id = jQuery("#post_ID").val();
                $("#update_button_track_osmid_success").css({"display":"none"});
                var data = {
                    'action': 'acf_osmid_update_hoqu',
                    'osmid': osmid,
                    'postid':  post_id,
                };
                $.ajax({
                    url: ajaxurl,
                    type : 'post',
                    data: data,
                    beforeSend: function(){
                        $("#osmid_ajax_spinner").addClass("is-active");
                    },
                    success : function( response ) {
                        $("#update_button_track_osmid_success").css({"display":"inline","color":"green"});
                    },
                    complete:function(data){
                        $("#osmid_ajax_spinner").removeClass("is-active");
                    }
                });
            });
        });
    })(jQuery);	
    </script>
    <?php
            
    }
add_action('acf/input/admin_footer', 'wm_acf_input_admin_footer');

// action that process ajax call : wm_acf_input_admin_footer() to update osmid ACF
add_action( 'wp_ajax_acf_osmid_update_hoqu', 'acf_osmid_update_hoqu' );
function acf_osmid_update_hoqu(){
    $osmid = $_POST['osmid'];
    $post_id = $_POST['postid'];          
    $return = update_field('osmid', $osmid, $post_id);
    echo $return;
    wp_die();
} 

// Function that adds hoqu job to route save and create
function update_route_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ($post->post_status == 'publish') {
            
            $wm_post = wm_get_original_post_it($post_id);

            $job = 'update_route';
            wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
        }
    }
}
add_action( "save_post_route", "update_route_job_hoqu", 10, 3);


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
    // else {
    //     return $response;
    // }
    $response = array();
    $response['job'] = 'update_track_geometry';
    return $response;
}



// Uses WPML filters to determine the ID of the post in original language
function wm_get_original_post_it($post_id) {
    $post = get_post( $post_id );
    $post_type = $post->post_type;

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang ) {
        $wm_post_id['id'] = $post_id;
    } else {
        $post_default_language_id = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $default_lang );
        $wm_post_id['id'] = $post_default_language_id;
    }

    if ($post_lang['language_code'] !== $default_lang ) {
        $wm_post_id['is_translation'] = true;
    } else {
        $wm_post_id['is_translation'] = false;
    }

    return $wm_post_id;
}