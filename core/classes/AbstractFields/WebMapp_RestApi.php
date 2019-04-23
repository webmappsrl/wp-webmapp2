<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 19:53
 */

/**
 *
 * SubClass WebMapp_RestApi of WebMapp_AbstractFields
 * Register
 *
 * @property $object_names - string/array post_type/taxonomy slug to associate fields
 * @property $args array - args for acf_add_local_field_group
 * @property $fields array - options with arguments to print ( useful for REST-API )
 *
 */
class WebMapp_RestApi extends WebMapp_AbstractFields
{

    /**
     * WebMapp_RestApi constructor.
     * @param $object_names
     * @param $args
     */
    function __construct( $object_names,  $args )
    {
        parent::__construct( $object_names, $args );
        add_action( 'rest_api_init', array( $this , 'fields_to_rest_api' ) );
    }

    /**
     * Register fields on each object_type ( tax/cpt ) provided
     */
    public function fields_to_rest_api()
    {
        $temp = $this->object_names;
        if ( ! is_array($temp ) && ! empty( $temp ) )
            $this->object_names = array( $temp );

        //support to fields of various custom types ( post/taxonomy )
        foreach( $this->object_names as $name )
            $this->register_rest_fields($name, $this->fields );
    }

    /**
     *
     * Register rest field associated to objecy_type
     *
     * @param $object_type
     * @param $attribute
     * @param $callback
     *
     * @reference https://developer.wordpress.org/reference/functions/register_rest_field/
     */
    static function register_rest_field( $object_type, $attribute, $callback ) {

        /**
         * Filter register_rest_field callback
         */
        $callback = apply_filters( 'WebMapp_pre_reg_field_rest-api', $callback , $object_type, $attribute );
        register_rest_field($object_type, $attribute, array(
            'get_callback' =>  $callback
        ));

    }

    /**
     *
     * Register multiple rest fields associated to objecy_type
     *
     * @param $post_type
     * @param $fields
     */
    public function register_rest_fields( $post_type , $fields ) {

        foreach ( $fields as $field )
        {
            $field_type = $field["type"];
            /**
             * Don't load tab fields ;)
             */
            if ( $field_type !== 'tab' )
            {
                $field_name = $field["name"];
                $field_key = $field["key"];
                self::register_rest_field( $post_type , $field_name,array( $this , 'register_rest_fields_callback' )  );

            }
        }
    }

    /**
     *
     * Cp.
     *
     * @param $poi_array
     * @param $field_name
     * @return mixed
     */
    public function register_rest_fields_callback( $poi_array, $field_name )
    {
            $taxonomy = '';
            if ( isset( $poi_array['taxonomy'] ) ) {
                $taxonomy = $poi_array['taxonomy'];
            }

            $poi_obj = get_post($poi_array['id']);

            if ( $field_name == "n7webmap_route_media_gallery" ) {
                $field_name = "wm_route_gallery"; //TODO: rendere questa cosa più intelligente! la galleria ha dei problemi ad essere recuperata con il name
            }
            elseif ( $field_name == "n7webmap_media_gallery" ) {
                $field_name = "wm_poi_gallery"; //TODO: rendere questa cosa più intelligente! la galleria ha dei problemi ad essere recuperata con il name
            }
            elseif ( $field_name == "n7webmap_track_media_gallery" ) {
                $field_name = "wm_track_gallery"; //TODO: rendere questa cosa più intelligente! la galleria ha dei problemi ad essere recuperata con il name
            }
            else {
                if ( $field_name == "n7webmap_map_bbox" ) {
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