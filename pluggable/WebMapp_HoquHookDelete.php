<?php

// Function that adds hoqu job to route save and create
function delete_track_job_hoqu( $post_id ){

    $hoqu_token = get_option("webmapp_hoqu_token");
    $hoqu_baseurl = get_option("webmapp_hoqu_baseurl");
    if ($hoqu_token && $hoqu_baseurl) {
            
        $wm_post = wm_get_original_post_it($post_id);

        $job = 'delete_track';
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