<?php
$labels = array(
    'name' => _x('Routes', 'post type general name', WebMapp_TEXTDOMAIN),
    'singular_name' => _x('Route', 'post type singular name', WebMapp_TEXTDOMAIN),
    'menu_name' => _x('Routes', 'admin menu', WebMapp_TEXTDOMAIN),
    'name_admin_bar' => _x('Route', 'add new on admin bar', WebMapp_TEXTDOMAIN),
    'add_new' => _x('Add New', 'route', WebMapp_TEXTDOMAIN),
    'add_new_item' => __('Add New Route', WebMapp_TEXTDOMAIN),
    'new_item' => __('New Route', WebMapp_TEXTDOMAIN),
    'edit_item' => __('Edit Route', WebMapp_TEXTDOMAIN),
    'view_item' => __('View Route', WebMapp_TEXTDOMAIN),
    'all_items' => __('All Routes', WebMapp_TEXTDOMAIN),
    'search_items' => __('Search Routes', WebMapp_TEXTDOMAIN),
    'parent_item_colon' => __('Parent Routes:', WebMapp_TEXTDOMAIN),
    'not_found' => __('No Routes found.', WebMapp_TEXTDOMAIN),
    'not_found_in_trash' => __('No Routes found in Trash.', WebMapp_TEXTDOMAIN)
);

$args = array(
    'labels' => $labels,
    'description' => __('Routes', WebMapp_TEXTDOMAIN),
    'public' => TRUE,
    'publicly_queryable' => TRUE,
    'show_ui' => TRUE,
    'show_in_menu' => TRUE,
    'query_var' => TRUE,
    'rewrite' => array('slug' => 'route'),
    'capability_type' => 'post',
    'has_archive' => TRUE,
    'hierarchical' => FALSE,
    'menu_position' => 31,
    'show_in_rest' => TRUE,
    'menu_icon' => 'dashicons-share',
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

$WebMapp_PoiPostType = new WebMapp_RegisterPostType('route',$args);