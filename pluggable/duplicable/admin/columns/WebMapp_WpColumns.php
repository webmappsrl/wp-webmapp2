<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 22/11/18
 * Time: 20:23
 */



function wm_wp_col_test( $post_id )
{
    echo $post_id;
}


new WebMapp_WpBackendColumns('poi' , "Intestazione POI" ,'wm_wp_col_test');
new WebMapp_WpBackendColumns('route' , "Intestazione ROUTE" ,'wm_wp_col_test');
new WebMapp_WpBackendColumns('track' , "Intestazione TRACK" ,'wm_wp_col_test');