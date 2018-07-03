<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 20:09
 */

class WebMapp_AbstractFields
{
    public $args;
    public $fields;
    public $object_names;

    function __construct( $object_names , $args )
    {
        //trigger error here todo
        if ( ! isset( $args['fields'] ) )
            return;
        $this->args = $args;
        $this->fields = $args['fields'];
        $this->object_names = $object_names;
    }

}