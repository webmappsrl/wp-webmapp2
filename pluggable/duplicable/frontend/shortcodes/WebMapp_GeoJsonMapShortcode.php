<?php

// Add Shortcode
function WebMapp_GeoJsonMapShortcode( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'post_id' => '',
            'zoom' => '16',
            'height' => '500',
            'geojson_url' => ''
        ),
        $atts
    );

    extract($atts );

    //search for multiple geojson urls
    $geojson_url_json = '';
    if ( strpos( $geojson_url , ',' ) )
    {
        $geojson_url_php_array = explode( ',' , $geojson_url );
        $geojson_url_php_array = array_map( function( $e ){ return esc_url( $e ); }, $geojson_url_php_array );
        $geojson_url_json = json_encode( $geojson_url_php_array );
    }
    else
        $geojson_url_json = json_encode( array( esc_url($geojson_url) ) );


    if ( json_last_error() != JSON_ERROR_NONE )
        trigger_error('Impossible convert geojson url/s in json on webmapp map shortcode.');


    $id = WebMapp_Utils::get_unique_id();

    ob_start(); ?>
    <div id="<?php echo $id?>" class="webmapp-geojson-map" style="height:<?php echo $height ;?>px"></div>
    <script type="text/javascript">
        jQuery(document).ready( function($){
            $('#<?php echo $id ?>').WebMapp_LeafletMap(
                {
                    id : "<?php echo $id ?>",
                    //container : "",
                    //pois: "#556b2f",
                    //tracks: "white",
                    //routes: '',
                    map_center : '',
                    post_id : '<?php echo $post_id ?>',
                    post_type: '<?php echo get_post_type( $post_id ) ?>',
                    url_geojson_filters: '<?php echo $geojson_url_json ?>'//json string
                }
            );
        });
    </script>
    <?php
    $output = ob_get_clean();

    return $output;
}

$WebMapp_GeoJsonMapShortcode = new WebMapp_RegisterShortcode( 'webmapp_geojson_map', 'WebMapp_GeoJsonMapShortcode' );