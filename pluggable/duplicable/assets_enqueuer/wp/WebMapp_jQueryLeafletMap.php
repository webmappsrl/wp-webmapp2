<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'webmapp_jqueryleafletmap' => array(
        'src' => WebMapp_ASSETS . 'js/WebMapp_jQueryLeafletMap.js',
        'deps' => array( 'jquery' ),
        'in_footer' => false
    )

);
new WebMapp_AssetEnqueuer( $args,'wp','script' );



$args = array(
    'webmapp_leaflet_map' => array(
        'src' => WebMapp_URL . 'assets/css/style_leaflet_map.css'
    )
);
new WebMapp_AssetEnqueuer( $args,'wp','style' );
