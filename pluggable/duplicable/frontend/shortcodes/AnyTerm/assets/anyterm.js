jQuery(document).ready( function($){
    $('.webmapp-anyterm-term-parent').click( function()
    {

        var $this = $(this);
        var $siblings;

        var $children = $this.find('.webmapp-anyterm-term-children-list');
        var is_open = $this.data('open');

        if ( ! is_open )
        {
                $siblings = $this.siblings();
                console.log($siblings);

                $siblings
                    .data( 'open' , 0 )
                    .find('.wm-icon-arrow-down-b')
                    .removeClass('wm-icon-arrow-down-b')
                    .addClass('wm-icon-arrow-right-b');

                $siblings.find('.webmapp-anyterm-term-children-list').slideUp();


            $children.slideDown();
            $this.find('.wm-icon-arrow-right-b').removeClass('wm-icon-arrow-right-b').addClass('wm-icon-arrow-down-b');
            $this.data('open' , 1 );
        }
        else
        {
            $children.slideUp();
            $this.find('.wm-icon-arrow-down-b').removeClass('wm-icon-arrow-down-b').addClass('wm-icon-arrow-right-b');
            $this.data('open' , 0 );
        }


    } );
} );