<?php

$fields = array (
    array (
        'key' => 'wm_page_menu_color',
        'label' => 'colore',
        'name' => 'menu_color',
        'type' => 'color_picker',
        'instructions' => 'Use the color picker (click on the "Select Color" button) to select the color of the page menu item or insert direclty the color RGB code in the followong format: #RRGGBB',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
    ),
    array (
        'key' => 'wm_page_menu_icon',
        'name' => 'menu_icon',
        'label' => 'The WEBMAPP Icon of the POI',
        'type' => 'text',
        'instructions' => 'Insert the icon associated to the page menu item. Use the WEBMAPP icons: https://icon.webmapp.it'
    )
);

$args = array (
    'key' => 'group_wm_page',
    'title' => 'Page main info for WEBMAPP',
    'fields' => $fields,
    'location' => array (
        array (
            array (
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
);

$WebMapp_RegisterPagesFields = new WebMapp_RegisterFieldsGroup('page' ,$args );