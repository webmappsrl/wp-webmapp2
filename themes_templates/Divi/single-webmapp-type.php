<?php


global $wp_query;

$post_id = get_the_ID();
$post_type = get_post_type( $post_id );

$geoJson = new WebMapp_GeoJson( $post_id );//ge geoJson
$geoJson_php = $geoJson->get_php();


$template_functions = new WebMapp_Single( $geoJson_php );



var_dump($template_functions->getShortInfo() );
var_dump($template_functions->getInfo() );
var_dump($template_functions->getRelatedObjects() );




/**
 * @return string
 */

function random_color()
{
    return "style='background-color:#" . substr(md5(rand()), 0, 6) . "'";
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

        <div class="container">


            <?php
            /**
             * FEATURED IMAGE
             */

            $featured_image = get_the_post_thumbnail_url( $post_id ,'full' );

            if ( $featured_image )
            {
                ?>
                <!-- LAYER 1 -->
                <div id='webmapp-layer-1' class="webmapp-featured-image" style="min-height:300px;background: url('<?php echo $featured_image; ?>')">
                    <h2 class="webmapp-featured-name"><?php the_title() ?></h2>
                </div>
                <!-- END LAYER 1 -->
                <?php
            }

            ?>


            <div id="content-area" class="clearfix">
                <div id="left-area" class="webmapp-grid-system">


                    <!-- START GRID -->
                    <div class="container-fluid">

                        <!-- LAYER 2 -->
                        <div id="webmapp-layer-2" class="row">
                            <div class="col-md-<?php echo $tem_l2_main_grid?>" <?php echo random_color() ?>>
                                <h2>
                                TITLE,
                                OTHER TAXONOMIES,
                                SHORT INFO,
                                EXCERPT
                                </h2>
                            </div>
                            <?php if( $tem_has_buy ) : ?>
                            <div class="col-md-3" <?php echo random_color() ?>>
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
                            <div class="col-md-6" <?php echo random_color() ?>>
                                <h2>
                                    GALLERY
                                </h2>
                            </div>
                            <?php endif;//if ( $tem_has_gallery ) ?>
                            <div class="col-md-<?php echo $tem_map_grid?>" <?php echo random_color() ?>>
                                <h2>
                                    MAP
                                </h2>
                            </div>
                        </div>
                        <!-- END LAYER 3 -->

                        <!-- LAYER 4 -->
                        <div id="webmapp-layer-4" class="row">
                            <div class="col-md-6" <?php echo random_color() ?>>
                                <h2>
                                    DESCRIPTION
                                </h2>
                            </div>
                            <div class="col-md-6" <?php echo random_color() ?>>
                                <div class="row">

                                    <?php if ( $tem_has_info ) : ?>
                                    <div class="col-md-12">
                                        <h2>
                                            INFO
                                        </h2>
                                    </div>
                                    <?php endif;//if ( $tem_has_info ) ?>

                                    <div class="col-md-12">
                                        <h2>
                                            RELATED OBJECTS
                                        </h2>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- END LAYER 4 -->

                        <!-- LAYER 5 -->
                        <div id="webmapp-layer-5" class="row">
                            <div class="col-md-12" <?php echo random_color() ?>>
                                <h2>
                                    SIMILAR OBJECTS
                                    (POTREBBE INTERESSARTI)
                                </h2>
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

                <?php get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php

