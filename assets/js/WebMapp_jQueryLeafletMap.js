
(function ( $ ) {

    function WebMapp_LeafletMapMethods ( settings , map ) {

        this.settings  = settings ;
        this.map  = map ;
        console.log(webmapp_cat);
        this.onEachFeature = ( e, layer ) => {

            //todo optimize here
            let imageurl = this.getContent( e.properties , 'image');
            let name = this.getContent( e.properties , 'name');
            let taxonomies = this.getContent( e.properties , 'taxonomy');
            let color = '#2a82cb';
            let icon = '';
            if ( taxonomies.webmapp_category ) {
              let id_tax = taxonomies.webmapp_category[0] ? taxonomies.webmapp_category[0] : false;

              if ( id_tax && webmapp_cat[id_tax]){
                color = this.getContent( e.properties , 'color') ? this.getContent( e.properties , 'color') : webmapp_cat[id_tax].color;
                icon = this.getContent( e.properties , 'icon') ? this.getContent( e.properties , 'icon') : webmapp_cat[id_tax].icon;
              } else {
                color = this.getContent( e.properties , 'color');
                icon = this.getContent( e.properties , 'icon');
              }
            } else {
              color = this.getContent( e.properties , 'color');
              icon = this.getContent( e.properties , 'icon');
            }

            let link = this.getContent( e.properties , 'web');

            let layer_id = this.getContent( e.properties , 'id');

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

        this.getContent = ( layer_properties , property_name ) =>
        {
            let value;

            let lang_details = WebmappLangDetails;
            let properties_language = layer_properties.locale;

            //english or other language case ( no main language )
            if ( lang_details && properties_language !== lang_details.locale )
            {
                let properties_translations = layer_properties.translations;

                try
                {
                    value = properties_translations[ lang_details.locale ][ property_name ];
                }
                catch( undefined_error )
                {
                    //Ignored null value
                }
            }

            if( ! value && layer_properties.hasOwnProperty( property_name ) )
            {
                value = layer_properties[ property_name ];
            }


            return value ? value : '';

        };


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
                apiUrl: data.apiUrl,
                show_expand: data.show_expand,
                url_geojson_filters: {},
                filter: 'true',//todo
                //clustering 5/12/2018
                have_clustering: data.maps_have_clustering
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
            if (  settings.appUrl === '#!' || ! settings.appUrl ){
                map.addControl(new L.Control.Fullscreen());
            } else {
            let link_url = settings.appUrl + '/#/poi/' + settings.post_id + '/' + settings.zoom;
                let html =
                '<a target="_blank" class="open-modal-map" href="' + link_url + '" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>';
            this.prepend( html );
            }
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

                        //console.log(geoJson);

                        //clustering
                        var leaflet_cluster;
                        if ( settings.have_clustering )
                        {
                            leaflet_cluster = L.markerClusterGroup({
                                showCoverageOnHover: false,
                                maxClusterRadius: 60
                            });
                            leaflet_cluster.addLayer(layer);
                        }
                        //no clustering
                        else
                        {
                            leaflet_cluster = layer;
                        }


                        overlayMaps[ "Filter Name " + i ] = leaflet_cluster;

                        map.addLayer(leaflet_cluster);

                });

            });


            if ( filterGeoJsonAjax )
            {
                $.when( filterGeoJsonAjax ).always(
                    function () {
                        if ( ! $.isEmptyObject( overlayMaps ) )
                        {
                            L.control.layers( {} , overlayMaps , {
                                position: 'bottomleft'
                            } ).addTo(map);
                            if (settings.force_zoom == '1' ) {
                                map.setZoom( settings.zoom );
                            }
                            if (settings.force_view == '1' ) {
                                map.setView(new L.LatLng(settings.force_view_lat, settings.force_view_lng), settings.force_view_zoom);
                            } else {
                                map.fitBounds( L.featureGroup( Object.values( overlayMaps ) ).getBounds() );
                            }
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