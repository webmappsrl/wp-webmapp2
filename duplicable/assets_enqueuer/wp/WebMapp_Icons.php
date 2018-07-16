<?php


$args = array(
    'webmapp_bootsrap_grid_system' => array(
        'src' => WebMapp_ASSETS . 'portoferraio-icons/style.css'
    )

);
$WebMapp_CustomMapAssets = new WebMapp_AssetEnqueuer( $args,'wp','style' );