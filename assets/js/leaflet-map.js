function setLeafletMap(mapid, geojsonFeature){
  
  var mymap = L.map(mapid).setView([43.6551217, 11.0812834], 9);

//        tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
//    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
//    maxZoom: 18,
//    id: 'your.mapbox.project.id',
//    accessToken: 'your.mapbox.public.access.token'
//    
//    
//    
//})
L.tileLayer('http://a.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, ' +
                '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="http://mapbox.com">Mapbox</a>',
        id: 'mapbox.streets'
}).addTo(mymap);

 var geojsonLayer  = L.geoJSON(geojsonFeature).addTo(mymap);

mymap.fitBounds(geojsonLayer.getBounds());

jQuery("#set_bbox").on("click", function(e){
  e.stopImmediatePropagation();
  e.preventDefault();
  var currentBbox = mymap.getBounds(),
  currentZoom = mymap.getZoom(),
  currentCenter = mymap.getCenter();

  var config = {
      maxZoom: currentZoom + 2,
      minZoom: currentZoom - 2,
      defZoom: currentZoom,
      center: {
          lat: currentCenter.lat,
          lng: currentCenter.lng
      },
      bounds: {
          southWest: [currentBbox._southWest.lat, currentBbox._southWest.lng],
          northEast: [currentBbox._northEast.lat, currentBbox._northEast.lng]
      },
  };

  document.getElementById('webmapp_bbox').innerHTML = JSON.stringify(config, null, 4).replace(/"/g, '');
        
})

}


