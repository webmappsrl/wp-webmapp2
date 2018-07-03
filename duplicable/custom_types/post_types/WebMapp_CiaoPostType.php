<?php
/**
 * Todo - registrare le stringhe con wpml
 */
$labels = array(
    'name' => _x('Ciao', 'post type general name', WebMapp_TEXTDOMAIN),
    'singular_name' => _x('Ciao', 'post type singular name', WebMapp_TEXTDOMAIN),
    'menu_name' => _x('Ciao', 'admin menu', WebMapp_TEXTDOMAIN),
    'name_admin_bar' => _x('Ciao', 'add new on admin bar', WebMapp_TEXTDOMAIN),
    'add_new' => _x('Ciao', 'poi', WebMapp_TEXTDOMAIN),
    'add_new_item' => __('Ciao', WebMapp_TEXTDOMAIN),
    'new_item' => __('Ciao', WebMapp_TEXTDOMAIN),
    'edit_item' => __('Edit Map', WebMapp_TEXTDOMAIN),
    'view_item' => __('View Map', WebMapp_TEXTDOMAIN),
    'all_items' => __('All Maps', WebMapp_TEXTDOMAIN),
    'search_items' => __('Search Map', WebMapp_TEXTDOMAIN),
    'parent_item_colon' => __('Parent Map:', WebMapp_TEXTDOMAIN),
    'not_found' => __('No Map found.', WebMapp_TEXTDOMAIN),
    'not_found_in_trash' => __('No Map found in Trash.', WebMapp_TEXTDOMAIN)
);

$args = array(
    'labels' => $labels,
    'description' => __('Ciao', WebMapp_TEXTDOMAIN),
    'public' => TRUE,
    'publicly_queryable' => TRUE,
    'show_ui' => TRUE,
    'show_in_menu' => TRUE,
    'show_in_rest' => TRUE,
    'query_var' => TRUE,
    'rewrite' => array('slug' => 'ciao'),
    'capability_type' => 'post',
    'has_archive' => TRUE,
    'hierarchical' => FALSE,
    'menu_icon' => 'dashicons-format-image',
    'menu_position' => 30,
    'supports' => array(
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'revisions'
    )
);

$WebMapp_TrackPostType = new WebMapp_RegisterPostType('ciap',$args);