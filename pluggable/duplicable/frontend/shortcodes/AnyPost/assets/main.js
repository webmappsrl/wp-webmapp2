
var force_aspect_ratio = ($e) => {
    let get_e_width = $e.parents('.webmapp_post-featured-img').width();
    let set_e_height = get_e_width / 16 * 9;
    $e.css('height', set_e_height);
};

//args to object todo
var webmapp_posts_ajax_call = (obj) => {


    for (var key in obj) {
        this[key] = obj[key];
    }


    (function ($) {

        const processAjaxResponse = (json) => {


            //set imgs height
            $posts_wrapper.find('figure').each(
                function (i, e) {
                    force_aspect_ratio($(e));
                }
            );


            //pagination
            let n_page = json.n_page;
            let total_posts = json.total;
            let $pagination_wrap = $current_section.find('.webmapp-pagination-numbers');
            //let $pagination_links = $pagination_wrap.find( '.pagination_link' );


            //pagination
            if (n_page > 1) {

                let new_link;
                $pagination_wrap.empty();
                for (let i = 1; i < n_page + 1; i++) {
                    new_link = $('<li class="pagination_link_wrapper"><a class="pagination_link webmapp_customizer_general_color1-background-color" data-paged="' + i + '">' + i + '</a></li>');

                    $pagination_wrap.append(new_link);
                    new_link.on('click', function (e) {
                        let temp = obj;
                        temp.firstPageAjax = false;
                        temp.paged = i;

                        e.preventDefault();
                        console.log(temp);
                        webmapp_posts_ajax_call(temp);
                        $current_section.find('.pagination_link_wrapper.active').removeClass('active');
                        $(this).addClass('active');
                    }
                    );
                }
                $current_section.find('[data-paged="' + paged + '"]').parent().addClass('active');


            }
            else {
                if (!total_posts) {
                    //$current_section.fadeOut().prev('h3').fadeOut();
                }
                else
                    $pagination_wrap.remove();
            }


            //compact mode text width fix
            var $compact_theme_elements = $('.webmapp-anypost-template-compact');
            if ($compact_theme_elements.length > 0) {
                $compact_theme_elements.each(function (i, e) {
                    let img_exists = $(e).find('.webmapp_post-featured-img img').length;
                    if (!img_exists)
                        $(e).find('.webmapp_post-featured-img ~ p').css('width', '100%');
                }
                );
            }

        };//end const processAjaxResponse

        let $current_section = $('#' + id);
        let $posts_wrapper = $current_section.find('.posts');
        let $loader_img = $current_section.find('.webmapp_loader_img');
        let $up_pagination = $current_section.find('.webmapp-on-pagination');
        //let $posts_controller = $current_section.find('.webmapp_posts_controller');


        let up_pagination_height = $up_pagination.outerHeight();
        if (typeof firstPageAjax !== 'object' && up_pagination_height > 0)
            $up_pagination.outerHeight(up_pagination_height);


        //center loader img
        let loader_img_height = $loader_img.outerHeight();
        let loader_img_width = $loader_img.outerWidth();
        let up_pagination_width = $up_pagination.outerWidth();
        let center_loader_in_height = (up_pagination_height / 2) - (loader_img_height / 2);
        let center_loader_in_width = (up_pagination_width / 2) - (loader_img_width / 2);

        $loader_img.css({
            top: center_loader_in_height,
            left: center_loader_in_width
        });


        //console.log('FIRST LOAD', firstPageAjax);
        if (typeof firstPageAjax == 'object' && firstPageAjax.hasOwnProperty('html')) {
            processAjaxResponse(firstPageAjax);
        }
        else {
            //loader image
            $posts_wrapper.fadeOut();
            $loader_img.fadeIn();

            $.post(
                shortcode_conf.ajaxurl,
                {
                    action: 'get_anypost_shortcode_page',
                    //nonce : shortcode_conf.nonce,
                    ...obj
                }
            )
                .done(function (response) {
                    //parse response in json format
                    let json = JSON.parse(response);
                    //display posts

                    let $new_html = $(json.html);
                    $posts_wrapper.empty().append($new_html);

                    processAjaxResponse(response)

                    $loader_img.fadeOut();
                    $posts_wrapper.fadeIn();
                    //force aspect ratio of images
                    $('figure.webmapp_post_image').each(function (i, e) {
                        force_aspect_ratio($(e));
                    });
                    $('html, body').animate({
                        scrollTop: $posts_wrapper.offset().top
                    }, 1000)

                }//end done
                )
                .fail(function (response) {
                    //loader image
                    $loader_img.fadeOut();
                    $posts_wrapper.fadeIn();

                    console.log('FAIL');
                }

                )//end fail
                .always(function (response) {
                    //console.log( response );
                })
        }

    })(jQuery);


};//end function


jQuery(document).ready(function ($) {

    var property_added = false;

    $(window).resize(function () {
        //fix fucking divi grid system conflicts on window resize
        if (!property_added) {
            $('.webmapp-grid-system .row').css('display', 'initial');
            property_added = true;
        }

        //force aspect ratio of images
        $('figure.webmapp_post_image').each(function (i, e) {
            force_aspect_ratio($(e));
        });

    });




});