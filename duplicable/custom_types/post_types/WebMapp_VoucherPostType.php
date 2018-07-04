<?php
/**
 * Todo - registrare le stringhe con wpml

 */

/**
 * Register voucher post type
 * @reference https://developer.wordpress.org/reference/functions/register_post_type/
 */


$labels = array(
    'name'                  => _x( 'Vouchers', 'Post Type General Name', WebMapp_TEXTDOMAIN ),
    'singular_name'         => _x( 'Voucher', 'Post Type Singular Name', WebMapp_TEXTDOMAIN ),
    'menu_name'             => __( 'Vouchers', WebMapp_TEXTDOMAIN ),
    'name_admin_bar'        => __( 'Voucher', WebMapp_TEXTDOMAIN ),
    'archives'              => __( 'Voucher Archives', WebMapp_TEXTDOMAIN ),
    'attributes'            => __( 'Voucher Attributes', WebMapp_TEXTDOMAIN ),
    'parent_item_colon'     => __( 'Parent Item:', WebMapp_TEXTDOMAIN ),
    'all_items'             => __( 'All Vouchers', WebMapp_TEXTDOMAIN ),
    'add_new_item'          => __( 'Add New Voucher', WebMapp_TEXTDOMAIN ),
    'add_new'               => __( 'Add New Voucher', WebMapp_TEXTDOMAIN ),
    'new_item'              => __( 'New Voucher', WebMapp_TEXTDOMAIN ),
    'edit_item'             => __( 'Edit Voucher', WebMapp_TEXTDOMAIN ),
    'update_item'           => __( 'Update Voucher', WebMapp_TEXTDOMAIN ),
    'view_item'             => __( 'View Voucher', WebMapp_TEXTDOMAIN ),
    'view_items'            => __( 'View Vouchers', WebMapp_TEXTDOMAIN ),
    'search_items'          => __( 'Search Voucher', WebMapp_TEXTDOMAIN ),
    'not_found'             => __( 'Not found', WebMapp_TEXTDOMAIN ),
    'not_found_in_trash'    => __( 'Not found in Trash', WebMapp_TEXTDOMAIN ),
    'featured_image'        => __( 'Featured Image', WebMapp_TEXTDOMAIN ),
    'set_featured_image'    => __( 'Set featured image', WebMapp_TEXTDOMAIN ),
    'remove_featured_image' => __( 'Remove featured image', WebMapp_TEXTDOMAIN ),
    'use_featured_image'    => __( 'Use as featured image', WebMapp_TEXTDOMAIN ),
    'insert_into_item'      => __( 'Insert into Voucher', WebMapp_TEXTDOMAIN ),
    'uploaded_to_this_item' => __( 'Uploaded to this Voucher', WebMapp_TEXTDOMAIN ),
    'items_list'            => __( 'Voucher list', WebMapp_TEXTDOMAIN ),
    'items_list_navigation' => __( 'Voucher list navigation', WebMapp_TEXTDOMAIN ),
    'filter_items_list'     => __( 'Filter Voucher list', WebMapp_TEXTDOMAIN ),
);

$args = array(
    'label'                 => __( 'Voucher', WebMapp_TEXTDOMAIN ),
    'description'           => __( 'Voucher used to activate download', WebMapp_TEXTDOMAIN ),
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
    'capabilities'          => array(),//set by class WebMapp_RegisterPostType with custom_capabilities param set on true
    'show_in_rest'          => false,
);

$WebMapp_VoucherPostType = new WebMapp_RegisterPostType('voucher',$args, true );