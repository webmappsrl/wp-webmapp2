/**
 * Not loaded
 */

(function ( $ ) {

    var WebMapp_LeafletMapMethods = {

        uniqueidGenerator : function() {
            var S4 = function() {
                return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
            };
            return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
        }
    };// end var WebMapp_LeafletMapMethods




    $.fn.WebMapp_LeafletMap = function( options )
    {

        // This is the easiest way to have default options.
        var settings = $.extend(
            {
                // These are the defaults.
                id : WebMapp_LeafletMapMethods.uniqueidGenerator.apply( this ),
                container : "",
                pois: "#556b2f",
                tracks: "white",
                routes: '',
                map_zoom : '',
                map_center : ''
            }
        , options );














        // Greenify the collection based on the settings variable.
        return this.css({
            color: settings.color,
            backgroundColor: settings.backgroundColor
        });

    };//end $.fn.WebMapp_LeafletMap = function( options )






}( jQuery ));