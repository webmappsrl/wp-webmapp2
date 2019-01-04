/**
var force_aspect_ratio = ( $e ) =>
{
    let $figure = $e.parent();
    let aspect_ratio_target_width = 16;
    let aspect_ratio_target_height = 9;
    let aspect_ratio_target = aspect_ratio_target_width / aspect_ratio_target_height;
    let aspect_ratio_target_inverse = aspect_ratio_target_height / aspect_ratio_target_width;

    let img_css_resize = {};

    //figure resize
    let figure_width = $figure.width();
    let figure_height = figure_width * aspect_ratio_target_inverse;
    $figure.css( 'height' , figure_height );


    //image resize or negative margin
    let post_img_width = parseInt( $e.width() );
    let post_img_height = parseInt ( $e.height() );

    //real aspect ratio ( before resizing )
    let real_aspect_ratio = post_img_width / post_img_height;

    if ( real_aspect_ratio !== aspect_ratio_target )
    {

        //vertical img
        if ( post_img_width < post_img_height
            || real_aspect_ratio === 1
            || real_aspect_ratio < aspect_ratio_target
        )
        {
            img_css_resize = {
                margin: '-' + ( ( post_img_height - figure_height ) / 2 ) + 'px 0'
            };
        }
        else //real_aspect_ratio > aspect_ratio_target
        {
            $e.css({
                height: figure_height,
                width: 'initial',
            });
            post_img_width = parseInt( $e.width() );

            img_css_resize = {
                margin: '0 -' + ( ( post_img_width - figure_width ) / 2 ) + 'px'
            };
        }


    }
    else
    {
        img_css_resize = { width : '100%' }
    }

    $e.css( img_css_resize );
};
**/


var force_aspect_ratio = ( $e ) =>
{
    let get_e_width = $e.parents('.webmapp_post-featured-img').width();
    let set_e_height = get_e_width / 16 * 9;
    $e.css( 'height' , set_e_height );
};

//args to object todo
var webmapp_posts_ajax_call =
    ( id , paged = 1 , term_id, post_id, posts_per_page, rows, post_type, posts_count, main_tax, post_ids, template ) =>
    {

        (function($){

            let $current_section = $('#' + id );
            let $posts_wrapper = $current_section.find('.posts');
            let $loader_img = $current_section.find('.webmapp_loader_img');
            let $up_pagination = $current_section.find('.webmapp-on-pagination');
            //let $posts_controller = $current_section.find('.webmapp_posts_controller');


            let up_pagination_height = $up_pagination.outerHeight();
            if ( up_pagination_height > 0 )
                $up_pagination.outerHeight( up_pagination_height );


            //center loader img
            let loader_img_height = $loader_img.outerHeight();
            let loader_img_width = $loader_img.outerWidth();
            let up_pagination_width = $up_pagination.outerWidth();
            let center_loader_in_height = ( up_pagination_height / 2 ) - ( loader_img_height / 2 );
            let center_loader_in_width = ( up_pagination_width / 2 ) - ( loader_img_width / 2 );

            $loader_img.css( {
                top: center_loader_in_height,
                left: center_loader_in_width
            } );

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
                    posts_count : posts_count,
                    main_tax : main_tax,
                    post_ids : post_ids,
                    template : template,
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

                        //set imgs height
                        $posts_wrapper.find('figure').each(
                            function ( i , e )
                            {
                                force_aspect_ratio( $(e) );
                            }
                        );



                        //resizing
                        /**
                         let $post_image = $posts_wrapper.find('.webmapp_post_image');
                        let $images = $post_image.find('img');
                        $images.one("load", function() {
                            let $e = $(this);
                            force_aspect_ratio( $e );
                        }).each(function() {
                            if(this.complete) $(this).load();
                        });
                         **/

                        //pagination
                        let n_page = json.n_page;
                        let total_posts = json.total;
                        let $pagination_wrap = $current_section.find( '.webmapp-pagination-numbers' );
                        //let $pagination_links = $pagination_wrap.find( '.pagination_link' );




                        //pagination
                        if ( n_page > 1 )
                        {

                                let new_link;
                                $pagination_wrap.empty();
                                for ( let i = 1; i < n_page + 1 ; i ++ )
                                {
                                    new_link = $('<li class="pagination_link_wrapper"><a class="pagination_link webmapp_customizer_general_color1-background-color" data-paged="' + i + '">' + i + '</a></li>');

                                    $pagination_wrap.append( new_link );
                                    new_link.on('click', function(e)
                                        {
                                            e.preventDefault();
                                            webmapp_posts_ajax_call( id , i , term_id, post_id, posts_per_page, rows, post_type, posts_count, main_tax );
                                            $current_section.find('.pagination_link_wrapper.active').removeClass('active');
                                            $(this).addClass('active');
                                        }
                                    );
                                }
                                $current_section.find('[data-paged="' + paged + '"]').parent().addClass('active');


                        }
                        else
                        {
                            if ( ! total_posts )
                            {
                                $current_section.fadeOut().prev('h3').fadeOut();
                            }
                            else
                                $pagination_wrap.remove();
                        }

/**
                        setTimeout( function(){
                            //fix posts height
                            let posts_controller_height = $posts_controller.outerHeight();


                            if ( posts_controller_height > up_pagination_height )
                                $up_pagination.css( 'height' , posts_controller_height );

                        }, 300 );
            **/



                        //compact mode text width fix
                        var $compact_theme_elements = $( '.webmapp-anypost-template-compact' );
                        if ( $compact_theme_elements.length > 0 )
                        {
                            $compact_theme_elements.each( function( i, e )
                                {
                                    let img_exists = $(e).find('.webmapp_post-featured-img img').length;
                                    if ( ! img_exists )
                                        $(e).find('.webmapp_post-featured-img ~ p').css( 'width' , '100%' );
                                }
                            );
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
                .always( function( response ){
                    //console.log( response );
                } )

        })( jQuery );


    };//end function


jQuery( document ).ready( function($){

    var property_added = false;


    $( window ).resize( function()
    {
        //fix fucking divi grid system conflicts on window resize
        if ( ! property_added )
        {
            $( '.webmapp-grid-system .row' ).css( 'display' , 'initial' );
            property_added = true;
        }

        //force aspect ratio of images

        $( 'figure.webmapp_post_image' ).each( function( i , e ){
            force_aspect_ratio( $(e) );
        } );



    } );




} );