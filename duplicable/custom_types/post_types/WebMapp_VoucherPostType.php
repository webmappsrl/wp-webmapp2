<?php
/**
 * Todo - registrare le stringhe con wpml
 */

$labels = array(
    'name'                  => _x( 'Vouchers', 'Post Type General Name', 'webmap_net7' ),
    'singular_name'         => _x( 'Voucher', 'Post Type Singular Name', 'webmap_net7' ),
    'menu_name'             => __( 'Vouchers', 'webmap_net7' ),
    'name_admin_bar'        => __( 'Voucher', 'webmap_net7' ),
    'archives'              => __( 'Voucher Archives', 'webmap_net7' ),
    'attributes'            => __( 'Voucher Attributes', 'webmap_net7' ),
    'parent_item_colon'     => __( 'Parent Item:', 'webmap_net7' ),
    'all_items'             => __( 'All Vouchers', 'webmap_net7' ),
    'add_new_item'          => __( 'Add New Voucher', 'webmap_net7' ),
    'add_new'               => __( 'Add New Voucher', 'webmap_net7' ),
    'new_item'              => __( 'New Voucher', 'webmap_net7' ),
    'edit_item'             => __( 'Edit Voucher', 'webmap_net7' ),
    'update_item'           => __( 'Update Voucher', 'webmap_net7' ),
    'view_item'             => __( 'View Voucher', 'webmap_net7' ),
    'view_items'            => __( 'View Vouchers', 'webmap_net7' ),
    'search_items'          => __( 'Search Voucher', 'webmap_net7' ),
    'not_found'             => __( 'Not found', 'webmap_net7' ),
    'not_found_in_trash'    => __( 'Not found in Trash', 'webmap_net7' ),
    'featured_image'        => __( 'Featured Image', 'webmap_net7' ),
    'set_featured_image'    => __( 'Set featured image', 'webmap_net7' ),
    'remove_featured_image' => __( 'Remove featured image', 'webmap_net7' ),
    'use_featured_image'    => __( 'Use as featured image', 'webmap_net7' ),
    'insert_into_item'      => __( 'Insert into Voucher', 'webmap_net7' ),
    'uploaded_to_this_item' => __( 'Uploaded to this Voucher', 'webmap_net7' ),
    'items_list'            => __( 'Voucher list', 'webmap_net7' ),
    'items_list_navigation' => __( 'Voucher list navigation', 'webmap_net7' ),
    'filter_items_list'     => __( 'Filter Voucher list', 'webmap_net7' ),
);

$args = array(
    'label'                 => __( 'Voucher', 'webmap_net7' ),
    'description'           => __( 'Voucher used to activate download', 'webmap_net7' ),
    'labels'                => $labels,
    'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields' ),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-images-alt2',
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => true,
    'publicly_queryable'    => true,
    'map_meta_cap'          => true,
    'capability_type'       => 'voucher',
    'capabilities'          => array(),//set by class WebMapp_RegisterPostType
    'show_in_rest'          => false,
);

$WebMapp_VoucherPostType = new WebMapp_RegisterPostType('voucher',$args, true );