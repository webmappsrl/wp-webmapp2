<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'webmapp-admin-webmapp-logos' => array(
        'src' => WebMapp_ASSETS . 'css/admin.css'
    )
);

new WebMapp_AssetEnqueuer( $args , 'admin' , 'style' );

