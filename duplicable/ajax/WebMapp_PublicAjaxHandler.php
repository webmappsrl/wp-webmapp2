<?php


/**
 * PUBLIC AJAX
 */

/**
 * todo
 * ???? ma stiamo a scherzà?
 */
function add_user_to_route() {

    $username = get_userdata($_REQUEST['user_id']);

    echo json_encode($username->data);

    die();

}
new WebMapp_AjaxHandler( true ,'add_user_to_route' );


function get_anypost_shortcode_page() {

    $atts = $_POST;
    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'post',
            'term_id' => '',
            'row' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'paged' => '1'
        ),
        $atts
    ));

    $output = '';
    $query_args = array();

    $term = isset( $term_id ) && is_numeric($term_id ) ? get_term( $term_id ) : '';
    $taxonomy = isset( $term->taxonomy ) && taxonomy_exists( $term->taxonomy ) ? $term->taxonomy : '';

    if ( $post_id && is_numeric( $post_id ) ) :

        $query_args['p'] = $post_id;

    elseif ( $post_type == 'route'
        && $taxonomy == 'activity'
        && WebMapp_Utils::project_has_route()
    ) :
        $query_args['post_type'] = 'route';
        $query_args['post__in'] = WebMapp_ActivityRoute::get_routes_by_activity( $term_id );


    elseif ( $post_type && post_type_exists( $post_type ) ):
        $query_args['post_type'] = $post_type;
        if ( $term_id && $taxonomy )
            $query_args ['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => array($term_id),
                    'field' => 'term_id'
                )
            );

    endif;

    if ( count( $query_args ) > 1 )
    {
        $query_args[ 'posts_per_page' ] = $posts_per_page;
        $query_args[ 'paged' ] = $paged;
    }



    $custom_posts = new WP_Query( $query_args );


    ob_start();
    if ( $custom_posts->have_posts() ) :
        while ( $custom_posts->have_posts() ) : $custom_posts->the_post();

       ?>
        <article class="webmapp_shortcode_any_post post_type_<?php echo $post_type?>">
            <div class="webmapp_post-featured-img">
                <?php the_post_thumbnail('medium') ?>
                <?php if( $term ) :
                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                    ?>
                <div class="webmapp_post-terms">
                    <p><i class="<?php echo $term_icon ?>"></i><?php echo $term->name?></p>
                </div>
                <?php endif; ?>
            </div>
            <div class="webmapp_post-title">
                <h3><?php the_title();?></h3>
            </div>
            <div class="webmapp_post-other-terms">

            </div>
        </article>




        <?php
        /**
         *  <h6><?php echo get_post_type( get_the_ID() ) ;?></h6>
        <p><?php the_content();?></p>
         */
        endwhile;
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

    else:

        echo "<p>Sorry, no posts found.</p>";

    endif;

    $output = ob_get_clean();

    $n_page = ceil( $custom_posts->found_posts / $posts_per_page );
    
    $return = array(
        'html' => $output,
        'paged' => $paged,
        'max_num_pages' => $custom_posts->max_num_pages,
        'total' => $custom_posts->found_posts,
        'n_page' => $n_page
    );



    echo json_encode( $return );

    die();

}
new WebMapp_AjaxHandler( true ,'get_anypost_shortcode_page' );