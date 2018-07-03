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
    public $object_type;

    function __construct( $tax_name , $object_type , $args )
    {

        $this->tax_name = $tax_name;
        $this->args = (array) $args;
        $this->object_type = $object_type;

        if ( empty( $object_type ) || $object_type == 'route' )
            $this->object_type = $this->get_object_type();


        add_action( 'init', array( $this , 'register_taxonomy' ) );
    }

    /**
     * Function to check if route is checked in options page
     * @return string
     */
    public function get_object_type()
    {
        $project_has_route = WebMapp_Utils::project_has_route();

        $main_tax = 'track';
        if ( $project_has_route )
            $main_tax = 'route';

        return $main_tax;
    }

    public function register_taxonomy()
    {
        $test = register_taxonomy( $this->tax_name, $this->object_type , $this->args );
    }
}

