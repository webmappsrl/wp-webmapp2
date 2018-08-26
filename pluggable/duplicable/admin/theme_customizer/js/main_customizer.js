/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */



( function( $ ) {

    if ( wm_customizer_data )
    {
        $.each( wm_customizer_data , function( i, e )
        {
            let id = e.id;
            let properties = e.properties;

            console.log( id,properties);

            /**
             * Register in live edit css of custom options
             */
            //Update site title color in real time...
            wp.customize( id , function( value )
            {
                value.bind( function( newval )
                {

                    $.each( properties , function( i2 , e2 )
                        {
                           $( '.' + id + '-' + e2  ).css( e2 , newval );
                        }
                    );

                } );
            } );

        } );


    }




} )( jQuery );