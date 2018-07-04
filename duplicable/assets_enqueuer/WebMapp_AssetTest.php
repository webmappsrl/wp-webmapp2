<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'my_test_mmm' => array(
        'src' => WebMapp_URL . 'assets/js/leaflet-map.js'
    )

);

new WebMapp_AssetEnqueuer( $args , array( 'login' , 'wp' ), 'script' );