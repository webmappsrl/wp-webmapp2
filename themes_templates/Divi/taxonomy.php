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
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">

                    <?php if ( $featured_title ) { ?>
                        <div class="webmapp-term-wrapper">
                            <h3 class="webmapp-term-featured-title webmapp_customizer_general_color1-color webmapp_customizer_general_font1-font-family webmapp_customizer_general_size7-font-size"><?php echo $featured_title ?></h3>
                            <?php if ( $term_description ) { ?>
                                <p class="webmapp-term-featured-description webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_general_size8-font-size"><?php echo $term_description ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>



                    <?php


                    if ( $term && $term instanceof WP_Term  )
                    {
                        $attr_post_type = 'any';
                        $project_has_route = WebMapp_Utils::project_has_route();
                        if ( $project_has_route && $term->taxonomy != 'webmapp_category' )
                            $attr_post_type = 'route';


                        echo do_shortcode("[webmapp_anypost posts_per_page='9' rows='3' post_type='$attr_post_type' term_id='$term->term_id']");
                    }

                    ?>
                </div>
                <?php //get_sidebar(); ?>

            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php get_footer();
