<?php


/**
 * Sub Class WebMapp_Acf of WebMapp_AbstractFields
 * Advanced custom fields element
 *
 * @property $object_names - string/array post_type/taxonomy slug to associate fields
 * @property $args array - args for acf_add_local_field_group
 * @property $fields array - options with arguments to print ( useful for REST-API )
 *
 * @reference https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */
class WebMapp_Acf extends WebMapp_AbstractFields
{

    /**
     * WebMapp_Acf constructor
     * @param $object_names
     * @param $args
     */
    function __construct( $object_names, $args )
    {
        parent::__construct( $object_names, $args );
        add_action( 'plugins_loaded' , array( $this , 'add_local_field_group') );
    }

    /**
     * ACF add group settings for us
     * Needs acf acf_add_local_field_group function to works
     */
    public function add_local_field_group()
    {
        if ( ! empty( $this->args ) && function_exists('acf_add_local_field_group') )
        {
            //ACF function
            acf_add_local_field_group( $this->args );
        }

    }



}