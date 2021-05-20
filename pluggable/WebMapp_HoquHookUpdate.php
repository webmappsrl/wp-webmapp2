<?php

// Function that adds hoqu job to poi save and create
function update_poi_job_hoqu( $post_id, $post, $update ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        $wm_post = wm_get_original_post_it($post_id);

        if ($post->post_status == 'publish') {
            $job = 'update_poi';
        }
        if ($post->post_status == 'draft') {
            $job = 'delete_poi';
        }
        if ($wm_post['id'] && $wm_post['id'] !== null) {
            $response = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
            if ($response['id']) {
                //set key hoquids after success response from hoqu
                if( ! session_id() ) {
                    session_start();
                }
                $_SESSION['hoquids'][] = $response['id'];
            }
        }
    }
}
add_action( "save_post_poi", "update_poi_job_hoqu", 99, 3);





// Function that adds hoqu job on track acf update
function update_track_job_hoqu( $post_id){

    $post = get_post( $post_id );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {

                $wm_post = wm_get_original_post_it($post_id);

                $job = 'update_track';
                if ($wm_post['id'] && $wm_post['id'] !== null) {
                    $risposta = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
                }

            }
        }
    }    
}
add_action( "acf/save_post", "update_track_job_hoqu", 99, 1);




// Function that adds hoqu job to track save and create the translation
function update_track_translation_job_hoqu( $post_id, $post, $update){
        
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            $wm_post = wm_get_original_post_it($post_id);
            if ($post->post_status == 'publish') {
                $job = 'update_track';
            }
            if ($post->post_status == 'draft') {
                $job = 'delete_track';
            }
            if ($wm_post['id'] && $wm_post['id'] !== null) {
                $response = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
                if ($response['id']) {
                    //set key hoquids after success response from hoqu
                    if( ! session_id() ) {
                        session_start();
                    }
                    $_SESSION['hoquids'][] = $response['id'];
                }
            }

            // after sending hoqu job to delete_track sends another job to update related routes
            if ($post->post_status == 'draft') {
                wm_update_route_after_track_trashed_draft($wm_post['id'],$hoqu_token,$hoqu_baseurl);
            }
        }
    }    
}
add_action( "save_post_track", "update_track_translation_job_hoqu", 99, 3);


// creates ajax function in admin footer that listens to update osmid button
// Updates's track osmid on demand request
function wm_acf_input_admin_footer() {
    ?>
    <script type="text/javascript">
    (function($) {
        $(window).load(function() {

            var osmid;
            osmid = $( "#acf-wm_track_osmid" ).val();
            $( "#acf-wm_track_osmid" ).keyup(function( e ) { 
                  
                osmid = this.value;
                $("#update_button_track_osmid_success").css({"display":"none"});
                
            });
            $( "#update_button_track_osmid" ).on( "click", function() {
                var post_id = jQuery("#post_ID").val();
                $("#update_button_track_osmid_success").css({"display":"none"});
                $("#osmid-hoqu-id-response").remove();
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
                    complete:function(response){
                        obj = JSON.parse(response.responseText);
                        $("<span id='osmid-hoqu-id-response' value="+obj.id+"></span>").appendTo("#update_button_track_osmid_success")
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
// Updates's track osmid on demand function
add_action( 'wp_ajax_acf_osmid_update_hoqu', 'acf_osmid_update_hoqu' );
function acf_osmid_update_hoqu(){
    $osmid = $_POST['osmid'];
    $post_id = $_POST['postid'];          
    update_field('osmid', $osmid, $post_id);
    $post = get_post( $post_id );
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        if ( $post->post_type == 'track' ) {
            if ($post->post_status == 'publish') {
                $job = 'update_track_osmid';
                $risposta = wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl);
            }
        }
    }
    echo json_encode($risposta);
    wp_die();
}



// Function that adds hoqu job to route save and create
function update_route_job_hoqu( $post_id, $post, $update ){
    
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        $wm_post = wm_get_original_post_it($post_id);
        if ($post->post_status == 'publish') {
            $job = 'update_route';
        }
        if ($post->post_status == 'draft') {
            $job = 'delete_route';
        }
        if ($wm_post['id'] && $wm_post['id'] !== null) {
            $response = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
            if ($response['id']) {
                //set key hoquids after success response from hoqu
                if( ! session_id() ) {
                    session_start();
                }
                $_SESSION['hoquids'][] = $response['id'];
            }
        }
    }
}
add_action( "save_post_route", "update_route_job_hoqu", 99, 3);

// Function that adds hoqu job to taxonomy save and create
function update_taxonomy_job_hoqu( $term_id, $tt_id, $taxonomy ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {

        $job = 'update_taxonomy';
        $response = wm_hoqu_job_api($term_id, $job, $hoqu_token, $hoqu_baseurl);
        if ($response['id']) {
            //set key hoquids after success response from hoqu
            if( ! session_id() ) {
                session_start();
            }
            $_SESSION['hoquids'][] = $response['id'];
        }
    }
}
add_action( "edit_term", "update_taxonomy_job_hoqu", 99, 3);


// Function that sends a create API to hoqu
function wm_hoqu_job_api($post_id, $job, $hoqu_token, $hoqu_baseurl) {
    
    $home_url = wm_create_clean_home_url();

    $requestJson = array();
    if ($job == 'update_track_osmid') {
        $requestJson = array(
            'instance' => $home_url,
            'job' => 'update_track',
            'parameters' => array(
                'id' => $post_id,
                'update_geometry' => true 
            )
        );
    } else {
        $requestJson = array(
            'instance' => $home_url,
            'job' => $job,
            'parameters' => array(
                'id' => $post_id,
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
        error_log("Something went wrong: $error_message");
    } 
    else {
        $response = json_decode(wp_remote_retrieve_body($response), true);
        return $response;
    }
    
}



// Uses WPML filters to determine the ID of the post in original language
function wm_get_original_post_it($post_id) {
    $post = get_post( $post_id );
    $post_type = $post->post_type;

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] ) {
        if ( $post_lang['language_code'] == $default_lang ) {
            $wm_post_id['id'] = $post_id;
        } else {
            $post_default_language_id = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $default_lang );
            $wm_post_id['id'] = $post_default_language_id; 
        }
    } else {
        $wm_post_id['id'] = $post_id;
    }

    // if ($post_lang['language_code'] !== $default_lang ) {
    //     $wm_post_id['is_translation'] = true;
    // } else {
    //     $wm_post_id['is_translation'] = false;
    // } 
    // add_action(wpml_set_element_language_detail
    // .ajaxComplete()

    return $wm_post_id;
}

function wm_create_clean_home_url () {
    $home_url = home_url();
    $home_url = preg_replace('#^https?://#', '', $home_url); //removes https:// and https:// from home url
    $home_url = preg_replace('#www.#', '', $home_url); //removes www. from home url
    $home_url = explode('/',$home_url); // removes all the parameters after the domain name
    $home_url = $home_url[0];
    return $home_url;
}


// Function that add hoqu jobs after admin column edit inline and bulk edit
function bulk_update_admin_column_job_hoqu( $column, $id, $value ) {
    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");    

    if ($hoqu_token && $hoqu_baseurl) {

        $post_type = $column->get_post_type();
        if ($post_type == 'track' || $post_type == 'route' || $post_type == 'poi') {

            // only applies when the column type is a 'osmid' and is from the post type 'track'
            if ( 'wm_track_osmid' == $column->get_option('field') ) {
                $job = 'update_track_osmid';
            } else {
                $job = 'update_'.$post_type;
            }
            $response = wm_hoqu_job_api($id, $job, $hoqu_token, $hoqu_baseurl);
            if ($response['id']) {
                //set key hoquids after success response from hoqu
                if( ! session_id() ) {
                    session_start();
                }
                $_SESSION['hoquids'][] = $response['id'];
            }
        }
    }
}
add_action( 'acp/editing/saved', 'bulk_update_admin_column_job_hoqu', 10, 3 );