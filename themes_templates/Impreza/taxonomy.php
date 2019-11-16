<?php get_header();

$term = get_queried_object();

?>

    <div id="main-content">
        <?php
        if ( $term && $term instanceof WP_Term  )
        {
            $featured_image = get_field( 'wm_taxonomy_featured_image' , $term );
            $featured_title = get_field( 'wm_taxonomy_title' , $term );
            $term_description = term_description( $term );

            if ( $featured_image['url'] )
                WebMapp_Utils::get_featured_image_header( $featured_image['url'], $term->taxonomy, $term->term_id );

        }
        ?>

            <!-- LAYER 1 -->
            <div id='webmapp-layer-1' class="webmapp-featured-image">
                <div class="webmapp-featured-image-img" style="background-image: url('<?php echo $featured_image; ?>')">
                    <div class="container">
                            <h2 class='webmapp-main-tax-name'>
                                    <span class="webmapp-main-tax-span-wrapper webmapp_customizer_general_color1-background-color-brightness webmapp_customizer_general_font2-font-size webmapp_customizer_general_size6-font-size">
                                    <span><?php echo $featured_title ?></span>
                                </span>
                            </h2>
                            <p class="webmapp-term-featured-description webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_general_size8-font-size"><?php echo $term_description ?></p>

                    </div>
                </div>
            </div>
            <!-- END LAYER 1 -->

    <div class="container">
        <div id="content-area" class="clearfix">



                    <?php


                    if ( $term && $term instanceof WP_Term  )
                    {
                        $attr_post_type = 'any';
                        $project_has_route = WebMapp_Utils::project_has_route();
                        if ( $project_has_route && $term->taxonomy != 'webmapp_category' )
                            $attr_post_type = 'route';


                        echo do_shortcode("[webmapp_anypost posts_per_page='9' rows='3' post_type='$attr_post_type' term_id='$term->term_id']");
                        //echo do_shortcode("[webmapp_anypost posts_per_page='3' rows='1' posts_count='3' post_type='$attr_post_type' term_id='$term->term_id' main_tax='$term->taxonomy']");
                    }

                    ?>
                <?php //get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->

    </div> <!-- #main-content -->

<?php get_footer();
