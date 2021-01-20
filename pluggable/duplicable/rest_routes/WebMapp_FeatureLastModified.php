<?php

/**
 * Check the last modification of a feature
 *
 * @return object|null json with last_modified parameter
 *
 * wm_api_voucher()
 */
function WebMapp_FeatureLastModified( WP_REST_Request $request ) {
 
    $resp=array();
    $feature_id = $request->get_param("id");

    //get post default language id
    $wm_post_id = wm_get_original_post_it($feature_id);

    $feature = get_post($wm_post_id['id']);
    $feature_modified = new DateTime($feature->post_modified);
    $last_modified = $feature_modified->format('Y-m-d H:i:s');
    $resp['last_modified']=$last_modified;
    
    return new WP_REST_Response($resp,200);

}

$namespace = 'webmapp/v1';
$route = '/feature/last_modified/(?P<id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_FeatureLastModified',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_FeatureLastModified = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


