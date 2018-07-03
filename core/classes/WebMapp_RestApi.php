<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 19:53
 */

class WebMapp_RestApi extends WebMapp_AbstractFields
{

    function __construct( $object_names,  $args )
    {
        parent::__construct( $object_names, $args );
        add_action( 'rest_api_init', array( $this , 'fields_to_rest_api' ) );
    }

    public function fields_to_rest_api()
    {
        $temp = $this->object_names;
        if ( ! is_array($temp ) && ! empty( $temp ) )
            $this->object_names = array( $temp );

        //support to fields of various custom types ( post/taxonomy )
        foreach( $this->object_names as $name )
            $this->register_rest_fields($name, $this->fields );
    }

    static function register_rest_field( $object_type, $attribute, $callback ) {

        register_rest_field($object_type, $attribute, array(
            'get_callback' =>  $callback
        ));

    }

    public function register_rest_fields( $post_type , $fields ) {

        foreach ( $fields as $field )
        {
            $field_type = $field["type"];
            /**
             * Dont load in rest-api tab fields ;)
             */
            if ( $field_type !== 'tab' )
            {
                $field_name = $field["name"];
                $field_key = $field["key"];
                self::register_rest_field( $post_type , $field_name,array( $this , 'register_rest_fields_callback' )  );

            }
        }
    }

    public function register_rest_fields_callback( $poi_array, $field_name )
    {
            $taxonomy = '';
            if (isset($poi_array['taxonomy'])) {
                $taxonomy = $poi_array['taxonomy'];
            }

            $poi_obj = get_post($poi_array['id']);

            if ($field_name == "n7webmap_route_media_gallery") {
                $field_name = "field_5853f586c83cd"; //TODO: rendere questa cosa più intelligente! la galleria ha dei problemi ad essere recuperata con il name
            }
            if ($field_name == "n7webmap_media_gallery") {
                $field_name = "field_5853f586c83cd"; //TODO: rendere questa cosa più intelligente! la galleria ha dei problemi ad essere recuperata con il name
            }
            else {
                if ($field_name == "n7webmap_map_bbox") {
                    $bbox = get_field($field_name, $poi_obj->ID);
                    if ($bbox == NULL || $bbox == "") {
                        return get_option('webmapp_bounding_box');
                    }
                }
            }
            $id = $poi_obj->ID;
            $taxonomies = array('webmapp_category','activity','theme','where','when','who');
            if (in_array($taxonomy, $taxonomies)) {
                $id = $taxonomy . '_' . $poi_array['id'];
            }
            return get_field($field_name, $id);
    }



}