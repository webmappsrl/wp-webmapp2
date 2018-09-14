/**
 * Not loaded
 */

(function ( $ ) {

    var WebMapp_LeafletMapMethods = {

        uniqueidGenerator : () => {
            var S4 = function() {
                return (((1+Math.random())*0x10000)|0).toString(16).substring(1);
            };
            return ( S4()+S4()+"-"+S4()+"-"+S4()+"-"+S4()+"-"+S4()+S4()+S4() );
        },


        onEachFeature : ( settings, e, layer ) => {

            let imageurl = e.properties.image;
            let name = e.properties.name;
            let taxonomies = e.properties.taxonomy;
            let color = e.properties.color;
            let link = e.properties.web;
            let icon = e.properties.icon;
            let layer_id = e.properties.id;

            let taxonomy_string = '';

            $.each( taxonomies ,  function( i , e )
            {
                $.each( e , function( i2 , e2 )
                {
                    taxonomy_string += e2;
                }
                );
            } );


            let link_before = "";
            let link_after = "";


            if ( link && layer_id.toString() !== data.current_post_id )
            {
                link_before = "<a href='" + link + "'>";
                link_after = "</a>";
            }


            let marker_img = "";
            if ( imageurl )
                marker_img = "<img src='" + imageurl + "'/>";
            else
                marker_img = "<div class='webmapp-icon-container'><i class='icon wm-icon-star2'></i></div>";


            let html = "<div class='webmapp-geoJsonmap-popup'>" + link_before + "<div class='popup-img'>" + marker_img + "</div>" +
                "<div class='popup-content-img'><div class='popup-category'></div>" +
                "<div class='popup-content-title'><div class='popup-title'><span>" + name + "</span></div></div>" +
                "</div>" + link_after + "</div>";


            layer.bindPopup( html , {
                minWidth : 310,
                className : 'webmapp_leaflet_popup'
            });

            let style_o = {};


            if ( layer instanceof L.Marker )//pois
            {
                style_o['icon'] = 'webmapp';
                if ( color )
                    style_o['markerColor'] = color;
                if ( icon )
                    style_o['extraClasses'] = icon;

                let iconMarker = L.VectorMarkers.icon( style_o );
                layer.setIcon( iconMarker );
            }
            else if ( layer instanceof L.Path )//tracks and routes
            {
                if ( color )
                    style_o['color'] = color;
                if ( icon )
                    style_o['icon'] = icon;

                layer.setStyle( style_o );
            }



        },

        loadGeojson : ( settings , geoJson , map ) => {

            let current_poi_neighbors = [];

            let geojsonLayer = L.geoJSON( geoJson ,
                {
                    onEachFeature : function (feature, layer)
                    {

                        WebMapp_LeafletMapMethods.onEachFeature( settings , feature , layer );
                        //todo add neigbors to map

                    }
                } )
                .addTo( map );




            map.fitBounds(
                geojsonLayer.getBounds(),
                {
                    maxZoom : parseInt( settings.zoom )
                }
            );


            //show add neighbors
            if( data.filter === 'true' && current_poi_neighbors.length > 0 )
            {
                //map.doubleClickZoom.disable();
                let $btFilter = $('<a id="' + settings.id + '-map-neighbors" class="wm_map_filter" title="neighbors"><span class="wm-icon-marker-15"></span> <span class="wm_filter_text">' + data.labelActive +'</span> ' + data.labelFilters + '</a>');

                $('#' + settings.id).prepend( $btFilter );

                let neighbors_active = false;

                $btFilter.on( 'click' , function( click_e )
                {
                    map.doubleClickZoom.disable();
                    click_e.preventDefault();

                    if( neighbors_active )
                    {
                        $(this).find('.wm_filter_text').text( data.labelDeactive );
                        $(this).find('.wm-icon-marker-15').addClass( 'wm-icon-marker-stroked-15' );

                        current_poi_neighbors.forEach(
                            function( marker )
                            {
                                L.geoJSON( marker ).addTo( map );
                            }
                            );
                        neighbors_active = false;

                    }
                    else
                    {
                        current_poi_neighbors.forEach(
                            function( marker )
                            {
                                map.removeLayer( marker );
                            }
                        );
                        $(this).find('.wm_filter_text').text(data.labelActive);
                        $(this).find('.wm-icon-marker-15').removeClass('wm-icon-marker-stroked-15');
                        neighbors_active = true;
                    }


                });

            }


        },


    };// end var WebMapp_LeafletMapMethods




    $.fn.WebMapp_LeafletMap = function( options )
    {


        // This is the easiest way to have default options.
        var settings = $.extend(
            {
                // These are the defaults.
                //id : WebMapp_LeafletMapMethods.uniqueidGenerator(),
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







        let geoJson = window['geoJson_' + settings.post_id] ? window['geoJson_' + settings.post_id] : false ;


        //this.append( mapContainer );

        var map = L.map( settings.id , {
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
            let link_url = settings.appUrl + '/#/poi/' + settings.post_id + '/' + settings.zoom;
                let html =
                '<a target="_blank" class="open-modal-map" href="' + link_url + '" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>';
            this.prepend( html );
        }



        //isset geojson in settings
        if ( geoJson )
        {
            console.log( 'geojson:' , geoJson );
            WebMapp_LeafletMapMethods.loadGeojson( settings , geoJson , map );
        }
        //necessary ajax call
        else
        {
            var ajax_call = $.ajax({
                url: settings.appUrl + '/geojson/' + settings.post_id + '.geojson',
                dataType: 'json',
                success: function (geoJson, text, xhr) {
                    console.log(text)
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });

            $.when( ajax_call ).done(function ( geoJson ) {

                WebMapp_LeafletMapMethods.loadGeojson( settings , geoJson , map );

            });
        }

        return this;

    };//end $.fn.WebMapp_LeafletMap = function( options )






}( jQuery ));