<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */


$args = array(
    'my_test_mmm' => array(
        'src' => WebMapp_URL . 'assets/js/leaflet-map.js',
        'deps' => '',
        'in_footer' => '',
        'screen_base' => '',//works only in admin pages
        'screen_id' => '',//works only in admin pages
        'localize' => array(
            'object_name' => '',
            'data' => ''
        )
    )

);

new WebMapp_AssetEnqueuer( $args , array( 'login' ), 'script' );

/**
 * Open popup in current page with screen_base and screen_id info
 * Only for develop use !!!
 * Please Authorize popups for your project domain to permit to static method works properly
 */
//WebMapp_AssetEnqueuer::see_where_i_am();