<?php

// Add Shortcode

function WebMapp_AnyTermShortcode($atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'taxonomy' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'title' => '',
            'subtitle' => '',
            'terms_count' => ''
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

    /**
     * todo
     */
    $terms = get_terms($args);


    $output = '<div class="webmapp-list-terms">';

    if ( ! empty($title) )
    {
        $output .= '<h2 class="webmapp-any-terms-title webmapp_customizer_general_color2-color webmapp_customizer_general_font1-font-damily webmapp_customizer_general_size1-font-size">' . $title . '</h2>';
    }
    if ( ! empty( $subtitle ) )
    {
        $output .= '<p class="webmapp-any-terms-subtitle webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_general_size3-font-size">' . $subtitle . '</p>';
    }


    $output .= '<ul class="webmapp-terms">';

    $i = 0; //terms counter


    if ( ! empty( $terms ) )
    {
        foreach ( $terms as $my_term )
        {
            if ( $terms_count )
            {
                if ( $i == $terms_count )
                    break;
                else
                    $i++;
            }


            $url = get_term_link( $my_term->term_id, $my_term->taxonomy );
            if ( !is_wp_error( $url ) )
            {
                $icon = get_field('icon',$my_term );
                $icon_html = $icon ? "<i class='webmapp-term-icon $icon'></i> " : '';
                $output .= '<li>';
                $output .= '<a href="' . $url . '" class="webmapp_customizer_general_color1-color webmapp_customizer_general_font2-font-family webmapp_customizer_general_size5-font-size">' . $icon_html . $my_term->name;
                $output .= '<i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
                $output .= '</li>';
            }
        }
    }
    $output .= '<!--<li class="wm-view-all"><a href="#">'.__('View all', 'webmapp-child-theme') .'<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>-->';

    if ( $terms_count )
    {
        $terms_link = WebMapp_Utils::get_tax_archive_link( $taxonomy );
        $output .= "<li><a href='$terms_link'>" . __('See all' , WebMapp_TEXTDOMAIN ) ."<i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></li>";

    }

    $output .= '</ul></div>';




    return $output;
}

$WebMapp_AnyTermShortcode = new WebMapp_RegisterShortcode( 'webmapp_anyterm', 'WebMapp_AnyTermShortcode' );


