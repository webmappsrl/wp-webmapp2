<?php get_header(); ?>

<div id="main-content">

	<div class="container">
		<div id="content-area" class="<?php extra_sidebar_class(); ?> clearfix">
			<div class="et_pb_extra_column_main">

                <?php

                global $wp_query;

                $tax = isset( $wp_query->query['taxonomy'] ) ? $wp_query->query['taxonomy'] : '';

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
