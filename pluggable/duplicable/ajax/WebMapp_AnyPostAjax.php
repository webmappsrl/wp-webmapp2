<?php
function get_anypost_shortcode_page() {

    //todo check nonce!!!
    $atts = $_POST;
    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'any',
            'term_id' => '',
            'rows' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'paged' => '1',
            'posts_count' => '',
            'main_tax' => '',
            'post_ids' => '',
            'template' => 'default',
            'orderby' => ''
        ),
        $atts
    ));

    $query_args = array();

    $term = isset( $term_id ) && is_numeric($term_id ) ? get_term( $term_id ) : '';
    $taxonomy = isset( $term->taxonomy ) && taxonomy_exists( $term->taxonomy ) ? $term->taxonomy : '';


    /**
     * Start elaborate quary args
     */
    if ( $post_id && is_numeric( $post_id ) ){

        $temp = get_post($post_id );
        if ( $post_type == 'any' && isset( $temp->post_type ) )
            $post_type = $temp->post_type;//
        $query_args['p'] = intval($post_id );
        $query_args[ 'posts_per_page' ] = '1';
        $rows = 1;
        $posts_per_page = 1;
    }
    elseif ( $post_ids && strpos($post_ids , ',') !== false )
    {
        $query_args[ 'post__in' ] = explode(',',$post_ids );
    }
    elseif  ( $post_type == 'route'
        && $taxonomy == 'activity'
        && WebMapp_Utils::project_has_route()
    ) {
        $routes_by_activity = WebMapp_ActivityRoute::get_routes_by_activity( $term_id );
        $query_args['post__in'] = empty( $routes_by_activity ) ? array( 0 ) : $routes_by_activity;
        $query_args[ 'posts_per_page' ] = $posts_per_page;

    }//end elseif
    elseif ( $post_type && ( post_type_exists( $post_type ) || $post_type = 'any' ) )
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


    //set query arguments
    $query_args[ 'paged' ] = $paged;
    $query_args[ 'post_status' ] = 'publish';
    $query_args['post_type'] = $post_type;


    //orderby
    if ( ! empty( $orderby ) )
    {
        switch ( $orderby )
        {
            case "sticky":
                $sticky_posts = get_option( 'sticky_posts' );
                if ( ! empty( $sticky_posts ) )
                {
                    $default_posts_args = $query_args;
                    $default_posts_args['fields'] = 'ids';
                    $default_posts_args['ignore_sticky_posts'] = 1;

                    $default_posts = get_posts( $default_posts_args );

                    $post__in = array_merge($sticky_posts, $default_posts);

                    if ( ! isset($query_args['post__in']) )
                        $query_args['post__in'] = $post__in;
                    else
                        $query_args['post__in'] = array_merge( $post__in , $query_args['post__in'] );

                    $query_args['ignore_sticky_posts'] = 1;
                    $query_args['orderby'] = 'post__in';


                }

                break;
            default:
                    $query_args['orderby'] = $orderby;
                break;
        }
    }



    //Query
    $custom_posts = new WP_Query( $query_args );


    /**
     * Bootstrap grid
     */

    //$posts_per_row = ceil($posts_per_page / $rows);
    $posts_per_row_t = ceil($posts_per_page / $rows);//calculate posts per row

    $posts_per_row_t = $posts_per_row_t != 1
                        && $posts_per_row_t != 3
                        && $posts_per_row_t % 2 == 1
                        ? $posts_per_row_t + 1 : $posts_per_row_t;//odd to even, doesn't use odd rows numbers!


    $bootstrap_col_type = ceil(12 / $posts_per_row_t );//bootstrap grid system

    $i = 0; $j_prop = true; $rows_closed = false;


    ob_start();//start register html



    var_dump( $orderby );
    var_dump( $query_args );

    //Start Loop
    if ( $custom_posts->have_posts() ) :

        //taxonomies initialization
        if ( $i == 0 )
        {
            $temporaney_post = $custom_posts->posts[0];//posts exists and are not empty
            $global_taxonomies = get_object_taxonomies( $temporaney_post );
        }

        if ( $posts_count && $posts_count < $custom_posts->found_posts && $term )
        {
            $term_link = get_term_link( $term );
            echo "<p class='webmapp_anypost_show_all'><a class='webmapp_anypost_show_all_link' href='$term_link'>" . __( 'Show all' , WebMapp_TEXTDOMAIN ) . "<i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></p>";
        }




        //prepare crossing variables
        //necessary to load external template
        global $wm_anypost_bootstrap_col_type,
               $wm_anypost_global_taxonomies,
               $wm_anypost_template,
               $wm_anypost_post_type;

        $wm_anypost_bootstrap_col_type = $bootstrap_col_type;
        $wm_anypost_global_taxonomies = $global_taxonomies;
        $wm_anypost_template = $template;
        $wm_anypost_post_type = $post_type;



        /**
         * The Loop Starts
         */
        while ( $custom_posts->have_posts() && $j_prop ) : $custom_posts->the_post();

            /**
             * Bootstrap Rows
             */
            if ( $i%$posts_per_row_t == 0 )
            {
                if ( $i === 0 )
                {
                    echo '<div class="row">';
                    $rows_closed = false;
                }
                else
                {
                    echo '</div>';
                    echo '<div class="row">';
                    $rows_closed = false;
                }

            }

            WebMapp_Utils::get_anypost_shortcode_template( $template );

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