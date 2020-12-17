<?php


/**
 * Returns all pois in geojson format
 *
 * @return object|null .
 *
 * webmapp_pois_geojson()
 */

function WebMapp_V1GeoJsonAllPoiRoute( WP_REST_Request $request ) {

    $result["type"] ='FeatureCollection';
    $pois = get_posts(array('post_type'=>'poi','posts_per_page'=>-1));
    $features=array();
    foreach ($pois as $poi) {
        $feature=array();
        //setup_postdata($poi);
        $feature['type']="Feature";
        $feature['properties']['id']=$poi->ID;
        $feature['properties']['name']=$poi->post_title;
        $feature['properties']['description']=$poi->post_content;

        // Address
        $addr = get_field("addr:street", $poi->ID);
        if ($addr) $feature['properties']['address']= $addr;

        // Housenumber
        $housenumber = get_field("addr:housenumber", $poi->ID);
        if ($housenumber) $feature['properties']['address_number']= $housenumber;

        $gallery = get_field("field_5853f586c83cd", $poi->ID);
        if($gallery)
            $feature['properties']['picture_url'] = $gallery[0]['url'];

        $coord = get_field('n7webmap_coord',$poi->ID);
        $feature['geometry']['type']='Point';
        $feature['geometry']['coordinates']=array((float) $coord['lng'], (float) $coord['lat']);

        $features[]=$feature;
    }
    //reset_postdata();
    $result['features']=$features;

    return new WP_REST_Response($result, 200);
}
$namespace = 'webmapp/v1';
$route = '/pois.geojson';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1GeoJsonAllPoiRoute',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
          return true;
  }
);
$WebMapp_V1GeoJsonAllPoiRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );

