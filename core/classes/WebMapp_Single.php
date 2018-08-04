<?php


class WebMapp_Single
{
    public $geoJson_php;

    function __construct( $geoJson_php )
    {
        $this->geoJson_php = $geoJson_php;
    }

    function getShortInfo()
    {
        $r = false;

        $fields_key = array(
            'phone' => 'field_58db8898b886d',//phone
            'email' => 'field_58db8898b886e',//email
            'rating' => 'wm_poi_stars'//rating
        );
        $fields = $this->getFields( $fields_key );
        if ( $fields )
            $r = $fields;

        return $r;
    }


    function getInfo()
    {
        $fields_key = array(
            'phone' => 'field_58db8898b886d',//phone
            'email' => 'field_58db8898b886e',//email
            'links' => 'field_585cdc9229191'//links
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
            'street' => 'field_58db8898b885d',//street
            'house_number' => 'field_58db8898b885e',//house number
            'postcode' => 'field_58db8898b885f',//postcode
            'city' => 'field_58db8898b885g'//city
        );

        $address_fields = $this->getFields( $fields_key );

        if ( $address_fields && ! empty( $fields_key ) )
            $r = implode(', ' ,  $address_fields );

        return $r;
    }

    function getRelatedObjects()
    {
        return $this->geoJson_php->properties->related;
    }

    function getFields( $fields )
    {
        $t = array();
        foreach( $fields as $key => $field )
        {
            $temp = get_field($field );
            if ( $temp )
                $t[$key] = $temp;
            else
                $t[$key] = false;
        }

        if ( empty( $t ) )
            $t = false;

        return $t;

    }

}