<?php

// Add Shortcode
function WebMapp_AnyPostShortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'post',
            'term_id' => '',
            'rows' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'posts_count' => ''
        ),
        $atts
    ));


    $id = WebMapp_Utils::get_unique_id();

    ob_start();


    ?>

    <section id="<?php echo $id?>" class="webmapp_anypost_shortcode">

        <div style="position:relative">
            <img id="<?php echo $id?>_loader_image" class="webmapp_loader_img" style="display:none;position:absolute;width:200px;" src="<?php echo WebMapp_ASSETS . 'images/loader_new.gif'?>">
            <div class="webmapp_posts_controller">
                <div class="posts container-fluid"></div>
            </div>
        </div>
        <nav class="webmapp-pagination">
            <ul class="pagination"></ul>
        </nav>

    </section>
    <script>
        jQuery( document ).ready( function($){
            webmapp_posts_ajax_call(
                '<?php echo $id?>',
                '1',
                '<?php echo $term_id ?>',
                '<?php echo $post_id ?>',
                '<?php echo $posts_per_page ?>',
                '<?php echo $rows ?>',
                '<?php echo $post_type ?>',
                '<?php echo $posts_count ?>'
            );
        } );
    </script>
<?php

    $output = ob_get_clean();



    return $output;
}

$WebMapp_MapShortcode = new WebMapp_RegisterShortcode( 'webmapp_anypost', 'WebMapp_AnyPostShortcode' );