<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 20:09
 */

/**
 * Class WebMapp_AbstractFields
 * Support class to define commons properties between ACF and REST-API
 * public $args;
 * public $fields;
 * public $object_names;
 *
 * @property $object_names - string/array post_type/taxonomy slug to associate fields
 * @property $args array - args for acf_add_local_field_group
 * @property $fields array - options with arguments to print ( useful for REST-API )
 */
class WebMapp_AbstractFields
{
    /**
     * @var string/array post_type/taxonomy slug to associate fields
     */
    public $args;

    /**
     * @var array args for acf_add_local_field_group
     */
    public $fields;

    /**
     * @var array/string options with arguments to print ( useful for REST-API )
     */
    public $object_names;

    /**
     * WebMapp_AbstractFields constructor.
     * @param $object_names
     * @param $args
     */
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