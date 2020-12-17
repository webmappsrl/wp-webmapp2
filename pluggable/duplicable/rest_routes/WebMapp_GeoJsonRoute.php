<?php

/**
 * Returns the geojson object for a route
 *
 * @return object|null .
 *
 * webmapp_route_geojson()
 */

function WebMapp_V1GeoJsonDataRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $obj_id = $param["id"];

    $obj = get_post($obj_id);


    $result = array();
    /*Aggiungo dati di esempio */
//   var_dump($map); //controlla i campi disponibili per la mappa
    $result["route-id"] = $obj->ID;
    $result["name"] = $obj->post_title;

    /*
     * per prendere i custom fields usare la funzione get_field(custom_field, id)
     * per la lista dei custom fields fare riferimento al file includes/custom_fields.php
     * dove sono registrati i custom fields per ogni post type
     */
    $result["related_track"] = get_field("n7webmap_route_related_track", $obj->ID);

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/route/(?P<id>\d+).geojson';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1GeoJsonDataRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1GeoJsonDataRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


/**
 * Returns the track object for a route
 *
 * @return object|null .
 *
 * webmapp_track_geojson()
 */

function WebMapp_V1TrackGeoJsonRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $obj_id = $param["id"];

    $result = geojson_track($obj_id);

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/track/(?P<id>\d+).geojson';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1TrackGeoJsonRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1TrackGeoJsonRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


/**
 * Returns the geojson object for a route
 *
 * @return object|null .
 *
 * webmapp_poi_geojson()
 */

function WebMapp_V1PoiGeoJsonRoute( WP_REST_Request $request ) {
    $param = $request->get_url_params();
    $obj_id = $param["id"];

    $obj = get_post($obj_id);


    $result = array();
    /*Aggiungo dati di esempio */
//   var_dump($map); //controlla i campi disponibili per la mappa
    $result["map-id"] = $obj->ID;
    $result["name"] = $obj->post_title;

    /*
     * per prendere i custom fields usare la funzione get_field(custom_field, id)
     * per la lista dei custom fields fare riferimento al file includes/custom_fields.php
     * dove sono registrati i custom fields per ogni post type
     */
    $result["coords"] = get_field("n7webmap_coord", $obj->ID);

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/poi/(?P<id>\d+).geojson';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1PoiGeoJsonRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1PoiGeoJsonRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );
