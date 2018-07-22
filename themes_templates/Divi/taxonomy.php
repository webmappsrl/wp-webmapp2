<?php get_header();

global $wp_query;

$tax = isset( $wp_query->query['taxonomy'] ) ? $wp_query->query['taxonomy'] : '';


?>

    <div id="main-content">

        <?php
        if ( $tax )
        {
            $option_image = get_option( $tax . '_featured_img' );
            $featured_title = get_option( $tax . '_featured_title' );
            $featured_image = $option_image ? wp_get_attachment_image_src( $option_image , 'full') : '';
            $featured_image = isset( $featured_image[0] ) ? $featured_image[0] : '';

            if ( ! empty( $featured_image ) )
            {
                ?>
                <div class="webmapp-term-featured-image">
                    <div class="webmapp-term-featured-image-img">
                        <img src="<?php echo $featured_image ?>">
                        <?php if ( $featured_title ) : ?>
                            <div class="container">
                                <h2 class='webmapp-term-name'>
                                    <span><?php echo $featured_title ?></span>
                                </h2>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
            }

        }

        ?>



        <div class="container">

            <div id="content-area" class="<?php extra_sidebar_class(); ?> clearfix">
                <div id="left-area">

                    <?php



                    if ( $tax )
                    {
                        $terms = get_terms( array(
                                'hide_empty' => true,
                                'taxonomy' => $tax
                            )
                        );
                        if ( $terms && ! is_wp_error( $terms ) )
                        {
                            $tax_details = get_taxonomy( $tax );
                            if ( $tax_details )
                                echo "<h2>$tax_details->label</h2>";

                            foreach ( $terms as $term )
                            {
                                $icon = get_field('wm_taxonomy_icon' , $term);
                                echo "<h3><i class='$icon'></i>$term->name</h3>";
                                echo do_shortcode("[webmapp_anypost posts_per_page='3' rows='1' posts_count='3' term_id='$term->term_id' main_tax='$term->taxonomy']");
                            }

                        }


                    }

                    ?>

                </div>
                <?php get_sidebar(); ?>

            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php get_footer();
