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
        $this->args['capabilities'] = $this->build_custom_capabilities();
    }

    public function build_custom_capabilities()
    {
        $single = $this->post_type;
        $plural = (string) $single . 's';
        $capabilities = array(
            'delete_others_posts' => "delete_others_$plural",
            'delete_posts' => "delete_$plural",
            'delete_private_posts' => "delete_private_$plural",
            'delete_published_posts' => "delete_published_$plural",
            'edit_others_posts' => "edit_others_$plural",
            'edit_posts' => "edit_$plural",
            'edit_private_posts' => "edit_private_$plural",
            'edit_published_posts' => "edit_published_$plural",
            'publish_posts' => "publish_$plural",
            'read_private_posts' => "read_private_$plural"
        );
        return $capabilities;
    }

}