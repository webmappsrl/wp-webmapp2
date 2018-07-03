<?php

$tabs = array(
    'main' => _x( "Main", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN ),
    'test' => _x( "Test", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN )
);
/**
 * Todo estendere argomenti
 */
$generalOptionsPage = array(
    'test1' => array(
        'label' => _x( "test", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "test",
        'attrs' => array( 'size' => 50 ),
        'tab' => 'main'
    ),
    'test2' => array(
        'label' => _x( "Bohgd", "Option label in webmapp settings page" , WebMapp_TEXTDOMAIN ),
        'info' => "test",
        'attrs' => array( 'cols' => 50 , 'rows' => 10 ),
        'tab' => 'test',
        'type' => 'textarea'

    )


);

$WEBMAPP_GeneralOptionsPage = new WebMapp_AdminOptionsPage(
    'Duplicable Test',
    'Duplicable Test',
    'manage_options',
    'webmap_netseven2',
    $generalOptionsPage,
    $tabs
);