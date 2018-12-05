<?php


$args = array(
    'webmap_font_awesome' => array(
        'src' => WebMapp_URL . 'third-part/font-awesome-4.7.0/css/font-awesome.min.css'
    ),
    'webmap_style_net7' => array(
        'src' => WebMapp_ASSETS . 'css/style.css'
    ),
    'webmap_leaflet' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet.css'
    ),
    'webmap_leaflet_vector_markers' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet-vector-markers.css'
    ),
    'webmap_leaflet_cluster_icon' => array(
        'src' => WebMapp_URL . 'third-part/Leaflet.markercluster-1.4.1/dist/MarkerCluster.css'
    ),
    'webmap_leaflet_cluster_icon_default' => array(
        'src' => WebMapp_URL . 'third-part/Leaflet.markercluster-1.4.1/dist/MarkerCluster.Default.css'
    ),
    'webmap_leaflet_cluster_style' => array(
        'src' => WebMapp_URL . 'third-part/LeafletClusterStyle/style.css'
    )
);

//use all sides
//copied from function called with init hook
new WebMapp_AssetEnqueuer( $args,array( 'login' , 'wp' , 'admin' ),'style' );



$args = array(

    'webmapp-leaflet-map' => array(
        'src' => WebMapp_ASSETS . 'js/leaflet-map.js',
        'deps' => array('jquery','webmap_leaflet_js'),
        'in_footer' => false
    ),
    'webmapp-leaflet-vector-markers' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet-vector-markers.min.js',
        'deps' => array('webmapp-leaflet-map')
    ),
    'jquery-ui-dialog' => array(),//format to enqueue already registered handles
    'webmap_leaflet_js' => array(
        'src' => WebMapp_URL . 'third-part/leaflet/leaflet.js',
        'in_footer' => false
    ),
    'webmap_leaflet_cluster' => array(
        'src' => WebMapp_URL . 'third-part/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js',
        'in_footer' => false
    )
);
//use all sides
//copied from function called with init hook
new WebMapp_AssetEnqueuer( $args,array( 'login' , 'wp' , 'admin' ),'script' );

