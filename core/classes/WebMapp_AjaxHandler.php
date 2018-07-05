<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 05/07/18
 * Time: 00:08
 */

class WebMapp_AjaxHandler
{
    protected $callback;
    protected $no_priv;

    function __construct( $no_priv, $callback )
    {
        $this->no_priv = $no_priv;
        $this->callback = $callback;

        $this->ajax_callback();
    }


    public function ajax_callback()
    {
        if ( function_exists( $this->callback ) )
        {
            $cb = $this->callback;
            add_action( 'wp_ajax_' . $cb , $cb );
            if ( $this->no_priv )
                add_action( 'wp_ajax_nopriv_' . $cb , $cb );
        }


    }

}