<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 02/07/18
 * Time: 19:18
 */

class WebMapp_AssetEnqueuer implements WebMapp_Interface_AssetsEnqueuer
{
    /**
     * @var array
     */
    protected $all_sides = array( 'admin' , 'login' , 'wp' );

    protected $all_register_types = array( 'script' , 'style' );

    public $handlers;
    public $srcs;
    public $in_footers;
    public $depss;


    public $sides;
    public $args;
    public $register_type;


    function __construct( $args , $sides , $register_type = 'script' )
    {

        if ( ! is_array( $sides ) )
            $sides = array( $sides );

        //todo trigger error
        if ( empty( array_intersect( $sides , $this->all_sides ) ) )
            return;

        //todo trigger error
        if ( ! is_string( $register_type ) || ! in_array( $register_type , $this->all_register_types) )
            return;

        $this->sides = $sides;
        $this->args = $args;
        $this->register_type = $register_type;

        $this->init_properties();


        foreach ( $this->sides as $side )
            add_action( $side . '_enqueue_scripts' , array( $this , 'enqueue_scripts' ) );

    }

    public function init_properties()
    {
        foreach ( $this->args as $handler_name => $handle_args )
        {

            $this->handlers[] = $handler_name;
            $this->srcs[$handler_name] = isset( $handle_args['src'] ) ? $handle_args['src'] : '';
            $this->in_footers[$handler_name] = isset( $handle_args['in_footer'] ) ? $handle_args['in_footer'] : true ;
            $this->depss[$handler_name] = isset( $handle_args['deps'] ) ? $handle_args['deps'] : array() ;

        }
    }

    public function enqueue_scripts()
    {

        foreach ( $this->handlers as $handler )
        {
            $resource_type = $this->register_type;

            $enqueue_method = 'enqueue_'.$resource_type;
            $this->$enqueue_method( $handler , $this->srcs[$handler] , $this->depss[$handler], $this->in_footers[$handler] );
        }

    }



    /**
     *
     *
     * todo add media support
     *
     * @param $handle
     * @param $src
     * @param $deps
     * @param $in_footer
     *
     * @reference https://developer.wordpress.org/reference/functions/wp_enqueue_style/
     */
    public function enqueue_style( $handle , $src , $deps , $in_footer )
    {
        wp_register_style( $handle, $src, $deps );
        wp_enqueue_style($handle );
    }


    /**
     * @param $handle
     * @param $src
     * @param $deps
     * @param $in_footer
     *
     * @reference https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     */
    public function enqueue_script( $handle , $src , $deps , $in_footer )
    {
        wp_register_script($handle , $src, $deps,null,$in_footer );
        wp_enqueue_script($handle );
    }



}