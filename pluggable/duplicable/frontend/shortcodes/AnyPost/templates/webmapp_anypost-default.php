
<?php

global $wm_anypost_bootstrap_col_type,
       $wm_anypost_global_taxonomies,
       $wm_anypost_template,
       $wm_anypost_post_type;

$title_link = get_the_permalink();
$get_the_post_thumbanil = get_the_post_thumbnail_url( get_the_ID() ,'full');
$current_post_type = get_post_type();

$main_tax_c = WebMapp_Utils::get_main_tax(get_the_ID() );

if ( $main_tax && taxonomy_exists( $main_tax ) )
    $main_tax_c = $main_tax;


?>

<div class="col-sm-12 col-md-<?php echo $wm_anypost_bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $wm_anypost_post_type?>">

    <?php

    $activity_level = 1;

    $taxs_htmls = array();

    if ( $current_post_type == 'route' )
    {
        $wm_anypost_global_taxonomies[] = 'activity';
    }

    //prepare main tax overlay
    foreach( $wm_anypost_global_taxonomies as $tax_name ) :

        $taxs_htmls[$tax_name] = '';

        if ( $current_post_type == 'route' && $tax_name == 'activity' )
        {
            $terms = WebMapp_ActivityRoute::get_route_activities(get_the_ID());
        }
        else
        {
            $terms = get_the_terms( get_the_ID() , $tax_name );
        }


        /**
         * Manage multiple terms in image overlay
         */
        $multiple = false;
        if ( $tax_name == $main_tax_c )
        {
            if ( count($terms ) > 1 )
                $multiple = true;
        }



        if ( $terms && is_array( $terms ) )
        {

            foreach ( $terms as $term )
            {
                $term_link = get_term_link( $term->term_id );

                if ( $main_tax_c == $tax_name )
                {
                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                    if ( $term_icon )
                    {
                        $i_class = $multiple ? 'webmapp_icon_multiple' : 'webmapp_icon_single';
                        $taxs_htmls[$tax_name] .= "<span class='webmapp_single_$tax_name webmapp_single_{$tax_name}_{$activity_level} webmapp_single_term'><a class='webmapp_single_{$tax_name}_link' href='$term_link' title='$term->name'><i class='$term_icon $i_class webmapp_customizer_general_color1-background-color'></i>";
                        if ( ! $multiple )
                            $taxs_htmls[$tax_name] .= "<span class='webmapp_single_{$tax_name}_name webmapp_customizer_general_font2-font-family webmapp_customizer_general_size2-font-size webmapp_customizer_general_color1-background-color-brightness'>$term->name</span>";

                        $taxs_htmls[$tax_name] .= "</a></span>";
                        $activity_level++;
                    }

                }
                else
                {
                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                    $icon = '';
                    if ( $term_icon )
                        $icon = "<i class='$term_icon webmapp_customizer_general_color1-color'></i>";

                    $taxs_htmls[$tax_name] .= "<span class='webmapp_single_$tax_name webmapp_single_term'><a class='webmapp_single_{$tax_name}_link webmapp_customizer_general_color3-color webmapp_customizer_general_font2-font-family webmapp_customizer_general_size5-font-size' href='$term_link' title='$term->name'><span>$term->name</span>$icon</a></span>";
                }


            }//endforeach

        }//endif

    endforeach;


    /**
     * PREPARE TAXONOMIES
     */
    $main_tax_class = $multiple ? 'webmapp_main_tax_multiple' : 'webmapp_main_tax_single';
    $main_tax_html = isset( $taxs_htmls[$main_tax_c] ) ? $taxs_htmls[$main_tax_c] : '' ;


    ?>

    <div class="webmapp_post-featured-img">
        <?php
        echo "<a href='$title_link' title=\"".get_the_title()."\">";
        ?>
        <figure class="webmapp_post_image" style="background-image: url('<?php echo $get_the_post_thumbanil; ?>')">
        </figure>
        <?php
        echo "</a>";

        if ( ! empty( $get_the_post_thumbanil ) )
            echo "<div class='webmapp_main_tax $main_tax_class'>" . $main_tax_html . "</div>";

       ?>

    </div>

    <div class="webmapp_post-title">
        <h2>
            <?php echo "<a href='$title_link' title=\"".get_the_title()."\" class='webmapp_customizer_general_color1-color webmapp_customizer_general_font1-font-family webmapp_customizer_general_size2-font-size'>" . get_the_title() . "</a>"; ?>
        </h2>

    </div>



    <div class="webmapp_post_terms">
        <?php
        if ( isset( $taxs_htmls['where'] ) )
            echo $taxs_htmls['where'];
        foreach ( $taxs_htmls as $key => $tax_html )
        {
            if ( $key != $main_tax_c && 'where' != $key )
                echo $tax_html;
        }
        ?>
    </div>



</div>
