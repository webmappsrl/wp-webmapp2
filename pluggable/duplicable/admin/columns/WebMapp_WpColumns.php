<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 22/11/18
 * Time: 20:23
 */



function wm_wp_col_test( $post_id )
{
    //webmapp api url
    $option = get_option('webmapp_map_apiUrl');

    if ( $option )
        echo "<a href=\"{$option}/geojson/{$post_id}.geojson\" target=\"_blank\">geoJson</a>";
    else
        echo '-';

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


function wm_wp_col_roadbook( $post_id )
{
    echo "<a href=\"http://a.webmapp.it/route/{$post_id}_rb.html\" target=\"_blank\">RoadBook</a>";
}
new WebMapp_WpBackendColumns('route' , "ROADBOOK" ,'wm_wp_col_roadbook');
