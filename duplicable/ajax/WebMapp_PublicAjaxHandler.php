<?php


/**
 * PUBLIC AJAX
 */

/**
 * todo
 * ????
 */
function add_user_to_route() {

    $username = get_userdata($_REQUEST['user_id']);

    echo json_encode($username->data);

    die();

}
new WebMapp_AjaxHandler( true ,'add_user_to_route' );



function get_anypost_shortcode_page() {

    //todo check nonce!!!
    $atts = $_POST;
    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'post',
            'term_id' => '',
            'rows' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'paged' => '1',
            'posts_count' => ''
        ),
        $atts
    ));



    $query_args = array();

    $term = isset( $term_id ) && is_numeric($term_id ) ? get_term( $term_id ) : '';
    $taxonomy = isset( $term->taxonomy ) && taxonomy_exists( $term->taxonomy ) ? $term->taxonomy : '';

    if ( $post_id && is_numeric( $post_id ) ){

        $temp = get_post($post_id );
        if ( $post_type == 'post' && isset( $temp->post_type ) )
            $post_type = $temp->post_type;//
        $query_args['p'] = intval($post_id );
        $query_args[ 'posts_per_page' ] = '1';
        $rows = 1;
        $posts_per_page = 1;
    }
    elseif  ( $post_type == 'route'
        && $taxonomy == 'activity'
        && WebMapp_Utils::project_has_route()
    ) {
        $query_args['post__in'] = WebMapp_ActivityRoute::get_routes_by_activity( $term_id );
        $query_args[ 'posts_per_page' ] = $posts_per_page;

    }//end elseif
    elseif ( $post_type && post_type_exists( $post_type ) )
    {
        if ( $term_id && $taxonomy )//set tax query
            $query_args ['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomy,
                    'terms' => array($term_id),
                    'field' => 'term_id'
                )
            );
        $query_args[ 'posts_per_page' ] = $posts_per_page;

    }//end elseif //endif


    $query_args[ 'paged' ] = $paged;
    $query_args[ 'post_status' ] = 'publish';
    $query_args['post_type'] = $post_type;






    $custom_posts = new WP_Query( $query_args );

    /**
     * Style operations
     */
    $twelve_odd_divider = array( 1 , 3 );
    //$posts_per_row = ceil($posts_per_page / $rows);
    $posts_per_row_t = ceil($posts_per_page / $rows);//calculate posts per row

    switch( $posts_per_row_t ){
        case 1 :
    }
    $posts_per_row_t = $posts_per_row_t!=1 && $posts_per_row_t % 2 == 1 ? $posts_per_row_t + 1 : $posts_per_row_t;//odd to even, doesn't use odd rows numbers!


    $bootstrap_col_type = ceil(12 / $posts_per_row_t );//bootstrap grid system

    $i = 0; $j = 0; $j_prop = true; $rows_closed = false;

    ob_start();

    var_dump( $query_args );

    if ( $custom_posts->have_posts() ) :


        //taxonomies initialization
        if ( $i == 0 )
        {
            $temporaney_post = $custom_posts->posts[0];//posts exists and are not empty
            $global_taxonomies = get_object_taxonomies( $temporaney_post );
        }


        /**
         * The Loop Starts
         */
        while ( $custom_posts->have_posts() && $j_prop ) : $custom_posts->the_post();

            /**
             * Rows
             */
            if ( $i%$posts_per_row_t == 0 )
            {
                if ( $i === 0 )
                {
                    echo '<div class="row">';
                    $rows_closed = false;
                }

                elseif ( $i === $posts_per_page - 1 )
                {
                    echo '</div>';
                    $rows_closed = true;
                }

                else
                {
                    echo '</div>';
                    echo '<div class="row">';
                    $rows_closed = false;
                }

            }



            ?>

            <div class="col-xs-12 col-sm-6 col-md-<?php echo $bootstrap_col_type?> col-lg-auto webmapp_shortcode_any_post post_type_<?php echo $post_type?>">
                <div class="webmapp_post-featured-img">
                    <?php the_post_thumbnail('full') ?>
                </div>
                <div class="webmapp_post-title">
                    <?php
                    $where_html = '';
                    $activity_html = '';
                    $others_html = '';
                    if ( $post_type == 'route' )
                    {
                        $global_taxonomies[] = 'activity';
                    }

                    foreach( $global_taxonomies as $tax_name ) :

                        if ( $post_type == 'route' && $tax_name == 'activity' )
                        {
                            $terms = WebMapp_ActivityRoute::get_route_activities(get_the_ID());
                        }
                        else
                        {
                            $terms = get_the_terms( get_the_ID() , $tax_name );
                        }

                        if ( $terms && is_array( $terms ) )
                        {
                            $where_html .= '<p>';
                            $activity_html .= '<p>';
                            $others_html .= '<p>';
                            foreach ( $terms as $term )
                            {
                                $term_link = get_term_link( $term->term_id );
                                if ( $tax_name == 'where' )
                                {
                                    $where_html .= "<a href='$term_link' title='$term->name'>$term->name</a>";
                                }
                                elseif ( $tax_name == 'activity' )
                                {
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    $activity_html .= "<a href='$term_link' title='$term->name'><i class='$term_icon'></i>$term->name</a>";
                                }
                                else
                                {
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    $others_html .= "<a href='$term_link' title='$term->name'><i class='$term_icon'></i></a>";
                                }

                            }//endforeach
                            $where_html .= '</p>';
                            $activity_html .= '</p>';
                            $others_html .= '</p>';
                        }//endif

                    endforeach;



                    echo $activity_html;
                    $title_link = get_the_permalink();
                    echo "<h3><a href='$title_link'>" . get_the_title() . "</a></h3>";
                    echo $where_html;
                    echo $others_html;


                    ?>

                </div>
                <div class="webmapp_post-other-terms">

                </div>
            </div>

            <?php
            /**
             *  <h6><?php echo get_post_type( get_the_ID() ) ;?></h6>
            <p><?php the_content();?></p>
             */
            $i ++;
            $j = ( $posts_per_page * ( $paged - 1 ) ) + $i;
            $j_prop = $posts_count ? $j < $posts_count : true;
        endwhile;
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

    else:

        echo "<p>Sorry, no posts found.</p>";

    endif;

    if( $rows_closed == false )
        echo "</div>";

    $output = ob_get_clean();

    $n_page = $posts_count ? ceil( $posts_count / $posts_per_page ) : ceil( $custom_posts->found_posts / $posts_per_page );

    $return = array(
        'html' => $output,
        'max_num_pages' => $custom_posts->max_num_pages,
        'total' => $custom_posts->found_posts,
        'n_page' => $n_page
    );



    echo json_encode( $return );

    die();

}
new WebMapp_AjaxHandler( true ,'get_anypost_shortcode_page' );