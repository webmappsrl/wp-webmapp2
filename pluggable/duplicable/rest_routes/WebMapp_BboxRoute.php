<?php

/**
 * Returns the bounding box webmapp setting
 *
 * @return string|null bounding box webmapp setting or null if none.
 *
 * webmapp_bbox()
 */
function WebMapp_V1BboxRoute($data) {
    $bbox = get_option('webmapp_bounding_box');

    if ( empty( $bbox ) ) {
        return NULL;
    }
    $data = array("bounding_box" => $bbox);
    return new WP_REST_Response($data, 200);
}
$namespace = 'webmapp/v1';
$route = '/bbox';
$args = array( 'methods' => 'GET', 'callback' => 'WebMapp_V1BboxRoute' ,
'permission_callback' => function () {
  $user_id = get_current_user_id();
  if (isset($user_id) && !empty($user_id) && $user_id > 0)
      return true;
});
$WebMapp_V1BboxRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );

