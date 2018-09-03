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
            'template' => ''
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
        $query_args['post__in'] = WebMapp_ActivityRoute::get_routes_by_activity( $term_id );
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


    //var_dump( $query_args );

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
            echo "<p class='webmapp_anypost_show_all'><a class='webmapp_anypost_show_all_linka' href='$term_link'>" . __( 'Show all' , WebMapp_TEXTDOMAIN ) . "<i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i></a></p>";
        }

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

            $title_link = get_the_permalink();
            $get_the_post_thumbanil = get_the_post_thumbnail(get_the_ID() ,'full');
            $current_post_type = get_post_type();

            $main_tax_c = WebMapp_Utils::get_main_tax(get_the_ID() );

            if ( $main_tax && taxonomy_exists( $main_tax ) )
                $main_tax_c = $main_tax;


            ?>

            <div class="col-sm-12 col-md-<?php echo $bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $post_type?>">

                    <?php

                    $activity_level = 1;

                    $taxs_htmls = array();

                    if ( $current_post_type == 'route' )
                    {
                        $global_taxonomies[] = 'activity';
                    }

                    //prepare main tax overlay
                    foreach( $global_taxonomies as $tax_name ) :

                        $taxs_htmls[$tax_name] = '';

                        if ( $current_post_type == 'route' && $tax_name == 'activity' )
                        {
                            $terms = WebMapp_ActivityRoute::get_route_activities(get_the_ID());
                        }
                        else
                        {
                            $terms = get_the_terms( get_the_ID() , $tax_name );
                        }


                        /**
                         * Manage multiple terms in image overlay
                         */
                        $multiple = false;
                        if ( $tax_name == $main_tax_c )
                        {
                            if ( count($terms ) > 1 )
                                $multiple = true;
                        }



                        if ( $terms && is_array( $terms ) )
                        {

                            foreach ( $terms as $term )
                            {
                                $term_link = get_term_link( $term->term_id );

                                if ( $main_tax_c == $tax_name )
                                {
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    if ( $term_icon )
                                    {
                                        $i_class = $multiple ? 'webmapp_icon_multiple' : 'webmapp_icon_single';
                                        $taxs_htmls[$tax_name] .= "<span class='webmapp_single_$tax_name webmapp_single_{$tax_name}_{$activity_level} webmapp_single_term'><a class='webmapp_single_{$tax_name}_link' href='$term_link' title='$term->name'><i class='$term_icon $i_class webmapp_customizer_general_color1-background-color'></i>";
                                        if ( ! $multiple )
                                            $taxs_htmls[$tax_name] .= "<span class='webmapp_single_{$tax_name}_name webmapp_customizer_general_font2-font-family webmapp_customizer_general_size2-font-size webmapp_customizer_general_color1-background-color-brightness'>$term->name</span>";

                                        $taxs_htmls[$tax_name] .= "</a></span>";
                                        $activity_level++;
                                    }

                                }
                                else
                                {
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    $icon = '';
                                    if ( $term_icon )
                                        $icon = "<i class='$term_icon webmapp_customizer_general_color1-color'></i>";

                                    $taxs_htmls[$tax_name] .= "<span class='webmapp_single_$tax_name webmapp_single_term'><a class='webmapp_single_{$tax_name}_link webmapp_customizer_general_color3-color webmapp_customizer_general_font2-font-family webmapp_customizer_general_size5-font-size' href='$term_link' title='$term->name'><span>$term->name</span>$icon</a></span>";
                                }


                            }//endforeach

                        }//endif

                    endforeach;



                    /**
                     * PREPARE TITLE
                     */
                    ob_start();
                    ?>

                    <div class="webmapp_post-title">
                        <h2>
                            <?php echo "<a href='$title_link' title=\"".get_the_title()."\" class='webmapp_customizer_general_color1-color webmapp_customizer_general_font1-font-family webmapp_customizer_general_size2-font-size'>" . get_the_title() . "</a>"; ?>
                        </h2>
                        <?php
                        if ( $template == 'compact' )
                            WebMapp_Utils::theShortInfo();

                        ?>
                    </div>

                    <?php
                    $post_title = ob_get_clean();

                    /**
                     * PREPARE TAXONOMIES
                     */
                    $main_tax_class = $multiple ? 'webmapp_main_tax_multiple' : 'webmapp_main_tax_single';
                    $main_tax_html = isset( $taxs_htmls[$main_tax_c] ) ? $taxs_htmls[$main_tax_c] : '' ;
                    ob_start();
                    if ( ! empty( $get_the_post_thumbanil ) )
                        echo "<div class='webmapp_main_tax $main_tax_class'>" . $main_tax_html . "</div>";
                    $post_taxonomies = ob_get_clean();

                    ?>

                <?php

                if ( $template == 'compact' )
                {
                    //echo $post_taxonomies;
                    echo $post_title;
                }
                ?>


                <div class="webmapp_post-featured-img">
                    <?php
                    echo "<a href='$title_link' title=\"".get_the_title()."\">";
                    ?>
                    <figure class="webmapp_post_image">
                    <?php echo $get_the_post_thumbanil; ?>

                    </figure>
                    <?php
                    echo "</a>";



                    if( $template == '' )
                        echo $post_taxonomies;

                   ?>
                </div>

                <?php

                    if ( $template == '' )
                        echo $post_title;
                    elseif( $template == 'compact' )
                        the_excerpt();
                ?>





                <?php if ( $template == '' ) : ?>


                    <div class="webmapp_post_terms">
                        <?php
                        if ( isset( $taxs_htmls['where'] ) )
                            echo $taxs_htmls['where'];
                        foreach ( $taxs_htmls as $key => $tax_html )
                        {
                            if ( $key != $main_tax_c && 'where' != $key )
                                echo $tax_html;
                        }
                        ?>
                    </div>

            <?php endif;//if ( $template == '' ) : ?>

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