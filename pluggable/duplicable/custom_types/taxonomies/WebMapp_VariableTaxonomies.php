<?php

// REGISTRO LE 5 TASSONOMIE (where,when,theme,activity,who)

//todo translate labels!
$track_taxonomies = array( 'activity' => array( 'Activity' , 'Activities' ) );
$route_or_track_taxonomies = array(
    'theme' => array( 'Theme' , 'Themes' ),
    'where' => array( 'Places to go' , 'Places to go' ),
    'when' => array( 'Season' , 'Seasons' ),
    'who' => array( 'Target' , 'Targets' )
);

//todo - test
$merge = $track_taxonomies + $route_or_track_taxonomies;

/**
 * @reference https://developer.wordpress.org/reference/functions/register_taxonomy/
 */

$taxonomies_to_register = array();
foreach ( $merge as $tax_name => $labels ) :
    $label_singular = $labels[0];
    $label_plural = $labels[1];

    $labels = array(
        'name'                       => _x( $label_plural, 'Taxonomy General Name', WebMapp_TEXTDOMAIN ),
        'singular_name'              => _x( $label_singular, 'Taxonomy Singular Name', WebMapp_TEXTDOMAIN ),
        'menu_name'                  => __( $label_plural, WebMapp_TEXTDOMAIN ),
        'all_items'                  => __( 'All Items', WebMapp_TEXTDOMAIN ),
        'parent_item'                => __( 'Parent Item', WebMapp_TEXTDOMAIN ),
        'parent_item_colon'          => __( 'Parent Item:', WebMapp_TEXTDOMAIN ),
        'new_item_name'              => __( 'New Item Name', WebMapp_TEXTDOMAIN ),
        'add_new_item'               => __( 'Add New Item', WebMapp_TEXTDOMAIN ),
        'edit_item'                  => __( 'Edit Item', WebMapp_TEXTDOMAIN ),
        'update_item'                => __( 'Update Item', WebMapp_TEXTDOMAIN ),
        'view_item'                  => __( 'View Item', WebMapp_TEXTDOMAIN ),
        'separate_items_with_commas' => __( 'Separate items with commas', WebMapp_TEXTDOMAIN ),
        'add_or_remove_items'        => __( 'Add or remove items', WebMapp_TEXTDOMAIN ),
        'choose_from_most_used'      => __( 'Choose from the most used', WebMapp_TEXTDOMAIN ),
        'popular_items'              => __( 'Popular Items', WebMapp_TEXTDOMAIN ),
        'search_items'               => __( 'Search Items', WebMapp_TEXTDOMAIN ),
        'not_found'                  => __( 'Not Found', WebMapp_TEXTDOMAIN ),
        'no_terms'                   => __( 'No items', WebMapp_TEXTDOMAIN ),
        'items_list'                 => __( 'Items list', WebMapp_TEXTDOMAIN ),
        'items_list_navigation'      => __( 'Items list navigation', WebMapp_TEXTDOMAIN ),
    );
    $rewrite = array(
        'slug'                       => $tax_name,
        'with_front'                 => true,
        'hierarchical'               => false,
    );
    $taxonomies_to_register[$tax_name] = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => $rewrite,
        'show_in_rest'               => true,
    );

endforeach;

$current_args = isset( $taxonomies_to_register['activity'] ) ? $taxonomies_to_register['activity'] : array();
if ( ! empty( $current_args ) )
    new WebMapp_RegisterTaxonomy( 'activity' ,array('route','track'), $current_args );



/**
 * Register taxonomies to track or to route if option ( WebMapp setting page ) is set to true
 */
foreach ( $route_or_track_taxonomies as $tax_name => $labels ) :
    $current_args = isset( $taxonomies_to_register[$tax_name] ) ? $taxonomies_to_register[$tax_name] : array();
    if ( ! empty( $current_args ) )
        new WebMapp_RegisterTaxonomy( $tax_name ,array('route','track'), $current_args );
endforeach;


