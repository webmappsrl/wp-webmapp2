<?php get_header();


global $wp_query;

$tax = isset( $wp_query->query['taxonomy'] ) ? $wp_query->query['taxonomy'] : '';

?>

<div id="main-content">
	<div class="container">

        <?php
        if ( $tax )
        {
            $option_image = get_option( $tax . '_featured_img' );
            $featured_title = WebMapp_Utils::get_option( $tax . '_featured_title' );
            $featured_image = $option_image ? wp_get_attachment_image_src( $option_image , 'full')[0] : '';


            if ( ! empty( $featured_image ) )
            {
                ?>
                <div class="webmapp-featured-image">
                    <div class="webmapp-featured-image-img">
                        <img src="<?php echo $featured_image; ?>">
                        <div class="container">
                            <h2 class='webmapp-main-tax-name'>
                                <span><?php echo $featured_title ?></span>
                            </h2>
                        </div>
                    </div>
                </div>
                <?php
            }

        }

        ?>

		<div id="content-area" class="clearfix">
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
                    $attr_post_type = 'any';
                    $project_has_route = WebMapp_Utils::project_has_route();
                    if ( $project_has_route )
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
			</div> <!-- #left-area -->

			<?php //get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
