<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */

$screen_id = 'toplevel_page_webmap_netseven';
$screen_base = 'toplevel_page_webmap_netseven';
$args = array(
    'webmapp-file-input-fields' => array(
        'src' => WebMapp_ASSETS . 'js/file_upload.js',
        'in_footer' => true,
        'deps' => array( 'jquery' ),
        'screen_base' => $screen_base,//works only in admin pages
        'screen_id' => $screen_id,//works only in admin pages
    ),
    'wp-media-upload' => array(
        'screen_base' => $screen_base,//works only in admin pages
        'screen_id' => $screen_id,//works only in admin pages
    )
);

new WebMapp_AssetEnqueuer( $args , 'admin' , 'script' );

