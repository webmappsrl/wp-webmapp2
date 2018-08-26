<?php


class WebMapp_TemplateSingle
{
    public $geoJson_php;
    public $geoJson_properties = array();

    function __construct( $geoJson_php = '' )
    {
        $this->geoJson_php = $geoJson_php;

        if ( isset( $this->geoJson_php->properties ) )
            $this->geoJson_properties = WebMapp_Utils::object_to_array( $this->geoJson_php->properties );

    }

    function getShortInfo()
    {


        $r = false;

        $fields_key = array(
            'difficulty' => 'difficulty',//capacity
            'rating' => 'wm_poi_stars',//rating
            'ascent' => 'ascent',//ascent
            'descent' => 'descent',//discent
            'distance' => 'distance',//distance
            'duration' => 'duration:forward'//duration:forward
        );
        $fields = $this->getFields( $fields_key );
        if ( $fields )
            $r = $fields;

        return $r;
    }

    function theShortInfo()
    {
        $shortInfo = $this->getShortInfo();

        if ( $shortInfo )
        {
            foreach ( $shortInfo as $key => $info )
            {
                echo "<span>$key: $info</span>";
            }
        }
    }

    function getInfo()
    {
        //todo controllare i fields a seconda del post type
        $fields_key = array(
            'phone' => 'contact:phone',//phone
            'email' => 'contact:email',//email
            'links' => 'net7webmap_related_url'//links
        );

        $t = $this->getFields( $fields_key );

        if ( isset( $t['links'] ) && $t['links'] )
        {
            $temp =  array_map( function( $i ){
                if ( is_array($i ) && ! empty( $i ) )
                    return current( $i);
                else
                    return false;
            }, $t['links'] ) ;
            $temp = array_filter( $temp );

            if ( ! empty( $temp ) )
                $t['links'] = $temp;
            else
                unset( $t['links'] );
        }


        $address = $this->getAddress();

        if ( $address )
            $t['address'] = $address;


        return $t;
    }


    function getAddress()
    {
        $r = false;

        $fields_key = array(
            'street' => 'addr:street',//street
            'house_number' => 'addr:housenumber',//house number
            'postcode' => 'addr:postcode',//postcode
            'city' => 'addr:city'//city
        );

        $address_fields = $this->getFields( $fields_key );

        if ( $address_fields && ! empty( $fields_key ) )
            $r = implode(', ' ,  $address_fields );

        return $r;
    }

    function getRelatedObjects()
    {
        $r = array();
        if ( $this->geoJson_php )
        {
            $temp = $this->geoJson_php->properties->related;

            if( $temp->poi || $temp->track || $temp->route )
            {
                $r = WebMapp_Utils::object_to_array( $temp );
            }

        }

        return $r;
    }

    function getFields( $fields , $post_id = '' )
    {
        $t = array();

        if ( !$post_id )
            $post_id = get_the_ID();

        foreach( $fields as $key => $field )
        {
            if ( ! empty( $this->geoJson_properties )
                && isset( $this->geoJson_properties[$field] )
                && ! empty( $this->geoJson_properties[$field] )
            )
                $t[$key] = $this->geoJson_properties[$field];//get field from geoJson
            else
            {
                $temp = get_field($field ,$post_id);//get field from wp database
                if ( $temp && ! empty( $temp) )
                    $t[$key] = $temp;
            }



        }



        return $t;

    }

    function getSimilarObjects()
    {
        $r = '';
        $post_type = get_post_type();
        $post_id = get_the_ID();

        $posts = get_posts(
            array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'fields' => 'ids',
                'post__not_in' => array( $post_id ),
                'posts_per_page' => 3
            )
        );

        if ( $posts && is_array( $posts ) && ! empty( $posts ) )
        {
            $posts_string = implode( ',',$posts);
            $r = do_shortcode("[webmapp_anypost posts_per_page='3' post_count='3' rows='1' post_ids='" . $posts_string . "']");
        }


        return $r;

    }

}