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


    if( empty($taxonomy) || ! taxonomy_exists( $taxonomy ) ) {
        $output = "<h2 class=\"webmapp-any-terms-title error\">" . __('Invalid taxonomy') . ": $taxonomy</h2>";
        return $output;//EXIT
    }

    $args['taxonomy'] = $taxonomy;

    if( !empty($orderby) ) {
        $args['orderby'] = $orderby;
    }
    if( !empty($order) ) {
        $args['orderby'] = $order;
    }

    $args['hide_empty'] = true;

    /**
     * todo
     */

    $defaults = array(
        'hide_empty'          => 1,
        'hierarchical'        => true,
        'order'               => 'ASC',
        'orderby'             => 'name',
        'parent' => 0,
    );



    $args = wp_parse_args( $args , $defaults );

    $terms = get_terms($args);




    $output = '<div class="webmapp-list-terms">';

    if ( ! empty($title) )
    {
        $output .= '<h2 class="webmapp-any-terms-title webmapp_customizer_general_color2-color webmapp_customizer_general_font1-font-family webmapp_customizer_anyterm_size1-font-size">' . $title . '</h2>';
    }
    if ( ! empty( $subtitle ) )
    {
        $output .= '<p class="webmapp-any-terms-subtitle webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_general_size3-font-size">' . $subtitle . '</p>';
    }


    $output .= '<ul class="webmapp-terms">';




    $i = 0; //terms counter


    $parent_terms_output = '';
    $parent_terms_class = 'parent';
    $only_parent_terms_class = 'no-children parent';


    $children_terms_output = '';
    $children_terms_class = 'child';


    $term_style = "webmapp_customizer_general_color1-color webmapp_customizer_general_font2-font-family webmapp_customizer_general_size5-font-size";



    //parent terms
    if ( ! empty( $terms ) )
    {
        foreach ( $terms as $my_term )
        {
            //count checker
            if ( $terms_count )
            {
                if ( $i == $terms_count )
                    break;
                else
                    $i++;
            }

            //set icon
            $icon = get_field('icon',$my_term );
            $icon_html = $icon ? "<i class='webmapp-term-icon $icon'></i> " : '';

            //get url
            $url = get_term_link( $my_term->term_id, $my_term->taxonomy );

            //get child terms
            $args['parent'] = $my_term->term_id;
            $children_terms = get_terms( $args );



            if ( empty( $children_terms ) )
            {
                $parent_terms_output .= '<li class="webmapp-anyterm-term-' . $only_parent_terms_class .'">';
                $parent_terms_output .= '<a href="' . $url . '" class="' . $term_style . '">' . $icon_html . $my_term->name;
                $parent_terms_output .= '<i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
                $parent_terms_output .= '</li>';
            }
            else
            {
                $children_terms_output .= "<li class='webmapp-anyterm-term-$parent_terms_class'>";
                $children_terms_output .= "<p class='{$term_style}'>{$icon_html}{$my_term->name} <i class='wm-icon-arrow-right-b'></i></p>";
                $children_terms_output .= "<ul class='webmapp-anyterm-term-children-list' style='display:none;'>";

                foreach ( $children_terms as $child )
                {
                    //set icon
                    $icon = get_field('icon',$child );
                    $icon_html = $icon ? "<i class='webmapp-term-icon $icon'></i> " : '';

                    //get url
                    $url = get_term_link( $child->term_id, $child->taxonomy );

                    $children_terms_output .= "<li class='webmapp-anyterm-term-$children_terms_class'>";
                    $children_terms_output .= "<a href='$url' class='$term_style'>{$icon_html}{$child->name}";
                    $children_terms_output .= '<i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
                    $children_terms_output .= "</li>";

                }

                $children_terms_output .= "</ul>";
                $children_terms_output .= '</li>';
            }

        }



        $children_terms_output .= "<li class='webmapp-anyterm-term-$parent_terms_class'><p class='{$term_style}'>Altri <i class='wm-icon-arrow-right-b'></i></p><ul class='webmapp-anyterm-term-children-list' style='display:none;'>$parent_terms_output</ul></li>";




    }
    //$output .= '<!--<li class="wm-view-all"><a href="#">'.__('View all', 'webmapp-child-theme') .'<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>-->';


    $output .= $children_terms_output;



    if ( $terms_count )
    {
        $terms_link = WebMapp_Utils::get_tax_archive_link( $taxonomy );
        $output .= "<p><a href='$terms_link'>" . __('See all' , WebMapp_TEXTDOMAIN ) ."<i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></p>";

    }

    $output .= '</ul></div>';





    return $output;
}

$WebMapp_AnyTermShortcode = new WebMapp_RegisterShortcode( 'webmapp_anyterm', 'WebMapp_AnyTermShortcode' );


