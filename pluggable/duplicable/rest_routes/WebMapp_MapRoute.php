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
    ),
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1MapsRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );

/**
 * Returns the conf object for a map
 *
 * @return object|null .
 *
 * webmapp_map_conf()
 */

function WebMapp_V1MapConfRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $map_id = $param["id"];

    $map = get_post($map_id);

    $result = array();

    /*Aggiungo dati di esempio */
//   var_dump($map); //controlla i campi disponibili per la mappa
    $result["map-id"] = $map->ID;
    $result["name"] = $map->post_title;

    /*
     * per prendere i custom fields usare la funzione get_field(custom_field, id)
     * per la lista dei custom fields fare riferimento al file includes/custom_fields.php
     * dove sono registrati i custom fields per ogni post type
     */
    $result["type"] = get_field("field_map_type", $map->ID);

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/map/(?P<id>\d+).conf';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1MapConfRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1MapConfRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );