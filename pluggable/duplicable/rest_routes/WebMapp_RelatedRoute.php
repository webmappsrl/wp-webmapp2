<?php

/**
 * Given a Track ID Returns a list of related route IDs
 *
 * @return object|null json with route IDs
 *
 * wm_api_voucher()
 */
function WebMapp_Relatedroute( WP_REST_Request $request ) {
 
    $feature_id = $request->get_param("id");
    $feature = get_post($feature_id);
    $feature_type = $feature->post_type;

    if ($feature_type !== 'track')
        return new WP_REST_Response(array('error' => 'The feature should be a track'), 400);

    $routes = get_posts(array('post_type'=>'route','posts_per_page'=>-1, 'post_status' => 'publish'));
    $features=array();
    foreach ($routes as $route) {
        $rrt = get_field("n7webmap_route_related_track", $route->ID);
        if (is_array($rrt) && !empty($rrt)) {
            foreach ($rrt as $r){
                if ($r->ID) {
                    $qry_id = $r->ID;
                    if ($qry_id == $feature_id) {
                        $features[] = $route->ID;
                    }
                } else {
                    $qry_id = intval($r);
                    if ($qry_id == $feature_id) {
                        $features[] = $route->ID;
                    }
                }
            }
        } 
    }

    
    return new WP_REST_Response($features,200);

}

$namespace = 'webmapp/v1';
$route = '/track/related_routes/(?P<id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_Relatedroute'
);
$WebMapp_Relatedroute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


