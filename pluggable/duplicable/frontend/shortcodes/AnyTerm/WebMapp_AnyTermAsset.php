<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */



$args = array(
    'webmapp_anyterm_css' => array(
        'src' => WebMapp_URL . 'pluggable/duplicable/frontend/shortcodes/AnyTerm/assets/style.css'
    )

);

new WebMapp_AssetEnqueuer( $args , 'wp', 'style' );