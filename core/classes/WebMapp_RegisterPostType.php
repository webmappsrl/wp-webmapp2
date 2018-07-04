<?php
/**
 * Todo creare funzione che genera automaticamente le labels partendo da un nome singolare
 */

/**
 * Class WebMapp_RegisterPostType
 *
 * Filters and register post types
 * filters by custom option
 *
 * @property $post_type string - custom post type slug
 * @property $args array - arguments for post type registration
 * @property $project_has_route bool - check if user wants route post type //todo very too specific !?
 * @property $custom_capabilities bool - asks about capabilities automatic generation from post type slug
 *
 */
class WebMapp_RegisterPostType
{
    /**
     * @var string - custom post type slug
     */
    public $post_type;

    /**
     * @var array - arguments for post type registration
     */
    public $args;

    /**
     * @var bool - check if user wants route post type
     */
    public $project_has_route;

    /**
     * @var bool - asks about capabilities automatic generation from post type slug
     */
    public $custom_capabilities;

    /**
     * WebMapp_RegisterPostType constructor.
     * @param $post_type
     * @param $args
     * @param bool $custom_capabilities
     */
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

    /**
     * Generate capabilities if user wants and register post type
     * @reference https://developer.wordpress.org/reference/functions/register_post_type/
     */
    public function register_post_type()
    {
        if ( $this->custom_capabilities )
           $this->set_custom_capabilities();

        /**
         * Hook post type registration arguments
         */
        $args = apply_filters( 'WebMapp_pre_register_post_type', $this->args, $this->post_type, $this->project_has_route );

        $test = register_post_type($this->post_type, $args );
    }

    /**
     * Sets to post type generated capabilities
     */
    public function set_custom_capabilities()
    {
        $this->args['capabilities'] = WebMapp_Utils::build_custom_capabilities( $this->post_type );
    }



}