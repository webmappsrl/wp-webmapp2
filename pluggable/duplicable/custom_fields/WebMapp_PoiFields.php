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
            'instructions' => 'Insert point of interests from map to get coordinates',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
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
            'type' => 'gallery',
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
            'instructions' => 'Insert the name of the respective street.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b885e',
            'label' => 'Housenumber',
            'name' => 'addr:housenumber',
            'type' => 'text',
            'instructions' => 'Insert the name the house number (may contain letters, dashes or other characters).',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b885f',
            'label' => 'Postcode',
            'name' => 'addr:postcode',
            'type' => 'text',
            'instructions' => 'The postal code of the building/area.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b885g',
            'label' => 'City',
            'name' => 'addr:city',
            'type' => 'text',
            'instructions' => 'The name of the city as given in postal addresses of the building/area.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
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
            'instructions' => 'Insert the contact phone number (format: +[country code] [area code] [local number] eg: +39 050 123456).',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b886e',
            'label' => 'Email',
            'name' => 'contact:email',
            'type' => 'email',
            'instructions' => 'Insert the contact email (must be a valid email address).',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b886f',
            'label' => 'Opening Hours',
            'name' => 'opening_hours',
            'type' => 'text',
            'instructions' => 'Insert the opening hours of the POI. Please refer to the OSM Wiki for examples and explenations: http://wiki.openstreetmap.org/wiki/Key:opening_hours#Examples',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'field_58db8898b886g',
            'label' => 'Capacity',
            'name' => 'capacity',
            'type' => 'text',
            'instructions' => 'Insert the capacity a facility is suitable for.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_stars',
            'label' => 'Stars',
            'name' => 'stars',
            'type' => 'text',
            'instructions' => 'Stars rating for hotels.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        )


    );


    $poi_fields5 = array(
        array(
            'key' => 'wm_poi_tab_link',
            'label' => 'Link & Media',
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
                    'type' => 'url',
                    'wpml_cf_preferences' => WEBMAPP_TRANSLATE_CUSTOM_FIELD,
                ),
            ),
            'layout' => 'table',
            'button_label' => 'Add Url',
            'key' => 'field_585cdc9229191',
            'label' => 'related url',
            'name' => 'n7webmap_rpt_related_url',
            'type' => 'repeater',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_audio',
            'label' => 'Audio',
            'name' => 'audio',
            'type' => 'file',
            'instructions' => 'Upload audio file',
            'return_format' => 'array',
            'library' => 'all',
            'mime_types' => 'mp3'
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
            'instructions' => 'Use the color picker (click on the "Select Color" button) to select the color of the POI or insert direclty the color RGB code in the followong format: #RRGGBB',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array (
            'key' => 'wm_poi_ele',
            'name' => 'ele',
            'label' => 'Altitude of the POI (in meters)',
            'type' => 'number',
            'instructions' => 'Insert the altitude of the poi in meters from min of 0 and max of 8848',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
            'min' => 0,
            'max' => 8848,
        ),
        array (
            'key' => 'wm_poi_icon',
            'name' => 'icon',
            'label' => 'The WEBMAPP Icon of the POI',
            'type' => 'text',
            'instructions' => 'Insert the icon associated to the taxonomy term. Use the WEBMAPP icons: https://icon.webmapp.it/',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_code',
            'label' => __("Code"),
            'name' => 'code',
            'type' => 'text',
            'instructions' => 'Use this field to add a code to the POI.',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,

        ),

        array (
            'key' => 'wm_poi_noDetails',
            'label' => 'No Details',
            'name' => 'noDetails',
            'type' => 'true_false',
            'instructions' => 'Check this if you want to disable the details of this POI in the APP and webapp',
            'default_value' => 0,
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array (
            'key' => 'wm_poi_noInteractions',
            'label' => 'No Interaction',
            'name' => 'noInteraction',
            'type' => 'true_false',
            'instructions' => 'Check this if you want to disable any interaction of this POI in the APP and webapp',
            'default_value' => 0,
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        )
    );



    $poi_fields7 = array(

        // ACCESSIBILITY
        array(
            'key' => 'wm_poi_tab_accessibility',
            'label' => 'Accessibility',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        // VALIDITY DATE
        array(
			'key' => 'wm_poi_accessibility_validity_date',
			'label' => 'Specific date of validity of the information',
			'name' => 'accessibility_validity_date',
			'type' => 'date_picker',
			'instructions' => 'Insert the date when the information has been last verified',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'acfe_permissions' => '',
			'display_format' => 'd-m-Y',
			'return_format' => 'd-m-Y',
			'first_day' => 1,
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
		),
        // GENERIC PDF ACCESSIBILITY INFORMATION
        array(
			'key' => 'wm_poi_accessibility_pdf',
			'label' => 'Generic information on accessibility (PDF)',
			'name' => 'accessibility_pdf',
			'type' => 'file',
			'instructions' => 'Upload a PDF with generic information on accessibility (only PDF allowed). Below you can insert the detailed information for each section',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'acfe_permissions' => '',
			'acfe_uploader' => 'wp',
			'return_format' => 'array',
			'library' => 'all',
			'min_size' => '',
			'max_size' => '',
			'mime_types' => 'pdf',
            'wpml_cf_preferences' => WEBMAPP_TRANSLATE_CUSTOM_FIELD,
		),
        // MOBILITY
        array(
            'key' => 'wm_access_mobility_check',
            'label' => 'Mobility Impairment',
            'name' => 'access_mobility_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to mobility',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_mobility_level',
            'label' => 'Mobility Access Level',
            'name' => 'access_mobility_level',
            'type' => 'select',
            'instructions' => 'Select the level of accessibility with regard to mobility impairment',
            'required' => 0,
            'conditional_logic' => array (
                array (
                    array (
                        'field' => 'wm_access_mobility_check',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'accessible_independently' => 'Accessible independently',
                'accessible_with_assistance' => 'Accessible with assistance',
                'accessible_with_a_guide' => 'Accessible with a guide',
            ),
            'default_value' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
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
            'label' => 'Hearing Impairment',
            'name' => 'access_hearing_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to hearing',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_hearing_level',
            'label' => 'Hearing Access Level',
            'name' => 'access_hearing_level',
            'type' => 'select',
            'instructions' => 'Select the level of accessibility with regard to hearing',
            'required' => 0,
            'conditional_logic' => array (
                array (
                    array (
                        'field' => 'wm_access_hearing_check',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'accessible_independently' => 'Accessible independently',
                'accessible_with_assistance' => 'Accessible with assistance',
                'accessible_with_a_guide' => 'Accessible with a guide',
            ),
            'default_value' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_hearing_description',
            'label' => 'Hearing Impairment Description',
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
            'label' => 'Vision Impairment',
            'name' => 'access_vision_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to vision',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_vision_level',
            'label' => 'Vision Access Level',
            'name' => 'access_vision_level',
            'type' => 'select',
            'instructions' => 'Select the level of accessibility with regard to vision',
            'required' => 0,
            'conditional_logic' => array (
                array (
                    array (
                        'field' => 'wm_access_vision_check',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'accessible_independently' => 'Accessible independently',
                'accessible_with_assistance' => 'Accessible with assistance',
                'accessible_with_a_guide' => 'Accessible with a guide',
            ),
            'default_value' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_vision_description',
            'label' => 'Vision Impairment Description',
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
            'label' => 'Cognitive Impairment',
            'name' => 'access_cognitive_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to cognitive',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_cognitive_level',
            'label' => 'Cognitive Access Level',
            'name' => 'access_cognitive_level',
            'type' => 'select',
            'instructions' => 'Select the level of accessibility with regard to cognitive',
            'required' => 0,
            'conditional_logic' => array (
                array (
                    array (
                        'field' => 'wm_access_cognitive_check',
                        'operator' => '==',
                        'value' => '1',
                    ),
                ),
            ),
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'accessible_independently' => 'Accessible independently',
                'accessible_with_assistance' => 'Accessible with assistance',
                'accessible_with_a_guide' => 'Accessible with a guide',
            ),
            'default_value' => array(
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_access_cognitive_description',
            'label' => 'Cognitive Impairment Description',
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
            'label' => 'Food Impairment',
            'name' => 'access_food_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered accessible with regard to food intolerance',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),

        array(
            'key' => 'wm_access_food_description',
            'label' => 'Food Impairment Description',
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

        // Reachability
        array(
            'key' => 'wm_poi_tab_reachability',
            'label' => 'Reachability',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        // BIKE
        array(
            'key' => 'wm_poi_reachability_by_bike_check',
            'label' => 'Reachable By Bike',
            'name' => 'reachability_by_bike_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered reachable by bike',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_reachability_by_bike_description',
            'label' => 'Reachable By Bike Description',
            'name' => 'reachability_by_bike_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the reachability of the point of interest by bike',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // FOOT
        array(
            'key' => 'wm_poi_reachability_on_foot_check',
            'label' => 'Reachable On Foot',
            'name' => 'reachability_on_foot_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered reachable on foot',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_reachability_on_foot_description',
            'label' => 'Reachable On Foot Description',
            'name' => 'reachability_on_foot_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the reachability of the point of interest on foot',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // CAR
        array(
            'key' => 'wm_poi_reachability_by_car_check',
            'label' => 'Reachability By Car',
            'name' => 'reachability_by_car_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered reachable by car',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_reachability_by_car_description',
            'label' => 'Reachability By Car Description',
            'name' => 'reachability_by_car_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the reachability of the point of interest by car',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

        // PUBLIC TRANSPORTATION
        array(
            'key' => 'wm_poi_reachability_by_public_transportation_check',
            'label' => 'Reachability By Public Transportation',
            'name' => 'reachability_by_public_transportation_check',
            'type' => 'true_false',
            'instructions' => 'Check this if you believe that the point of interest can be considered reachable by public transportaion',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        ),
        array(
            'key' => 'wm_poi_reachability_by_public_transportation_description',
            'label' => 'Reachability By Public Transportation Description',
            'name' => 'reachability_by_public_transportation_description',
            'type' => 'wysiwyg',
            'instructions' => 'Describe in detail the reachability of the point of interest by public transportaion',
            'tabs' => 'all',
            'toolbar' => 'basic',
            'media_upload' => 1,
            'delay' => 1
        ),

    );

    $poi_fields9 = array(
        array(
            'key' => 'wm_poi_tab_advanced',
            'label' => 'Advanced',
            'type' => 'tab',
            'required' => 0,
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
			'key' => 'wm_poi_zindex',
			'label' => 'Z-index',
			'name' => 'zindex',
			'type' => 'number',
			'instructions' => 'Insert the visibility order of this POI on the map, the value should be between -50 and 50. Higher value means this POI is positioned above the others on the map.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => -50,
			'max' => 50,
            'step' => '',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
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
            'instructions' => 'Use this field to set the content of this poi from another POI',
            'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,

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
            $poi_fields8,
            $poi_fields9
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
