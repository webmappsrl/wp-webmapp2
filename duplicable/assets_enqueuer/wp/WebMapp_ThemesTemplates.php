<?php


$args = array(
    'webmapp_theme_templates' => array(
        'src' => WebMapp_URL . 'themes_templates/style.css'
    )

);
new WebMapp_AssetEnqueuer( $args,'wp','style' );