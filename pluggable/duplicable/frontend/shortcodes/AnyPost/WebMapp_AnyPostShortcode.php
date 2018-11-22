<?php

// Add Shortcode
function WebMapp_AnyPostShortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'any',
            'term_id' => '',
            'rows' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'posts_count' => '',
            'main_tax' => '',
            'post_ids' => '',
            'template' => ''// available templates: '', 'compact'
        ),
        $atts
    ));


    $id = WebMapp_Utils::get_unique_id();

    $template_class = $template ? " webmapp-anypost-template-$template" : " webmapp-anypost-template-full";

    ob_start();


    ?>

    <section id="<?php echo $id?>" class="webmapp_anypost_shortcode">

        <div style="display: block">
            <div class="webmapp-on-pagination">
                <img id="<?php echo $id?>_loader_image" class="webmapp_loader_img" src="<?php echo WebMapp_ASSETS . 'images/loader_new.gif'?>">
                <div class="webmapp_posts_controller webmapp-grid-system<?php echo $template_class; ?>">
                    <div class="posts webmapp-container-fluid"></div>
                </div>
            </div>
            <nav class="webmapp-pagination">
                <ul class="webmapp-pagination-numbers"></ul>
            </nav>
        </div>

    </section>
    <script>
        jQuery( document ).ready( function($){
            webmapp_posts_ajax_call(
                '<?php echo $id?>',//unique id for section
                '1',//paged
                '<?php echo $term_id ?>',//posts term id
                '<?php echo $post_id ?>',//post id, to display an unique post
                '<?php echo $posts_per_page ?>',//posts per page, please set it
                '<?php echo $rows ?>',//rows per page, please set it
                '<?php echo $post_type ?>',//posts post_type
                '<?php echo $posts_count ?>',//number of posts to display
                '<?php echo $main_tax ?>',//main taxonomy
                '<?php echo $post_ids ?>',//post ids separate by commas
                '<?php echo $template ?>'//shortcode template
            );
        } );
    </script>
<?php

    $output = ob_get_clean();



    return $output;
}

$WebMapp_MapShortcode = new WebMapp_RegisterShortcode( 'webmapp_anypost', 'WebMapp_AnyPostShortcode' );