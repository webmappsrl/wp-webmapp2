<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 07/07/18
 * Time: 03:25
 */

class WebMapp_ActivityRoute
{


    public static function get_routes_by_activity( $term_id )
    {

        global $wpdb;
        //get routes by term id
        $routes = get_posts(
            array(
                'post_type' => 'route',
                'nopaging' => 'true',
                'fields' => 'ids',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'activity',
                        'field' => 'term_id',
                        'terms' => array( $term_id )
                    )
                )
            )
        );

        //get tracks by term id to calculate related routes
        // $tracks = get_posts(
        //     array(
        //         'post_type' => 'track',
        //         'nopaging' => 'true',
        //         'fields' => 'ids',
        //         'post_status' => 'publish',
        //         'tax_query' => array(
        //             array(
        //                 'taxonomy' => 'activity',
        //                 'field' => 'term_id',
        //                 'terms' => array( $term_id )
        //             )
        //         )
        //     )
        // );

        // if ( $tracks )
        // {
        //     $related_track_query = '';
        //     foreach( $tracks as $track_id ) :
        //         if (has_filter('wpml_object_id')) {
        //             $default_lang = apply_filters('wpml_default_language', NULL);
        //             $track_id = apply_filters('wpml_object_id', $track_id, 'track', TRUE, $default_lang);
        //         }
        //         $related_track_query .= "PM.meta_value LIKE '%\"$track_id\"%' OR ";
        //     endforeach;
        //     $related_track_query = substr( $related_track_query , 0, -4 );

        //     $sql = "SELECT DISTINCT P.ID FROM $wpdb->posts P "
        //         . "LEFT JOIN $wpdb->postmeta PM "
        //         . "ON P.ID = PM.post_id "
        //         . "WHERE P.post_status = 'publish' "
        //         . "AND P.post_type = 'route' "
        //         . "AND PM.meta_key = 'n7webmap_route_related_track' "
        //         . "AND ( $related_track_query );";

        //     $routes = $wpdb->get_results( $sql , ARRAY_A );
        //     $routes = array_map( function( $e ){
        //         return isset( $e['ID'] ) ? $e['ID'] : false;
        //     },$routes );
        // }

        // return array_unique( $routes );
        return $routes;

    }

    public static function get_route_activities( $post_id , $field = 'all' )
    {
        $post = get_post( $post_id );

        if( ! $post )
            return;

        if ( $post->post_type !== 'route' )
            return;

        $this_ = new WebMapp_ActivityRoute();

        //get route direct activity terms
        $terms = wp_get_object_terms($post_id , 'activity', array( 'fields' => $field ) );

        $related_tracks = $this_->get_route_related_tracks( $post_id );

        if ( $related_tracks !== false && is_array( $related_tracks ) )
        {
            $tracks_terms = $this_::get_the_super_terms($related_tracks , 'activity');

            if ( $field == 'ids' )
                $tracks_terms = array_unique( array_values( array_map( function( $e )
                {
                    return isset( $e->term_id ) ? $e->term_id : false;
                },
                    $tracks_terms
                )));

            foreach ( $tracks_terms as $tracks_term )
                array_push( $terms,$tracks_term);


        }

        else
            $terms = WebMapp_Utils::array_unique_terms( $terms );

        return $terms;
    }


    public function get_route_related_tracks( $post_id )
    {
        $post = get_post( $post_id );

        if( ! $post )
            return false;

        if ( $post->post_type !== 'route' )
            return false;



        $related_tracks = get_field( 'n7webmap_route_related_track' , $post_id );
        //$related_tracks

        $test = false;
        if ( ! empty( $related_tracks ) && is_array( $related_tracks ) )
        {
            $test = array_map( function( $e ){
                return isset( $e->ID ) ? $e->ID : false;
            } , $related_tracks );
        }


        return $test;
    }
    //retrieve acf field
    //get activities by track_ids

    /**
     * Get all taxonomies of provided posts ids
     * @param $post_ids
     * @param $taxonomy
     * @return array|bool
     */
    public static function get_the_super_terms( $post_ids , $taxonomy )
    {
        if ( ! is_array( $post_ids ) )
            return false;

        if ( ! in_array( $taxonomy , get_taxonomies() ) )
            return false;

        $terms = array();

        foreach ( $post_ids as $post_id ) :

            $check = get_the_terms( $post_id ,$taxonomy);

            if ( is_array( $check ) ) :

                $terms = array_merge( $check , $terms );

            elseif ( is_wp_error( $check ) ) :

                trigger_error('Impossible to get terms for this post type' . $check->get_error_message(), 'notice');

            endif;

        endforeach;

        return WebMapp_Utils::array_unique_terms( $terms );
    }






}
