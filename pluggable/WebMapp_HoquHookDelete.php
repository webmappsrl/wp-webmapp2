<?php

// Function that adds hoqu job to route save and create
function delete_track_job_hoqu( $post_id ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");
    if ($hoqu_token && $hoqu_baseurl) {
            
        $wm_post = wm_get_original_post_it($post_id);

        $post = get_post( $post_id );
        $post_type = $post->post_type;
        if ($post_type == 'track') 
            $job = 'delete_track';

        if ($post_type == 'route') 
            $job = 'delete_route';

        if ($post_type == 'poi') 
            $job = 'delete_poi';
            
        $response = wm_hoqu_job_api($wm_post['id'], $job, $hoqu_token, $hoqu_baseurl);
        
        if ($response['id']) {
            //set key hoquids after success response from hoqu
            if( ! session_id() ) {
                session_start();
            }
            $_SESSION['hoquids'][] = $response['id'];
        }

        // after sending hoqu job to delete_track sends another job to update related routes
        if ($post_type == 'track') {
            wm_update_route_after_track_trashed_draft($wm_post['id'],$hoqu_token,$hoqu_baseurl);
        } 
    }
}
add_action( "wp_trash_post", "delete_track_job_hoqu", 99, 1);

// Function that adds hoqu job to taxonomy on delete
function delete_taxonomy_job_hoqu( $term_id, $tt_id, $taxonomy ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        $term = get_term_by('id', $term_id, $taxonomy);

        $job = 'delete_taxonomy';
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
add_action( "delete_term", "delete_taxonomy_job_hoqu", 99, 3);

function wm_admin_notice__success() {
    $hoquids = $_SESSION['hoquids'];
    if (!empty($hoquids)) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Hoqu successfuly processed post: <span id="hoqu-deleted-ids"><?php echo implode(",", $hoquids); ?></span></p>
        </div>
        <?php
    }

    $_SESSION['hoquids'] = null;
}
add_action( 'admin_notices', 'wm_admin_notice__success' );

// Sends a update_route job to hoqu when the track and route relation is deleted on track status being changed to Draft
function wm_update_route_after_track_trashed_draft($post_id,$hoqu_token,$hoqu_baseurl) {

    $home_url = home_url();
    $related_routes = "$home_url/wp-json/webmapp/v1/track/related_routes/$post_id";
    $c = json_decode(file_get_contents($related_routes),TRUE);
    $routes_id = $c['related_routes'];
    if ($routes_id){
        foreach($routes_id as $id) {
            $job = 'update_route';
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