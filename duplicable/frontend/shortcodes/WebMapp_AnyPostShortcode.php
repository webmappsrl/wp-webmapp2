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

    <section id="<?php echo $id?>">
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
        if ( ! shortcode_conf )
        var shortcode_conf = {
            ajaxurl : '/wp-admin/admin-ajax.php',
            nonce: '<?php echo wp_create_nonce('webmapp_anypost_shortcode') ?>'
        };


            var webmapp_posts_ajax_call_<?php echo $id ?> = ( paged = 1 ) =>
            {
                let $current_section = $('#<?php echo $id ?>');
                let $posts_wrapper = $current_section.find('.posts');
                let $loader_img = $current_section.find('.webmapp_loader_img');
                let $posts_controller = $current_section.find('.webmapp_posts_controller');




                //loader image
                $posts_wrapper.fadeOut();
                $loader_img.fadeIn();

                $.post(
                    shortcode_conf.ajaxurl,
                    {
                        action : 'get_anypost_shortcode_page',
                        nonce : shortcode_conf.nonce,
                        term_id : '<?php echo $term_id ?>',
                        post_id : '<?php echo $post_id ?>',
                        posts_per_page : '<?php echo $posts_per_page ?>',
                        rows : '<?php echo $rows ?>',
                        paged : paged,
                        post_type : '<?php echo $post_type ?>',
                        posts_count : '<?php echo $posts_count ?>'
                    }
                )
                    .done( function( response )
                    {
                        //parse response in json format
                        let json = JSON.parse( response );
                        //display posts

                        $posts_wrapper.empty().append( json.html );
                        $loader_img.fadeOut();
                        $posts_wrapper.fadeIn();


                        //pagination
                        let n_page = json.n_page;
                        let $pagination_wrap = $current_section.find( '.pagination' );
                        let $pagination_links = $pagination_wrap.find( '.pagination_link' );

                        if ( n_page !== 1 && $pagination_links.length === 0 )
                        {
                            let new_link;
                            $pagination_wrap.empty();
                            for ( let i = 1; i < n_page + 1 ; i ++ )
                            {
                                new_link = $('<li class="pagination_link_wrapper"><a class="pagination_link" data-paged="' + i + '">' + i + '</a></li>');

                                $pagination_wrap.append( new_link );
                                new_link.on('click', function(e)
                                {
                                    e.preventDefault();
                                    webmapp_posts_ajax_call_<?php echo $id ?>( i );
                                    $current_section.find('.pagination_link_wrapper.active').removeClass('active');
                                    $(this).addClass('active');
                                }
                                );
                            }
                            $current_section.find('[data-paged="' + paged + '"]').parent().addClass('active');
                        }

                        let posts_wrapper_height = $posts_wrapper.innerHeight();
                        $posts_controller.css( 'height' , posts_wrapper_height.toString() + 'px' );
                    }//end done
                    )
                    .fail( function( response )
                        {
                            //loader image
                            $loader_img.fadeOut();
                            $posts_wrapper.fadeIn();

                            console.log( 'FAIL' );
                        }

            )

            };

        webmapp_posts_ajax_call_<?php echo $id ?>();



    </script>
<?php

    $output = ob_get_clean();



    return $output;
}

$WebMapp_MapShortcode = new WebMapp_RegisterShortcode( 'webmapp_anypost', 'WebMapp_AnyPostShortcode' );