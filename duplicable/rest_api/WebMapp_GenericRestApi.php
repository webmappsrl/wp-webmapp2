<?php


WebMapp_RestApi::register_rest_field( 'route' ,'activity' ,
    function ($obj_array, $field_name) {
        return WebMapp_ActivityRoute::get_route_activities( $obj_array['id'] , 'ids');
    }
);

//out of group and only in rest api
WebMapp_RestApi::register_rest_field( 'track' ,'n7webmap_geojson' ,
    function ($obj_array, $field_name) {
        return get_post_meta($obj_array['id'], $field_name, TRUE);
    }
);


//out of group and only in rest-api
WebMapp_RestApi::register_rest_field( 'route' ,'n7webmapp_route_bbox' ,
    function ($obj_array, $field_name) {
        return get_post_meta($obj_array['id'], $field_name, TRUE);
    }
);