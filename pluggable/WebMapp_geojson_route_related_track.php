<?php
// Geojson della traccia
function geojson_route_related_track($obj_id) {

  $related_track = get_field("n7webmap_route_related_track", $obj_id);
  $result = array();
  /*Aggiungo dati di esempio */
//   var_dump($map); //controlla i campi disponibili per la mappa
  if (!empty($related_track)) {
    $result["type"] = 'FeatureCollection';
    $result["id"] = $obj_id;

    $features = array();
    foreach ($related_track as $track) {
      $features[] = geojson_track($track->ID);
    }

    $result["features"] = $features;
  }

  return $result;
}