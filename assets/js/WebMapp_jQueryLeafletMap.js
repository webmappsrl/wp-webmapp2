
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

        this.loadGeojson = ( geoJson ) => {

            let wthis = this;
            let this_settings = wthis.settings;
            let map = wthis.map;
            let added_layers = [];


            let geojsonLayer = L.geoJSON( geoJson ,
                {

                    onEachFeature : function ( feature, layer)
                    {

                        added_layers.push(layer);
                        wthis.onEachFeature( feature , layer );
                        //todo add neigbors to map

                    }

                } )
                .addTo( map );



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
        }


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
                tilesUrl : data.tilesUrl,
                show_pin : data.show_pin,
                no_app : data.no_app,
                show_expand : data.show_expand,
                click_iframe : data.click_iframe,
                activate_zoom : data.activate_zoom,
                geojson_url : ''
            }
            , options );


        console.log( 'GEOJSONURL' , settings.geojson_url );




        let geoJson = window['geojson_' + settings.post_id] ? window['geojson_' + settings.post_id] : false ;
        let geoJson_neighbors = window[ 'geojson_' + settings.post_id + '_' + settings.post_type + '_neighbors' ] ? window[ 'geojson_' + settings.post_id + '_' + settings.post_type + '_neighbors' ] : false ;

        //this.append( mapContainer );

        let map = L.map( settings.id , {
            center: [settings.initialLat, settings.initialLng],
            zoom: settings.zoom,
            scrollWheelZoom: false,
            maxZoom: 16
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


        let methods = new WebMapp_LeafletMapMethods( settings , map );


        console.log( geoJson );

        //$('#' + settings.id ).click( function(){ console.log( 'zoom: ' , map.getZoom() ); });
        //isset geojson in settings
        if ( geoJson )
        {
            methods.loadGeojson( geoJson , map );
        }
        //necessary ajax call
        else
        {
            let geojsonurlforajax = settings.appUrl + '/geojson/' + settings.post_id + '.geojson';

            if ( settings.geojson_url )
                geojsonurlforajax = settings.geojson_url;




            //todo ajax call to this server!
            //todo add neighbors compatibility
            //todo $.getJSON
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





        //show add neighbors
        if( data.filter === 'true' && geoJson_neighbors )
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


        return this;

    };//end $.fn.WebMapp_LeafletMap = function( options )






}( jQuery ));