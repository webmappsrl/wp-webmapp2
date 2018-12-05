<?php

add_action( 'wp' , function() {


    $tiles_url = get_option('webmapp_map_tilesUrl');
    $zoom = get_option( 'webmapp_map_zoom' );
    $app_url = get_option( 'webmapp_map_appUrl' );
    $pin = !empty( get_option( 'webmapp_map_show-pin' ) ) ? get_option( 'webmapp_map_show-pin' ) : 'true';
    $expand = get_option( 'webmapp_map_show-expand' );
    $click = !empty( get_option( 'webmapp_map_click-iframe' ) ) ? get_option( 'webmapp_map_click-iframe' ) : 'true';
    $no_app = get_option( 'webmapp_map_no_app' );
    $filter = get_option( 'webmapp_map_filter' );
    $activateZoom = get_option( 'webmapp_map_activate_zoom' );


    //new options 9/11/2018
    $api_url = get_option( 'webmapp_map_apiUrl' );
    $min_zoom = get_option( 'webmapp_map_min_zoom' );
    $max_zoom = get_option( 'webmapp_map_max_zoom' );

    //new options clustering 5/12/2018
    $maps_have_clustering = get_option('webmapp_maps_have_clustering');



    $data = array(
        'label' => 'Mappa',
        'tilesUrl' => $tiles_url,
        'zoom' => $zoom,
        'appUrl' => $app_url,
        'show_pin' => $pin,
        'show_expand' => $expand,
        'click_iframe' => $click,
        'current_post_id' => get_the_ID(),
        'labelFilters' => __('punti d\'interesse vicini', WebMapp_TEXTDOMAIN ),
		'labelDeactive' => __('Disattiva', WebMapp_TEXTDOMAIN ),
		'labelActive' => __('Attiva', WebMapp_TEXTDOMAIN ),
        //new options 9/11/2018
        'apiUrl' => $api_url,
        'zoom_max' => $max_zoom,
        'zoom_min' => $min_zoom,
        //new options clustering 5/12/2018
        'maps_have_clustering' => $maps_have_clustering
    );

    if (!empty($no_app)){
        $data['no_app'] = $no_app;
    }

    if (!empty($filter)){
        $data['filter'] = $filter;
    }

    if (!empty($activateZoom)){
        $data['activate_zoom'] = $activateZoom;
    }

    $args = array(
        'custom-map' => array(
            'src' => WebMapp_ASSETS . 'js/custom-map.js',
            'deps' => array('jquery'),
            'in_footer' => true,
            'screen_base' => '',//works only in admin pages
            'screen_id' => '',//works only in admin pages
            'localize' => array(
                'object_name' => 'data',
                'data' => $data
            )
        )

    );
    new WebMapp_AssetEnqueuer( $args,'wp','script' );

} );


