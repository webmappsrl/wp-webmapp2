
(function ( $ ) {

    function WebMapp_LeafletMapMethods ( settings , map ) {

        this.settings  = settings ;
        this.map  = map ;

        this.onEachFeature = ( e, layer ) => {

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



        };//end this.eachFeature

        this.geoJsonToLayer = ( geoJson ) => {
            let wthis = this;
            return L.geoJSON( geoJson ,
                {

                    onEachFeature : function ( feature, layer)
                    {

                        //added_layers.push(layer);
                        wthis.onEachFeature( feature , layer );
                        //todo add neigbors to map

                    }

                } );
        };

        this.loadGeojson = ( geoJson ) => {

            let wthis = this;
            let this_settings = wthis.settings;
            let map = wthis.map;
            let added_layers = [];

            let geojsonLayer = this.geoJsonToLayer( geoJson ).addTo( map );

            map.fitBounds(
                geojsonLayer.getBounds(),
                {
                    maxZoom : parseInt( this_settings.zoom )
                }
            );

            return added_layers;
        };

        this.removeLayers = ( main_geojson , added_layers ) =>
        {

            added_layers.forEach(
                function(e)
                    {
                        e.remove();
                    }
            );


            let this_settings = this.settings;

            this.map.fitBounds(
                L.geoJSON( main_geojson ).getBounds(),
                {
                    maxZoom : parseInt( this_settings.zoom )
                }
            );
        };


        this.ajaxGeoJson = ( url ) =>
        {
            return $.ajax({
                url: url,
                dataType: 'json',
                success: function (geoJson, text, xhr)
                {
                    console.log(geoJson);
                },
                error: function (xhr)
                {
                    console.log('Impossible load geojson for map here: ' + url) ;
                }
            });



        };//end ahaxGeoJson method


    }// end var WebMapp_LeafletMapMethods




    $.fn.WebMapp_LeafletMap = function( options )
    {


        // This is the easiest way to have default options.
        let settings = $.extend(
            {
                // These are the defaults.
                //id : WebMapp_LeafletMapMethods.uniqueidGenerator(),
                map_center : '',
                post_id : '',
                initialLat: 43.689740,//pisa lat
                initialLng: 10.392279,//pisa lng
                appUrl: data.appUrl,
                label: data.label,
                zoom: data.zoom,
                zoom_min: data.zoom_min,
                zoom_max: data.zoom_max,
                tilesUrl: data.tilesUrl,
                show_expand: data.show_expand,
                url_geojson_filters: {},
                filter: 'true'//todo
            }
            , options );


        //convert json string to object
        try
        {
            settings.url_geojson_filters = JSON.parse( settings.url_geojson_filters );
        }
        catch(e)
        {
            console.log('invalid json in jquery plugin settings:' + url_geojson_filters);
        }





        //this.append( mapContainer );

        /**
         * Load map
         */
        let map = L.map( settings.id , {
            center: [settings.initialLat, settings.initialLng],
            zoom: settings.zoom,
            scrollWheelZoom: false,
            maxZoom: settings.zoom_max,
            minZoom: settings.zoom_min,

        } );//parseInt( settings.zoom )

        /**
         * Set map tiles
         */
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


        /**
         * Expand map implementation
         */
        if ( data.show_expand === 'true' )
        {
            let link_url = settings.appUrl + '/#/poi/' + settings.post_id + '/' + settings.zoom;
                let html =
                '<a target="_blank" class="open-modal-map" href="' + link_url + '" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>';
            this.prepend( html );
        }


        /**
         * Load support methods
         * @type {WebMapp_LeafletMapMethods}
         */
        let methods = new WebMapp_LeafletMapMethods( settings , map );


        /**
         * Implementation for single post type template
         * when post_id attribute is set on shortcode
         */
        if ( settings.post_id )
        {

            //search geoJson in footer ( window var )
            let geoJson = window['geojson_' + settings.post_id] ? window['geojson_' + settings.post_id] : false ;



            //todo
            geoJson = geoJson ? geoJson : methods.ajaxGeoJson( settings.apiUrl + '/geojson/' + settings.post_id + '.geojson' );





            methods.loadGeojson( geoJson , map );

        }


        /**
         * Works on filters
         */
        if ( settings.filter === 'true' && settings.url_geojson_filters )
        {
            let overlayMaps = {}, filterGeoJsonAjax;
            $.each( settings.url_geojson_filters , function( i , url )
            {

                filterGeoJsonAjax = methods.ajaxGeoJson( url );
                $.when( filterGeoJsonAjax ).done(
                    function ( geoJson )
                    {
                        let layer = methods.geoJsonToLayer( geoJson );
                        overlayMaps["Filter Name " + i] = layer;
                        map.addLayer( layer );

                });

            });


            if ( filterGeoJsonAjax )
            {
                $.when( filterGeoJsonAjax ).always(
                    function () {
                        if ( overlayMaps )
                        {
                            L.control.layers( {} , overlayMaps , {
                                position: 'bottomleft'
                            } ).addTo(map);
                            map.fitBounds( L.featureGroup( Object.values( overlayMaps ) ).getBounds() );
                        }
                    });
            }



        }//end if ( settings.filter === 'true' )


        /**
         * OLD



        //$('#' + settings.id ).click( function(){ console.log( 'zoom: ' , map.getZoom() ); });
        //isset geojson in settings
        if ( geoJson )
        {
            methods.loadGeojson( geoJson , map );
        }
        //necessary ajax call
        else
        {


            if ( settings.geojson_url )
                geojsonurlforajax = settings.geojson_json;


            let ajax_call = $.ajax({
                url: geojsonurlforajax,
                dataType: 'json',
                success: function (geoJson, text, xhr) {
                    console.log(text)
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });

            $.when( ajax_call ).done(function ( geoJson ) {

                methods.loadGeojson( geoJson , map );

            });
        }

         */


        /**
         * NEIGHBORS

        if( settings.filter === 'true' )
        {
            //map.doubleClickZoom.disable();
            let $btFilter = $('<a id="' + settings.id + '-map-neighbors" class="wm_map_filter" title="neighbors"><span class="wm-icon-marker-15"></span> <span class="wm_filter_text">' + data.labelActive +'</span> ' + data.labelFilters + '</a>');

            $('#' + settings.id).prepend( $btFilter );

            let neighbors_active = false;
            let first_time = true;
            let added_layers = [];

            $btFilter.on( 'click' , function( click_e )
            {
                if ( first_time )
                {
                    map.doubleClickZoom.disable();
                    first_time = false;
                }

                click_e.preventDefault();

                neighbors_active = ! neighbors_active ;

                if( neighbors_active )
                {
                    $(this).find('.wm_filter_text').text( data.labelDeactive );
                    $(this).find('.wm-icon-marker-15').addClass( 'wm-icon-marker-stroked-15' );
                    added_layers = methods.loadGeojson( geoJson_neighbors );
                }
                else
                {
                    $(this).find('.wm_filter_text').text(data.labelActive);
                    $(this).find('.wm-icon-marker-15').removeClass('wm-icon-marker-stroked-15');
                    methods.removeLayers( geoJson , added_layers );
                    added_layers = [];
                }


            });

        }

         */


        return this;

    };//end $.fn.WebMapp_LeafletMap = function( options )






}( jQuery ));