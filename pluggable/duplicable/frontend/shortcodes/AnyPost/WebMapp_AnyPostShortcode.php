<?php

// Add Shortcode
function WebMapp_AnyPostShortcode( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'post_type' => 'any',
            'term_id' => '',
            'term_ids' => '',
            'exclude_term_ids' => '',
            'rows' => '2',
            'posts_per_page' => get_option( 'posts_per_page' ),
            'post_id' => '',
            'posts_count' => '',
            'main_tax' => '',
            'post_ids' => '',
            'template' => 'default',// available templates: 'default', 'compact',
            'orderby' => '',
            'activity_color' => '',
            'order' => 'DESC',
            'custom' => ''
        ),
        $atts
    ));


    $id = WebMapp_Utils::get_unique_id();

    $template_class = "webmapp-anypost-template-$template";

    /** Get the template of first page on server side, loaded by js */
    $data = array(
        "id" =>  $id,//unique id for section
        "paged" =>  '1',//paged
        "term_id" =>  $term_id ,//posts term id
        "term_ids" =>  $term_ids ,//posts term ids
        "exclude_term_ids" =>  $exclude_term_ids ,//posts term ids
        "post_id" =>  $post_id ,//post id, to display an unique post
        "posts_per_page" =>  $posts_per_page ,//posts per page, please set it
        "rows" =>  $rows ,//rows per page, please set it
        "post_type" =>  $post_type ,//posts post_type
        "posts_count" => $posts_count ,//number of posts to display
        "main_tax" =>  $main_tax ,//main taxonomy
        "post_ids" =>  $post_ids ,//post ids separate by commas
        "template" =>  $template ,//shortcode template
        "orderby" =>  $orderby ,//orderby wp query
        "order" => $order,//order query
        "activity_color" =>  $activity_color ,//theme color of activity
        "custom" =>  $custom ,//custom attribute,
        "echo" => false
    );
    
    $ajaxCallback = get_anypost_shortcode_page( $data );

    ob_start();

    ?>

    <section id="<?php echo $id?>" class="webmapp_anypost_shortcode">

        <div style="display: block">
            <div class="webmapp-on-pagination">
                <img id="<?php echo $id?>_loader_image" class="webmapp_loader_img" src="<?php echo WebMapp_ASSETS . 'images/loader_new.gif'?>" style="display:none;">
                <div class="webmapp_posts_controller webmapp-grid-system <?php echo $template_class; ?>">
                    <div class="posts webmapp-container-fluid">
                        <?= $ajaxCallback['html'] ?>
                    </div>
                </div>
            </div>
            <nav class="webmapp-pagination">
                <ul class="webmapp-pagination-numbers"></ul>
            </nav>
        </div>

    </section>
    <?php $ajaxCallback['html'] = ''; ?> 
    <script>
        
        webmapp_posts_ajax_call(
            {
                id: '<?php echo $id?>',//unique id for section
                paged: '1',//paged
                term_id: '<?php echo $term_id ?>',//posts term id
                term_ids: '<?php echo $term_ids ?>',//posts term ids
                exclude_term_ids: '<?php echo $exclude_term_ids ?>',//posts term ids
                post_id: '<?php echo $post_id ?>',//post id, to display an unique post
                posts_per_page: '<?php echo $posts_per_page ?>',//posts per page, please set it
                rows: '<?php echo $rows ?>',//rows per page, please set it
                post_type: '<?php echo $post_type ?>',//posts post_type
                posts_count:'<?php echo $posts_count ?>',//number of posts to display
                main_tax: '<?php echo $main_tax ?>',//main taxonomy
                post_ids: '<?php echo $post_ids ?>',//post ids separate by commas
                template: '<?php echo $template ?>',//shortcode template
                orderby: '<?php echo $orderby ?>',//orderby wp query
                activity_color: '<?php echo $activity_color ?>',//theme color of activity
                custom: '<?php echo $custom ?>',//custom attribute
                firstPageAjax: <?= json_encode($ajaxCallback) ?>,
                order: '<?= $order ?>'
            }   
        ); 
    </script>
<?php

    $output = ob_get_clean();



    return $output;
}

$WebMapp_MapShortcode = new WebMapp_RegisterShortcode( 'webmapp_anypost', 'WebMapp_AnyPostShortcode' );