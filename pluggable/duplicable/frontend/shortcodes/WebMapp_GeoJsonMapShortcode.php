<?php

// Add Shortcode
function WebMapp_GeoJsonMapShortcode( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'post_id' => '',
            'zoom' => '16',
            'height' => '500',
            'geojson_url' => '',
            'marker' => '',
            'force_zoom' => '0',
            // map.setView(new L.LatLng(40.737, -73.923), 8);
            // set std parameter zoom/lng/lat
            // 14/45.8327/6.8651
            // Example (Monte Bianco) force_view="14/6.8651/45.8327"
            'force_view' => '0'
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

    if ($atts['marker'] == 'custom'){

	    wp_deregister_script( 'webmapp-leaflet-vector-markers' );
	    wp_enqueue_script('custom-vector-markers');
    }
    if ($force_view==0) {
        $force_view="force_view: '0'";
    }
    else {
        $vals = explode('/',$force_view);
        $zoom = $vals[0]; $lon = $vals[1]; $lat = $vals [2];
        $force_view = "force_view: '1',
                       force_view_zoom: '$zoom',
                       force_view_lng: '$lon',
                       force_view_lat: '$lat'";
    }

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
                    url_geojson_filters: '<?php echo $geojson_url_json ?>',//json string
                    force_zoom: '<?php echo $force_zoom ?>',
                    <?php echo $force_view ?>
                }
            );
        });
    </script>
    <?php
    $output = ob_get_clean();

    return $output;
}

$WebMapp_GeoJsonMapShortcode = new WebMapp_RegisterShortcode( 'webmapp_geojson_map', 'WebMapp_GeoJsonMapShortcode' );

// Register the Stylesheet so it's ready to go.
function shortcode_enqueue_scripts() {
	wp_register_script( 'custom-vector-markers', WebMapp_URL . 'third-part/leaflet/custom_leaflet-vector-markers.js', array('webmapp-leaflet-map') );
}
// Enqueue Stylesheet Action
add_action( 'wp_enqueue_scripts', 'shortcode_enqueue_scripts' );