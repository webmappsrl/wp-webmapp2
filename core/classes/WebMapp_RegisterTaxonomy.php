<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 02/07/18
 * Time: 23:03
 */

class WebMapp_RegisterTaxonomy
{
    public $tax_name;
    public $args;

    public $label_singular;
    public $label_plural;
    public $object_types;

    function __construct( $tax_name , $object_types , $args )
    {

        $this->tax_name = $tax_name;
        $this->args = (array) $args;
        $this->object_types = $object_types;

        if ( empty( $object_types )
            || ( is_array( $object_types ) && in_array('route' ,$object_types ) != false )
        )
            $this->object_types = $this->get_object_type();


        add_action( 'init', array( $this , 'register_taxonomy' ) );
    }

    /**
     * Function to check if route is checked in options page
     * @return string
     */
    public function get_object_type()
    {

        $temp = $this->object_types;
        $project_has_route = WebMapp_Utils::project_has_route();



        if ( is_array( $temp )
            && ( $i = array_search( 'route' , $temp ) ) !== false
            && ! $project_has_route
        )
        {
            unset ( $temp[$i] );
        }
        elseif( is_string($temp ) )
        {
            if ( $project_has_route )
                $temp = 'route';
            else
                $temp = 'track';
        }

        /**
         * Update object property
         */
        if ( $temp != $this->object_types )
            $this->object_types = $temp;


        return $temp;
    }

    public function register_taxonomy()
    {
        if ( is_array( $this->object_types ) )
            $this->object_types = array_values( $this->object_types );

        $test = register_taxonomy( $this->tax_name, $this->object_types , $this->args );
    }
}

