<?php
add_action( 'wp_enqueue_scripts', 'Divi_parent_theme_enqueue_styles' );

function Divi_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'divi-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'webmapp-theme-style', get_stylesheet_directory_uri() . '/style.css', [ 'divi-style' ], '.1' );
	wp_enqueue_style( 'webmapp-theme-style-mb', get_stylesheet_directory_uri() . '/style-mb.css', [ 'divi-style' ], '.1' );

	//wp_enqueue_script( 'webmapp-theme_functions', get_stylesheet_directory_uri() . '/js/functions.js', [ 'jquery' ], '.1', TRUE );
	//wp_localize_script( 'webmapp-theme_functions', 'ajax_object', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );
}

function WM_Custom_Modules() {
	if ( class_exists( "ET_Builder_Module" ) ) {
		//include( "include/webmapp-custom-modules.php" );
	}
}

function Prep_WM_Custom_Modules() {
	global $pagenow;

	$is_admin                     = is_admin();
	$action_hook                  = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages         = [
		'edit.php',
		'post.php',
		'post-new.php',
		'admin.php',
		'customize.php',
		'edit-tags.php',
		'admin-ajax.php',
		'export.php',
	]; // list of admin pages where we need to load builder files
	$specific_filter_pages        = [
		'edit.php',
		'admin.php',
		'edit-tags.php',
	];
	$is_edit_library_page         = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page          = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page               = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action( $action_hook, 'WM_Custom_Modules', 9789 );
	}
}

Prep_WM_Custom_Modules();


function et_divi_get_top_nav_items() {
	$items = new stdClass;

	$items->phone_number = et_get_option( 'phone_number' );

	$items->email = et_get_option( 'header_email' );

	$items->contact_info_defined = $items->phone_number || $items->email;

	$items->show_header_social_icons = et_get_option( 'show_header_social_icons', FALSE );

	$items->secondary_nav = wp_nav_menu( [
		'theme_location' => 'secondary-menu',
		'container'      => '',
		'fallback_cb'    => '',
		'menu_id'        => 'et-secondary-nav',
		'echo'           => FALSE,
		'after'          => '<i class="fa fa-circle" aria-hidden="true"></i>',
	] );

	$items->top_info_defined = $items->contact_info_defined || $items->show_header_social_icons || $items->secondary_nav;

	$items->two_info_panels = $items->contact_info_defined && ( $items->show_header_social_icons || $items->secondary_nav );

	return $items;
}


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'portfolio-size', 800, 400, TRUE );
	add_image_size( 'photogallery', 350, 240, TRUE );
}


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'portfolio-size', 800, 400, TRUE );
	add_image_size( 'photogallery', 350, 240, TRUE );
}

function containsTerm( $myArray, $word ) {
	foreach ( $myArray as $element ) {
		if ( $element->slug == $word ) {
			return TRUE;
		}
	}

	return FALSE;
}

add_action( 'pre_get_posts', 'only_current' );
function only_current( $query ) {

	if ( is_admin() ) {
		return;
	}

	if ( ! $query->is_main_query() ) {
		return;
	}

	if ( ! is_post_type_archive( 'webmapp_category' ) ) {
		return;
	}
}