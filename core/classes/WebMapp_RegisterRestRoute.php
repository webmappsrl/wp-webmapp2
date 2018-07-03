<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 22:04
 */

class WebMapp_RegisterRestRoute
{

    public $args;
    public $route;
    public $namespace;

    function __construct( $namespace , $route , $args  )
    {
        $this->namespace = $namespace;
        $this->route = $route;
        $this->args = $args;

        add_action( 'rest_api_init', array( $this , 'register_rest_route' ) );
    }

    public function register_rest_route()
    {
        register_rest_route($this->namespace, $this->route,$this->args );
    }

}