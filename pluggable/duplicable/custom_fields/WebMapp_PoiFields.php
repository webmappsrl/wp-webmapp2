<?php

// Position / Gallery / Address / Contact / Link / Info / Accessibility


    $poi_fields1 = array(
        array(
            'key' => 'wm_poi_tab_coordinate',
            'label' => 'Position',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_58528c8fff96b',
            'label' => 'Coordinate',
            'name' => 'n7webmap_coord',
            'type' => 'google_map',
            'center_lat' => '43.6551217',
            'center_lng' => '11.0812834',
            'zoom' => '7',
            'instructions' => 'Insert point of interests from map to get coordinates'
        ));


    $poi_fields2 = array(
        array(
            'key' => 'wm_poi_tab_gallery',
            'label' => 'Gallery',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'library' => 'all',
            'insert' => 'append',
            'key' => 'wm_poi_gallery',
            'label' => 'Media Gallery',
            'name' => 'n7webmap_media_gallery',
            'type' => 'gallery'
        ));


    $poi_fields3 = array(
        array(
            'key' => 'wm_poi_tab_address',
            'label' => 'Address',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_58db8898b885d',
            'label' => 'Street',
            'name' => 'addr:street',
            'type' => 'text',
            'instructions' => 'Insert the name of the respective street.'
        ),
        array(
            'key' => 'field_58db8898b885e',
            'label' => 'Housenumber',
            'name' => 'addr:housenumber',
            'type' => 'text',
            'instructions' => 'Insert the name the house number (may contain letters, dashes or other characters).'
        ),
        array(
            'key' => 'field_58db8898b885f',
            'label' => 'Postcode',
            'name' => 'addr:postcode',
            'type' => 'text',
            'instructions' => 'The postal code of the building/area.'
        ),
        array(
            'key' => 'field_58db8898b885g',
            'label' => 'City',
            'name' => 'addr:city',
            'type' => 'text',
            'instructions' => 'The name of the city as given in postal addresses of the building/area.'
        )

    );



    $poi_fields4 = array(
        array(
            'key' => 'wm_poi_tab_contact',
            'label' => 'Contact',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_58db8898b886d',
            'label' => 'Phone',
            'name' => 'contact:phone',
            'type' => 'text',
            'instructions' => 'Insert the contact phone number (format: +[country code] [area code] [local number] eg: +39 050 123456).'
        ),
        array(
            'key' => 'field_58db8898b886e',
            'label' => 'Email',
            'name' => 'contact:email',
            'type' => 'email',
            'instructions' => 'Insert the contact email (must be a valid email address).'
        ),
        array(
            'key' => 'field_58db8898b886f',
            'label' => 'Opening Hours',
            'name' => 'opening_hours',
            'type' => 'text',
            'instructions' => 'Insert the opening hours of the POI. Please refer to the OSM Wiki for examples and explenations: http://wiki.openstreetmap.org/wiki/Key:opening_hours#Examples'
        ),
        array(
            'key' => 'field_58db8898b886g',
            'label' => 'Capacity',
            'name' => 'capacity',
            'type' => 'text',
            'instructions' => 'Insert the capacity a facility is suitable for.'
        ),
        array(
            'key' => 'wm_poi_stars',
            'label' => 'Stars',
            'name' => 'stars',
            'type' => 'text',
            'instructions' => 'Stars rating for hotels.'
        )


    );


    $poi_fields5 = array(
        array(
            'key' => 'wm_poi_tab_link',
            'label' => 'Link',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'sub_fields' => array(
                array(
                    'key' => 'field_585cdd464c509',
                    'label' => 'url',
                    'name' => 'net7webmap_related_url',
                    'type' => 'url'
                ),
            ),
            'layout' => 'table',
            'button_label' => 'Add Url',
            'key' => 'field_585cdc9229191',
            'label' => 'related url',
            'name' => 'n7webmap_rpt_related_url',
            'type' => 'repeater'
        )
    );


    $poi_fields6 = array(
        array(
            'key' => 'wm_poi_tab_info',
            'label' => 'Info',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array (
            'key' => 'wm_poi_color',
            'name' => 'color',
            'label' => 'The color of the POI',
            'type' => 'color_picker',
            'instructions' => 'Use the color picker (click on the "Select Color" button) to select the color of the POI or insert direclty the color RGB code in the followong format: #RRGGBB'
        ),
        array (
            'key' => 'wm_poi_icon',
            'name' => 'icon',
            'label' => 'The WEBMAPP Icon of the POI',
            'type' => 'text',
            'instructions' => 'Insert the icon associated to the taxonomy term. Use the WEBMAPP icons: https://icon.webmapp.it/'
        ),
        array(
            'key' => 'wm_poi_code',
            'label' => __("Code"),
            'name' => 'code',
            'type' => 'text',
            'instructions' => 'Use this field to add a code to the POI.'

        ),

        array (
            'key' => 'wm_poi_noDetails',
            'label' => 'No Details',
            'name' => 'noDetails',
            'type' => 'true_false',
            'instructions' => 'Check this if you want to disable the details of this POI in the APP and webapp',
            'default_value' => 0
        ),
        array (
            'key' => 'wm_poi_noInteractions',
            'label' => 'No Interaction',
            'name' => 'noInteraction',
            'type' => 'true_false',
            'instructions' => 'Check this if you want to disable any interaction of this POI in the APP and webapp',
            'default_value' => 0
        )
    );



    $poi_fields7 = array(

        // MOBILITY
        array(
            'key' => 'wm_poi_tab_accessibility',
            'label' => 'Accessibility',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'wm_access_mobility_check',
            'label' => 'Mobility Impairment',
            'name' => 'access_mobility_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to mobility'
        ),

        array(
            'key' => 'wm_access_mobility_description',
            'label' => 'Mobility Impairment Description',
            'name' => 'access_mobility_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the accessibility of the point of interest for the mobility impairment',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // HEARING hearing
        array(
            'key' => 'wm_access_hearing_check',
            'label' => 'hearing Impairment',
            'name' => 'access_hearing_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to hearing'
        ),

        array(
            'key' => 'wm_access_hearing_description',
            'label' => 'hearing Impairment Description',
            'name' => 'access_hearing_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the accessibility of the point of interest for the hearing impairment',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // VISION vision
        array(
            'key' => 'wm_access_vision_check',
            'label' => 'vision Impairment',
            'name' => 'access_vision_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to vision'
        ),

        array(
            'key' => 'wm_access_vision_description',
            'label' => 'vision Impairment Description',
            'name' => 'access_vision_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the accessibility of the point of interest for the vision impairment',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // COGNITIVE cognitive
        array(
            'key' => 'wm_access_cognitive_check',
            'label' => 'cognitive Impairment',
            'name' => 'access_cognitive_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to cognitive'
        ),

        array(
            'key' => 'wm_access_cognitive_description',
            'label' => 'cognitive Impairment Description',
            'name' => 'access_cognitive_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the accessibility of the point of interest for the cognitive impairment',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // FOOD INTOLERANCE food

        array(
            'key' => 'wm_access_food_check',
            'label' => 'food Impairment',
            'name' => 'access_food_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to food intolerance'
        ),

        array(
            'key' => 'wm_access_food_description',
            'label' => 'food Impairment Description',
            'name' => 'access_food_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the accessibility of the point of interest for the food intolerance',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        )

    );



    $poi_fields8 = array(
        array(
            'key' => 'wm_poi_tab_advanced',
            'label' => 'Advanced',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'wm_poi_content_from',
            'label' => 'Content from',
            'name' => 'content_from',
            'post_type' => array(
                0 => 'poi',
            ),
            'filters' => array(
                0 => 'search',
                1 => 'post_type',
                2 => 'taxonomy',
            ),
            'type' => 'relationship',
            'max' => '1',
            'return_format' => 'object',
            'instructions' => 'Use this field to set the content of this poi from another POI'

        ));



    $args = array(
        'key' => 'group_58528c8aa5b2f',
        'title' => 'POI',
        'fields' => array_merge(
            $poi_fields1,
            $poi_fields2,
            $poi_fields3,
            $poi_fields4,
            $poi_fields5,
            $poi_fields6,
            $poi_fields7,
            $poi_fields8
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'poi',
                ),
            ),
        ),
        'menu_order' => 0,
        'active' => 1
    );

    //var_dump( $poi_fields );


$WebMapp_RegisterPoiFields = new WebMapp_RegisterFieldsGroup( 'poi', $args );
