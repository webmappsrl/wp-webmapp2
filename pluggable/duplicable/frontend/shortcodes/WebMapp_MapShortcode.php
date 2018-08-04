<?php

// Add Shortcode
function WebMapp_MapShortcode( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'lat' => '',
            'lng' => '',
            'zoom' => '16',
            'height' => '500'
        ),
        $atts
    );

    $outuput = '<div id="custom-shortcode-map" style="height:' .$atts['height']. 'px;" data-lat="' . $atts['lat'] .'" data-lng="' . $atts['lng'] .'" data-zoom="' . $atts['zoom'] .'"></div>';


    return $outuput;
}

$WebMapp_MapShortcode = new WebMapp_RegisterShortcode( 'wm_map', 'WebMapp_MapShortcode' );