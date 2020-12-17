<?php

/**
 * Returns all tracks in geojson format
 *
 * @return object|null .
 *
 * webmapp_tracks_geojson()
 */
function WebMapp_V1GeoJsonAllTrackRoute( WP_REST_Request $request ) {

    $result["type"] = 'FeatureCollection';
    $tracks = get_posts(array('post_type' => 'track', 'posts_per_page' => -1));
    $features = array();
    foreach ($tracks as $track) {
        $feature = array();
        $geometry = get_field('n7webmap_geojson', $track->ID);
        if ($geometry != null && $geometry != "") {
            $feature["type"] = 'Feature';
            $feature['properties']['id']=$track->ID;
            $feature["properties"]["name"] = $track->post_title;
            $feature['properties']['description'] = $track->post_content;
            $feature['properties']['color']=  get_field('n7webmapp_track_color', $track->ID);
            $gallery = get_field("field_5853f586c83cd", $track->ID);
            if($gallery){
                $feature['properties']['picture_url'] = $gallery[0]['url'];
            }

            $feature["geometry"] = $geometry;
            $features[] = $feature;
        }
    }
    $result['features'] = $features;

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/tracks.geojson';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1GeoJsonAllTrackRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1GeoJsonAllTrackRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );
