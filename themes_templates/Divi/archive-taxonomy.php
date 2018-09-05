<?php get_header();


global $wp_query;

$tax = isset( $wp_query->query['taxonomy'] ) ? $wp_query->query['taxonomy'] : '';

?>

<div id="main-content">


        <?php
        if ( $tax )
        {
            $option_image = get_option( $tax . '_featured_img' );
            $featured_title = WebMapp_Utils::get_option( $tax . '_featured_title' );
            $featured_image = $option_image ? wp_get_attachment_image_src( $option_image , 'full')[0] : '';


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
                    </div>
                </div>
            </div>
            <!-- END LAYER 1 -->






            <?php

        }

        ?>

    <div class="container">
		<div id="content-area" class="clearfix">

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
                    $attr_post_type = 'any';

                    $project_has_route = WebMapp_Utils::project_has_route();
                    if ( $project_has_route && $tax == 'activity' )
                        $attr_post_type = 'route';


                    echo do_shortcode("[webmapp_anypost posts_per_page='3' rows='1' posts_count='3' post_type='$attr_post_type' term_id='$term->term_id' main_tax='$term->taxonomy']");
                }

            }


        }


            if ( function_exists( 'wp_pagenavi' ) )
                wp_pagenavi();
            else
                get_template_part( 'includes/navigation', 'index' );

			?>


			<?php //get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
