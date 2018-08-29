/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */
( function( $ ) {

    /**
     * COLOR 1
     */
    //Update site title color in real time...
    wp.customize( 'webmapp_customizer_general_color1', function( value ) {
        value.bind( function( newval ) {



            //todo $('.pagination_link_wrapper a.pagination_link').css('background-color', newval + '7F' );//main tax icon background color
            $('.webmapp_customizer_general_color1-background-color-brightness').css('background-color', newval + '7F' );//7F = 127 ≈ 255 / 2
            //$('div.webmapp_post_terms .webmapp_single_term a i').css( 'filter' , 'brightness(140%)');


        } );
    } );




} )( jQuery );