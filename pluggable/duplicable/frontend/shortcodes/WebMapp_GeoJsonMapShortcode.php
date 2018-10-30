<?php

// Add Shortcode
function WebMapp_GeoJsonMapShortcode( $atts ) {

    // Attributes
    $atts = shortcode_atts(
        array(
            'post_id' => '',
            'zoom' => '16',
            'height' => '500',
            'gejson_url' => ''
        ),
        $atts
    );

    extract( $atts );


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
                    post_type: '<?php echo get_post_type( $post_id ) ?>'
                    geojson_url: '<?php echo $gejson_url ?>'
                }
            );
        });
    </script>
    <?php
    $output = ob_get_clean();

    return $output;
}

$WebMapp_GeoJsonMapShortcode = new WebMapp_RegisterShortcode( 'webmapp_geojson_map', 'WebMapp_GeoJsonMapShortcode' );