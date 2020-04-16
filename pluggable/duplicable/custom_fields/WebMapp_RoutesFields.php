<?php

$fields_all = array(
    /**
     * MAIN INFO
     */
    array(
        'key' => 'wm_route_main_info',
        'label' => 'Main Info',
        'type' => 'tab',
        'required' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    ),
    array(
        'key' => 'field_route_cod',
        'label' => __("Route code"),
        'name' => 'n7webmapp_route_cod',
        'type' => 'text',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    array(
        'key' => 'wm_route_is_group',
        'label' => 'Group trip?',
        'name' => 'is_group',
        'type' => 'true_false',
        'message' => 'Set this field to true if the trip is for groups.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD      
    ),
    array(
        'key' => 'wm_route_only_double',
        'label' => 'Only single and double room',
        'name' => 'only_double',
        'type' => 'true_false',
        'message' => 'Set this field to true if rooms are single or double. No triple or quadruple room available.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_route_boat_trip',
        'label' => 'Boat trip',
        'name' => 'boat_trip',
        'type' => 'true_false',
        'message' => 'Set this field to true if the trip is By Bike and Boat',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_route_from',
        'label' => 'Departure from',
        'name' => 'from',
        'type' => 'text',
        'placeholder' => 'Name of the city of departure'
    ),
    array(
        'key' => 'wm_route_to',
        'label' => 'Arrive to',
        'name' => 'to',
        'type' => 'text',
        'placeholder' => 'Name of the city of arrival'
    ),
    array(
        'key' => 'wm_route_shape',
        'label' => 'Shape',
        'name' => 'shape',
        'type' => 'radio',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => array(
            'linear' => 'Percorso lineare',
            'roundtrip' => 'Percorso ad anello',
            'daisy' => 'Percorso a margherita',
        ),
        'allow_null' => 1,
        'other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal',
        'return_format' => 'value',
        'save_other_choice' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'font_size' => 14,
        'slider_type' => 'number',
        'min' => 0,
        'max' => 5,
        'default_value_1' => 0,
        'default_value_2' => 5,
        'step' => 0.5,
        'title' => 'Difficulty level',
        'separate' => '-',
        'prepend' => '',
        'append' => '',
        'key' => 'field_58c0211c3afdd',
        'label' => 'Difficulty level',
        'name' => 'n7webmapp_route_difficulty',
        'type' => 'range',
        'instructions' => '',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
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
        'type' => 'repeater',
    ),
    array(
        'key' => 'wm_route_audio',
        'label' => 'Audio',
        'name' => 'audio',
        'type' => 'file',
        'instructions' => 'Upload audio file',
        'return_format' => 'array',
        'library' => 'all',
        'mime_types' => 'mp3'
    ),
    /**
     * GALLERY
     */
    array(
        'key' => 'wm_route_tab_gallery',
        'label' => 'Gallery',
        'type' => 'tab',
        'required' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    ),
    array(
        'library' => 'all',
        'insert' => 'append',
        'key' => 'wm_route_gallery',
        'label' => 'Media Gallery',
        'name' => 'n7webmap_route_media_gallery',
        'type' => 'gallery',
    ),
    /**
     * ACCESS
     */
    array(
        'key' => 'wm_route_access',
        'label' => 'Access',
        'type' => 'tab',
        'required' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    ),
    array(
        'key' => 'wm_route_public',
        'label' => 'Public route',
        'name' => 'wm_route_public',
        'type' => 'true_false',
        'message' => 'Set this field to true if the route is public, no authorization needed by the user.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    array(
        'role' => array(
            0 => 'subscriber',
        ),
        'multiple' => 1,
        'allow_null' => 1,
        'key' => 'n7webmap_route_users',
        'label' => 'authorized users',
        'name' => 'n7webmap_route_users',
        'type' => 'user',
        'default_value' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'wm_route_public',
                    'operator' => '!=',
                    'value' => '1',
                ),
            ),
        ),
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    //payment
    array(
        'key' => 'wm_route_payment',
        'label' => 'A pagamento?',
        'name' => 'wm_route_payment',
        'type' => 'true_false',
        'message' => 'Set this field to true if the route has a price.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'role' => array(
            0 => 'subscriber',
        ),
        //'multiple' => 1,
        'allow_null' => 1,
        'key' => 'wm_route_price',
        'label' => 'Price',
        'name' => 'wm_route_price',
        'type' => 'number',
        'default_value' => 9.99,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'wm_route_payment',
                    'operator' => '==',
                    'value' => '1',
                ),
            ),
        ),
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    // PASSWORD PROTECTED
    array(
        'key' => 'wm_route_use_password',
        'label' => 'Password protected route',
        'name' => 'use_password',
        'type' => 'true_false',
        'message' => 'Set this field to true if you want to protect the route with a password.',
        'default_value' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'wm_route_public',
                    'operator' => '!=',
                    'value' => '1',
                ),
            )
        ),
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD

    ),
    array(
        'key' => 'wm_route_route_password',
        'label' => __("Password"),
        'name' => 'route_password',
        'type' => 'text',
        'message' => 'Route Password.',
        'default_value' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'wm_route_use_password',
                    'operator' => '==',
                    'value' => '1',
                ),
            )
        ),
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD

    ),

    /**
     * TRACKS & ACTIVITIES
     */
    array(
        'key' => 'wm_route_tracks_and_activities',
        'label' => 'Tracks & Activities',
        'type' => 'tab',
        'required' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    ),
    array(
       'key' => 'wm_route_distance',
        'label' => 'Distance',
        'name' => 'distance',
        'type' => 'number',
        'placeholder' => 'Total distance of the route in km',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    array(
        'post_type' => array(
            0 => 'track'
        ),
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'return_format' => 'object',
        'key' => 'field_5859342579a1ee',
        'label' => 'Related Tracks',
        'name' => 'n7webmap_route_related_track',
        'type' => 'relationship',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    array(
        'key' => 'wm_route_tax_activity',
        'label' => 'Activities',
        'name' => 'wm_route_tax_activity',
        'type' => 'taxonomy',
        'instructions' => 'Add activities',
        'required' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'taxonomy' => 'activity',
        'field_type' => 'multi_select',
        'allow_null' => 1,
        'add_term' => 0,
        'save_terms' => 1,
        'load_terms' => 1,
        'return_format' => 'object',
        'multiple' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_route_from_poi',
        'label' => 'Start POI',
        'name' => 'from_poi',
        'type' => 'relationship',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'post_type' => array(
            0 => 'poi',
        ),
        'taxonomy' => '',
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'elements' => '',
        'min' => 0,
        'max' => 1,
        'return_format' => 'id',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),
    array(
        'key' => 'wm_route_to_poi',
        'label' => 'End POI',
        'name' => 'to_poi',
        'type' => 'relationship',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'post_type' => array(
            0 => 'poi',
        ),
        'taxonomy' => '',
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'elements' => '',
        'min' => 0,
        'max' => 1,
        'return_format' => 'id',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD
    ),


    /**
     * FORMULA
     */
    // array(
    //     'key' => 'wm_route_formula',
    //     'label' => 'Formula',
    //     'type' => 'tab',
    //     'required' => 0,
    //     'placement' => 'top',
    //     'endpoint' => 0,
    // ),
    // array(
    //     'key' => "wm_fdn" ,
    //     'name' => "wm_fdn" ,
    //     'type' => "true_false" ,
    //     'label' => "Fatto da noi"
    // ),//fatto da noi
    // array(
    //     'key' => "wm_self_guided" ,
    //     'name' => "wm_self_guided" ,
    //     'type' => "true_false" ,
    //     'label' => "Viaggio individuale"
    // ),//viaggio individuale
    // array(
    //     'key' => "wm_guided" ,
    //     'name' => "wm_guided" ,
    //     'type' => "true_false" ,
    //     'label' => "Viaggio con guida"
    // ),//viaggio con guida
    /**
    array(
        'key' => 'field_parse_gpx',
        'label' => 'Import track from GPX/KML file',
        'name' => 'n7webmap_import_gpx',
        'type' => 'message'
    ),
    **/

);

$fields_promotion = array(
    /**
     * PROMOTION (only with e-commerce features)
     */
    array(
        'key' => 'wm_route_promotion',
        'label' => 'Promotion',
        'message' => 'The promotion_ * fields contained in this TAB cannot be modified from this interface: they are managed automatically by the promotions interface',
        'type' => 'tab',
        'required' => 0,
        'placement' => 'top',
        'endpoint' => 0,
    ),
    array(
        'key' => 'wm_route_promotion_name',
        'label' => __("Name"),
        'message' => 'Name of the activated promotion',
        'name' => 'promotion_name',
        'type' => 'text',
        'readonly' => 1
    ),
    array(
        'key' => 'wm_route_promotion_value',
        'label' => __("Value"),
        'message' => 'Discount value',
        'name' => 'promotion_value',
        'type' => 'text',
        'readonly' => 1,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
);


if(get_option('webmapp_has_ecommerce')) {
    $fields = array_merge($fields_all,$fields_promotion);
} else {
    $fields = $fields_all;
}

$args = array(
    'key' => 'group_58528c8aa5b2ff',
    'title' => 'Routes main info',
    'fields' => $fields,
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'route',
            ),
        ),
    ),
    'menu_order' => 0,
    'active' => 1
);
$WebMapp_RegisterRouteFields = new WebMapp_RegisterFieldsGroup('route' ,$args );

