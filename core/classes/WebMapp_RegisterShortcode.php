<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 17:52
 */

/**
 * Class WebMapp_RegisterShortcode
 */
class WebMapp_RegisterShortcode
{
    public $tag;
    public $callback;

    /**
     * WebMapp_RegisterShortcode constructor.
     * @param $tag
     * @param $callback
     */
    function __construct( $tag , $callback )
    {
        $this->tag = $tag;
        $this->callback =$callback;
        $this->add_shortcode();
    }

    /**
     * @reference https://developer.wordpress.org/reference/functions/add_shortcode/
     */
    public function add_shortcode()
    {
        add_shortcode( $this->tag, $this->callback );
    }

}