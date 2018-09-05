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
        $tracks = get_posts(
            array(
                'post_type' => 'track',
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

        $routes = array();
        if ( $tracks )
        {
            $related_track_query = '';
            foreach( $tracks as $track_id ) :
                $related_track_query .= "PM.meta_value LIKE '%\"$track_id\"%' OR ";
            endforeach;
            $related_track_query = substr( $related_track_query , 0, -4 );

            $sql = "SELECT DISTINCT P.ID FROM $wpdb->posts P "
                . "LEFT JOIN $wpdb->postmeta PM "
                . "ON P.ID = PM.post_id "
                . "WHERE P.post_status = 'publish' "
                . "AND P.post_type = 'route' "
                . "AND PM.meta_key = 'n7webmap_route_related_track' "
                . "AND ( $related_track_query );";



            $routes = $wpdb->get_results( $sql , ARRAY_A );
            $routes = array_map( function( $e ){
                return isset( $e['ID'] ) ? $e['ID'] : false;
            },$routes );
        }

        return $routes;

    }

    public static function get_route_activities( $post_id , $field = 'object' )
    {
        $post = get_post( $post_id );

        if( ! $post )
            return;

        if ( $post->post_type !== 'route' )
            return;

        $this_ = new WebMapp_ActivityRoute();
        $terms = array();

        $related_tracks = $this_->get_route_related_tracks( $post_id );
        if ( ! $related_tracks )
            trigger_error('Impossible to get related tracks');
        elseif ( is_array( $related_tracks ) )
        {
            $terms = $this_::get_the_super_terms($related_tracks , 'activity');
            if ( $field == 'ids' )
                $terms = array_values( array_map( function( $e )
                {
                    return isset( $e->term_id ) ? $e->term_id : false;
                },
                $terms
                ));
        }

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

        return array_map( function( $e ){
            return isset( $e->ID ) ? $e->ID : false;
        } , $related_tracks );
    }
    //retrieve acf field
    //get activities by track_ids

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