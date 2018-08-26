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
    wp.customize( 'webmapp_shortcodes_color1', function( value ) {
        value.bind( function( newval ) {


            $('.pagination_link_wrapper a.pagination_link').css('background-color', newval + '7F' );//main tax icon background color
            $('.webmapp_main_tax').css('background-color', newval + '7F' );//7F = 127 ≈ 255 / 2
            //$('div.webmapp_post_terms .webmapp_single_term a i').css( 'filter' , 'brightness(140%)');


        } );
    } );


    /**
     * COLOR 3
     */

    wp.customize( 'webmapp_shortcodes_color3', function( value ) {
        value.bind( function( newval )
        {

        } );
    } );

    /**
     * FONT 1
     */

    wp.customize( 'webmapp_shortcodes_font1', function( value ) {
        value.bind( function( newval )
        {


        } );
    } );


    /**
     * FONT 2
     */
    wp.customize( 'webmapp_shortcodes_font2', function( value ) {
        value.bind( function( newval ) {


        } );
    } );




} )( jQuery );