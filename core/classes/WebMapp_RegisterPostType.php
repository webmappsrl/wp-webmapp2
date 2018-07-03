<?php


class WebMapp_RegisterPostType
{
    public $post_type;
    public $args;
    public $project_has_route;

    function __construct( $post_type , $args )
    {
        $this->post_type = $post_type;
        $this->args = $args;
        $this->project_has_route = WebMapp_Utils::project_has_route();

        if ( $post_type == 'route' && ! $this->project_has_route )
            return;

        add_action( 'init' , array( $this , 'register_post_type' ) );
    }

    public function register_post_type()
    {
        $test = register_post_type($this->post_type, $this->args );
    }

}