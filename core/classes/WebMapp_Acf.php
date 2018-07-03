<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 02/07/18
 * Time: 18:52
 */

class WebMapp_Acf extends WebMapp_AbstractFields
{

    function __construct( $object_names, $args )
    {
        parent::__construct( $object_names, $args );
        add_action( 'plugins_loaded' , array( $this , 'add_local_field_group') );
    }

    public function add_local_field_group()
    {
        if ( ! empty( $this->args ) && function_exists('acf_add_local_field_group') )
        {
            acf_add_local_field_group( $this->args );
        }

    }



}