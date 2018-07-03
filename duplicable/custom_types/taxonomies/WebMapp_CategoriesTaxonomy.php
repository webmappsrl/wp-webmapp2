<?php


$labels = array(
    'name' => _x('Webmapp categories', 'taxonomy general name', WebMapp_TEXTDOMAIN),
    'singular_name' => _x('Webmapp category', 'taxonomy singular name', WebMapp_TEXTDOMAIN),
    'search_items' => __('Search Webmapp categories', WebMapp_TEXTDOMAIN),
    'all_items' => __('All Webmapp categories', WebMapp_TEXTDOMAIN),
    'parent_item' => __('Parent Webmapp category', WebMapp_TEXTDOMAIN),
    'parent_item_colon' => __('Parent Webmapp category:', WebMapp_TEXTDOMAIN),
    'edit_item' => __('Edit Webmapp category', WebMapp_TEXTDOMAIN),
    'update_item' => __('Update Webmapp category', WebMapp_TEXTDOMAIN),
    'add_new_item' => __('Add New Webmapp category', WebMapp_TEXTDOMAIN),
    'new_item_name' => __('New Webmapp category Name', WebMapp_TEXTDOMAIN),
    'menu_name' => __('Webmapp category', WebMapp_TEXTDOMAIN),
);

$args = array(
    'hierarchical' => TRUE,
    'labels' => $labels,
    'show_ui' => TRUE,
    'show_admin_column' => TRUE,
    'query_var' => TRUE,
    'show_in_rest' => TRUE,
);

new WebMapp_RegisterTaxonomy('webmapp_category', 'poi', $args );