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
            //set key montepisanotree_order_json in user session with json order
            if( ! session_id() ) {
                session_start();
            }
            $_SESSION['hoquids'][] = $response['id'];
        }
    }
}
add_action( "wp_trash_post", "delete_track_job_hoqu", 999, 1);

// Function that adds hoqu job to taxonomy on delete
function delete_taxonomy_job_hoqu( $term_id, $tt_id, $taxonomy ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");

    if ($hoqu_token && $hoqu_baseurl) {
        $term = get_term_by('id', $term_id, $taxonomy);

        $job = 'delete_taxonomy';
        $response = wm_hoqu_job_api($term_id, $job, $hoqu_token, $hoqu_baseurl);
        if ($response['id']) {
            //set key montepisanotree_order_json in user session with json order
            if( ! session_id() ) {
                session_start();
            }
            $_SESSION['hoquids'][] = $response['id'];
        }
    }
}
add_action( "delete_term", "delete_taxonomy_job_hoqu", 99, 3);

function sample_admin_notice__success() {
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
add_action( 'admin_notices', 'sample_admin_notice__success' );