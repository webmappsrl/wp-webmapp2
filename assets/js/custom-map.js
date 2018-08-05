(function ($) {
  $(document).ready(function () {

    $custom_poi_map = $('#custom-poi-map');

    if ($custom_poi_map.length) {

      var lat = $custom_poi_map.data('lat'),
          lng = $custom_poi_map.data('lng'),
          id = $custom_poi_map.data('id'),
          modal = '<div id="modal-map"><div class="modal-content"><i class="fa fa-times close-modal" aria-hidden="true"></i><iframe src="' + data.appUrl + '/#/poi/' + id + '/' + data.zoom + '" width="100%"></iframe></div></div>',
          icon_class = $custom_poi_map.data('icon'),
          color = $custom_poi_map.data('icon-color');

      var map = L.map('custom-poi-map').setView([lat, lng], data.zoom);
      L.tileLayer(data.tilesUrl, {
        layers: [
          {
            label: data.label,
            type: 'maptile',
            tilesUrl: data.tilesUrl,
            default: true
          }],
        //maxZoom: 17
      }).addTo(map);


      var poi = $.ajax({
        url: data.appUrl + '/geojson/poi/' + id + '.geojson',
        dataType: 'json',
        success: function (data, text, xhr) {
          console.log(text)
        },
        error: function (xhr) {
          console.log(xhr);
          getDataPoiFromTemplate(data, icon_class, color, map, lat, lng, modal);
        }
      })

      $.when(poi).done(function (e) {

        if (data.show_pin === 'true') {

          if (icon_class !== '' || color !== '') {
            var iconMarker = L.VectorMarkers.icon({
              icon: 'poi',
              prefix: 'wm',
              extraClasses: icon_class,
              markerColor: color,
              iconSize: [36, 45],
            })
            marker = L.marker([lat, lng], {icon: iconMarker}).addTo(map)
          }
          else if (icon_class !== '') {
            var iconMarker = L.VectorMarkers.icon({
              markerColor: color,
              iconSize: [36, 45],
            })
            marker = L.marker([lat, lng], {icon: iconMarker}).addTo(map)
          }
          else if (color !== '') {
            var iconMarker = L.VectorMarkers.icon({
              icon: 'poi',
              prefix: 'wm',
              extraClasses: icon_class,
              iconSize: [36, 45],
            })
            marker = L.marker([lat, lng], {icon: iconMarker}).addTo(map)
          }
          else {
            marker = L.marker([lat, lng]).addTo(map)
          }

          if (data.no_app === 'true') {
            if ( e.properties["addr:street"] !== undefined && e.properties["addr:housenumber"] !== undefined ) {
              marker.bindPopup('<strong>' + e.properties.name + '</strong><br />' + e.properties["addr:street"] + ' ' + e.properties["addr:housenumber"] )
            } else if ( e.properties["address"] !== undefined ) {
              marker.bindPopup('<strong>' + e.properties.name + '</strong><br />' + e.properties["address"] )
            } else {
              marker.bindPopup('<strong>' + e.properties.name + '</strong>' )
            }
          }
          else {
            marker.on('click', function () {
              $('body').prepend(modal)
              $('#modal-map iframe').height($(window).height() * 80 / 100)

            })
          }
        }

      });

      if (data.show_expand === 'true') {

        attr = 'open-modal-map'

        html = '<a target="_blank" class="' + attr +
          '" href="#" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>'
        $custom_poi_map.prepend(html)

        $('.open-modal-map').on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)

        })
      }

      if (data.click_iframe === 'true') {
        $('#custom-poi-map').on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)
        })
      }

      $('body').on('click', '.close-modal', function (e) {
        e.preventDefault()
        $('#modal-map').remove()
      });

      if (data.activate_zoom !== 'true'){
        disableZoomAndDraggable(map);
      }
    }



    /////// MAP TRACK ///////

    $custom_track_map = $('#custom-track-map');

    if ($custom_track_map.length) {
      id = $custom_track_map.data('id');
      map = L.map('custom-track-map').setView([0, 0], data.zoom);
      L.tileLayer(data.tilesUrl, {
        layers: [
          {
            label: data.label,
            type: 'maptile',
            tilesUrl: data.tilesUrl,
            default: true
          }],
        //maxZoom: 17
      }).addTo(map);

      var track = $.ajax({
        url: data.appUrl + '/geojson/track/' + id + '.geojson',
        dataType: 'json',
        success: function (data, text, xhr) {

        },
        error: function (xhr) {
          console.log(xhr);
          $related_pois = $('.related_poi');
          if ($related_pois.length) {
            $related_pois.each(function (index, element) {

              var lat = $(element).data('lat'),
                lng = $(element).data('lng'),
                title = $(element).data('title'),
                id = $(element).data('id');
              /*
              var iconMarker = L.VectorMarkers.icon({
                icon: 'poi',
                prefix: 'wm',
                extraClasses: icon_class,
                markerColor: color,
                iconSize: [36, 45],
              })
              marker = L.marker([lat, lng], {icon: iconMarker}).addTo(map) */
              marker = L.marker([lat, lng]).addTo(map);
              marker.bindPopup('<a href="/?p='+ id +'" title="'+ title  +'"><strong>' + title + '</strong></a>');

            })
          }

        }
      })

      if( data.filter === 'true' ) {
        map.doubleClickZoom.disable();
        var btFilter = '<a target="_blank" class="wm_map_filter" href="" title="attiva poi vicini" data-toggle="true" ><span class="wm-icon-marker-15"></span> <span class="wm_filter_text">' + data.labelActive +'</span> ' + data.labelFilters + '</a>';
        $custom_track_map.prepend(btFilter);

      }

      $.when(track).done(function (element, text, xhr) {

        var related = element.properties.related.poi.related;

        $.each( related, function (index, value) {

          var term_id = value.webmapp_category["0"];

          var icon = terms_icon[term_id].icon,
          color = terms_icon[term_id].color;

          if ( color !== '' ){
            var iconMarker = L.VectorMarkers.icon({
              icon: 'poi',
              prefix: 'wm',
              extraClasses: icon,
              markerColor: color,
              iconSize: [36, 45]
            });
            marker = L.marker([value.lat, value.lon], {icon: iconMarker}).addTo(map);
          } else {
            marker = L.marker([value.lat, value.lon]).addTo(map);
          }

          marker.bindPopup('<a href="'+ value.web +'" title="'+ value.name  +'"><strong>' + value.name + '</strong></a>');
        });

        if( data.filter === 'true' ) {

          var markers = [],
          neighbors = element.properties.related.poi.neighbors;

          var sem = true;
          $('.wm_map_filter').on('click', function(event){
            event.preventDefault();

            if(sem){
              $.each( neighbors, function (index, value) {

                var term_id = value.webmapp_category["0"],
                  icon = terms_icon[term_id].icon,
                  color = terms_icon[term_id].color;


                if ( color !== '' ){
                  var iconMarker = L.VectorMarkers.icon({
                    icon: 'poi',
                    prefix: 'wm',
                    extraClasses: icon,
                    markerColor: color,
                    iconSize: [36, 45]
                  });
                  marker = L.marker([value.lat, value.lon], {icon: iconMarker}).addTo(map);
                } else {
                  marker = L.marker([value.lat, value.lon]).addTo(map);
                }

                  marker.bindPopup('<a href="'+ value.web +'" title="'+ value.name  +'"><strong>' + value.name + '</strong></a>');
                  markers.push(marker);
              });
              $('.wm_filter_text').text(data.labelDeactive);
              $('.wm-icon-marker-15').addClass('wm-icon-marker-stroked-15');
              sem = false;
            } else {

              markers.forEach(function(marker) {
                map.removeLayer(marker);
              });
              markers = [];
              $('.wm_filter_text').text(data.labelActive);
              $('.wm-icon-marker-15').removeClass('wm-icon-marker-stroked-15');
              sem = true;
            }

          });

        }

      });

      var geojson = $custom_track_map.data('geojson');
      L.geoJSON(geojson).addTo(map)

      var geojsonLayer = L.geoJson(geojson).addTo(map)
      map.fitBounds(geojsonLayer.getBounds())

      center = map.getCenter()
      zoom = map.getZoom()



      if (data.no_app !== 'true') {
        var modal = '<div id="modal-map"><div class="modal-content"><i class="fa fa-times close-modal" aria-hidden="true"></i><iframe src="' +
          data.appUrl + '/#/track/' + id +
          '" width="100%"></iframe></div></div>'
      }

      if (data.show_expand === 'true') {

        attr = 'open-modal-map'

        var expand = '<a target="_blank" class="' + attr +
          '" href="#" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>'

        $custom_track_map.prepend(expand)

        $('.open-modal-map').on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)
        })

      }

      if (data.click_iframe === 'true') {
        $custom_track_map.on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)
        })
      }

      $('body').on('click', '.close-modal', function (e) {
        e.preventDefault()
        $('#modal-map').remove()
      })

      if (data.activate_zoom !== 'true'){
        disableZoomAndDraggable(map);
      }
    }

    ///// CUSTOM SHORTCODE MAP /////

    $custom_shortcode_map = $('#custom-shortcode-map')

    if ($custom_shortcode_map.length) {

      var lat = $custom_shortcode_map.data('lat'),
        lng = $custom_shortcode_map.data('lng'),
        zoom = $custom_shortcode_map.data('zoom'),
        modal = '<div id="modal-map"><div class="modal-content"><i class="fa fa-times close-modal" aria-hidden="true"></i><iframe src="' +
          data.appUrl + '/#/?map=' + zoom + '/' + lat + '/' + lng +
          '" width="100%"></iframe></div></div>'

      map = L.map('custom-shortcode-map').setView([lat, lng], zoom)

      L.tileLayer(data.tilesUrl, {
        layers: [
          {
            label: data.label,
            type: 'maptile',
            tilesUrl: data.tilesUrl,
            default: true,
          }],
      }).addTo(map)

      if (data.click_iframe === 'true') {
        html = '<a target="_blank" class="open-modal-map" href="#" title="apri tutta la mappa"><span class="wm-icon-arrow-expand"></span></a>'
        $custom_shortcode_map.prepend(html);

        $('.open-modal-map').on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)

        })

        $custom_shortcode_map.css('cursor', 'pointer')
        $custom_shortcode_map.on('click', function (e) {
          e.preventDefault()
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)
        })
      }

      $('body').on('click', '.close-modal', function (e) {
        e.preventDefault()
        $('#modal-map').remove()
      })

      if (data.activateZoom !== 'true'){
        disableZoomAndDraggable(map)
      }
    }

  });


  function getDataPoiFromTemplate (data, icon_class, color, map, lat, lng, modal) {

    if (data.show_pin === 'true') {

      if (icon_class !== '' || color !== '') {
        var iconMarker = L.VectorMarkers.icon({
          icon: 'poi',
          prefix: 'wm',
          extraClasses: icon_class,
          markerColor: color,
          iconSize: [36, 45],
        })
        marker = L.marker([lat, lng], {icon: iconMarker}).addTo(map)
      }
      else {
        marker = L.marker([lat, lng]).addTo(map)
      }

      if (data.click_iframe === 'true') {
        marker.on('click', function () {
          $('body').prepend(modal)
          $('#modal-map iframe').height($(window).height() * 80 / 100)
        });
      }

    }

  }

  function disableZoomAndDraggable (map) {
    map.touchZoom.disable()
    map.dragging.disable()
    map.touchZoom.disable()
    map.doubleClickZoom.disable()
    map.scrollWheelZoom.disable()
    map.boxZoom.disable()
    map.keyboard.disable()
    jQuery('.leaflet-control-zoom').css('visibility', 'hidden')
  }

})(jQuery);
