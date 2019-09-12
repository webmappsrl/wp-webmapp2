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
        'deps' => false,
        'localize' => array(
	        'object_name' => 'webmapp_login_text',
	        'data' => array(
                'check_email' => __('Check the email, we sent you the link to use to reset the password', 'webmapp'),
                'success_password' => __('The password has been reset.','webmapp'),
	        ),
        )
    ),

);
$WebMapp_LoginAssets = new WebMapp_AssetEnqueuer( $args,'login','script' );