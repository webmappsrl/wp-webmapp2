<?php


/**
 * PRIVATE AJAX
 */

function webmapp_manage_bulk_quick_save_bulk_edit() {
    // we need the post IDs
    $post_ids = (isset($_POST['post_ids']) && !empty($_POST['post_ids'])) ? $_POST['post_ids'] : NULL;

    // if we have post IDs
    if (!empty($post_ids) && is_array($post_ids)) {

        // get the custom fields
        $custom_fields = array('noDetails', 'noInteraction');

        foreach ($custom_fields as $field) {

            // if it has a value, doesn't update if empty on bulk
            if (isset($_POST[$field]) && $_POST[$field] != '-1') {
                // update for each post ID
                foreach ($post_ids as $post_id) {
                    update_post_meta($post_id, $field, $_POST[$field]);
                }

            }

        }

    }

}
new WebMapp_AjaxHandler( false ,'webmapp_manage_bulk_quick_save_bulk_edit' );


function webmapp_import_create_poi() {

    $poi = $_POST["objects"];
    $response = array();
    foreach ($poi as $p) {
        if ($p != "") {
            $post = array(
                'ID' => 0,
                'post_type' => "poi",
                'post_name' => sanitize_title($p['name']),
                // The name (slug) for your post
                'post_title' => $p['name'],
                // The title of your post.
                'post_content' => $p['desc'],
                // The title of your post.
                'post_status' => 'publish'
            );
            if (isset($p['cats']) && $p['cats'] != "") {
                $post['tax_input'] = array("webmapp_category" => explode(",", $p['cats']));
            }
            $poi_id = wp_insert_post($post, TRUE);

            if ($poi_id > 0) {
                $value = array("address" => "", "lat" => $p["lat"], "lng" => $p["lon"]);
                update_field('n7webmap_coord', $value, $poi_id);
                $response[$p['name']] = get_edit_post_link($poi_id, "");
            }
        }
    }
    echo json_encode($response);
    die;
}
new WebMapp_AjaxHandler( true ,'webmapp_import_create_poi' );


function webmapp_create_track() {

    $title = $_POST["track_name"] != "" ? $_POST["track_name"] : "undefined";


    $poi = $_POST["poi"];
    $file = $_POST["gpx_file"];
    $post_type = $_POST["content_type"];
    $post_id = 0;
    $file_type = $_POST["file_type"];

    if ($post_type == "track") {
        $post_id = $_POST["post_id"];
    }

    $post = array(
        'ID' => $post_id,
        'post_type' => "track",
        'post_name' => sanitize_title($title), // The name (slug) for your post
        'post_title' => $title, // The title of your post.
        'post_status' => 'publish'
    );

    if ($post_id == 0) {
        $post_id = wp_insert_post($post, TRUE);
    }
    else {
        $post_id = wp_update_post($post, TRUE);
    }

    if (file_exists($file)) {
        $content = file_get_contents($file);
        try {
            if ($file_type == "gpx") {
                $geojson = gpx_to_geojson((string) $content);
            }
            elseif ($file_type == "kml") {
                $geojson = kml_to_geojson((string) $content);

            }
        } catch (Exception $ex) {
            $response["json_error"] = $ex->getMessage();
        }

        if ($geojson != NULL && $geojson != "") {
            $obj = json_decode($geojson, TRUE);
            update_post_meta($post_id, "n7webmap_geojson", serialize($obj));
            unlink($file);
        }

    }


//  $wp_upload_dir = wp_upload_dir();
//  $gpx_file_name = $wp_upload_dir['path'] . "/" . "track_" . $post_id . ".gpx";
//
//  $file_mvd = rename($file, $gpx_file_name);
//
//  if ($file_mvd) {
//    $gpx_id = create_attachment($gpx_file_name);
//    update_field("n7webmap_gpx", $gpx_id, $post_id);
//  }


    if ($post_type == "route") {
        $route_id = $_POST["post_id"];
        $route_related = get_field("n7webmap_route_related_track", $route_id);
        $route_related[] = get_post($post_id);
        update_field("n7webmap_route_related_track", $route_related, $route_id);
    }

    $poi_ids = get_field('n7webmap_related_poi', $post_id);
    if (empty($poi_ids)) {
        $poi_ids = array();
    }

    foreach ($poi as $p) {
        if ($p != "") {
            $post = array(
                'ID' => 0,
                'post_type' => "poi",
                'post_name' => sanitize_title($p['name']),
                // The name (slug) for your post
                'post_title' => $p['name'],
                // The title of your post.
                'post_content' => $p['desc'],
                // The title of your post.
                'post_status' => 'publish'
            );
            if (isset($p['cats']) && $p['cats'] != "") {
                $post['tax_input'] = array("webmapp_category" => explode(",", $p['cats']));
            }
            $poi_id = wp_insert_post($post, TRUE);


            if ($post_id > 0) {
                $poi_ids[] = $poi_id;
                $value = array("address" => "", "lat" => $p["lat"], "lng" => $p["lon"]);
                update_field('n7webmap_coord', $value, $poi_id);
            }
        }
    }


    update_field('n7webmap_related_poi', $poi_ids, $post_id);

    $response = array();
    $response["url"] = get_edit_post_link($post_id, "");
    $response["track_name"] = (string) $title;
    $response["track_id"] = $post_id;
//      echo get_edit_post_link($post_id);
    $response["redirect"] = "";
    if ($post_type == "track") {
        $response["redirect"] = $response["url"];
    }

    echo json_encode($response);
    die;
}
new WebMapp_AjaxHandler( false ,'webmapp_create_track' );
function gpx_to_geojson($text) {
    $decoder = new gisconverter\GPX();
    return $decoder->geomFromText($text)->toGeoJSON();
}
function kml_to_geojson($text) {
    $decoder = new gisconverter\KML();
    return $decoder->geomFromText($text)->toGeoJSON();
}


function webmapp_kml_upload() {

    $data = isset($_FILES) ? $_FILES : array();

    $temp_name = $data["webmapp_file_upload"]["tmp_name"];

    $fileName = $data["webmapp_file_upload"]["name"];
    $fileNameChanged = str_replace(" ", "_", $fileName);

    $filepath = WebMapp_DIR . "/uploads";

    if ( ! file_exists($filepath ) )
    {
        // create directory/folder uploads.
        mkdir($filepath, 0755 , true );
    }

    $file = $filepath . "/" . $fileNameChanged;

    $response = array();
    $file_mvd = move_uploaded_file($temp_name, $file);

    if ($file_mvd) {
        $response = webmapp_parse_kml($file, $response);


    }

    echo json_encode($response);

    die();
}
new WebMapp_AjaxHandler( false ,'webmapp_kml_upload' );




function webmapp_file_upload() {

    $data = isset($_FILES) ? $_FILES : array();

    $temp_name = $data["webmapp_file_upload"]["tmp_name"];
    $fileName = $data["webmapp_file_upload"]["name"];

    $fileNameChanged = str_replace(" ", "_", $fileName);

    $filepath = WebMapp_DIR . "/uploads";
    $file = $filepath . "/" . $fileNameChanged;


    $response = array();
    //$response["error"] = $temp_name ;
    $file_mvd = move_uploaded_file($temp_name, $file);
    //$text = file_get_contents( $temp_name );

    //$test = gpx_to_geojson ($text);


    if ($file_mvd) {
        $file_type = explode(".", $fileName);

        $ftype = end($file_type);

        if ($ftype == "gpx") {
            $response = webmapp_parse_gpx($file, $response);
        }
        elseif ($ftype == "kml") {
            $response = webmapp_parse_kml($file, $response);
        }
        else {
            $response["error"] = "Unknown file type - ".$ftype;
        }
        $response["file_type"] = $ftype;

    }


    echo json_encode($response);

    die();
}
new WebMapp_AjaxHandler( false ,'webmapp_file_upload' );


function webmapp_parse_gpx($file, $response) {

    $gpx = simplexml_load_file($file);
    if ($gpx === FALSE) {
        $response["error"] = __("Failed loading GPX: ", "webmap_net7");
        foreach (libxml_get_errors() as $error) {
            $response["error"] .= "<br>" . $error->message;
        }
    }
    else {
        if ($gpx->trk->name) {
            $response["label"] = __("Creating Track with name: ", "webmap_net7");
            $response["title"] = (string) $gpx->trk->name;
        }
        else {
            $response["label"] = __("No name given for this track", "webmap_net7");
            $response["title"] = "undefined";
        }
        $response["poi"] = array();

        foreach ($gpx->wpt as $wpt) {
            //        var_dump($wpt); die;
            $response["poi"][] = array(
                'name' => (string) $wpt->name,
                'desc' => (string) $wpt->desc,
                'lat' => (string) $wpt["lat"],
                'lon' => (string) $wpt["lon"],
            );
        }
        unset($gpx->wpt);
        $gpx->asXML($file);
        $response["gpx_file"] = $file;
    }

    return $response;
}
function webmapp_parse_kml($file, $response) {

    $kml = simplexml_load_file($file);
    if ($kml === FALSE) {
        $response["error"] = __("Failed loading KML: ", "webmap_net7");
        foreach (libxml_get_errors() as $error) {
            $response["error"] .= "<br>" . $error->message;
        }
    }
    else {


        foreach ($kml->Document->Placemark as $plm) {
            if (count($plm->Point) > 0) {
                $point = explode(",", $plm->Point->coordinates);
                $response["poi"][] = array(
                    'name' => (string) $plm->name,
                    'desc' => (string) $plm->description,
                    'lat' => (string) $point[1],
                    'lon' => (string) $point[0]
                );
                unset($plm);
            }
            elseif (count($plm->LineString) > 0) {
                $response["label"] = __("Creating Track with name: ", "webmap_net7");
                $response["title"] = (string) $plm->name;
                $plm->asXML($file);
            }
            else {
                unset($plm);
            }
        }
        $response["gpx_file"] = $file;
    }
    return $response;
}

