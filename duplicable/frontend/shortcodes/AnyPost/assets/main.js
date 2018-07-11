

var webmapp_posts_ajax_call = ( id , paged = 1 , term_id, post_id, posts_per_page, rows, post_type, posts_count ) =>
{

    (function($){


        let $current_section = $('#' + id );
        let $posts_wrapper = $current_section.find('.posts');
        let $loader_img = $current_section.find('.webmapp_loader_img');

        //loader image
        $posts_wrapper.fadeOut();
        $loader_img.fadeIn();

        $.post(
            shortcode_conf.ajaxurl,
            {
                action : 'get_anypost_shortcode_page',
                //nonce : shortcode_conf.nonce,
                term_id : term_id,
                post_id : post_id,
                posts_per_page : posts_per_page,
                rows : rows,
                paged : paged,
                post_type : post_type,
                posts_count : posts_count
            }
        )
            .done( function( response )
                {
                    //parse response in json format
                    let json = JSON.parse( response );
                    //display posts

                    let $new_html = $(json.html);
                    $posts_wrapper.empty().append( $new_html );
                    $loader_img.fadeOut();
                    $posts_wrapper.fadeIn();


                    let $post_image = $posts_wrapper.find('.webmapp_post_image');

                    $post_image.find('img').one("load", function() {

                        let $e = $(this);
                        let post_img_height = $e.outerHeight();
                        let post_img_width = $e.outerWidth();
                        let post_img_height_resize = 9/16 * post_img_width;
                        if ( post_img_height > post_img_height_resize )
                        {
                            let img_margin = ( post_img_height - post_img_height_resize ) / 2;
                            $e.css(
                                {
                                    'margin' : '-' + img_margin + 'px' + ' 0',
                                });
                            console.log('cropped');
                        }




                    }).each(function() {
                        if(this.complete) $(this).load();
                    });

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
                                    webmapp_posts_ajax_call( id , i , term_id, post_id, posts_per_page, rows, post_type, posts_count);
                                    $current_section.find('.pagination_link_wrapper.active').removeClass('active');
                                    $(this).addClass('active');
                                }
                            );
                        }
                        $current_section.find('[data-paged="' + paged + '"]').parent().addClass('active');
                    }

                }//end done
            )
            .fail( function( response )
                {
                    //loader image
                    $loader_img.fadeOut();
                    $posts_wrapper.fadeIn();

                    console.log( 'FAIL' );
                }

            )//end fail

    })( jQuery );


};//end function
