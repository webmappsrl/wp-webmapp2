<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 12/07/18
 * Time: 17:26
 */

$term = get_queried_object();

get_header(); ?>

    <div id="main-content">
    <div class="container">
<?php
if ( $term && $term instanceof WP_Term  )
{
    $featured_image = get_field( 'wm_taxonomy_featured_image' , $term );

    if ( isset( $featured_image['url'] ) )
    {
        ?>
        <div class="webmapp-term-featured-image" style="background: url('<?php echo $featured_image['url'];; ?>')">
            <?php if ( $featured_title ) { ?>
                <h2 class="webmapp-term-featured-name"><?php echo $featured_title ?></h2>
            <?php } ?>
        </div>
        <?php
    }

}

?>

        <div id="content-area" class="clearfix">
            <div id="left-area">
                    <?php
                    $featured_title = get_field( 'wm_taxonomy_title' , $term );

                    if ( $term && $term instanceof WP_Term  )
                    {
                        if ( $featured_title ) { ?>
                            <h2 class="webmapp-term-title"><?php echo $featured_title ?></h2>
                        <?php }

                        echo do_shortcode("[webmapp_anypost posts_per_page='9' rows='3' term_id='$term->term_id' main_tax='$term->taxonomy']");
                    }

                if ( function_exists( 'wp_pagenavi' ) )
                wp_pagenavi();
                else
                get_template_part( 'includes/navigation', 'index' );

                ?>
            </div> <!-- #left-area -->

            <?php get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php

get_footer();