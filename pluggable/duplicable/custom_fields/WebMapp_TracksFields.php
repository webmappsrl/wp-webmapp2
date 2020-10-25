<?php

//fields location settings
$location = array(
    array(
        array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'track',
        ),
    ),
);




$fields1 = array(
    array(
        'key' => 'field_parse_gpx',
        'label' => 'Import track from GPX file',
        'name' => 'n7webmap_import_gpx',
        'type' => 'message',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
);
$args = array(
    'key' => 'group_5853f89462666b4',
    'title' => 'Import track (GPX file)',
    'fields' => $fields1,
    'location' => $location,
    'menu_order' => 0,
    'position' => 'acf_after_title',
);
$WebMapp_RegisterTrackFields1 = new WebMapp_RegisterFieldsGroup('track' ,$args );


//getTrackCustomFields()
$fields2 = array(
    array (
        'default_value' => '',
        'key' => 'field_58c7ef836e6e2',
        'label' => 'Track color',
        'name' => 'n7webmapp_track_color',
        'type' => 'color_picker',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ), array(
        'key' => 'wm_track_code',
        'label' => __("Route code"),
        'name' => 'code',
        'type' => 'text',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'library' => 'all',
        'insert' => 'append',
        'key' => 'wm_track_gallery',
        'label' => 'Media Gallery',
        'name' => 'n7webmap_track_media_gallery',
        'type' => 'gallery',
    ),
    array(
        'key' => 'field_585933bd79a1a',
        'label' => 'Start',
        'name' => 'n7webmap_start',
        'type' => 'text'
    ),
    array(
        'post_type' => array(
            0 => 'poi',
        ),
        'taxonomy' => array(
        ),
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'max' => '1',
        'return_format' => 'object',
        'key' => 'field_585933d079a1b',
        'label' => 'start POI',
        'name' => 'n7webmap_start_poi',
        'type' => 'relationship',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'field_585933f779a1c',
        'label' => 'end',
        'name' => 'n7webmap_end',
        'type' => 'text'
    ),
    array(
        'post_type' => array(
            0 => 'poi',
        ),
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'max' => '1',
        'return_format' => 'object',
        'key' => 'field_5859340879a1d',
        'label' => 'end POI',
        'name' => 'n7webmap_end_poi',
        'type' => 'relationship',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'post_type' => array(
            0 => 'poi'
        ),
        'filters' => array(
            0 => 'search',
            1 => 'post_type',
            2 => 'taxonomy',
        ),
        'return_format' => 'object',
        'key' => 'field_5859342579a1e',
        'label' => 'related POI',
        'name' => 'n7webmap_related_poi',
        'type' => 'relationship',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'post_type' => array(
            0 => 'track',
        ),
        'taxonomy' => array(
        ),
        'filters' => array(
            0 => 'search',
            1 => 'taxonomy',
        ),
        'max' => '1',
        'return_format' => 'id',
        'key' => 'wm_track_prev_track',
        'label' => 'Previous Track',
        'name' => 'prev_track',
        'type' => 'relationship',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),    
    array(
        'post_type' => array(
            0 => 'track',
        ),
        'taxonomy' => array(
        ),
        'filters' => array(
            0 => 'search',
            1 => 'taxonomy',
        ),
        'max' => '1',
        'return_format' => 'id',
        'key' => 'wm_track_next_track',
        'label' => 'Next Track',
        'name' => 'next_track',
        'type' => 'relationship',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
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
        'key' => 'wm_track_audio',
        'label' => 'Audio',
        'name' => 'audio',
        'type' => 'file',
        'instructions' => 'Upload audio file',
        'return_format' => 'array',
        'library' => 'all',
        'mime_types' => 'mp3'
    ),
    array(
        'key' => 'wm_track_zindex',
        'label' => 'Z-index',
        'name' => 'zindex',
        'type' => 'number',
        'instructions' => 'Insert the visibility order of this track on the map, the value should be between -50 and 50. Higher value means this track is positioned above the others on the map.',
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
        'key' => 'wm_track_stroke_width',
        'label' => 'Stroke width',
        'name' => 'stroke_width',
        'type' => 'number',
        'instructions' => 'Insert the line width of this track on the map, the value should be between 1 and 10. Leave empty for default.',
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
        'min' => 1,
        'max' => 10,
        'step' => '',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_stroke_opacity',
        'label' => 'Stroke opacity',
        'name' => 'stroke_opacity',
        'type' => 'number',
        'instructions' => 'Insert the line opacity of this track on the map, the value should be between 1 and 100. Leave empty for default.',
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
        'min' => 1,
        'max' => 100,
        'step' => '',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_line_dash_repeater',
        'label' => 'Line dash repeater',
        'name' => 'line_dash_repeater',
        'type' => 'repeater',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        'instructions' => 'Insert the line dash pattern of this track on the map, it should be pairs of numbers between 1 and 50. Leave empty for a continuous line',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'collapsed' => '',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => '',
        'sub_fields' => array(
            array(
                'key' => 'wm_track_line_dash',
                'label' => 'line dash',
                'name' => 'line_dash',
                'type' => 'number',
                'instructions' => '',
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
                'min' => 1,
                'max' => 50,
                'step' => '',
                'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
            ),
        ),
    ),
);
$args = array(
    'key' => 'group_5853f894626b4',
    'title' => 'Track',
    'fields' => $fields2,
    'location' => $location,
    'menu_order' => 1
);
$WebMapp_RegisterTrackFields2 = new WebMapp_RegisterFieldsGroup('track' ,$args );



//getTrackHikingFields()
// HIKING FIELDS (from OSM)

$fields3 = array(
    array(
        'key' => 'wm_track_ref',
        'label' => 'REF (the track number or code)',
        'name' => 'ref',
        'type' => 'text',
        'instructions' => 'Insert the track number or code. Format alphanumeric. Example: 135 or E121.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_ascent',
        'label' => 'Ascent (D+)',
        'name' => 'ascent',
        'type' => 'text',
        'instructions' => 'Insert the total ascent (positive gain) of the track considering the track walked from the start point to the end point. Use meter as unit.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_descent',
        'label' => 'Descent (D-)',
        'name' => 'descent',
        'type' => 'text',
        'instructions' => 'Insert the the total descent (negative gain) of the track considering the track walked from the start point to the end point. Use meter as unit.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_distance',
        'label' => 'Distance (lenght of the track)',
        'name' => 'distance',
        'type' => 'text',
        'instructions' => 'Insert the total lenght of the track. Use meter as unit.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_duration:forward',
        'label' => 'Duration forward',
        'name' => 'duration:forward',
        'type' => 'text',
        'instructions' => 'Insert the estimated time to walk the track form the start point to the end point. Use the following format: hh:mm',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_duration_backword',
        'label' => 'Duration backward',
        'name' => 'duration:backward',
        'type' => 'text',
        'instructions' => 'Insert the estimated time to walk the track form the end point to the start point. Use the following format: hh:mm',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_cai_scale',
        'label' => 'Difficulty',
        'name' => 'cai_scale',
        'type' => 'text',
        'instructions' => 'Insert the path difficulty classification according to the Club Alpino Italiano scale (T,E,EE,EEA). Please refer to the following address for more information: http://wiki.openstreetmap.org/wiki/Proposed_features/cai_scale',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_track_osmid',
        'label' => 'Osmid',
        'name' => 'osmid',
        'type' => 'text',
        'instructions' => 'Insert the corresponding relation (or way) OSMID.',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_update_track_osmid',
        'label' => 'Update OSMID',
        'name' => 'update_track_osmid',
        'type' => 'acfe_button',
        'instructions' => 'Hit this button to send an on demand request to update the geometry.',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => 'wm_track_osmid',
                    'operator' => '!=empty',
                ),
            ),
        ),
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'wpml_cf_preferences' => 0,
        'acfe_permissions' => array(
            0 => 'administrator',
            1 => 'editor',
            2 => 'author',
        ),
        'button_value' => 'Update',
        'button_type' => 'submit',
        'button_class' => 'button button-secondary',
        'button_id' => 'update_button_track_osmid',
        'button_osmid' => '',
        'button_before' => '',
        'button_after' => '<span id="osmid_ajax_spinner" class="spinner"></span><p id="update_button_track_osmid_success" style="display:inline;display:none;"><span class="dashicons dashicons-yes"></span> Geometry updated successfully</p>',
        'button_ajax' => 1,
    ),
    array(
        'key' => 'wm_track_surface',
        'label' => 'Surface',
        'name' => 'surface',
        'type' => 'repeater',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
        'instructions' => 'Add surface',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'collapsed' => 'wm_track_surface_type',
        'min' => 0,
        'max' => 0,
        'layout' => 'table',
        'button_label' => '',
        'sub_fields' => array(
            array(
                'key' => 'wm_track_surface_type',
                'label' => 'Surface Type',
                'name' => 'surface_type',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'asphalt' => 'asphalt',
                    'unpaved' => 'unpaved',
                    'paved' => 'paved',
                    'ground' => 'ground',
                    'gravel' => 'gravel',
                    'concrete' => 'concrete',
                    'paving_stones' => 'paving_stones',
                    'dirt' => 'dirt',
                    'grass' => 'grass',
                    'compacted' => 'compacted',
                    'sand' => 'sand',
                    'cobblestone' => 'cobblestone',
                    'fine_gravel' => 'fine_gravel',
                    'sett' => 'sett',
                    'earth' => 'earth',
                    'wood' => 'wood',
                    'concrete:plates' => 'concrete:plates',
                    'pebblestone' => 'pebblestone',
                    'mud' => 'mud',
                    'metal' => 'metal',
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
                'key' => 'wm_track_surface_type_percentage',
                'label' => 'Percentage',
                'name' => 'surface_type_percentage',
                'type' => 'range',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'min' => '',
                'max' => 100,
                'step' => '',
                'prepend' => '',
                'append' => '',
                'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
            ),
        ),
    )
);
$args = array(
    'title' => 'Hiking Info',
    'fields' => $fields3,
    'location' => $location,
    'menu_order' => 2
);

$WebMapp_RegisterRouteFields = new WebMapp_RegisterFieldsGroup('track' ,$args );


$fields4 = array(
    array(
        'key' => 'wm_track_rb_track_section',
        'label' => 'ROADBOOK section',
        'name' => 'rb_track_section',
        'type' => 'wysiwyg'
    ),
);

$args = array(
    'key' => 'group_wm_track_rb',
    'title' => 'ROADBOOK',
    'fields' => $fields4,
    'location' => $location,
    'menu_order' => 3,
);

$WebMapp_RegisterTrackFields1 = new WebMapp_RegisterFieldsGroup('track' ,$args );


