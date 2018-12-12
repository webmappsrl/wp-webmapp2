<?php


global $wp_query;

$post_id = get_the_ID();
$post_type = get_post_type( $post_id );

$geoJson = new WebMapp_GeoJson( $post_id );//get geoJson
$geoJson_php = $geoJson->get_php( "{$post_id}");//json_decode
$geoJson_json = $geoJson->get_json( "{$post_id}" );//json

$taxonomies = get_post_taxonomies();

$template_functions = new WebMapp_TemplateSingle( $geoJson_php );//template support class


function my_print_r( $arr )
{
    echo "<pre>";
    print_r( $arr );
    echo "</pre>";
}


/**
 * FIELDS
 */


$template_fields_key = array(
    'gallery' => 'n7webmap_track_media_gallery'
);

$template_fields = $template_functions->getFields( $template_fields_key );
extract( $template_fields );



$gallery = isset( $gallery ) && is_array( $gallery ) ?
    array_filter (
            array_map(
                    function( $i )
                    {
                        $r = isset( $i['ID'] ) ? $i['ID'] : '';
                        return $r;
                        } ,
                    $gallery
            )
    )
    : array();


/**
 * TEMPLATE CONF VARIABLES
 */

//LAYER 2

$tem_has_buy = false;
$tem_buy_grid = 3;

$tem_l2_main_grid = $tem_has_buy ? 9 : 12;

//LAYER 3

$tem_has_gallery = isset( $gallery ) && $gallery ;
$tem_gallery_grid = 6;

$tem_map_grid = $tem_has_gallery ? 6 : 12;

//LAYER 4
$tem_has_info = $template_functions->getInfo() == true ;


?>

    <div id="main-content webmapp-single webmapp-single-<?php echo $post_type ?>">

        <?php
        /**
         * FEATURED IMAGE
         */

        $featured_image = get_the_post_thumbnail_url( $post_id ,'full' );
        $main_tax = WebMapp_Utils::get_main_tax( $post_id );
        $terms = get_the_terms( $post_id , $main_tax );


        WebMapp_Utils::get_featured_image_header( $featured_image , $main_tax , array() , $post_id );

        ?>

        <div class="container">

            <div id="content-area" class="clearfix">
                <div id="left-area" class="webmapp-grid-system" style="width: 100%;padding: 23px 0px 0px !important;float: none !important;">

<?php while ( have_posts() ) : the_post(); ?>
                    <!-- START GRID -->
                    <div class="webmapp-container-fluid">

                        <!-- LAYER 2 -->
                        <div id="webmapp-layer-2" class="row">
                            <div class="col-md-<?php echo $tem_l2_main_grid?>">
                                <h3 class="webmapp_customizer_general_color1-color webmapp_customizer_general_font1-font-family webmapp_customizer_general_size7-font-size"><?php the_title()?></h3>
                                <?php
                                foreach ( $taxonomies as $taxonomy )
                                {
                                    if ( $taxonomy != $main_tax )
                                    {
                                        $terms = get_the_terms( $post_id , $taxonomy );
                                        if ( $terms && is_array( $terms ) )
                                            foreach ( $terms as $term ) :
                                                $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                                $term_link = get_term_link( $term );
                                                echo "<span class=\"webmapp-term-short webmapp-term-short-$term->slug\"><i class=\"$term_icon\"></i><span><a href='$term_link'>$term->name</a></span></span>";
                                            endforeach;
                                    }
                                }


                                $getShortInfo = $template_functions->getShortInfo();

                                if ( $getShortInfo ) : ?>
                                    <?php
                                    $template_functions->theShortInfo();
                                    ?>

                                <?php endif; ?>

                                <?php echo "<p class='webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_general_size8-font-size'>" . get_the_excerpt() . "</p>"?>
                            </div>
                            <?php if( $tem_has_buy ) : ?>
                                <div class="col-md-3">
                                    <h2>
                                        BUY
                                    </h2>
                                </div>
                            <?php endif;//if( $tem_has_buy ) ?>
                        </div>
                        <!-- END LAYER 2 -->

                        <!-- LAYER 3 -->
                        <div id="webmapp-layer-3" class="row">
                            <?php if ( $tem_has_gallery ) : ?>
                                <div class="col-md-6">
                                    <?php
                                    echo do_shortcode("[et_pb_gallery _builder_version='3.9' gallery_ids='" . implode( ',' , $gallery ) . "' show_pagination='off' zoom_icon_color='#466434' hover_overlay_color='rgba(255,255,255,0.9)' posts_number='1' fullwidth='on' /]");
                                    ?>
                                </div>
                            <?php endif;//if ( $tem_has_gallery ) ?>
                            <div class="col-md-<?php echo $tem_map_grid?>">
                                <?php
                                $api_url = get_option('webmapp_map_apiUrl');
                                $neighbors_url = esc_url("{$api_url}{$post_id}_{$post_type}_neighbors.geojson");
                                echo do_shortcode("[webmapp_geojson_map post_id='$post_id' geojson_url='$neighbors_url']");
                                ?>
                            </div>
                        </div>
                        <!-- END LAYER 3 -->

                        <!-- LAYER 4 -->
                        <div id="webmapp-layer-4" class="row">
                            <div class="col-md-6 webmapp_customizer_general_color3-color webmapp_customizer_general_font3-font-family webmapp_customizer_singlepost_size10-font-size">
                                <p class="webmapp-template-sigle-content">
                                    <?php echo get_the_content(); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <?php if ( $tem_has_info ) :
                                        $getInfo = $template_functions->getInfo();
                                        if ( $getInfo ) :
                                            ?>
                                            <div class="col-md-12 webmapp-get-info">
                                                <?php $template_functions->theInfo() ?>
                                            </div>
                                        <?php
                                        endif;//if ( $getInfo ) :
                                    endif;//if ( $tem_has_info )
                                    ?>
                                    <div class="col-md-12 webmapp-get-related-objects">
                                        <?php

                                        $related_objects = $template_functions->getRelatedObjects();


                                        if ( $related_objects )
                                        {

                                            foreach( $related_objects as $key => $val )
                                            {
                                                if ( is_array( $val ) && ! empty( $val ) )
                                                {
                                                    echo "<h4 class='webmapp-related-objects-title'>$key</h4>";
                                                    foreach ( $val as $type => $ids )
                                                    {


                                                        if ( is_array( $ids ) && ! empty( $ids ) ) :
                                                            echo "<h5 class='webmapp-related-objects-subtitle'>$type</h5>";

                                                            foreach( $ids as $key2 => $val2  )
                                                            {

                                                                $t = $val2;

                                                                //echo "<div class='row'>";
                                                                if ( $t != 0 && is_numeric( $t ) )
                                                                    echo do_shortcode("[webmapp_anypost post_id='$t' template='compact']");
                                                                //echo "</div>";
                                                            }
                                                        endif;//if ( ! is_array( $ids ) && ! empty( $ids ) ) :
                                                    }//end foreach ( $val as $type => $ids )
                                                }//end if ( is_array( $val ) && ! empty( $val ) )
                                            }//end foreach( $related_objects as $key => $val )
                                        }

                                        ?>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- END LAYER 4 -->

                        <!-- LAYER 5 -->
                        <div id="webmapp-layer-5" class="row">
                            <div class="col-md-12">
                                <h2>
                                    <?php echo _x( 'Related posts' , 'singular template' , WebMapp_TEXTDOMAIN ) ?>
                                </h2>
                                <?php echo $template_functions->getSimilarObjects() ?>
                            </div>
                        </div>
                        <!-- END LAYER 5 -->

                    </div>



                    <!-- END GRID -->

                    <?php

                    if ( function_exists( 'wp_pagenavi' ) )
                        wp_pagenavi();
                    else
                        get_template_part( 'includes/navigation', 'index' );

                    ?>

<?php endwhile; ?>
                </div> <!-- #left-area -->

                <?php //get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->