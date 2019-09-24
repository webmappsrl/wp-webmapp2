<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 04/07/18
 * Time: 19:46
 */
function wm_embed_map_script() {

	$categories = get_terms( [
		'taxonomy'   => 'webmapp_category',
		'hide_empty' => FALSE,
	] );

	$cat = [];
	foreach ( $categories as $category ) {
		$color                     = get_field( 'color', $category );
		if ( $color == null){ $color = ''; }
		$icon                      = get_field( 'icon', $category );
		if ( $icon == null){ $icon = ''; }
		$cat[ $category->term_id ] = [ 'color' => $color, 'icon' => $icon ];
	}


	$args = [
		'webmapp_jqueryleafletmap' => [
			'src'       => WebMapp_ASSETS . 'js/WebMapp_jQueryLeafletMap.js',
			'deps'      => [ 'jquery' ],
			'in_footer' => FALSE,
			'localize' => array(
				'object_name' => 'webmapp_cat',
				'data' => $cat
			)
		],

	];
	new WebMapp_AssetEnqueuer( $args, 'wp', 'script' );


}

add_action( 'get_header', 'wm_embed_map_script' );

$args = [
	'webmapp_leaflet_map' => [
		'src' => WebMapp_URL . 'assets/css/style_leaflet_map.css',
	],
];


new WebMapp_AssetEnqueuer( $args, 'wp', 'style' );






