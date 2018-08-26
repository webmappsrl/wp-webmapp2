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



            let html = "<div class='webmapp-geoJsonmap-popup'><img src='" +
                imageurl + "'/>" +
                "<h5>" + taxonomy_string + "</h5>" +
                "<h6>" + name + "</h6>" +
                "</div>";


            layer.bindPopup( html );



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

        prepareMarkers : ( settings , marker_settings ) => {
            if ( settings.show_pin === 'true')
            {

                var marker;

                var markerObject = { icon : L.VectorMarkers.icon({
                        icon: 'poi',
                        prefix: 'wm',
                        extraClasses: marker_settings.icon_class,
                        markerColor: marker_settings.color,
                        iconSize: [36, 45],
                    })};

                marker = L.marker([ marker_settings.lat, marker_settings.lng ], markerObject ).addTo( marker_settings.map );

                if ( settings.no_app === 'true')
                {
                    if ( e.properties["addr:street"] !== undefined && e.properties["addr:housenumber"] !== undefined )
                    {
                        marker.bindPopup('<strong>' + e.properties.name + '</strong><br />' + e.properties["addr:street"] + ' ' + e.properties["addr:housenumber"] )
                    }
                    else if ( e.properties["address"] !== undefined )
                    {
                        marker.bindPopup('<strong>' + e.properties.name + '</strong><br />' + e.properties["address"] )
                    }
                    else
                    {
                        marker.bindPopup('<strong>' + e.properties.name + '</strong>' )
                    }
                }
                else
                {
                    marker.on('click', function ()
                    {
                        $('body').prepend( marker_settings.modal );
                        $('#modal-map iframe').height($(window).height() * 80 / 100);

                    });
                }
            }
            if ( settings.show_expand === 'true')
            {

                var attr = 'open-modal-map';

                var html = '<a target="_blank" class="' + attr +
                    '" href="#" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>';
                marker_settings.mapContainer.prepend(html);

                $('.open-modal-map').on('click', function (e)
                {
                    e.preventDefault();
                    $('body').prepend( marker_settings.modal );
                    $('#modal-map iframe').height($(window).height() * 80 / 100);

                })
            }

            if ( settings.click_iframe === 'true')
            {
                $('#custom-poi-map').on('click', function (e) {
                    e.preventDefault();
                    $('body').prepend( marker_settings.modal );
                    $('#modal-map iframe').height($(window).height() * 80 / 100);
                })
            }

            $('body').on('click', '.close-modal', function (e)
            {
                e.preventDefault();
                $('#' + marker_settings.modalMapId ).remove();
            });

            if ( settings.activate_zoom !== 'true')
            {
                WebMapp_LeafletMapMethods.disableZoomAndDraggable( marker_settings.map );
            }
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