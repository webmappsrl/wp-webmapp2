<?php


$args = array(
    'webmapp_bootsrap_grid_system' => array(
        'src' => WebMapp_URL . 'third-part/bootstrap-grid-system/bootstrap.min.css'
    )

);
$WebMapp_CustomMapAssets = new WebMapp_AssetEnqueuer( $args,'wp','style' );