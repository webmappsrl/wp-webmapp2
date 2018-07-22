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
        $this->args = $args;

        if ( is_string( $object_types ) )
        {
            if ( $object_types == '' )
                $this->object_types = array();
            else
                $this->object_types = array( $object_types );
        }
        else
            $this->object_types = (array) $object_types;


        /**
         * Filter object types for taxonomy before registration
         */
        $this->object_types = apply_filters( 'WebMapp_taxonomy_object_types' , $this->object_types , $this->tax_name, $this->args );

        /**
         * Todo
         * below two methods with same functions
         * found better way if filters options are more than these
         */



        if ( in_array('route' ,$this->object_types ) != false )
        {
            $project_has_route = WebMapp_Utils::project_has_route();
            if ( ! $project_has_route )
                $this->object_types = array( 'track' );
            else
                $this->object_types = array( 'route' );
        }




        /**
         * Filter taxonomyes
         */
        $tracks_has_webmapp_category = WebMapp_Utils::tracks_has_webmapp_category();
        if ( $this->tax_name == 'webmapp_category'
           && ( $i = array_search('track',$this->object_types ) ) !== false
            && ! $tracks_has_webmapp_category
        )
            unset( $this->object_types[$i] );



        add_action( 'init', array( $this , 'register_taxonomy' ) );
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

