<?php get_header();

$term = get_queried_object();

?>

    <div id="main-content">
        <?php
        if ( $term && $term instanceof WP_Term  )
        {
            $featured_image = get_field( 'wm_taxonomy_featured_image' , $term );
            $featured_title = get_field( 'wm_taxonomy_title' , $term );
            $term_icon = get_field( 'wm_taxonomy_icon',$term );
            $term_description = term_description( $term );

            if ( isset( $featured_image['url'] ) )
            {
                /**
                 *
                 * style="background-image: url('<?php echo $featured_image['url']; ?>')"
                 */

                ?>
                <div class="webmapp-term-featured-image">
                    <div class="webmapp-term-featured-image-img">
                        <img src="<?php echo $featured_image['url']; ?>">
                        <div class="container">
                            <h2 class='webmapp-term-name'>
                                <i class='<?php echo $term_icon?>'></i>
                                <span><?php echo $term->name ?></span>
                            </h2>
                        </div>
                    </div>

                </div>
                <?php
            }

        }
        ?>
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">

                    <?php if ( $featured_title ) { ?>
                        <div class="container">
                            <h3 class="webmapp-term-featured-title"><?php echo $featured_title ?></h3>
                            <?php if ( $term_description ) { ?>
                                <p class="webmapp-term-featured-description"><?php echo $term_description ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>



                    <?php


                    if ( $term && $term instanceof WP_Term  )
                    {
                        $attr_post_type = 'any';
                        $project_has_route = WebMapp_Utils::project_has_route();
                        if ( $project_has_route )
                            $attr_post_type = 'route';


                        echo do_shortcode("[webmapp_anypost posts_per_page='9' rows='3' post_type='$attr_post_type' term_id='$term->term_id']");
                    }

                    ?>
                </div>
                <?php get_sidebar(); ?>

            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php get_footer();
