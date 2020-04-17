<?php


$location = array(
    array(
        array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'map',
        ),
    ),
);



$fields1 = array(
    array(
        'role' => array(
            0 => 'subscriber',
        ),
        'multiple' => 1,
        'allow_null' => 1,
        'key' => 'field_58b43d34d1201',
        'label' => 'authorized users',
        'name' => 'n7webmap_map_users',
        'type' => 'user',
    )
);
$args = array(
    'key' => 'group_58528c8aa5bbfff',
    'title' => 'Authorized users',
    'fields' => $fields1,
    'location' => $location,
    'menu_order' => 0,
    'active' => 1
);
$WebMapp_RegisterMapFields1 = new WebMapp_RegisterFieldsGroup( 'map', $args );



//getMapGeoInfoCustomFields()
$fields2 = array(
    array(
        'key' => 'field_map_bbox',
        'label' => 'bounding box',
        'name' => 'n7webmap_map_bbox',
        'type' => 'textarea',
        'instructions' => 'Use this field to manually insert overlay layers. To be used carefully.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_map_config_url',
        'label' => 'Config URL',
        'name' => 'config_url',
        'type' => 'text'
    )
);
$args = array(
    'key' => 'group_58b9286d1af3111',
    'title' => __("Geographical Info"),
    'fields' => $fields2,
    'location' => $location,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'menu_order' => 1
);
$WebMapp_RegisterMapFields2 = new WebMapp_RegisterFieldsGroup( 'map', $args );



//getMapMainInfoCustomFields()
$fields3 = array(
            array(
                'multiple' => 0,
                'allow_null' => 0,
                'choices' => array(
                    'all' => 'all',
                    'layers' => 'layers',
                    'single' => 'single route',
                ),
                'key' => 'field_map_type',
                'label' => 'type',
                'name' => 'n7webmap_type',
                'type' => 'select',
                'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
            ),
            array(
                'post_type' => array(
                    0 => 'route',
                ),
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                    2 => 'taxonomy',
                ),
                'max' => 1,
                'return_format' => 'object',
                'key' => 'field_single_map_route',
                'label' => 'related route',
                'name' => 'net7webmap_map_route',
                'type' => 'relationship',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_map_type',
                            'operator' => '==',
                            'value' => 'single',
                        ),
                    ),
                ),
                'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
            ),
            array (
                'key' => 'wm_map_layer_poi',
                'label' => 'Poi\'s layer',
                'name' => 'layer_poi',
                'type' => 'taxonomy',
                'instructions' => 'Select the POI layer (webmapp category) used to create the POI menu and layers in the APP.',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_map_type',
                            'operator' => '==',
                            'value' => 'layers',
                        ),
                    ),
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'taxonomy' => 'webmapp_category',
                'field_type' => 'radio',
                'allow_null' => 1,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id',
                'multiple' => 0,
            ),
            array (
                'key' => 'wm_map_tiles',
                'label' => 'tiles',
                'name' => 'tiles',
                'type' => 'text',
                'instructions' => 'Insert the tiles URL in the following form http://{s}.tile.osm.org/',
                'required' => 1,
                'default_value' => 'http://{s}.tile.osm.org/',
            ),
            array(
                'key' => 'wm_map_style',
                'label' => 'Map Style',
                'instructions' => 'Use this textarea to set the MAPP (app and webapp) style. Use valid json format.',
                'name' => 'style',
                'type' => 'textarea'
            ),

            array(
                'key' => 'wm_map_pages_title',
                'label' => 'Pages Menu Title (About)',
                'instructions' => 'Set the title of the pages menu item. If empty About is used.',
                'name' => 'pages_title',
                'type' => 'text'
            ),

            array(
                'post_type' => array(
                    0 => 'page'
                ),
                'filters' => array(
                    0 => 'search'
                ),
                'return_format' => 'object',
                'key' => 'wm_map_pages',
                'label' => 'Map Pages',
                'name' => 'pages',
                'type' => 'relationship',
                'instructions' => 'Select pages to be added to the menu'
            ),
            array (
                'key' => 'wp_map_pages_no_first_level',
                'label' => 'NO first level',
                'name' => 'pages_no_first_level',
                'type' => 'true_false',
                'instructions' => 'By default pages are in menu under ABOUT item. Check this if you want to put pages directly in the main menu.',
                'default_value' => 0
            ),
            array (
                'key' => 'wp_map_has_offline',
                'label' => 'OFFLINE',
                'name' => 'has_offline',
                'type' => 'true_false',
                'instructions' => 'Activate OFFLINE features',
                'default_value' => 0
            ),
            array (
                'key' => 'wp_map_offline_label',
                'label' => 'OFFLINE menu label',
                'name' => 'offline_menu_label',
                'type' => 'text',
                'instructions' => 'Set The Offline menu label (Mappa offline)',
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'wp_map_has_offline',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),

            array (
                'key' => 'wp_map_app_id',
                'label' => 'APP ID',
                'name' => 'app_id',
                'type' => 'text',
                'instructions' => 'Insert the app ID (e.g. it.webmapp.mappadeimontipisani)'
            ),
            array (
                'key' => 'wp_map_app_description',
                'label' => 'APP description',
                'name' => 'app_description',
                'type' => 'textarea',
                'instructions' => 'Insert the app description'
            ),
            array (
                'key' => 'wp_map_app_icon',
                'label' => 'APP ICON',
                'name' => 'app_icon',
                'type' => 'image',
                'instructions' => 'Upload the APP (PNG 1024x1024 not alpha)',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),array (
                'key' => 'wp_map_app_splash',
                'label' => 'APP SPLASH',
                'name' => 'app_splash',
                'type' => 'image',
                'instructions' => 'Upload the splashscreen. Splash screen 2732 x 2732 png (not alpha), viewpoort inside the 1200 x 1200 square.',
                'return_format' => 'url',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ),
            array (
                'key' => 'wp_map_default_language',
                'label' => 'Default language',
                'name' => 'default_language',
                'type' => 'text',
                'instructions' => 'Set default (actual) language, even if the platform (app, webapp, website) is monolingual.',
                'default_value' => 'it'
            ),
            array (
                'key' => 'wp_map_has_languages',
                'label' => 'Multilanguages',
                'name' => 'has_languages',
                'type' => 'true_false',
                'instructions' => 'Activate multilanguages features',
                'default_value' => 0
            ),
            array (
                'key' => 'wp_map_languages_label',
                'label' => 'Multilanguages menu label',
                'name' => 'languages_menu_label',
                'type' => 'text',
                'instructions' => 'Set The Multilanguages menu label (Cambia lingua)',
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'wp_map_has_languages',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            array (
                'key' => 'wp_map_languages_list',
                'label' => 'Multilanguages list',
                'name' => 'languages_list',
                'type' => 'text',
                'instructions' => 'Set The Multilanguages available languages: use coma separated values (e.g. it_IT,en_EN,fr_FR)',
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'wp_map_has_languages',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
            array (
                'key' => 'wp_map_report_email',
                'label' => 'Email-to address for alert messages',
                'name' => 'report_email',
                'type' => 'email',
                'instructions' => 'Insert the email recipient for the alert messages send by APP and WEBAPP. Leave it blank for no email alert service'
            ),
            array (
                'key' => 'wp_map_report_sms',
                'label' => 'MOBILE number for SMS alert messages',
                'name' => 'report_sms',
                'type' => 'text',
                'instructions' => 'Insert the MOBILE recipient for the alert messages send by APP. Leave it blank for no SMS alert service. FORMAT: +XX XXX XXXXXXXXXX'
            ),
            array (
                'key' => 'wp_map_activate_zoom_control',
                'label' => 'Activate Zoom Control',
                'name' => 'activate_zoom_control',
                'type' => 'true_false',
                'instructions' => 'Activate Zoom Control Buttons (+/-) in the MAP interface (webapp an APP)',
                'default_value' => 0
            ),
            array (
                'key' => 'wp_map_hide_webmapp_page',
                'label' => 'Remove Webmapp page from main menu',
                'name' => 'hide_webmapp_page',
                'type' => 'true_false',
                'instructions' => 'Check this option if you want to remove Webmapp page from app and webapp Main Menu',
                'default_value' => 0
            ),
            array (
                'key' => 'wp_map_hide_attribution_page',
                'label' => 'Remove Attribution page from main menu',
                'name' => 'hide_attribution_page',
                'type' => 'true_false',
                'instructions' => 'Check this option if you want to remove Attrbution page from app and webapp Main Menu',
                'default_value' => 0
            ),
            // showAccessibilityButtons
            array (
                'key' => 'wp_map_show_accessibility_buttons',
                'label' => 'Activate accessibility features (showAccessibilityButtons) on APP and WEBAPP',
                'name' => 'show_accessibility_buttons',
                'type' => 'true_false',
                'instructions' => 'Check this option if you want to activate Accesibility features (show Accessibility Buttons on APP and WEBAPP)',
                'default_value' => 0
            ),

        );
$args = array(
    'key' => 'group_58b9286d1af31',
    'title' => __("Main info"),
    'fields' => $fields3,
    'location' => $location,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'menu_order' => 2
);
$WebMapp_RegisterMapFields3 = new WebMapp_RegisterFieldsGroup( 'map', $args );



//getMapAdvancedOptionsFields()
$fields4 = array(
            array(
                'key' => 'wm_map_additional_overlay_layers',
                'label' => 'Additional Overlay Layers',
                'name' => 'additional_overlay_layers',
                'type' => 'textarea',
            )
        );
$args = array(
            'key' => 'group_wm_map_advanced_options',
            'title' => __("Advanced Options"),
            'fields' => $fields4,
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'map',
                    ),
                ),
            ),
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'menu_order' => 3
        );
$WebMapp_RegisterMapFields4 = new WebMapp_RegisterFieldsGroup( 'map', $args );











