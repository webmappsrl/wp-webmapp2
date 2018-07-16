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
            <div id="content-area" class="<?php extra_sidebar_class(); ?> clearfix">
                <div class="et_pb_extra_column_main">

                    <?php if ( $featured_title ) { ?>
                        <div class="container">
                            <h3 class="webmapp-term-featured-title"><?php echo $featured_title ?></h3>
                        </div>
                    <?php } ?>

                    <?php


                    if ( $term && $term instanceof WP_Term  )
                    {
                        echo do_shortcode("[webmapp_anypost posts_per_page='9' rows='3' term_id='$term->term_id' main_tax='$term->taxonomy']");
                    }

                    ?>
                </div>
                <?php get_sidebar(); ?>

            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php get_footer();
