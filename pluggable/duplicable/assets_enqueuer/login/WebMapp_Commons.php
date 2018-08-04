<?php

$args = array(
    'login_css' => array(
        'src' => WebMapp_ASSETS . 'css/webmapp-login.css',
        'deps' => false
    )
);

$WebMapp_LoginAssets = new WebMapp_AssetEnqueuer( $args,'login','style' );

$args = array(
    'login_js' => array(
        'src' => WebMapp_ASSETS . 'js/webmapp-login.js',
        'deps' => false
    )
);
$WebMapp_LoginAssets = new WebMapp_AssetEnqueuer( $args,'login','script' );