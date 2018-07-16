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


            let color_this = [
                //ANY POST SHORTCODE
                'div.webmapp_post_terms .webmapp_single_term a i',//other taxonomies icon background color
                '.webmapp_shortcode_any_post .webmapp_post-title h2 a',//post title
                //ANY TERM SHORTCODE
                '.webmapp-list-terms ul.webmapp-terms li a'//terms list

            ];
            for ( let i in color_this )
            {
                $(color_this[i]).css( 'color' , newval );
            }

            //ANY POST SHORTCODE
            $('.webmapp_main_tax i').css('background-color', newval );//main tax icon background color
            $('.pagination_link_wrapper.active a.pagination_link').css('background-color', newval );//main tax icon background color
            $('.pagination_link_wrapper a.pagination_link').css('background-color', newval + '7F' );//main tax icon background color
            $('.webmapp_main_tax').css('background-color', newval + '7F' );//7F = 127 ≈ 255 / 2
            //$('div.webmapp_post_terms .webmapp_single_term a i').css( 'filter' , 'brightness(140%)');


        } );
    } );
    /**
     * COLOR 2
     */

    wp.customize( 'webmapp_shortcodes_color2', function( value ) {
        value.bind( function( newval )
        {
            //ANY TERM SHORTCODE
            $('.webmapp-any-terms-title').css('color', newval );//where color
        } );
    } );


    /**
     * COLOR 3
     */

    wp.customize( 'webmapp_shortcodes_color3', function( value ) {
        value.bind( function( newval )
        {
            //ANY POST SHORTCODE
            $('div.webmapp_post_terms .webmapp_single_term a').css('color', newval );//where color
            //ANY TERM SHORTCODE
            $('.webmapp-any-terms-subtitle').css('color', newval );//where color
        } );
    } );

    /**
     * FONT 1
     */

    wp.customize( 'webmapp_shortcodes_font1', function( value ) {
        value.bind( function( newval )
        {
            //ANY POST SHORTCODE
            $('.webmapp_shortcode_any_post .webmapp_post-title h2 a').css('font-family', newval );//where color

            //ANY TERM SHORTCODE
            $('.webmapp-any-terms-title').css('font-family', newval );//where color

        } );
    } );


    /**
     * FONT 2
     */
    wp.customize( 'webmapp_shortcodes_font2', function( value ) {
        value.bind( function( newval ) {

            //ANY POST SHORTCODE
            $('.webmapp_single_term a span').css('font-family', newval );//where color

            //ANY TERM SHORTCODE
            $('.webmapp-list-terms ul.webmapp-terms li a').css('font-family', newval )
        } );
    } );

    /**
     * FONT 3
     */
    wp.customize( 'webmapp_shortcodes_font3', function( value ) {
        value.bind( function( newval ) {


            //ANY TERM SHORTCODE
            $('.webmapp-any-terms-subtitle').css('font-family', newval )
        } );
    } );


} )( jQuery );