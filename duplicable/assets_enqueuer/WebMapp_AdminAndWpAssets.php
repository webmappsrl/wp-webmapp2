<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'webmapp-icons' => array(
        'src' => 'https://icon.webmapp.it/style.css'
    )
);

new WebMapp_AssetEnqueuer( $args , array( 'wp' , 'admin' ), 'style' );

/**
 * Open popup in current page with screen_base and screen_id info
 * Only for develop use !!!
 * Please Authorize popups for your project domain to permit to static method works properly
 */
//WebMapp_AssetEnqueuer::see_where_i_am();