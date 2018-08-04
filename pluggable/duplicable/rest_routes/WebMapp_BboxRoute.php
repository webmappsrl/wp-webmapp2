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
$args = array( 'methods' => 'GET', 'callback' => 'WebMapp_V1BboxRoute' );
$WebMapp_V1BboxRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );

