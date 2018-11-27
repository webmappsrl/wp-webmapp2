<?php

$args = array(
    'webmapp_edit_route_js' => array(
        'src' => WebMapp_ASSETS . 'js/admin-edit-route.js',
        'screen_base' => 'post',//works only in admin pages
        'screen_id' => 'route',//works only in admin pages
        'in_footer' => true

    )
);
new WebMapp_AssetEnqueuer( $args,'admin', 'script' );

$args = array(
    'webmapp_edit_route_css' => array(
        'src' => WebMapp_ASSETS . 'css/admin-edit-route.css',
        'screen_base' => 'post',//works only in admin pages
        'screen_id' => 'route',//works only in admin pages

    )
);

new WebMapp_AssetEnqueuer( $args,'admin', 'style' );
