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

/**
 * Insert:
 *
 * post_type (string) - For which post type do you want the column available?
 * column header (string) - Title and identifier of a column
 * callback name (string) - Callback for each row of table ( post id is provided as param )
 *
 * ENJOY
 */
new WebMapp_WpBackendColumns('poi' , "Intestazione POI test" ,'wm_wp_col_test');
new WebMapp_WpBackendColumns('route' , "Intestazione ROUTE test" ,'wm_wp_col_test');
new WebMapp_WpBackendColumns('track' , "Intestazione TRACK test" ,'wm_wp_col_test');