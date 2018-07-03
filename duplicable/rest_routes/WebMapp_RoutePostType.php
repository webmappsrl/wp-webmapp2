<?php


/**
 * Returns the routes for users
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_user_maps()
 */
function WebMapp_V1MapsRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $user_id = $param["id"];

    $maps = get_posts(array(
        'post_type' => 'map',
        'meta_query' => array(
            array(
                'key' => 'n7webmap_map_users',
                // name of custom field
                'value' => '"' . $user_id . '"',
                // matches exaclty "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));
    $controller = new WP_REST_Posts_Controller("map");
    $result = array();
    foreach ($maps as $post) {
        $data = $controller->prepare_item_for_response($post, $request);
        $result[] = $controller->prepare_response_for_collection($data);
    }
    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/maps/(?P<id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1MapsRoute',
    'args' => array(
        'id' => array(
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param);
            }
        ),
    )
);
$WebMapp_V1MapsRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


/**
 * Returns the routes id for users
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_user_maps_id()
 */
function WebMapp_V1UserMapsRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $user_id = $param["id"];

    $routes = get_posts(array(
        'post_type' => 'map',
        'meta_query' => array(
            array(
                'key' => 'n7webmap_map_users',
                // name of custom field
                'value' => '"' . $user_id . '"',
                // matches exaclty "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));
    $controller = new WP_REST_Posts_Controller("map");
    $result = array();
    foreach ($routes as $post) {
        $result[$post->ID] = array("active" => TRUE);
    }
    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/maps_id/(?P<id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1UserMapsRoute',
    'args' => array(
        'id' => array(
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param);
            }
        ),
    )
);
$WebMapp_V1UserMapsRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );



/**
 * Returns the routes id for users
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_user_route_id()
 */
function WebMapp_V1UserRouteIdRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $user_id = $param["id"];

    $routes = get_posts(array(
        'post_type' => 'route',
        'numberposts' => -1,
        'meta_query' => array(
            array(
                'key' => 'n7webmap_route_users',
                // name of custom field
                'value' => '"' . $user_id . '"',
                // matches exaclty "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));

    $result = array();
    foreach ($routes as $post) {
        $result[$post->ID] = array("active" => TRUE);
    }
    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/route_id/(?P<id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1UserRouteIdRoute',
    'args' => array(
        'id' => array(
            'validate_callback' => function ($param, $request, $key) {
                return is_numeric($param);
            }
        ),
    )
);
$WebMapp_V1UserRouteIdRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );
