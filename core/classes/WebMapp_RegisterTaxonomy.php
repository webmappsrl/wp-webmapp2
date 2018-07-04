<?php


/**
 *
 * Class WebMapp_RegisterTaxonomy
 *
 * Filters taxonomy before registration and then register it
 *
 * @property $tax_name string - taxonomy name slug
 * @property $args array - args for register_taxonomy
 * @property $object_types array/string - posts/object types of this taxonomies
 *
 */
class WebMapp_RegisterTaxonomy
{

    /**
     * @var string - taxonomy name slug
     */
    public $tax_name;

    /**
     * @var array - args for register_taxonomy
     */
    public $args;

    /**
     * @var string array/string - posts/object types of this taxonomies
     */
    public $object_types;

    //deprecated
    public $label_singular;
    public $label_plural;

    /**
     * WebMapp_RegisterTaxonomy constructor.
     * @param $tax_name
     * @param $object_types
     * @param $args
     */
    function __construct( $tax_name , $object_types , $args )
    {

        $this->tax_name = $tax_name;
        $this->args = (array) $args;
        $this->object_types = $object_types;

        /**
         * Filter object types for taxonomy before registration
         */
        $object_types = apply_filters( 'WebMapp_taxonomy_object_types' , $this->object_types , $this->tax_name, $this->args );


        if ( empty( $object_types )
            || ( is_array( $object_types ) && in_array('route' ,$object_types ) != false )
        )
            $this->object_types = $this->get_object_type();

        add_action( 'init', array( $this , 'register_taxonomy' ) );
    }

    /**
     * Return filtered object type
     * @return string/array
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

    /**
     * Register taxonomy after check format of object_types
     * @reference https://developer.wordpress.org/reference/functions/register_taxonomy/
     */
    public function register_taxonomy()
    {
        if ( is_array( $this->object_types ) )
            $this->object_types = array_values( $this->object_types );

        /**
         * Hook taxonomy registration arguments
         */
        $args = apply_filters( 'WebMapp_pre_register_taxonomy' , $this->args ,  $this->tax_name, $this->args );
        $test = register_taxonomy( $this->tax_name, $this->object_types , $args );
    }
}

