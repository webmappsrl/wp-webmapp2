<?php

$tabs = array(
    'main' => _x( "Main", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN )
);
/**
 * Todo extend args
 */
$generalOptionsPage = array(
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
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main'
    ),
    'webmapp_map_tilesUrl' => array(
        'label' => _x( "TilesUrl mappa", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main'
    ),
    'webmapp_map_appUrl' => array(
        'label' => _x( "Map TilesUrl", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "short description",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main'
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
    'webmapp_has_route' => array(
        'label' => _x( "Active Route Custom Post Type" , WebMapp_TEXTDOMAIN ),
        'info' => _x( 'Il sito utilizza almeno una route' , WebMapp_TEXTDOMAIN),
        'type' => 'checkbox'
    ),

);

$WEBMAPP_GeneralOptionsPage = new WebMapp_AdminOptionsPage(
    'Webmapp Options',
    'Webmapp',
    'manage_options',
    'webmap_netseven',
    $generalOptionsPage,
    $tabs
);