<?php


class WebMapp_RegisterPostType
{
    public $post_type;
    public $args;
    public $project_has_route;
    public $custom_capabilities;

    function __construct( $post_type , $args , $custom_capabilities = false )
    {
        $this->post_type = $post_type;
        $this->args = $args;
        $this->project_has_route = WebMapp_Utils::project_has_route();
        $this->custom_capabilities = $custom_capabilities;

        if ( $post_type == 'route' && ! $this->project_has_route )
            return;

        add_action( 'init' , array( $this , 'register_post_type' ) );
    }

    public function register_post_type()
    {
        if ( $this->custom_capabilities )
           $this->set_custom_capabilities();

        $test = register_post_type($this->post_type, $this->args );
    }

    public function set_custom_capabilities()
    {
        $this->args['capabilities'] = WebMapp_Utils::build_custom_capabilities( $this->post_type );
    }



}