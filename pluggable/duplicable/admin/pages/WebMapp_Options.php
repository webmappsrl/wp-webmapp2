<?php

$tabs = array(
    'main' => _x( "Maps", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
    'custom_types' =>  _x( "Custom Types", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
    'taxonomies' =>  _x( "Taxonomies Details", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
    'wizards' =>  _x( "Wizards", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
    'hoqu' =>  _x( "Hoqu", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
);




$taxonomies_inputs = array();

$plugin_taxs = array(
    'theme',
    'where',
    'when',
    'who',
    'activity',
    'webmapp_category'
);
foreach ( $plugin_taxs as $tax_name ) :

    $taxonomies_inputs[ $tax_name . '_title' ] = array(
        'type' => 'html',
        'tab' => 'taxonomies',
        'html' => "<h3>$tax_name</h3>"
    );

    $input_name1 = $tax_name . '_featured_img';
    $taxonomies_inputs[ $input_name1 ] = array(
        'label' => _x( "Add $tax_name featured image" , WebMapp_TEXTDOMAIN ),
        'info' => _x( '' , WebMapp_TEXTDOMAIN),
        'type' => 'media',
        'tab' => 'taxonomies'
    );

    $input_name2 = $tax_name . '_featured_title';
    $taxonomies_inputs[ $input_name2 ] = array(
        'label' => _x( "Add $tax_name featured title" , WebMapp_TEXTDOMAIN ),
        'info' => _x( '' , WebMapp_TEXTDOMAIN),
        'type' => 'text',
        'tab' => 'taxonomies',
        'multilang' => true
    );


endforeach;



$generalOptionsPage = array(
    /**
     * MAIN TAB
     * MAPS
     */
    'google_api_key' => array(
        'label' => _x( "Google Maps API Key", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "<em><a target=\"_blank\" href=\"https://developers.google.com/maps/documentation/javascript/get-api-key\">" . _x( "Get a Google API Key","Option info in webmapp settings page", WebMapp_TEXTDOMAIN ) . "</a></em>",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main'
    ),
    'webmapp_bounding_box' => array(
        'label' => _x( "Bounding Box", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'attrs' => array( 'cols' => 50 , 'rows' => 10 ),
        'tab' => 'main',
        'type' => 'textarea'

    ),
    'webmapp_map_zoom' => array(
        'label' => _x( "Map Zoom", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'tab' => 'main',
        'type' => 'number',
        'default' => 16
    ),
    'webmapp_map_min_zoom' => array(
        'label' => _x( "Map Min Zoom", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'tab' => 'main',
        'type' => 'number',
        'default' => 10
    ),
    'webmapp_map_max_zoom' => array(
        'label' => _x( "Map Max Zoom", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'tab' => 'main',
        'type' => 'number',
        'default' => 16
    ),
    'webmapp_map_tilesUrl' => array(
        'label' => _x( "TilesUrl mappa", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'tab' => 'main',
        'type' => 'select',
        'options' => array(
            'https://api.webmapp.it/tiles/{z}/{x}/{y}.png' => 'Webmapp' ,
            'https://a.tile.openstreetmap.org/{z}/{x}/{y}.png' => 'OSM'
        ),
        'default' => 'http://api.webmapp.it/tiles/{z}/{x}/{y}.png'
    ),
    'webmapp_map_appUrl' => array(
        'label' => _x( "Map AppUrl", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main',
        'default' => str_replace('be' , 'j' ,$_SERVER['SERVER_NAME'] )
    ),
    'webmapp_map_apiUrl' => array(
        'label' => _x( "API url", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main',
        'default' => str_replace('be' , 'j' ,$_SERVER['SERVER_NAME'] )
    ),
    'webmapp_map_show-pin' => array(
        'label' => _x( "Show Pins", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    'webmapp_map_show-expand' => array(
        'label' => _x( "Show Extend Map", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    'webmapp_map_click-iframe' => array(
        'label' => _x( "Modal Open on Map Click", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    'webmapp_map_no_app' => array(
        'label' => _x( "Disable map modal" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Disattiva la modale che incorpora l\'iframe dell\'app e attiva il click sui marker.', 'Option info in webmapp settings page' , WebMapp_TEXTDOMAIN),
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    'webmapp_map_filter' => array(
        'label' => _x( "Filters active", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Attiva i filtri per vedere i poi vicini alla track.', 'Option info in webmapp settings page' , WebMapp_TEXTDOMAIN),
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    'webmapp_map_activate_zoom' => array(
        'label' => _x( "Active zoom and draggable maps", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Attiva lo zoom e il trascinamento sulla mappa' , WebMapp_TEXTDOMAIN),
        'type' => 'select',
        'tab' => 'main',
        'options' => array( 'true' => 'Sì' , 'false' => 'No' )
    ),
    //clustering
    'webmapp_maps_have_clustering' => array(
        'label' => _x( "Activate clustering on maps" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Attiva la funzionalità di clustering nella mappe Webmapp' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'main'
    ),
    /**
     * CUSTOM TYPES TAB
     */
    'webmapp_has_route' => array(
        'label' => _x( "Active Route Custom Post Type" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Il sito utilizza almeno una route' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'custom_types'
    ),
    'webmapp_tracks_has_webmapp_category' => array(
        'label' => _x( "Activate webmapp_category for track" , WebMapp_TEXTDOMAIN ),
        'info' => _x( '' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'custom_types'
    ),
    'webmapp_has_ecommerce' => array(
        'label' => _x( "Activate E-commerce Features" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Webmapp Editorial Platform uses E-commerce features (woo-commerce needed)' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'custom_types'
    ),
    'webmapp_wp_login_logo' => array(
        'label' => _x( "Featured logo for wp-login page" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Logo should be 284x284px in PNG format' , WebMapp_TEXTDOMAIN),
        'type' => 'media',
        'tab' => 'custom_types'
    ),
    //new fields from cyclando
    'webmapp_show_interactive_route_map' => array(
        'label' => _x( "Show interactive route map" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Mostrare mappa interattiva solo se show_interactive_route_map è true' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'main',
        'default' => 0
    ),
    'webmapp_use_wizards' => array(
        'label' => _x( "Use wizards" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Mostrare bottoni Wizard solo se use_wizards è true' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox',
        'tab' => 'wizards',
        'default' => 0
    ),
    // new fields for tab hoqu access token
    'webmapp_hoqu_token' => array(
        'label' => _x( "Access token" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Il token privato di HOQU ' , WebMapp_TEXTDOMAIN),
        'attrs' => array( 'size' => 50 ),
        'tab' => 'hoqu',
    ),
);
/**
 * TAXONOMIES TAB
 */
$generalOptionsPage = array_merge( $generalOptionsPage , $taxonomies_inputs );

/**
 * Create admin page
 */
$WEBMAPP_GeneralOptionsPage = new WebMapp_AdminOptionsPage(
    'Webmapp Options',
    'Webmapp',
    'manage_options',
    'webmap_netseven',
    $generalOptionsPage,
    $tabs
);