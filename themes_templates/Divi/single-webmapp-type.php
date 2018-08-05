<?php


global $wp_query;

$post_id = get_the_ID();
$post_type = get_post_type( $post_id );

$geoJson = new WebMapp_GeoJson( $post_id );//get geoJson
$geoJson_php = $geoJson->get_php();//json_decode
$geoJson_json = $geoJson->get_json();//json_decode

$taxonomies = get_post_taxonomies();





$template_functions = new WebMapp_TemplateSingle( $geoJson_php );//template support class



//var_dump($template_functions->getShortInfo() );
//var_dump($template_functions->getInfo() );
//var_dump($template_functions->getRelatedObjects() );






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
    'gallery' => 'field_5853f586c83cd'
);

$template_fields = $template_functions->getFields( $template_fields_key );
extract( $template_fields );


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




        if ( $featured_image )
        {
            ?>
            <!-- LAYER 1 -->
            <div id='webmapp-layer-1' class="webmapp-featured-image">
                <div class="webmapp-featured-image-img">
                    <img src="<?php echo $featured_image; ?>">
                    <div class="container">
                        <?php if ( $terms && is_array( $terms ) ) :

                            $multiple = false;
                            if ( count($terms) > 1 )
                                $multiple = true;
                            ?>
                            <h2 class='webmapp-main-tax-name'>
                                <?php foreach( $terms as $term ) :
                                    $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                    ?>
                                    <i class='<?php echo $term_icon?>'></i>
                                    <span><?php echo $term->name ?></span>
                                <?php endforeach; ?>
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- END LAYER 1 -->
            <?php
        }

        ?>

        <div class="container">





            <div id="content-area" class="clearfix">
                <div id="left-area" class="webmapp-grid-system" style="width: 100%;padding: 23px 0px 0px !important;float: none !important;">
                    <!-- START GRID -->
                    <div class="webmapp-container-fluid">

                        <!-- LAYER 2 -->
                        <div id="webmapp-layer-2" class="row">
                            <div class="col-md-<?php echo $tem_l2_main_grid?>">
                                <h3><?php the_title()?></h3>
                                <?php
                                foreach ( $taxonomies as $taxonomy )
                                {
                                    if ( $taxonomy != $main_tax )
                                    {
                                        $terms = get_the_terms( $post_id , $taxonomy );
                                        foreach ( $terms as $term ) :
                                            $term_icon = get_field( 'wm_taxonomy_icon',$term );
                                            $term_link = get_term_link( $term );
                                            echo "<span class=\"webmapp-term-short webmapp-term-short-$term->slug\"><i class=\"$term_icon\"></i><span><a href='$term_link'>$term->name</a></span></span>";
                                        endforeach;
                                    }
                                }


                                $getShortInfo = $template_functions->getShortInfo();
                                if ( $getShortInfo ) : ?>
                                    <h2>
                                        GET SHORT INFO
                                    </h2>
                                    <?php
                                    $template_functions->theShortInfo();
                                    ?>

                                <?php endif; ?>

                                <h2>
                                    EXCERPT
                                </h2>

                                <?php the_excerpt()?>
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
                                    <h2>
                                        GALLERY
                                    </h2>
                                    <?php
                                    echo do_shortcode("[et_pb_gallery _builder_version='3.9' gallery_ids='1452,1450,1448,1444,1440,1432,1428,1422,1413,1410,1385' show_pagination='off' zoom_icon_color='#466434' hover_overlay_color='rgba(255,255,255,0.9)' posts_number='1' fullwidth='on' /]");
                                    ?>
                                </div>
                            <?php endif;//if ( $tem_has_gallery ) ?>
                            <div class="col-md-<?php echo $tem_map_grid?>">
                                <h2>
                                    MAP
                                </h2>
                                <?php
                                echo do_shortcode("[webmapp_geojson_map post_id='$post_id' ]");
                                ?>
                            </div>
                        </div>
                        <!-- END LAYER 3 -->

                        <!-- LAYER 4 -->
                        <div id="webmapp-layer-4" class="row">
                            <div class="col-md-6">
                                <h2>
                                    CONTENT
                                </h2>
                                <?php the_content(); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <?php if ( $tem_has_info ) :
                                        $getInfo = $template_functions->getInfo();
                                        if ( $getInfo ) :
                                            ?>
                                            <div class="col-md-12">
                                                <h2>
                                                    GET INFO
                                                </h2>
                                                <?php my_print_r( $getInfo ) ?>
                                            </div>
                                        <?php
                                        endif;//if ( $getInfo ) :
                                    endif;//if ( $tem_has_info )
                                    ?>
                                    <div class="col-md-12">
                                        <h2>
                                            GET RELATED OBJECTS
                                        </h2>

                                        <?php

                                        $related_objects = $template_functions->getRelatedObjects();
                                        if ( $related_objects )
                                        {
                                            foreach( $related_objects as $key => $val )
                                            {
                                                echo "<h4>$key</h4>";
                                                if ( is_array( $val ) && ! empty( $val ) )
                                                {
                                                    foreach ( $val as $type => $ids )
                                                    {
                                                        if ( is_array( $ids ) && ! empty( $ids ) ) :
                                                            echo "<h5>$type</h5>";
                                                            foreach( $ids as $id => $details )
                                                            {
                                                                //echo "<div class='row'>";
                                                                echo do_shortcode("[webmapp_anypost post_id='$id' template='compact']");
                                                                //echo "</div>";
                                                            }
                                                        endif;//if ( ! is_array( $ids ) && ! empty( $ids ) ) :
                                                    }//end foreach ( $val as $type => $ids )
                                                }//end if ( is_array( $val ) && ! empty( $val ) )
                                            }//end foreach( $related_objects as $key => $val )
                                        }

                                        ?>

                                    </>

                                </div>

                            </div>
                        </div>
                        <!-- END LAYER 4 -->

                        <!-- LAYER 5 -->
                        <div id="webmapp-layer-5" class="row">
                            <div class="col-md-12">
                                <h2>
                                    SIMILAR OBJECTS
                                    (POTREBBE INTERESSARTI)
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
                </div> <!-- #left-area -->

                <?php //get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php

