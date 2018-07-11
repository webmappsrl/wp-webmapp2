<?php

// Add Shortcode
function WebMapp_AnyTermShortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'taxonomy' => '',
            'orderby' => 'name',
            'order' => 'ASC'
        ),
        $atts
    ));

    $args = array();

    if( !empty($taxonomy) ){
        $args['taxonomy'] = $taxonomy;
    }
    if( !empty($orderby) ){
        $args['orderby'] = $orderby;
    }
    if( !empty($order) ){
        $args['orderby'] = $order;
    }

    $args['hide_empty'] = true;

    $terms = get_terms($args);

    $output = '<div class="wm-list-terms">';

    $output .= '<ul class="wm-terms">';


    if ( ! empty( $terms ) ){
        foreach ( $terms as $my_term ) {
            $url = get_term_link( $my_term->term_id, $my_term->taxonomy);
            if ( !is_wp_error( $url ) ) {
                $icon = get_field('icon', $my_term->taxonomy . '_' . $my_term->term_id);
                $output .= '<li><span class="' . $icon . '"></span>';
                $output .= '<a href="' . $url . '">' . $my_term->name;
                $output .= ' <i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
                $output .= '</li>';
            }
        }
    }
    $output .= '<!--<li class="wm-view-all"><a href="#">'.__('View all', 'webmapp-child-theme') .'<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>-->';


    $output .= '</ul></div>';


    return $output;
}

$WebMapp_AnyTermShortcode = new WebMapp_RegisterShortcode( 'webmapp_anyterm', 'WebMapp_AnyTermShortcode' );

