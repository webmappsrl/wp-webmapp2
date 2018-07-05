<?php
// Geojson della traccia
function geojson_track($obj_id) {
  $obj = get_post($obj_id);

  
  $result = array();  
  /*Aggiungo dati di esempio */
//   var_dump($map); //controlla i campi disponibili per la mappa
  $result["type"] ='FeatureCollection';
  $result["id"] = $obj->ID;
  
  $features=array();
  $feature=array();
  
  $feature["type"] = 'Feature';
  $feature["properties"]["name"] = $obj->post_title;
  $feature["properties"]["description"] = $obj->post_content;
  $feature['properties']['color']=  get_field('n7webmapp_track_color', $obj->ID);
  $gallery = get_field("field_5853f586c83cd", $obj->ID);
  if($gallery)
    $feature['properties']['picture_url'] = $gallery[0]['url'];
  
  $feature["geometry"]=get_field('n7webmap_geojson',$obj->ID);
  
  $features[]=$feature;
  $result["features"] = $features;

  return $result;
  
}


?>