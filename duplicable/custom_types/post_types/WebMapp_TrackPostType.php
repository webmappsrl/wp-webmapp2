<?php
$labels = array(
    'name' => _x('Tracks', 'post type general name', WebMapp_TEXTDOMAIN),
    'singular_name' => _x('Track', 'post type singular name', WebMapp_TEXTDOMAIN),
    'menu_name' => _x('Tracks', 'admin menu', WebMapp_TEXTDOMAIN),
    'name_admin_bar' => _x('Track', 'add new on admin bar', WebMapp_TEXTDOMAIN),
    'add_new' => _x('Add New', 'track', WebMapp_TEXTDOMAIN),
    'add_new_item' => __('Add New Track', WebMapp_TEXTDOMAIN),
    'new_item' => __('New Track', WebMapp_TEXTDOMAIN),
    'edit_item' => __('Edit Track', WebMapp_TEXTDOMAIN),
    'view_item' => __('View Track', WebMapp_TEXTDOMAIN),
    'all_items' => __('All Tracks', WebMapp_TEXTDOMAIN),
    'search_items' => __('Search Tracks', WebMapp_TEXTDOMAIN),
    'parent_item_colon' => __('Parent Tracks:', WebMapp_TEXTDOMAIN),
    'not_found' => __('No Tracks found.', WebMapp_TEXTDOMAIN),
    'not_found_in_trash' => __('No Tracks found in Trash.', WebMapp_TEXTDOMAIN)
);

$args = array(
    'labels' => $labels,
    'description' => __('Track in maps', WebMapp_TEXTDOMAIN),
    'public' => TRUE,
    'publicly_queryable' => TRUE,
    'show_ui' => TRUE,
    'show_in_menu' => TRUE,
    'query_var' => TRUE,
    'rewrite' => array('slug' => 'track'),
    'capability_type' => 'post',
    'has_archive' => TRUE,
    'hierarchical' => FALSE,
    'menu_position' => 32,
    'show_in_rest' => TRUE,
    'menu_icon' => 'dashicons-location-alt',
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

$WebMapp_TrackPostType = new WebMapp_RegisterPostType('track',$args);