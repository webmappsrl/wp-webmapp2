(function( $ ) {


    var support_methods = {
        remove_image : function()
        {
            $('.remove-this-file' ).on( 'click' , function (event) {
                event.preventDefault();
                $(this).parent().parent().remove();
            });
        },
        show_display_remove_button : function ()
        {
            $('.webmapp-remove-element').parent().parent().hover(
                function(){
                    $(this).find('.webmapp-remove-element').show();
                },
                function(){
                    $(this).find('.webmapp-remove-element').hide();
                }
            );
        }
    };

    support_methods.show_display_remove_button();
    support_methods.remove_image();

    $.fn.webmappFileInput = function( options ) {

        // This is the easiest way to have default options.
        let settings = $.extend({
            // These are the defaults.
            name: "webmapp_file_input",
            multiple: false
        }, options );


        let $container = this;
        let $addLink = $container.find('.upload-custom-file');
        let frame;

        $addLink.on( 'click', function( event )
        {
            event.preventDefault();
            // If the media frame already exists, reopen it.
            if ( frame ) {
                frame.open();
                return;
            }

            let frame_title;
            if ( settings.multiple )
                frame_title = 'Seleziona uno o più file.';
            else
                frame_title = 'Seleziona un file.';
            // Create a new media frame
            frame = wp.media({
                title: frame_title,
                button: {
                    text: 'Inserisci'
                },
                multiple: settings.multiple  // Set to true to allow multiple files to be selected
            });


            // When an image is selected in the media frame...
            frame.on( 'select', function() {

                // Get media attachment details from the frame state
                //var attachment = frame.state().get('selection').first().toJSON();

                let attachments = frame.state().get('selection').toJSON();

                let imageurl;

                for ( let i = 0 ; i < attachments.length ; i++ ) {

                    if (attachments[i].type === 'image') {
                        if ( attachments[i].sizes.hasOwnProperty('thumbnail') )
                            imageurl = attachments[i].sizes.thumbnail.url;
                        else
                            imageurl = attachments[i].url;
                    }
                    else
                        imageurl = attachments[i].icon;

                    let input_name = settings.multiple ? settings.name + '[]' : settings.name;

                    if ( ! settings.multiple )
                      $container.find('.file-container').remove();

                    $container.append( '' +
                        '<div class="file-container">' +
                        '<div class="webmapp-file-box">' +
                        '<img src="' + imageurl + '" alt="' + attachments[i].id + '" />' +
                        '<input type="button" class="webmapp-remove-element remove-this-file button" value="X"/>' +
                        '<input type="hidden" class="' + settings.name + '" name="' + input_name + '" value="'+attachments[i].id+'" />' +
                        '</div>' +
                        '<p><a href="' + attachments[i].url + '" target="blank">' + attachments[i].title + '</a></p>' +
                        '</div>' );
                    // Send the attachment id to our hidden input

                }
                support_methods.remove_image();
                support_methods.show_display_remove_button()

                // Send the attachment URL to our custom image input field.
                //imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:50%;"/>' );

                // Hide the add image link
                //addImgLink.addClass( 'hidden' );

                // Unhide the remove image link
                //delImgLink.removeClass( 'hidden' );
            });

            // Finally, open the modal on click
            frame.open();
        });



        return this;

    };

}( jQuery ));
