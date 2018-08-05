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
