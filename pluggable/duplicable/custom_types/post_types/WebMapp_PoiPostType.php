<?php
$labels = array(
    'name' => _x('POI', 'post type general name', WebMapp_TEXTDOMAIN),
    'singular_name' => _x('POI', 'post type singular name', WebMapp_TEXTDOMAIN),
    'menu_name' => _x('POI', 'admin menu', WebMapp_TEXTDOMAIN),
    'name_admin_bar' => _x('POI', 'add new on admin bar', WebMapp_TEXTDOMAIN),
    'add_new' => _x('Add New', 'poi', WebMapp_TEXTDOMAIN),
    'add_new_item' => __('Add New POI', WebMapp_TEXTDOMAIN),
    'new_item' => __('New POI', WebMapp_TEXTDOMAIN),
    'edit_item' => __('Edit POI', WebMapp_TEXTDOMAIN),
    'view_item' => __('View POI', WebMapp_TEXTDOMAIN),
    'all_items' => __('All POI', WebMapp_TEXTDOMAIN),
    'search_items' => __('Search POI', WebMapp_TEXTDOMAIN),
    'parent_item_colon' => __('Parent POI:', WebMapp_TEXTDOMAIN),
    'not_found' => __('No POI found.', WebMapp_TEXTDOMAIN),
    'not_found_in_trash' => __('No POI found in Trash.', WebMapp_TEXTDOMAIN)
);

$args = array(
    'labels' => $labels,
    'description' => __('Points of interests.', WebMapp_TEXTDOMAIN),
    'public' => TRUE,
    'publicly_queryable' => TRUE,
    'show_ui' => TRUE,
    'show_in_menu' => TRUE,
    'show_in_rest' => TRUE,
    'query_var' => TRUE,
    'rewrite' => array('slug' => 'poi'),
    'capability_type' => 'post',
    'has_archive' => TRUE,
    'hierarchical' => FALSE,
    'menu_icon' => 'dashicons-location',
    'menu_position' => 33,
    'supports' => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'revisions',
        'comments'
    )
);

$WebMapp_PoiPostType = new WebMapp_RegisterPostType('poi',$args );