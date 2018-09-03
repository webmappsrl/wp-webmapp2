/**
 * Not loaded
 */

(function ( $ ) {

    var WebMapp_LeafletMapMethods = {

        uniqueidGenerator : () => {
            var S4 = function() {
                return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
            };
            return (S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4());
        },

        disableZoomAndDraggable : (map) => {
            map.touchZoom.disable();
            map.dragging.disable();
            map.touchZoom.disable();
            map.doubleClickZoom.disable();
            map.scrollWheelZoom.disable();
            map.boxZoom.disable();
            map.keyboard.disable();
            $('.leaflet-control-zoom').css('visibility', 'hidden');
        },

        onEachFeature : ( settings, e, layer ) => {

            let imageurl = e.properties.image;
            let name = e.properties.name;
            let taxonomies = e.properties.taxonomy;

            let taxonomy_string = '';

            $.each( taxonomies ,  function( i , e )
            {
                $.each( e , function( i2 , e2 )
                {
                    taxonomy_string += e2;
                }
                );
            } );



            let html = "<div class='webmapp-geoJsonmap-popup'><div class='popup-img'><img src='" +
                imageurl + "'/></div>" +
                "<div class='popup-content-img'><div class='popup-category'><span>" + taxonomy_string + "</span></div>" +
                "<div class='popup-content-title'><div class='popup-title'><span>" + name + "</span></div></div>" +
                "</div></div>";


            layer.bindPopup( html , {
                minWidth : 310,
                className : 'webmapp_leaflet_popup'
            });



            if ( settings.post_id !== data.current_post_id )
            {

            }

            /**
             * immagine
             * Nome categoria
             * Nome
             * ( inserire link all'oggetto, tranne per quello corrente )
             * todo
             *
             * Caricare elemento del template +
             * https://api.webmapp.it/a/sgt.be.webmapp.it/geojson/345_poi_related.geojson (type: FeatureCollection, geometry types: Point).
             * se esiste ( sono eventuali related ) non neighbors
             */

            /**

            if ( false && settings.no_app )
            {
                let string;

                if ( e.properties["addr:street"] !== undefined && e.properties["addr:housenumber"] !== undefined )
                {
                    string = '<strong>' + e.properties.name + '</strong><br />' + e.properties["addr:street"] + ' ' + e.properties["addr:housenumber"] ;
                }
                else if ( e.properties["address"] !== undefined )
                {
                    string = '<strong>' + e.properties.name + '</strong><br />' + e.properties["address"];
                }
                else
                {
                    string = '<strong>' + e.properties.name + '</strong>';
                }

                string = '<a href="'+ e.properties.web +'" title="'+ e.properties.name  +'"><strong>' + e.properties.name + '</strong></a>';


            }
            else {

                marker.on('click', function () {
                    $('body').prepend(modal)
                    $('#modal-map iframe').height($(window).height() * 80 / 100)

                })

            }
            **/
        },

        loadGeojson : ( settings , geoJson , map ) => {

            let geojsonLayer = L.geoJSON( geoJson ,
                {
                    onEachFeature : function (feature, layer)
                    {
                        WebMapp_LeafletMapMethods.onEachFeature( settings , feature , layer );
                    }
                } ).addTo( map );


            map.fitBounds(
                geojsonLayer.getBounds(),
                {
                    maxZoom : parseInt( settings.zoom )
                }
            );


        },


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
                map_center : '',
                post_id : '',
                initialLat: 43.689740,//pisa
                initialLng: 10.392279,//pisa
                appUrl: data.appUrl,
                label: data.label,
                zoom: data.zoom,
                tilesUrl : data.tilesUrl,
                show_pin : data.show_pin,
                no_app : data.no_app,
                show_expand : data.show_expand,
                click_iframe : data.click_iframe,
                activate_zoom : data.activate_zoom
            }
            , options );



        var mapId = settings.id,
            postId = settings.post_id,
            modalMapId = WebMapp_LeafletMapMethods.uniqueidGenerator.apply( this ),
            modal = '<div id="' + modalMapId + '"><div class="modal-content"><i class="fa fa-times close-modal" aria-hidden="true"></i></div></div>',
            icon_class = '',//todo
            color = '',//todo
            mapContainer = $("<div id='" + mapId + "'></div>"),
            geoJson = window['geoJson_' + postId] ? window['geoJson_' + postId] : false ;


        this.append(mapContainer);

        var map = L.map( mapId , {
            center: [settings.initialLat, settings.initialLng],
            zoom: settings.zoom,
            scrollWheelZoom: false
        } );//parseInt( settings.zoom )

        L.tileLayer( settings.tilesUrl, {
            layers: [
                {
                    label: settings.label,
                    type: 'maptile',
                    tilesUrl: settings.tilesUrl,
                    default: true
                }],
            //maxZoom: 17
        }).addTo(map);


        //show expand
        if ( data.show_expand === 'true' )
        {
            let link_url = settings.appUrl + '/#/poi/' + postId + '/' + settings.zoom;
                let html =
                '<a target="_blank" class="open-modal-map" href="' + link_url + '" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>';
            mapContainer.prepend( html );
        }




        var marker_settings = {
            color : color,
            icon_class : icon_class,
            modal : modal,
            modalMapId : modalMapId,
            map : map,
            mapContainer : mapContainer,
            lng: settings.initialLng,
            lat: settings.initialLat
        };


        //isset geojson in settings
        if ( geoJson )
        {
            WebMapp_LeafletMapMethods.loadGeojson( settings , geoJson , map );
        }
        //necessary ajax call
        else
        {
            var ajax_call = $.ajax({
                url: settings.appUrl + '/geojson/' + postId + '.geojson',
                dataType: 'json',
                success: function (geoJson, text, xhr) {
                    console.log(text)
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });

            $.when(ajax_call).done(function ( geoJson ) {

                WebMapp_LeafletMapMethods.loadGeojson( settings , geoJson , map );

            });
        }

        return this;

    };//end $.fn.WebMapp_LeafletMap = function( options )






}( jQuery ));