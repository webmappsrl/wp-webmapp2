<?php

/*ADD METABOX IN ACF FIELD GROUP */


add_action('add_meta_boxes', 'addingtrack_meta_boxes', 10, 2);
function addingtrack_meta_boxes($post_type, $post) {
    //var_dump( get_post_meta($post->ID) );
  if (get_post_meta($post->ID, "n7webmap_geojson", TRUE) != "" || get_post_meta($post->ID, 'n7webmap_route_related_track') != NULL) {
    add_meta_box(
      'webmapp-track-map',
      __('Track Map', "webmap_net7"),
      'render_map_leaflet',
      'track',
      'normal',
      'high'
    );

    add_meta_box(
      'webmapp-track-map',
      __('Related Track Map', "webmap_net7"),
      'render_map_route_leaflet',
      'route',
      'normal',
      'default'
    );
  }
}



function render_map_leaflet($post) {
    

  ?>
    <div id='track-leaflet-map'></div>

    <script>

            setLeafletMap('track-leaflet-map', <?php echo json_encode(geojson_track($post->ID)) ?>);

    </script>
  <?php
//  echo "<div id='track-leaftlet-map'></div>";
}

function render_map_route_leaflet($post) {
  ?>
    <div id='track-leaflet-map'></div><br>
    <button id="set_bbox">Get bounding box</button> <br><br>
    <textarea id="webmapp_bbox" name="n7webmapp_route_bbox" cols="50" rows="20">
       <?php echo get_post_meta($post->ID, 'n7webmapp_route_bbox', TRUE); ?>
    </textarea>
    <script>
      <?php $related_track = geojson_route_related_track($post->ID);
      if (!empty($related_track)): ?>

          setLeafletMap('track-leaflet-map', <?php echo json_encode(geojson_route_related_track($post->ID)) ?>);

          <?php endif; ?>
    </script>
  <?php
//  echo "<div id='track-leaftlet-map'></div>";
}

