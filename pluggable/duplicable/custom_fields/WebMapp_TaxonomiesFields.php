<?php

//getWebmappTaxonomyCustomFields

$fields = array (
    array(
        'key' => 'wm_html_description',
        'label' => 'Taxonomy HTML description',
        'name' => 'html_description',
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => 'full',
        'media_upload' => 0,
        'delay' => 0,
    ),
    array (
        'key' => 'wm_taxonomy_color',
        'label' => 'color',
        'name' => 'color',
        'type' => 'color_picker',
        'instructions' => 'Use the color picker (click on the "Select Color" button) to select the color of the POI or insert direclty the color RGB code in the followong format: #RRGGBB',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array (
        'key' => 'wm_taxonomy_icon',
        'label' => 'Icon',
        'name' => 'icon',
        'type' => 'text',
        'instructions' => 'Insert the icon associated to the taxonomy term. Use the WEBMAPP icons: https://icon.webmapp.it',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array (
        'key' => 'wp_taxonomy_show_by_default',
        'label' => 'Show by default',
        'name' => 'show_by_default',
        'type' => 'true_false',
        'instructions' => 'Enable this feature to display items (POIs or TRACKS) on the map by default.',
        'default_value' => 1,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array (
        'key' => 'wp_taxonomy_alert',
        'label' => 'Enable Alert Feature',
        'name' => 'alert',
        'type' => 'true_false',
        'instructions' => 'Check this if you want to enable the alert feature on the POI in this term. This feature works only for MyEasyRoute with the navigation option in the single stage of a route.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array (
        'key' => 'wp_taxonomy_exclude',
        'label' => 'Exclude this category from general MAP',
        'name' => 'exclude',
        'type' => 'true_false',
        'instructions' => 'Check this if you want to exclude the features of this term from the general MAP.',
        'default_value' => 0,
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array (
        'key' => 'wm_taxonomy_title',
        'label' => 'Title',
        'name' => 'title',
        'type' => 'text',
        'instructions' => 'Insert the title used in the WEB term page'
    ),
    array(
        'key' => 'wm_taxonomy_featured_image',
        'label' => 'Featured image',
        'name' => 'featured_image',
        'type' => 'image',
        'instructions' => 'Insert a 16x9 image for WEB site term page',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => 'png, jpg, jpeg',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
    array(
        'key' => 'wm_taxonomy_featured_icon',
        'label' => 'Featured icon',
        'name' => 'featured_icon',
        'type' => 'image',
        'instructions' => 'Insert a featured Icon ( visible in vn menu )',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'return_format' => 'array',
        'preview_size' => 'thumbnail',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => 'png, jpg, jpeg',
        'wpml_cf_preferences' => WEBMAPP_COPY_CUSTOM_FIELD,
    ),
);

$taxonomies_with_this_fields = array(
    "webmapp_category",
    "where",
    "when",
    "who",
    "theme",
    "activity"
);

$location = array();
foreach ( $taxonomies_with_this_fields as $tax_name )
{
    $location[] = array(
        array(
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => $tax_name
        )
    );
}
$args = array (
    'key' => 'wm_taxonomy_main',
    'title' => 'Additional info',
    'fields' => $fields,
    'location' => $location,
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
);


$WebMapp_RegisterRouteFields = new WebMapp_RegisterFieldsGroup($taxonomies_with_this_fields ,$args );